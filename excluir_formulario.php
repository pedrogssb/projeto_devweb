<?php

require_once 'conexao.php';
require_once 'dados.model.php';
require_once 'dados.service.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id']; 

    try {
        $conexao = new Conexao();

        $dadosService = new DadosService($conexao);

        $sucesso = $dadosService->remover($id);

        if ($sucesso) {
            header('Location: formularios_existentes.php?status=success_delete');
            exit();
        } else {
            header('Location: formularios_existentes.php?status=error_delete');
            exit();
        }
    } catch (PDOException $e) {
        error_log("Erro no script excluir_formulario.php: " . $e->getMessage());
        header('Location: formularios_existentes.php?status=error_delete');
        exit();
    }
} else {
    header('Location: formularios_existentes.php?status=notfound');
    exit();
}

?>