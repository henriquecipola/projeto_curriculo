<?php
session_start(); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $formacao = $_POST['formacao'] ?? '';
    $experiencia = $_POST['experiencia'] ?? '';

    
    $_SESSION['curriculo'] = [
        'nome' => $nome,
        'email' => $email,
        'telefone' => $telefone,
        'endereco' => $endereco,
        'formacao' => $formacao,
        'experiencia' => $experiencia
    ];

    
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "Curriculos"; 

    
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    
    $sql = "INSERT INTO curriculos (nome, email, telefone, endereco, formacao, experiencia)
            VALUES ('$nome', '$email', '$telefone', '$endereco', '$formacao', '$experiencia')";

    if ($conn->query($sql) === TRUE) {
        echo "Currículo gerado e salvo no banco de dados com sucesso!";
    } else {
        echo "Erro ao salvar o currículo no banco de dados: " . $conn->error;
    }

    
    $conn->close();

    
    echo "<!DOCTYPE html>
          <html lang='pt-BR'>
          <head>
              <meta charset='UTF-8'>
              <title>Currículo de $nome</title>
              <link rel='stylesheet' href='styles.css'>
          </head>
          <body>
              <div class='container'>
                  <h1>Currículo de $nome</h1>
                  <p><strong>Email:</strong> $email</p>
                  <p><strong>Telefone:</strong> $telefone</p>
                  <p><strong>Endereço:</strong> $endereco</p>
                  <h2>Formação Acadêmica</h2>
                  <p>$formacao</p>
                  <h2>Experiência Profissional</h2>
                  <p>$experiencia</p>
                  <button onclick='window.location.href=\"index.html\"'>Novo Currículo</button>
                  <button onclick='window.location.href=\"editar_curriculo.php?id=<?\"'>Editar Currículo</button>
                   
              </div>
          </body>
          </html>";
} else {
    
    echo "<!DOCTYPE html>
          <html lang='pt-BR'>
          <head>
              <meta charset='UTF-8'>
              <title>Gerador de Currículo</title>
              <link rel='stylesheet' href='styles.css'>
          </head>
          <body>
              <div class='container'>
                  <h1>Gerador de Currículo</h1>
                  <form action='index.php' method='post'>
                      <div class='form-group'>
                          <label for='nome'>Nome:</label>
                          <input type='text' id='nome' name='nome' required>
                      </div>
                      <div class='form-group'>
                          <label for='email'>Email:</label>
                          <input type='email' id='email' name='email' required>
                      </div>
                      <div class='form-group'>
                          <label for='telefone'>Telefone:</label>
                          <input type='tel' id='telefone' name='telefone'>
                      </div>
                      <div class='form-group'>
                          <label for='endereco'>Endereço:</label>
                          <input type='text' id='endereco' name='endereco'>
                      </div>
                      <div class='form-group'>
                          <label for='formacao'>Formação Acadêmica:</label>
                          <textarea id='formacao' name='formacao' rows='4'></textarea>
                      </div>
                      <div class='form-group'>
                          <label for='experiencia'>Experiência Profissional:</label>
                          <textarea id='experiencia' name='experiencia' rows='4'></textarea>
                      </div>
                      <button type='submit'>Gerar Currículo</button>
                  </form>
              </div>
          </body>
          </html>";
}
?>
