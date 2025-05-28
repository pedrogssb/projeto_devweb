<?php 

class DadosPessoais {
    private $id;
    private $nome;
    private $cpf;
    private $genero;
    private $dataNascimento;
    private $cargo;
    private $sobrenome;

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
    private $quantidadeGestacoes;
    private $quantidadeCesarea;
    private $quantidadePartoNormal;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo,$valor){
        $this->$atributo = $valor;
    }
}


?>