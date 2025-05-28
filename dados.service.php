<?php 

class DadosService {

    private $conexao;
    private $dadosPessoais;
    private $habitosAtividades;
    private $historicoSaude;
    private $antecedentesMedicos;
    private $habitos;
    private $gestacoes;

    public function __construct(
        Conexao $conexao, DadosPessoais $dadosPessoais, HabitosAtividades $habitosAtividades, 
        HistoricoSaude $historicoSaude, AntecedentesMedicos $antecedentesMedicos, Habitos $habitos, 
        Gestacoes $gestacoes
        ){
            $this->conexao = $conexao->conectar();
            $this->dadosPessoais = $dadosPessoais; 
            $this->habitosAtividades = $habitosAtividades;
            $this->historicoSaude = $historicoSaude;
            $this->antecedentesMedicos = $antecedentesMedicos;
            $this->habitos = $habitos;
            $this->gestacoes = $gestacoes;

    }

    public function inserir(){

        try{

            $this->conexao->beginTransaction();

            $query = 'insert into tb_dados_pessoais(nome,cpf,genero,data_nascimento,cargo,sobrenome) values(:nome,:cpf,:genero,:dataNascimento,:cargo,:sobrenome)';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':nome', $this->dadosPessoais->__get('nome'));
            $stmt->bindValue(':cpf', $this->dadosPessoais->__get('cpf'));
            $stmt->bindValue(':genero', $this->dadosPessoais->__get('genero'));
            $stmt->bindValue(':dataNascimento', $this->dadosPessoais->__get('dataNascimento'));
            $stmt->bindValue(':cargo', $this->dadosPessoais->__get('cargo'));
            $stmt->bindValue(':sobrenome', $this->dadosPessoais->__get('sobrenome'));
            $stmt->execute();

            $idNovoPaciente = $this->conexao->lastInsertId();

            $query = 'insert into tb_habitos_atividades(id_pessoal,frequencia_exercicio,hobbies,atividade_laborativa,descreva_atividade) values(:idPessoal,:frequenciaExercicio,:hobbies,:atividadeLaborativa,:descricaoAtividade)';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':idPessoal', $idNovoPaciente);
            $stmt->bindValue(':frequenciaExercicio', $this->habitosAtividades->__get('frequenciaExercicio'));
            $stmt->bindValue(':hobbies', $this->habitosAtividades->__get('hobbies'));
            $stmt->bindValue(':atividadeLaborativa', $this->habitosAtividades->__get('atividadeLaborativa'));
            $stmt->bindValue(':descricaoAtividade', $this->habitosAtividades->__get('descricaoAtividade'));
            $stmt->execute();

            $historicoFamiliarJson = json_encode($this->historicoSaude->__get('historicoFamiliar'));
            $historicoPessoalJson = json_encode($this->historicoSaude->__get('historicoPessoal'));

            $query = 'insert into tb_historico_saude(id_pessoal_historico_saude,historico_familiar,historico_pessoal) values(:idPessoalHistoricoSaude,:historicoFamilar,:historicoPessoal)';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':idPessoalHistoricoSaude', $idNovoPaciente);
            $stmt->bindValue(':historicoFamilar', $historicoFamiliarJson);
            $stmt->bindValue(':historicoPessoal', $historicoPessoalJson);
            $stmt->execute();

            $query = 'insert into tb_antecedentes_medicos(id_pessoal_antecedentes_medicos,alergias,cirurgias,medicamentos_continuos,tipo_sanguineo,doador_sangue) values(:idPessoalAntecedentesMedicos,:alergias,:cirurgias,:medicamentosContinuos,:tipoSanguineo,:doadorSangue)';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':idPessoalAntecedentesMedicos', $idNovoPaciente);
            $stmt->bindValue(':alergias', $this->antecedentesMedicos->__get('alergias'));
            $stmt->bindValue(':cirurgias', $this->antecedentesMedicos->__get('cirurgias'));
            $stmt->bindValue(':medicamentosContinuos', $this->antecedentesMedicos->__get('medicamentosContinuos'));
            $stmt->bindValue(':tipoSanguineo', $this->antecedentesMedicos->__get('tipoSanguineo'));
            $stmt->bindValue(':doadorSangue', $this->antecedentesMedicos->__get('doadorSangue'));
            $stmt->execute();

            $query = 'insert into tb_habitos(id_pessoal_habitos,consumo_alcool,consumo_drogas,tabagismo,tipo_deficiencia) values(:idPessoalHabitos,:bebidaAlcoolica,:usoDrogas,:tabagismo,:descPCD)';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':idPessoalHabitos', $idNovoPaciente);
            $stmt->bindValue(':bebidaAlcoolica', $this->habitos->__get('bebidaAlcoolica'));
            $stmt->bindValue(':usoDrogas', $this->habitos->__get('usoDrogas'));
            $stmt->bindValue(':tabagismo', $this->habitos->__get('tabagismo'));
            $stmt->bindValue(':descPCD', $this->habitos->__get('descPCD'));
            $stmt->execute();

            $query = 'insert into tb_gestacoes(id_pessoal_gestacoes,gestacoes,cesarea,normal) values(:idPessoalGestacoes,:quantidadeGestacoes,:quantidadeCesarea,:quantidadePartoNormal)';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':idPessoalGestacoes', $idNovoPaciente);
            $stmt->bindValue(':quantidadeGestacoes', $this->gestacoes->__get('quantidadeGestacoes'));
            $stmt->bindValue(':quantidadeCesarea', $this->gestacoes->__get('quantidadeCesarea'));
            $stmt->bindValue(':quantidadePartoNormal', $this->gestacoes->__get('quantidadePartoNormal'));
            $stmt->execute();

            $this->conexao->commit();
            return true;

        }catch(PDOException $e){

            $this->conexao->rollBack();
            error_log("Erro na inserção: ".$e->getMessage());
            return false;

        }

        
    }

}
?>