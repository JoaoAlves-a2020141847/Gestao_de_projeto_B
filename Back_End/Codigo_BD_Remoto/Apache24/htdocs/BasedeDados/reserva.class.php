<?php

    Class Reserva {

        private string $nome;
        private string $curso;
        private string $tipo;
        private array $dias;
        private int $contact;

        public function __construct(string $aNome,string $aCurso,string $aTipo,array $aDias,int $aContact){

            $this->nome = $aNome;
            $this->curso = $aCurso;
            $this->tipo = $aTipo;
            $this->dias = $aDias;
            $this->contact = $aContact;

        }

        public function calculaCusto(){
            $desconto=1;
            if($this->tipo=="estudante"){
                $desconto=0.5;
            }
            for($i=0;$i < count($this->dias);$i++){
                $preco=5*count($this->dias);
            }
            $preco=$preco*$desconto;
            return $preco;
        }

        public function guardar(){
            $DBH=bd::get_instance();
            $STH = $DBH->prepare("INSERT INTO reservas (R_Nome, R_Curso, R_Tipo, R_Contacto) values (?, ?, ?, ?)");
            $STH->execute(array($this->nome,$this->curso,$this->tipo,$this->contact));
            $ultimo_id = $DBH->lastInsertId();
            foreach($this->dias as $dia ){
                $STH = $DBH->prepare("INSERT INTO reservadias (R_ID, D_ID) values (?,?)");
                $STH->execute(array($ultimo_id,$dia));
            }
        }

        public function __toString(){
            $str='';
            for($i=0;$i<count($this->dias);$i++){
                $str.=$this->dias[$i]."<br>";
            }
           return "nome: ".$this->nome."<br>curso: ".$this->curso."<br>tipo: ".$this->tipo."<br>contacto: ".$this->contact."<br>Dias: ".$str."Custo total: ".$this->calculaCusto();
        }

    }
?>