<?php
    require_once 'classes/Conexao.php';
    require_once 'classes/Pessoa.php';

    $p = new Pessoa($pdo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Cadastro Pessoa</title>
</head>
<body>
    <?php
        if(isset($_POST['btn-cadastrar'])){

            if(isset($_GET['id_up'])){
            //------------------ Atualizar ---------------------
            $id = filter_input(INPUT_GET, 'id_up');
            $nome = filter_input(INPUT_POST, 'nome');
            $telefone = filter_input(INPUT_POST, 'telefone');
            $email = filter_input(INPUT_POST, 'email');
            
            $p->atualizarDados($id, $nome, $telefone, $email);
                header('Location:index.php');
            }
            else
            {
            // ----------------- Cadastrar ----------------------
            $nome = filter_input(INPUT_POST, 'nome');
            $telefone = filter_input(INPUT_POST, 'telefone');
            $email = filter_input(INPUT_POST, 'email');

            if(!empty($nome) && !empty($telefone) && !empty($email)){
                if($p->cadastrarPessoa($nome, $telefone, $email)){
                    echo "Cadastrada com sucesso!";
                }
                else{
                    echo "E-mail já cadastrado";
                }
            }
            else
            {
                echo "Preencha todos os campos!";
            }
            }
        }
    ?>

    <?php
        if(isset($_GET['id_up'])){
            $id = filter_input(INPUT_GET, 'id_up');
            $res = $p->buscarPessoa($id);
        }
    ?>

    <section id="esquerda">
        <form method="POST">
            <h2>Cadastrar Pessoa</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php if(isset($res)){ echo $res['nome']; }?>">
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone" value="<?php if(isset($res)){ echo $res['telefone']; }?>">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" value="<?php if(isset($res)){ echo $res['email']; }?>">
            <input type="submit" name="btn-cadastrar" value="<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";} ?>">
            
        </form>
    </section>

    <section id="direita">
        <table>
            <tr id="titulo">
                <td>Nome</td>
                <td>Telefone</td>
                <td colspan=2>E-mail</td>
            </tr>
            <?php $dados = $p->buscarDados();
            foreach ($dados as $item): ?>
            <tr>
                <td><?= $item['nome']; ?></td>
                <td><?= $item['telefone']; ?></td>
                <td><?= $item['email']; ?></td>
                <td>
                    <a href="index.php?id_up=<?= $item['id']; ?>">Editar</a>
                    <a href="index.php?id_del=<?= $item['id']; ?>">Excluir</a></td>
            </tr>
            <?php endforeach; ?>
            <?php
                if(isset($_GET['id_del'])){
                    $id = filter_input(INPUT_GET, 'id_del');
                    $p->excluirPessoa($id);
                    header('Location:index.php');
                }
            ?>    
        </table>
    </section>
</body>
</html>