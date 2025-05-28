<?php
require_once 'inc/conexao.php';

try {
    // Criar um usuário de teste se não existir
    $login = 'admin';
    $senha = 'admin123';
    $nome = 'Administrador';

    // Verificar se já existe
    $sql = "SELECT COUNT(*) as count FROM tbUsuarios WHERE login = :login";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] == 0) {
        // Criar usuário
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO tbUsuarios (nome, login, senha) VALUES (:nome, :login, :senha)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', $senhaHash);

        if ($stmt->execute()) {
            echo "Usuário de teste criado com sucesso!<br>";
            echo "Login: admin<br>";
            echo "Senha: admin123<br>";
        } else {
            echo "Erro ao criar usuário de teste.<br>";
        }
    } else {
        echo "Usuário 'admin' já existe.<br>";
    }

    // Verificar hash da senha
    $sql = "SELECT senha FROM tbUsuarios WHERE login = :login";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "Hash da senha no banco: " . substr($user['senha'], 0, 50) . "...<br>";
        echo "Verificação da senha 'admin123': " . (password_verify('admin123', $user['senha']) ? 'OK' : 'FALHOU') . "<br>";
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
