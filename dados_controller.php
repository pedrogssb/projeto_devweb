<?php 

    require "dados.model.php";
    require "dados.service.php";
    require "conexao.php";

    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    $dadosPessoais = new DadosPessoais();
    $dadosPessoais->__set('nome', $_POST['nome']);
    $dadosPessoais->__set('cpf', $_POST['cpf']);
    $dadosPessoais->__set('genero', $_POST['genero']);
    $dadosPessoais->__set('dataNascimento', $_POST['dataNascimento']);
    $dadosPessoais->__set('cargo', $_POST['cargo']);
    $dadosPessoais->__set('sobrenome', $_POST['sobrenome']);

    $habitosAtividades = new HabitosAtividades();
    $habitosAtividades->__set('frequenciaExercicio', $_POST['frequenciaExercicio']);
    $habitosAtividades->__set('hobbies', $_POST['hobbies']);
    $habitosAtividades->__set('atividadeLaborativa', $_POST['atividadeLaborativa']);
    $habitosAtividades->__set('descricaoAtividade', $_POST['descricaoAtividade']);

    $historicoSaude = new HistoricoSaude();
    $historicoSaude->__set('historicoFamiliar', $_POST['historicoFamiliar']);
    $historicoSaude->__set('historicoPessoal', $_POST['historicoPessoal']);

    $antecedentesMedicos = new AntecedentesMedicos();
    $antecedentesMedicos->__set('alergias', $_POST['alergias']);
    $antecedentesMedicos->__set('cirurgias', $_POST['cirurgias']);
    $antecedentesMedicos->__set('medicamentosContinuos', $_POST['medicamentosContinuos']);
    $antecedentesMedicos->__set('tipoSanguineo', $_POST['tipoSanguineo']);
    $antecedentesMedicos->__set('doadorSangue', $_POST['doadorSangue']);

    $habitos = new Habitos();
    $habitos->__set('bebidaAlcoolica', $_POST['bebidaAlcoolica']);
    $habitos->__set('usoDrogas', $_POST['usoDrogas']);
    $habitos->__set('tabagismo', $_POST['tabagismo']);
    $habitos->__set('descPCD', $_POST['descPCD']);

    $gestacoes = new Gestacoes();
    $gestacoes->__set('quantidadeGestacoes', $_POST['quantidadeGestacoes']);
    $gestacoes->__set('quantidadeCesarea', $_POST['quantidadeCesarea']);
    $gestacoes->__set('quantidadePartoNormal', $_POST['quantidadePartoNormal']);

    $conexao = new Conexao();
    $dadosService = new DadosService(
        $conexao, $dadosPessoais, $habitosAtividades, 
        $historicoSaude, $antecedentesMedicos, $habitos, $gestacoes
    );
    $dadosService->inserir();

    echo '<pre>';
    print_r($dadosService);
    echo '</pre>';
?>