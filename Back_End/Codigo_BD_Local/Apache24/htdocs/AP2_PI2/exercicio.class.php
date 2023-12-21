<?php

    class exercicio{

        private string $name;
        private string $desc;
        private string $photo;
        private string $muscles;
        private int $reps;
        private bool $active;
        private int $id;

        public function __construct(string $aName, string $aDesc, string $aPhoto, 
                                    string $aMuscles, int $aReps, bool $aActive = null, int $aId = null){

            $this->name=$aName;
            $this->desc=$aDesc;
            $this->photo=$aPhoto;
            $this->muscles=$aMuscles;
            $this->reps=$aReps;
            if($aActive==null && $aId==null){
                $this->active=true;
                $this->id=0;
            }
            else{
                $this->active=$aActive;
                $this->id=$aId;
            }
        }

        public function insereExercicio(){
            $DBH=bd::get_instance();
            $STH = $DBH->prepare("INSERT INTO exercise (e_name,e_desc,e_photo,e_muscles,e_repetitions,e_active) values (?,?,?,?,?,?);");
            $STH->execute(array($this->name,$this->desc,$this->photo,$this->muscles,$this->reps,$this->active));
        }

        public function editaExercicio($nome,$desc,$photo,$muscles,$repetitions){
            $DBH=bd::get_instance();
            $STH = $DBH->prepare("UPDATE exercise SET e_name = ?, e_desc = ?, e_photo = ?, e_muscles = ?, e_repetitions = ? WHERE e_id = ?;");
            $STH->execute(array($nome,$desc,$photo,$muscles,$repetitions,$this->id));
        }
        public function atualizaEstado(){
            
            if($this->active){
                $num=0;
            }
            else{
                $num=1;
            }
            $DBH=bd::get_instance();
            $STH = $DBH->prepare("UPDATE exercise SET e_active = ? WHERE e_id = ?;");
            $STH->execute(array($num,$this->id));
        }

        public function getNome(){
            return $this->name;
        }
        public function getId(){
            return $this->id;
        }
        public function getDesc(){
            return $this->desc;
        }
        public function getPhoto(){
            return $this->photo;
        }
        public function getMuscles(){
            return $this->muscles;
        }
        public function getReps(){
            return $this->reps;
        }
        public function getActive(){
            return $this->active;
        }
        public function setID($aId){
            $this->id=$aId;
        }

        public function __toString(){
        //     $str='';
        //     if($this->active){
        //         $num=i18n(LABEL_STATE_ACTIVE);
        //     }
        //     else{
        //         $num=i18n(LABEL_STATE_DEACTIVE);
        //     }
        //    return i18n(LABEL_NAME_EXE).": ".$this->name."<br>".i18n(LABEL_DESC_EXE).": ".$this->desc."<br>".i18n(LABEL_PHOTO_EXE).": <img width=200 height=200 src='".$this->photo."'alt='".i18n(LABEL_PHOTO_EXE)."'><br>".i18n(LABEL_MUSCLES_EXE).": ".$this->muscles."
        //    <br>".i18n(LABEL_REP_EXE).": ".$this->reps."<br>".i18n(LABEL_STATE_EXE).": ".$num;
        }

    }

?>