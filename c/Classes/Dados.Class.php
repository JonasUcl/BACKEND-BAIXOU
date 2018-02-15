<?php
class Dados{
    public function DownloadFiles($FileName = ""){
        $Global_Funcs = new VersionCommon();
        if(!$Global_Funcs->IS_NULL($FileName))
            $File = $FileName;
        else if(isset($_POST['fileName']))
            $File = $_POST['fileName'];
        else if(isset($_GET['fileName']))
            $File = $_GET['fileName'];
        if($Global_Funcs->IS_NULL($File))
            return json_encode(array("Error"=>"Você precisar indicar de onde o arquivo será baixado."));
        $FileName = $File;
        error_reporting(E_ALL);
        $src                = $FileName;
        $z                  = DESTINO_DOWNLOAD."/".NOME_ARQUIVO_DOWNLOAD;

        $fp = fopen($z, 'w+');
        $ch = curl_init();
		
        curl_setopt_array($ch, array(
            CURLOPT_URL                     => $src,
            CURLOPT_FILE                    => $fp,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.7) Gecko/20070914 Firefox/2.0.0.7'
        ));
        $down = curl_exec($ch);
        $info = curl_getinfo($ch);

        //echo '{ '.curl_error($ch).' | '.$down.' | '.print_r($info, 1).' }';
        $Errors = curl_error($ch);
        if($down)
            $Message = 'Processo concluído com sucesso!';
        $Array = array("Message"=>$Message, "Error"=>$Errors);

        curl_close($ch);
        fclose($fp);
        return json_encode($Array);
    }
    public function UncompressFile(){
		
        $File = DESTINO_DOWNLOAD."/".NOME_ARQUIVO_DOWNLOAD;
        $Destiny = DESTINO_EXTRAIR.'/';

        $zip = new ZipArchive;
        $zip->open($File);
        if($zip->extractTo($Destiny) == TRUE)
            $Message = 1;
        else
            $Message = 0;
        $zip->close();
        return $Message;
    }
    public function InsertOnDataBase(){
		
        $Connection = new SQLConnection();
        $Connection->Database = DB;
        $Connection->Open_Connection();
		
        $XML = $this->LoadXML();
        for($i = 0; $i < count($XML->produto);$i++){
            $Codigo = $XML->produto[$i]->Reduzido;
            $Query = $Connection->ExecuteQuery("SELECT * FROM produtos WHERE codigo='$Codigo'");
            if(mysql_num_rows($Query) > 0){
                $Query = "UPDATE produtos SET 
                    descricao='{$XML->produto[$i]->Descricao}', 
                    fornecedor='{$XML->produto[$i]->Fornecedor}',
                    preco='{$XML->produto[$i]->PrecoPor}',
                    datahoraatualizacao=NOW() WHERE codigo='$Codigo';
                    ";
                $Query = $Connection->ExecuteQuery($Query);
            }
            else{
                $Query = "INSERT INTO produtos (codigo, descricao, fornecedor, preco, datahoraatualizacao) VALUES ";
                $Query .= "('$Codigo','{$XML->produto[$i]->Descricao}','{$XML->produto[$i]->Fornecedor}','{$XML->produto[$i]->PrecoPor}',NOW())";
                $Query = $Connection->ExecuteQuery($Query);
            }
        }
        $Query = $Connection->JSON_ENCODE("SELECT * FROM produtos");
        return $Query;
    }
    private function LoadXML(){
        $XML_FILE = DESTINO_EXTRAIR."/".XML_FILE_NAME;
        $Download = $this->DownloadFiles(ZIP_FILE);
        $UnCompress = $this->UncompressFile();
        if($UnCompress){
            $XML_FILE = $this->TrataXML($XML_FILE);
            @$xml = simplexml_load_string($XML_FILE, null, LIBXML_NOCDATA);
            return $xml;
        }
        else return json_encode("Erro ao descompactar o arquivo.");

    }
    private function TrataXML($File){
        
        $Global_Funcs = new VersionCommon();
        $File = file_get_contents($File);
        //$File = utf8_encode($File);
        $Find = array("&");
        $Replace = array("&amp;");
        preg_match_all("|<(.*)>|U", $File, $result);
        $openedtags = $result[1];
        $Open_Tag = array();
        $Close_Tag = array();
        for($i = 0; $i < count($openedtags);$i++){
            if(!$Global_Funcs->IS_NULL($openedtags[$i]) && 
            !(VersionCommon::IndexOf($openedtags[$i],"CDATA") > -1) && 
            !(VersionCommon::IndexOf($openedtags[$i],"/") > -1) &&
            !(VersionCommon::IndexOf($openedtags[$i],"?xml version") > -1)
            )
                $Open_Tag[] = $openedtags[$i];
        }
        preg_match_all("|</(.*)>|U", $File, $result);
        $closedtags = $result[1];
        for($i = 0; $i < count($closedtags);$i++){
            if(!$Global_Funcs->IS_NULL($closedtags[$i]))
                $Close_Tag[] = $closedtags[$i];
        }
        for($i = 0; $i < count($Close_Tag);$i++){
            if(!in_array($Open_Tag[$i], $Close_Tag)){
                $File = str_replace("<{$Open_Tag[$i]}>", "", $File);
            }
        }
        $File = str_replace($Find, $Replace, $File);
        return $File;
    }
}
?>