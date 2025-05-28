<?php
include_once 'inc/funcoes.php';
require_once 'inc/conexao.php';

$retorno = 0;

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $vLogin = $_POST["username"] ?? '';
        $vSenha = $_POST["password"] ?? '';

        if (empty($vLogin) || empty($vSenha)) {
            echo "0";
            exit;
        }

        $sql = "SELECT usuario_id, login, senha FROM tbUsuarios WHERE login = '$vLogin'";
        salvar_log($sql, 'validar');

        $stmt = $conn->prepare("SELECT usuario_id, login, senha FROM tbUsuarios WHERE login = :login");
        $stmt->bindParam(":login", $vLogin);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($vSenha, $user['senha'])) {
            $_SESSION["loggedin"] = true;
            $_SESSION["usuario_id"] = $user['usuario_id'];
            $retorno = 1;
        } else {
            $retorno = 0;
        }

        echo $retorno;
    } else {
        echo "0";
    }
} catch (Exception $e) {
    echo "0";
}
