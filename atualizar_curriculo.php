<?php
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['id'], $_POST['nome'], $_POST['email'], $_POST['telefone'], $_POST['endereco'], $_POST['formacao'], $_POST['experiencia'])) {
        
        $id = $_POST['id'];
        $nome = limpar_dados($_POST['nome']);
        $email = limpar_dados($_POST['email']);
        $telefone = limpar_dados($_POST['telefone']);
        $endereco = limpar_dados($_POST['endereco']);
        $formacao = limpar_dados($_POST['formacao']);
        $experiencia = limpar_dados($_POST['experiencia']);

        $servername = "localhost"; 
        $username = "root"; 
        $password = ""; 
        $dbname = "curriculos"; 

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        $id = $conn->real_escape_string($id);
        $nome = $conn->real_escape_string($nome);
        $email = $conn->real_escape_string($email);
        $telefone = $conn->real_escape_string($telefone);
        $endereco = $conn->real_escape_string($endereco);
        $formacao = $conn->real_escape_string($formacao);
        $experiencia = $conn->real_escape_string($experiencia);

        $sql = "UPDATE curriculos SET nome='$nome', email='$email', telefone='$telefone', endereco='$endereco', formacao='$formacao', experiencia='$experiencia' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Currículo atualizado com sucesso";
        } else {
            echo "Erro ao atualizar o currículo: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Erro ao processar os dados do formulário. Algum campo está faltando.";
    }
} else {

    header("Location: index.php");
    exit();
}

function limpar_dados($dados) {

    $dados = trim($dados);
    $dados = str_replace(array("\r", "\n"), '', $dados);
    return $dados;
}
?>
