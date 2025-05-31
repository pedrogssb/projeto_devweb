<?php  

    class Conexao { 

        private $host = 'localhost'; 
        private $dbname = 'formulario_medico'; 
        private $user = 'root'; 
        private $pass = ''; 

        public function conectar(){ 
            try{ 

                $conexao = new PDO( 
                    "mysql:host=$this->host;dbname=$this->dbname", 
                    "$this->user", 
                    "$this->pass" 
                ); 
                $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                $conexao->exec("set names utf8mb4"); 

                return $conexao; 

            }catch(PDOException $e){ 

                error_log("Erro de conexão PDO: " . $e->getMessage()); 
                echo '<p>Erro ao conectar com o banco de dados. Tente novamente mais tarde.</p>';
                die(); 
            } 
        } 
    } 

?>