<?php
require_once 'inc/conexao.php';

try {
    // Verificar se a tabela tbUsuarios existe e tem dados
    $sql = "SELECT COUNT(*) as total FROM tbUsuarios";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "Total de usuários: " . $count['total'] . "<br>";

    // Mostrar estrutura da tabela
    $sql = "DESCRIBE tbUsuarios";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Estrutura da tabela tbUsuarios:</h3>";
    foreach ($columns as $column) {
        echo $column['Field'] . " - " . $column['Type'] . "<br>";
    }

    // Mostrar alguns usuários (sem senha)
    echo "<h3>Usuários cadastrados:</h3>";
    $sql = "SELECT usuario_id, nome, login FROM tbUsuarios LIMIT 5";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        echo "ID: " . $user['usuario_id'] . " - Nome: " . $user['nome'] . " - Login: " . $user['login'] . "<br>";
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
