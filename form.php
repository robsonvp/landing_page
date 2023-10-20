<?php
// Valida os dados do formulário

// Função para formatar o número de telefone no formato brasileiro
function formatPhoneNumber($phoneNumber) {
    $phoneNumber = preg_replace("/[^0-9]/", "", $phoneNumber);
    $length = strlen($phoneNumber);
    
    if ($length == 11) {
        return "+55 " . substr($phoneNumber, 0, 2) . " " . substr($phoneNumber, 2, 5) . " " . substr($phoneNumber, 7);
    } elseif ($length == 10) {
        return "+55 " . substr($phoneNumber, 0, 2) . " " . substr($phoneNumber, 2, 4) . " " . substr($phoneNumber, 6);
    }
    
    return false; // Retorna falso se o número não for válido
}

// Verifica se o nome está preenchido
if (empty($_POST['nome'])) {
    echo "O campo 'Nome' é obrigatório.";
}

// Verifica se o e-mail está preenchido e é válido
elseif (empty($_POST['email'])) {
    echo "O campo 'E-mail' é obrigatório.";
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "O e-mail informado não é válido.";
}

// Verifica se o telefone está preenchido e é válido
elseif (empty($_POST['telefone'])) {
    echo "O campo 'Telefone' é obrigatório.";
} elseif (($formattedPhone = formatPhoneNumber($_POST['telefone'])) === false) {
    echo "O telefone informado não é válido.";
}

// Verifica se a mensagem está preenchida e tem pelo menos 10 caracteres
elseif (empty($_POST['mensagem'])) {
    echo "O campo 'Mensagem' é obrigatório e deve ter pelo menos 10 caracteres.";
} elseif (strlen($_POST['mensagem']) < 10) {
    echo "A mensagem deve ter pelo menos 10 caracteres.";
} else {
    // Conecta-se ao banco de dados
    $conn = new mysqli("localhost", "root", "", "formulario");

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Insira os dados no banco de dados (incluindo o número de telefone formatado)
    $sql = "INSERT INTO formulario (nome, email, telefone, mensagem) VALUES ('" . $_POST['nome'] . "', '" . $_POST['email'] . "', '" . $formattedPhone . "', '" . $_POST['mensagem'] . "')";

    // Execute o comando SQL
    if ($conn->query($sql) === TRUE) {
        echo "Os dados foram inseridos com sucesso!";
    } else {
        echo "Erro ao inserir os dados: " . $conn->error;
    }

    // Feche a conexão com o banco de dados
    $conn->close();
}
?>
