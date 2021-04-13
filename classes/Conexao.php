<?php
    $dbname = "crud_pdo";
    $host = "localhost";
    $user = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:dbname=".$dbname.";host=".$host, $user, $password);
    }
    catch (PDOException $erro)
    {
        echo "Erro no banco de dados = ".$mensagem = $erro->getMessage();
        exit();
    }
    catch (Exception $erro)
    {
        echo "Erro = ".$mensagem = $erro->getMessage();
        exit();
    }

?>