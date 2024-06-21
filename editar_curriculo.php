<?php
session_start(); 


$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "curriculos"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        
        $id = $_POST['id'];
        $sql = "DELETE FROM curriculos WHERE id = $id";
        
        if ($conn->query($sql) === TRUE) {
            echo "Currículo deletado com sucesso!";
            header("Location: index.html"); 
            exit();
        } else {
            echo "Erro ao deletar o currículo: " . $conn->error;
        }
    } else {
        
        $id = $_POST['id'];
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

        $sql = "UPDATE curriculos SET 
                nome = '$nome', 
                email = '$email', 
                telefone = '$telefone', 
                endereco = '$endereco', 
                formacao = '$formacao', 
                experiencia = '$experiencia'
                WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "Currículo atualizado com sucesso!";
        } else {
            echo "Erro ao atualizar o currículo no banco de dados: " . $conn->error;
        }
    }
} else {
    
    $sql = "SELECT * FROM curriculos ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        $row = $result->fetch_assoc();

        $id = $row['id'];
        $nome = $row['nome'];
        $email = $row['email'];
        $telefone = $row['telefone'];
        $endereco = $row['endereco'];
        $formacao = $row['formacao'];
        $experiencia = $row['experiencia'];
    } else {
        echo "Nenhum currículo encontrado.";
        $conn->close();
        exit();
    }
}

$conn->close();
?>
            
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Currículo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .form-group .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group .btn:hover {
            background-color: #45a049;
        }
        .form-group .btn-delete {
            background-color: #f44336;
        }
        .form-group .btn-delete:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Currículo</h2>
        <form action="editar_curriculo.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" value="<?php echo htmlspecialchars($endereco); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="formacao">Formação:</label>
                <textarea id="formacao" name="formacao" required><?php echo htmlspecialchars($formacao); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="experiencia">Experiência:</label>
                <textarea id="experiencia" name="experiencia" required><?php echo htmlspecialchars($experiencia); ?></textarea>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn">Atualizar Currículo</button>
                <a href="index.html" class="btn" style="background-color: #ccc;">Cancelar</a>
            </div>
        </form>
        <form action="editar_curriculo.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este currículo?');">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="delete" value="1">
            <div class="form-group">
                <button type="submit" class="btn btn-delete">Excluir Currículo</button>
            </div>
        </form>
    </div>
</body>
</html>
