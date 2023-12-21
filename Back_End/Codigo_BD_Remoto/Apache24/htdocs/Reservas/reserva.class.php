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
            $str=PHP_EOL.'';

            $str.=$this->nome.";";
            $str.=$this->curso.";";
            $str.=$this->tipo.";";
            for($i=0;$i < count($this->dias);$i++){
                if($i==count($this->dias)-1){
                    $str.=$this->dias[$i].";";
                }
                else{
                    $str.=$this->dias[$i].",";
                }
            }
            $str.=$this->contact.";";
            $str.=$this->calculaCusto();

            file_put_contents('bilhetes',$str,FILE_APPEND);
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