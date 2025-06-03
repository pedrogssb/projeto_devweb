<?php

require_once 'conexao.php';
require_once 'dados.model.php'; 
require_once 'dados.service.php';

$conexao = new Conexao();
$dadosService = new DadosService($conexao);

$search_cpf = $_GET['search_cpf'] ?? '';
$cpf_limpo_para_busca = str_replace(['.', '-'], '', $search_cpf);


$formularios = $dadosService->listar($cpf_limpo_para_busca);

$status_message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $status_message = '<div class="alert alert-success" role="alert">Formulário salvo com sucesso!</div>';
    } elseif ($_GET['status'] == 'error') {
        $status_message = '<div class="alert alert-danger" role="alert">Erro ao salvar formulário. Por favor, tente novamente.</div>';
    } elseif ($_GET['status'] == 'notfound') {
        $status_message = '<div class="alert alert-warning" role="alert">Formulário não encontrado.</div>';
    } elseif ($_GET['status'] == 'success_delete') {
        $status_message = '<div class="alert alert-success" role="alert">Formulário excluído com sucesso!</div>';
    } elseif ($_GET['status'] == 'error_delete') {
        $status_message = '<div class="alert alert-danger" role="alert">Erro ao excluir formulário. Por favor, tente novamente.</div>';
    } elseif ($_GET['status'] == 'success_update') {
        $status_message = '<div class="alert alert-success" role="alert">Formulário atualizado com sucesso!</div>';
    } elseif ($_GET['status'] == 'error_update') {
        $status_message = '<div class="alert alert-danger" role="alert">Erro ao atualizar formulário. Por favor, tente novamente.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulários Existentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/formularios-existentes.css">
</head>
<body class="forms-page-body">
    <div class="container mt-5">
        <div class="header-forms">
            <h1 class="text-center mb-4"><i class="bi bi-folder-check me-2"></i> Formulários Criados</h1>
            <p class="text-center lead">Aqui você pode visualizar e gerenciar os formulários de exame admissional.</p>
            <div class="d-flex justify-content-center mt-4">
                <a href="index.html" class="btn btn-outline-light me-2">
                    <i class="bi bi-plus-circle"></i> Criar Novo Formulário
                </a>
                <a href="login.html" class="btn btn-light">
                    <i class="bi bi-box-arrow-right"></i> Sair
                </a>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-lg-10 col-12">
                <?php echo $status_message; ?>

                <form class="d-flex mb-4" method="GET" action="formularios_existentes.php">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Buscar por CPF" aria-label="Buscar por CPF" name="search_cpf" id="search_cpf" value="<?php echo htmlspecialchars($search_cpf); ?>">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i> Buscar</button>
                    </div>
                </form>

                <?php if (!empty($formularios)): ?>
                    <?php foreach ($formularios as $formulario): ?>
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-person me-2"></i> Formulário de <?php echo htmlspecialchars($formulario['nome'] . " " . $formulario['sobrenome']); ?></h5>
                                <p class="card-text"><strong>CPF:</strong> <?php echo htmlspecialchars($formulario['cpf']); ?></p>
                                <p class="card-text"><strong>Cargo:</strong> <?php echo htmlspecialchars($formulario['cargo']); ?></p>
                                <p class="card-text"><strong>Data de Criação:</strong> <?php echo date('d/m/Y H:i', strtotime($formulario['data_criacao'])); ?></p>
                                <div class="d-flex justify-content-end">
                                    <a href="visualizar_formulario.php?cpf=<?php echo urlencode($formulario['cpf']); ?>" class="btn btn-info btn-sm me-2"><i class="bi bi-eye"></i> Visualizar</a>
                                    <a href="excluir_formulario.php?id=<?php echo $formulario['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este formulário?');"><i class="bi bi-trash"></i> Excluir</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted mt-5">Nenhum formulário encontrado.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search_cpf').mask('000.000.000-00');
        });
    </script>
</body>
</html>