<?php
header('Content-Type: application/json; charset=utf-8');

if(isset($_GET['cmd']))
    $Command = $_GET['cmd'];
else if(isset($_POST['cmd']))
    $Command = $_POST['cmd'];
else $Command = "";
$Dados = new Dados();
switch($Command){
    case "GetData":
        $Response = $Dados->InsertOnDataBase(); 
        echo $Response;
    break;
    default:
        echo json_encode("Nenhum comando recebido.");
    break;
}

?>