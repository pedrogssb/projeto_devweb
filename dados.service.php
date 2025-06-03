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
            Conexao $conexao,
            DadosPessoais $dadosPessoais = null,
            HabitosAtividades $habitosAtividades = null,
            HistoricoSaude $historicoSaude = null,
            AntecedentesMedicos $antecedentesMedicos = null,
            Habitos $habitos = null,
            Gestacoes $gestacoes = null
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

                // 1. Inserir Dados Pessoais
                $query = 'INSERT INTO tb_dados_pessoais(nome,cpf,genero,data_nascimento,cargo,sobrenome) VALUES(:nome,:cpf,:genero,:dataNascimento,:cargo,:sobrenome)';
                $stmt = $this->conexao->prepare($query);
                $stmt->bindValue(':nome', $this->dadosPessoais->__get('nome'));
                $stmt->bindValue(':cpf', $this->dadosPessoais->__get('cpf'));
                $stmt->bindValue(':genero', $this->dadosPessoais->__get('genero'));
                $stmt->bindValue(':dataNascimento', $this->dadosPessoais->__get('dataNascimento'));
                $stmt->bindValue(':cargo', $this->dadosPessoais->__get('cargo'));
                $stmt->bindValue(':sobrenome', $this->dadosPessoais->__get('sobrenome'));
                $stmt->execute();
                $idNovoPaciente = $this->conexao->lastInsertId();

                // 2. Inserir Hábitos e Atividades
                $query = 'INSERT INTO tb_habitos_atividades(id_pessoal,frequencia_exercicio,hobbies,atividade_laborativa,descreva_atividade) VALUES(:idPessoal,:frequenciaExercicio,:hobbies,:atividadeLaborativa,:descricaoAtividade)';
                $stmt = $this->conexao->prepare($query);
                $stmt->bindValue(':idPessoal', $idNovoPaciente);
                $stmt->bindValue(':frequenciaExercicio', $this->habitosAtividades->__get('frequenciaExercicio') ?? null, PDO::PARAM_STR);
                $stmt->bindValue(':hobbies', $this->habitosAtividades->__get('hobbies') ?? null, PDO::PARAM_STR);
                $stmt->bindValue(':atividadeLaborativa', $this->habitosAtividades->__get('atividadeLaborativa'));
                $stmt->bindValue(':descricaoAtividade', $this->habitosAtividades->__get('descricaoAtividade') ?? null, PDO::PARAM_STR);
                $stmt->execute();

                // 3. Inserir Histórico de Saúde
                $historicoFamiliarJson = $this->historicoSaude->__get('historicoFamiliar') ?? '[]'; // Já deve vir JSON do controller
                $historicoPessoalJson = $this->historicoSaude->__get('historicoPessoal') ?? '[]';   // Já deve vir JSON do controller
                $query = 'INSERT INTO tb_historico_saude(id_pessoal_historico_saude,historico_familiar,historico_pessoal) VALUES(:idPessoalHistoricoSaude,:historicoFamilar,:historicoPessoal)';
                $stmt = $this->conexao->prepare($query);
                $stmt->bindValue(':idPessoalHistoricoSaude', $idNovoPaciente);
                $stmt->bindValue(':historicoFamilar', $historicoFamiliarJson);
                $stmt->bindValue(':historicoPessoal', $historicoPessoalJson);
                $stmt->execute();

                // 4. Inserir Antecedentes Médicos
                $query = 'INSERT INTO tb_antecedentes_medicos(id_pessoal_antecedentes_medicos,alergias,cirurgias,medicamentos_continuos,tipo_sanguineo,doador_sangue) VALUES(:idPessoalAntecedentesMedicos,:alergias,:cirurgias,:medicamentosContinuos,:tipoSanguineo,:doadorSangue)';
                $stmt = $this->conexao->prepare($query);
                $stmt->bindValue(':idPessoalAntecedentesMedicos', $idNovoPaciente);
                $stmt->bindValue(':alergias', $this->antecedentesMedicos->__get('alergias') ?? null, PDO::PARAM_STR);
                $stmt->bindValue(':cirurgias', $this->antecedentesMedicos->__get('cirurgias') ?? null, PDO::PARAM_STR);
                $stmt->bindValue(':medicamentosContinuos', $this->antecedentesMedicos->__get('medicamentosContinuos') ?? null, PDO::PARAM_STR);
                $stmt->bindValue(':tipoSanguineo', $this->antecedentesMedicos->__get('tipoSanguineo'));
                $stmt->bindValue(':doadorSangue', $this->antecedentesMedicos->__get('doadorSangue'));
                $stmt->execute();

                // 5. Inserir Hábitos (Consumo, Tabagismo, PCD)
                $query = 'INSERT INTO tb_habitos(id_pessoal_habitos,consumo_alcool,consumo_drogas,tabagismo,tipo_deficiencia) VALUES(:idPessoalHabitos,:bebidaAlcoolica,:usoDrogas,:tabagismo,:tipoDeficiencia)';
                $stmt = $this->conexao->prepare($query);
                $stmt->bindValue(':idPessoalHabitos', $idNovoPaciente);
                $stmt->bindValue(':bebidaAlcoolica', $this->habitos->__get('bebidaAlcoolica'));
                $stmt->bindValue(':usoDrogas', $this->habitos->__get('usoDrogas'));
                $stmt->bindValue(':tabagismo', $this->habitos->__get('tabagismo'));
                $stmt->bindValue(':tipoDeficiencia', $this->habitos->__get('descPCD') ?? null, PDO::PARAM_STR);
                $stmt->execute();

                // 6. Inserir Gestações (condicional à instância do objeto)
                if ($this->gestacoes !== null) {
                    $query = 'INSERT INTO tb_gestacoes(id_pessoal_gestacoes, gestacao_bool, quantidade_gestacoes, cesarea_bool, quantidade_cesarea, normal_bool, quantidade_parto_normal, intercorrencias_gestacionais) VALUES(:idPessoalGestacoes, :gestacaoBool, :quantidadeGestacoes, :cesareaBool, :quantidadeCesarea, :normalBool, :quantidadePartoNormal, :intercorrenciasGestacionais)';
                    $stmt = $this->conexao->prepare($query);
                    $stmt->bindValue(':idPessoalGestacoes', $idNovoPaciente);
                    $stmt->bindValue(':gestacaoBool', $this->gestacoes->__get('gestacao'));
                    $stmt->bindValue(':quantidadeGestacoes', $this->gestacoes->__get('quantidadeGestacoes') ?? null, PDO::PARAM_INT);
                    $stmt->bindValue(':cesareaBool', $this->gestacoes->__get('cesarea'));
                    $stmt->bindValue(':quantidadeCesarea', $this->gestacoes->__get('quantidadeCesarea') ?? null, PDO::PARAM_INT);
                    $stmt->bindValue(':normalBool', $this->gestacoes->__get('partoNormal'));
                    $stmt->bindValue(':quantidadePartoNormal', $this->gestacoes->__get('quantidadePartoNormal') ?? null, PDO::PARAM_INT);
                    $stmt->bindValue(':intercorrenciasGestacionais', $this->gestacoes->__get('intercorrenciasGestacionais') ?? null, PDO::PARAM_STR);
                    $stmt->execute();
                }

                $this->conexao->commit();
                return true;

            } catch(PDOException $e) {
                $this->conexao->rollBack();
                error_log("Erro na inserção: ".$e->getMessage());
                return false;
            }
        }

        /**
         * Busca um formulário completo por CPF.
         * @param string 
         * @return array|null
         */
        public function buscarPorCpf($cpf) {
            try {
                $query = "
                    SELECT
                        dp.*,
                        ha.frequencia_exercicio, ha.hobbies, ha.atividade_laborativa, ha.descreva_atividade,
                        hs.historico_familiar, hs.historico_pessoal,
                        am.alergias, am.cirurgias, am.medicamentos_continuos, am.tipo_sanguineo, am.doador_sangue,
                        h.consumo_alcool, h.consumo_drogas, h.tabagismo, h.tipo_deficiencia AS desc_pcd,
                        g.gestacao_bool AS gestacao, g.quantidade_gestacoes, g.cesarea_bool AS cesarea, g.quantidade_cesarea, g.normal_bool AS parto_normal, g.quantidade_parto_normal, g.intercorrencias_gestacionais
                    FROM tb_dados_pessoais dp
                    LEFT JOIN tb_habitos_atividades ha ON dp.id = ha.id_pessoal
                    LEFT JOIN tb_historico_saude hs ON dp.id = hs.id_pessoal_historico_saude
                    LEFT JOIN tb_antecedentes_medicos am ON dp.id = am.id_pessoal_antecedentes_medicos
                    LEFT JOIN tb_habitos h ON dp.id = h.id_pessoal_habitos
                    LEFT JOIN tb_gestacoes g ON dp.id = g.id_pessoal_gestacoes
                    WHERE dp.cpf = :cpf
                ";

                $stmt = $this->conexao->prepare($query);
                $stmt->bindValue(':cpf', $cpf);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC); 
            } catch (PDOException $e) {
                error_log("Erro ao buscar formulário por CPF: " . $e->getMessage());
                return null;
            }
        }

        /**
         * Lista formulários com opção de filtro por CPF.
         * @param string 
         * @return array
         */
        public function listar($cpf = ''){
            try {
                $query = "
                    SELECT
                        id, nome, sobrenome, cpf, cargo, data_criacao, genero
                    FROM tb_dados_pessoais
                ";
                $params = [];

                if (!empty($cpf)) {
                    $query .= " WHERE cpf LIKE :cpf";
                    $params[':cpf'] = "%" . $cpf . "%"; 
                }
                $query .= " ORDER BY data_criacao DESC";

                $stmt = $this->conexao->prepare($query);
                $stmt->execute($params);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                error_log("Erro ao listar formulários: ".$e->getMessage());
                return [];
            }
        }
        /** * Remove um formulário e todos os dados relacionados.
     *
     * @param int
     * @return bool 
     */
    public function remover($id) {
        try {
            $this->conexao->beginTransaction(); 

            $query = 'DELETE FROM tb_dados_pessoais WHERE id = :id';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $this->conexao->commit(); 
            return true;

        } catch (PDOException $e) {
            $this->conexao->rollBack(); 
            error_log("Erro ao remover formulário com ID " . $id . ": " . $e->getMessage());
            return false;
        }
    }
}
?>