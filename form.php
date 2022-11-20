<?php
require_once 'class.php';
$n = new pessoa("agenda", "localhost", "3307", "root", "");

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendinha TOP</title>
    <style>
        body {
            background-color: black;
            color: white;
        }

        .main {
            width: 100%;
        }

        .left {
            width: 30%;
            margin-left: 90px;
        }

        .right {
            position: relative;
            margin-left: 600px;
            bottom: 230px;
            font-size: 18px;
        }

        .l1 {
            background-color: blue;
            border-color: blue;
        }

        td {
            padding: 0px 5px;

        }

        a {
            padding: 1px 5px;
            text-decoration: none;
            background-color: cyan;
            color: darkblue;
        }
    </style>
</head>

<body>


    <h1 style="text-align: center; background-color: cyan; color: darkblue; padding: 10px 0px;">Trabalho da Agenda</h1>

    <?php

    if (isset($_POST['nome'])) {

        if (isset($_GET['id_up']) && !empty($_GET['id_up'])) {
            $id_update = addslashes($_GET['id_up']);
            $nome = addslashes($_POST['nome']);
            $sexo = addslashes($_POST['sexo']);
            $nasc = addslashes($_POST['nasc']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);

            $n->atualizarDados($id_update, $nome, $sexo, $nasc, $telefone, $email);
            header("location: form.php");
                
        } else {
            $nome = addslashes($_POST['nome']);
            $sexo = addslashes($_POST['sexo']);
            $nasc = addslashes($_POST['nasc']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);

            if (!$n->cadastrarPessoa( $nome, $sexo, $nasc, $telefone, $email)) {
                echo "Email já está cadastrado";
            }
        }
    }

    ?>

    <?php
    if (isset($_GET['id_up'])) {
        $id_update = addslashes($_GET['id_up']);
        $list = $n->buscarDadosPessoa($id_update);
    }


    ?>



    <div class="main">
        <div class="left">
            <fieldset>
                <legend>Adicionar contatos</legend>
                <form action="" method="POST">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="<?php if (isset($list)) {
                                                                echo $list['ds_nome'];
                                                            } ?>" required>
                    <br><br>
                    <label for="sexo">Sexo:</label>
                    <Input type="radio" name="sexo" value="M" required>
                    <label for="sexo">Masculino</label>
                    <Input type="radio" name="sexo" value="F" required>
                    <label for="sexo">Feminino</label>
                    <Input type="radio" name="sexo" value="PNI" required>
                    <label for="sexo">Prefiro não informar</label>
                    <br><br>
                    <label for="nasc">Data de Nascimento:</label>
                    <input type="date" name="nasc" value="<?php if (isset($list)) {
                                                                echo $list['dt_nasc'];
                                                            } ?>" required>
                    <br><br>
                    <label for="telefone">Telefone:</label>
                    <input type="number" name="telefone" value="<?php if (isset($list)) {
                                                                    echo $list['nr_telefone'];
                                                                } ?>" required>
                    <br><br>
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" value="<?php if (isset($list)) {
                                                                echo $list['ds_email'];
                                                            } ?>" required>
                    <br><br><br>
                    <input type="submit" value="<?php if (isset($list)) {
                                                    echo "Atualizar";
                                                } else {
                                                    echo "adicionar";
                                                } ?>" name="enviar">
                </form>
            </fieldset>
        </div>
        <div class="right">
            <table>
                <tr>
                    <td colspan="5" class="l1">Nome:</td>
                    <td class="l1">Sexo:</td>
                    <td class="l1">Data de Nasc:</td>
                    <td class="l1">Telefone:</td>
                    <td colspan="5" class="l1">E-mail:</td>
                </tr>


                <?php
                $dados = $n->buscarDados();
                if (count($dados) > 0) {
                    for ($i = 0; $i < count($dados); $i++) {

                        echo "<tr>";
                        foreach ($dados[$i] as $k => $v) {
                            if ($k != "id") {

                                echo "<td>" . $v . "<td>";
                            }
                        }
                ?> <td><a href="form.php?id_up=<?php echo $dados[$i]['id_pessoa']; ?>">Editar</a>
                            <a href="form.php?id=<?php echo $dados[$i]['id_pessoa']; ?>">Excluir</a>
                        </td><?php
                                echo "</tr>";
                            }
                        } else {
                            echo "Ainda não há contatos cadastrados";
                        }
                                ?>
            </table>

        </div>
    </div>


</body>

</html>


<?php
if (isset($_GET['id'])) {
    $id_pessoa = addslashes($_GET['id']);
    $n->excluirPessoa($id_pessoa);
    header("location: form.php");
}
?>