<?php

require_once 'conexao.php';
require_once 'dados.model.php';
require_once 'dados.service.php';

$formulario = null;

if (isset($_GET['cpf']) && !empty($_GET['cpf'])) {
    $cpf = $_GET['cpf']; 

    $conexao = new Conexao();
    $dadosService = new DadosService($conexao);

    $formulario = $dadosService->buscarPorCpf($cpf);
}

if (!$formulario) {
    header("Location: formularios_existentes.php?status=notfound");
    exit();
}

$historico_familiar = json_decode($formulario['historico_familiar'] ?? '[]', true);
$historico_pessoal = json_decode($formulario['historico_pessoal'] ?? '[]', true);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Formulário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="forms-page-body">
    <div class="container mt-5">
        <div class="header">
            <h1 class="text-center mb-4"><i class="bi bi-clipboard-data me-2"></i> Detalhes do Formulário</h1>
            <p class="text-center lead">Visualizando o formulário de exame admissional.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10 col-12">
                <div class="card shadow-sm mb-4 p-4">
                    <h2 class="mb-4">Dados Pessoais</h2>
                    <p><strong>Nome Completo:</strong> <?php echo htmlspecialchars($formulario['nome'] . " " . $formulario['sobrenome']); ?></p>
                    <p><strong>CPF:</strong> <?php echo htmlspecialchars($formulario['cpf']); ?></p>
                    <p><strong>Gênero:</strong> <?php echo htmlspecialchars($formulario['genero']); ?></p>
                    <p><strong>Data de Nascimento:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($formulario['data_nascimento']))); ?></p>
                    <p><strong>Cargo:</strong> <?php echo htmlspecialchars($formulario['cargo']); ?></p>

                    <hr>

                    <h2 class="mb-4">Hábitos e Atividades</h2>
                    <p><strong>Frequência de Exercícios:</strong> <?php echo htmlspecialchars($formulario['frequencia_exercicio'] ?? 'Não informado'); ?></p>
                    <p><strong>Hobbies:</strong> <?php echo htmlspecialchars($formulario['hobbies'] ?? 'Não informado'); ?></p>
                    <p><strong>Já fez alguma atividade laborativa?</strong> <?php echo htmlspecialchars($formulario['atividade_laborativa'] ?? 'Não informado'); ?></p>
                    <?php if (isset($formulario['atividade_laborativa']) && $formulario['atividade_laborativa'] === 'Sim' && !empty($formulario['descreva_atividade'])): ?>
                        <p><strong>Descrição da Atividade Laborativa:</strong> <?php echo htmlspecialchars($formulario['descreva_atividade']); ?></p>
                    <?php endif; ?>

                    <hr>

                    <h2 class="mb-4">Histórico de Saúde</h2>
                    <p><strong>Histórico Familiar:</strong>
                        <?php echo empty($historico_familiar) ? 'Nenhum' : htmlspecialchars(implode(', ', $historico_familiar)); ?>
                    </p>
                    <p><strong>Histórico Pessoal:</strong>
                        <?php echo empty($historico_pessoal) ? 'Nenhum' : htmlspecialchars(implode(', ', $historico_pessoal)); ?>
                    </p>

                    <hr>

                    <h2 class="mb-4">Antecedentes Médicos</h2>
                    <p><strong>Alergias:</strong> <?php echo htmlspecialchars($formulario['alergias'] ?? 'Nenhuma'); ?></p>
                    <p><strong>Cirurgias:</strong> <?php echo htmlspecialchars($formulario['cirurgias'] ?? 'Nenhuma'); ?></p>
                    <p><strong>Medicamentos Contínuos:</strong> <?php echo htmlspecialchars($formulario['medicamentos_continuos'] ?? 'Nenhum'); ?></p>
                    <p><strong>Tipo Sanguíneo:</strong> <?php echo htmlspecialchars($formulario['tipo_sanguineo'] ?? 'Não informado'); ?></p>
                    <p><strong>É doador de sangue?</strong> <?php echo htmlspecialchars(isset($formulario['doador_sangue']) && $formulario['doador_sangue'] === 'sim' ? 'Sim' : 'Não'); ?></p>

                    <hr>

                    <h2 class="mb-4">Hábitos</h2>
                    <p><strong>Consumo de Álcool:</strong> <?php echo htmlspecialchars($formulario['consumo_alcool'] ?? 'Não informado'); ?></p>
                    <p><strong>Tabagismo:</strong> <?php echo htmlspecialchars($formulario['tabagismo'] ?? 'Não informado'); ?></p>
                    <p><strong>Uso de Drogas:</strong> <?php echo htmlspecialchars($formulario['consumo_drogas'] ?? 'Não informado'); ?></p>
                    <p><strong>É PCD?</strong> <?php echo htmlspecialchars(isset($formulario['pcd']) && $formulario['pcd'] === 'sim' ? 'Sim' : 'Não'); ?></p>
                    <?php if (isset($formulario['pcd']) && $formulario['pcd'] === 'sim' && !empty($formulario['desc_pcd'])): ?>
                        <p><strong>Descrição da Deficiência:</strong> <?php echo htmlspecialchars($formulario['desc_pcd']); ?></p>
                    <?php endif; ?>

                    <?php
                    $genero = $formulario['genero'] ?? '';
                    if (($genero === 'Mulher cis' || $genero === 'Homem trans' || $genero === 'Não binário') && isset($formulario['gestacao'])):
                    ?>
                        <hr>
                        <h2 class="mb-4">Histórico Gestacional</h2>
                        <p><strong>Teve gestações?</strong> <?php echo htmlspecialchars($formulario['gestacao'] === 'sim' ? 'Sim' : 'Não'); ?></p>
                        <?php if ($formulario['gestacao'] === 'sim'): ?>
                            <p><strong>Quantidade de Gestações:</strong> <?php echo htmlspecialchars($formulario['quantidade_gestacoes'] ?? 'Não informado'); ?></p>
                            <p><strong>Teve cesárea?</strong> <?php echo htmlspecialchars(isset($formulario['cesarea']) && $formulario['cesarea'] === 'sim' ? 'Sim' : 'Não'); ?></p>
                            <?php if (isset($formulario['cesarea']) && $formulario['cesarea'] === 'sim'): ?>
                                <p><strong>Quantidade de Cesáreas:</strong> <?php echo htmlspecialchars($formulario['quantidade_cesarea'] ?? 'Não informado'); ?></p>
                            <?php endif; ?>
                            <p><strong>Teve parto normal?</strong> <?php echo htmlspecialchars(isset($formulario['parto_normal']) && $formulario['parto_normal'] === 'sim' ? 'Sim' : 'Não'); ?></p>
                            <?php if (isset($formulario['parto_normal']) && $formulario['parto_normal'] === 'sim'): ?>
                                <p><strong>Quantidade de Partos Normais:</strong> <?php echo htmlspecialchars($formulario['quantidade_parto_normal'] ?? 'Não informado'); ?></p>
                            <?php endif; ?>
                            <p><strong>Intercorrências Gestacionais:</strong> <?php echo htmlspecialchars($formulario['intercorrencias_gestacionais'] ?? 'Nenhuma'); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="formularios_existentes.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>