<?php  

class DadosPessoais { 
    private $id; 
    private $nome; 
    private $cpf; 
    private $genero; 
    private $dataNascimento; 
    private $cargo; 
    private $sobrenome; 
    private $dataCriacao; 

    public function __get($atributo){ 
        return $this->$atributo; 
    } 

    public function __set($atributo,$valor){ 
        $this->$atributo=$valor; 
    } 
} 

class HabitosAtividades { 
    private $id_habitos_atividades; 
    private $id_pessoal; 
    private $frequenciaExercicio; 
    private $hobbies; 
    private $atividadeLaborativa; 
    private $descricaoAtividade; 

    public function __get($atributo){ 
        return $this->$atributo; 
    } 

    public function __set($atributo,$valor){ 
        $this->$atributo = $valor; 
    } 
} 

class HistoricoSaude { 
    private $id_historico_saude; 
    private $id_pessoal_historico_saude; 
    private $historicoFamiliar; 
    private $historicoPessoal; 

    public function __get($atributo){ 
        return $this->$atributo; 
    } 

    public function __set($atributo,$valor){ 
        $this->$atributo = $valor; 
    } 
} 

class AntecedentesMedicos { 
    private $id_antecedentes_medicos; 
    private $id_pessoal_antecedentes_medicos; 
    private $alergias; 
    private $cirurgias; 
    private $medicamentosContinuos; 
    private $tipoSanguineo; 
    private $doadorSangue; 

    public function __get($atributo){ 
        return $this->$atributo; 
    } 

    public function __set($atributo,$valor){ 
        $this->$atributo = $valor; 
    } 
} 

class Habitos { 
    private $id_habitos; 
    private $id_pessoal_habitos; 
    private $bebidaAlcoolica; 
    private $usoDrogas; 
    private $tabagismo; 
    private $descPCD;
    private $pcd; 

    public function __get($atributo){ 
        return $this->$atributo; 
    } 

    public function __set($atributo,$valor){ 
        $this->$atributo = $valor; 
    } 
} 

class Gestacoes { 
    private $id_gestacoes; 
    private $id_pessoal_gestacoes; 
    private $gestacao; 
    private $quantidadeGestacoes; 
    private $cesarea; 
    private $quantidadeCesarea; 
    private $partoNormal; 
    private $quantidadePartoNormal; 
    private $intercorrenciasGestacionais; 

    public function __get($atributo){ 
        return $this->$atributo; 
    } 

    public function __set($atributo,$valor){ 
        $this->$atributo = $valor; 
    } 
} 

?>  