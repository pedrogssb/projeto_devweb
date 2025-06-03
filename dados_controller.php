<?php

header('Content-Type: application/json');

require "dados.model.php";
require "dados.service.php";
require "conexao.php";

$response = [
    'success' => false,
    'message' => 'Método de requisição inválido.' 
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexao = new Conexao();

    // --- Dados Pessoais ---
    $dadosPessoais = new DadosPessoais();
    $dadosPessoais->__set('nome', $_POST['nome'] ?? '');

    $cpf_com_mascara = $_POST['cpf'] ?? '';
    $cpf_sem_mascara = str_replace(['.', '-'], '', $cpf_com_mascara);
    $dadosPessoais->__set('cpf', $cpf_sem_mascara); 

    $dadosPessoais->__set('genero', $_POST['genero'] ?? '');
    $dadosPessoais->__set('dataNascimento', $_POST['dataNascimento'] ?? '');
    $dadosPessoais->__set('cargo', $_POST['cargo'] ?? '');
    $dadosPessoais->__set('sobrenome', $_POST['sobrenome'] ?? '');

    // --- Hábitos e Atividades ---
    $habitosAtividades = new HabitosAtividades();
    $habitosAtividades->__set('frequenciaExercicio', $_POST['frequenciaExercicio'] ?? null);
    $habitosAtividades->__set('hobbies', $_POST['hobbies'] ?? null);
    $habitosAtividades->__set('atividadeLaborativa', $_POST['atividadeLaborativa'] ?? 'nao');
    $habitosAtividades->__set('descricaoAtividade', $_POST['descricaoAtividade'] ?? null);

    // --- Histórico de Saúde ---
    $historicoSaude = new HistoricoSaude();
    
    // Histórico Familiar: Coleta os dados e serializa para JSON
    $historicoFamiliarArray = $_POST['historicoFamiliar'] ?? [];
    if (isset($_POST['outrasMolestiasFamiliaDesc']) && !empty($_POST['outrasMolestiasFamiliaDesc'])) {
        $historicoFamiliarArray[] = "Outros: " . $_POST['outrasMolestiasFamiliaDesc'];
    }
    $historicoSaude->__set('historicoFamiliar', json_encode($historicoFamiliarArray));

    // Histórico Pessoal: Coleta os dados e serializa para JSON
    $historicoPessoalArray = $_POST['historicoPessoal'] ?? [];
    if (isset($_POST['outrasMolestiasPessoalDesc']) && !empty($_POST['outrasMolestiasPessoalDesc'])) {
        $historicoPessoalArray[] = "Outros: " . $_POST['outrasMolestiasPessoalDesc'];
    }
    $historicoSaude->__set('historicoPessoal', json_encode($historicoPessoalArray));

    // --- Antecedentes Médicos ---
    $antecedentesMedicos = new AntecedentesMedicos();
    $antecedentesMedicos->__set('alergias', $_POST['alergias'] ?? null);
    $antecedentesMedicos->__set('cirurgias', $_POST['cirurgias'] ?? null);
    $antecedentesMedicos->__set('medicamentosContinuos', $_POST['medicamentosContinuos'] ?? null);
    $antecedentesMedicos->__set('tipoSanguineo', $_POST['tipoSanguineo'] ?? null);
    $antecedentesMedicos->__set('doadorSangue', $_POST['doadorSangue'] ?? 'nao');

    // --- Hábitos (Álcool, Drogas, Tabagismo, PCD) ---
    $habitos = new Habitos();
    $habitos->__set('bebidaAlcoolica', $_POST['bebidaAlcoolica'] ?? null);
    $habitos->__set('usoDrogas', $_POST['usoDrogas'] ?? null);
    $habitos->__set('tabagismo', $_POST['tabagismo'] ?? null);
    $habitos->__set('pcd', $_POST['pcd'] ?? 'nao');
    $habitos->__set('descPCD', $_POST['descPCD'] ?? null);

    // --- Gestações (Condicional) ---
    $gestacoes = null;
    $generoSelecionado = $_POST['genero'] ?? '';
    if ($generoSelecionado === 'Mulher cis' || $generoSelecionado === 'Homem trans' || $generoSelecionado === 'Não binário') {
        if (isset($_POST['gestacao']) && $_POST['gestacao'] === 'sim') {
            $gestacoes = new Gestacoes();
            $gestacoes->__set('gestacao', $_POST['gestacao']);
            $gestacoes->__set('quantidadeGestacoes', $_POST['quantidadeGestacoes'] ?? null);
            $gestacoes->__set('cesarea', $_POST['cesarea'] ?? 'nao');
            $gestacoes->__set('quantidadeCesarea', $_POST['quantidadeCesarea'] ?? null);
            $gestacoes->__set('partoNormal', $_POST['partoNormal'] ?? 'nao');
            $gestacoes->__set('quantidadePartoNormal', $_POST['quantidadePartoNormal'] ?? null);
            $gestacoes->__set('intercorrenciasGestacionais', $_POST['intercorrenciasGestacionais'] ?? null);
        }
    }

    $dadosService = new DadosService(
        $conexao, $dadosPessoais, $habitosAtividades,
        $historicoSaude, $antecedentesMedicos, $habitos, $gestacoes
    );

    if ($dadosService->inserir()) {
        $response['success'] = true;
        $response['message'] = 'Dados salvos com sucesso!';
    } else {
        $response['message'] = 'Erro ao salvar os dados. Por favor, tente novamente.';
    }
}

echo json_encode($response);
exit();
?>