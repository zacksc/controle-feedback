<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (function_exists('alert')==false)
{
    function alert($msg)
    {
        echo "<script language='JavaScript'>";
        echo "alert('$msg');";
        echo "</script>";
    }
}

if (function_exists('salvar_log')==false)
{
    function salvar_log($sql, $operacao = 'geral')    
    {
        $timestamp = date('Y-m-d H:i:s');
        $user_ip = $_SERVER['REMOTE_ADDR'] ?? 'localhost';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'N/A';
        
        // Define o arquivo baseado no tipo de operação
        $arquivo_nome = '';
        switch(strtolower($operacao)) {
            case 'validar':
            case 'login':
            case 'autenticacao':
                $arquivo_nome = 'validar.sql';
                break;
            case 'inserir':
            case 'insert':
            case 'cadastrar':
            case 'salvar':
                $arquivo_nome = 'inserir.sql';
                break;
            case 'editar':
            case 'update':
            case 'alterar':
                $arquivo_nome = 'editar.sql';
                break;
            case 'excluir':
            case 'delete':
            case 'remover':
                $arquivo_nome = 'excluir.sql';
                break;
            default:
                $arquivo_nome = 'geral.sql';
                break;
        }
        
        $caminho_arquivo = $_SERVER['DOCUMENT_ROOT'].'/controle-feedback/logs/'.$arquivo_nome;
        $log_entry = "-- [{$timestamp}] IP: {$user_ip} | User-Agent: " . substr($user_agent, 0, 100) . PHP_EOL;
        $log_entry .= $sql . PHP_EOL . PHP_EOL;
        
        $file = fopen($caminho_arquivo, 'a+');
        if ($file) {
            fwrite($file, $log_entry);
            fclose($file);
        }
    }
}
?>
