<?php 
    include_once("gos.php");
    include_once("../helper.php");

    class Fase {

        private $nom;
        private $inici;
        private $final;
        private $gossos;



        public function __construct(string $nom)
        {
                $this->nom = $nom;
                $this->afegirGossos();
        }

        function dadesFormatArr(){
            return [$this->nom , $this->inici , $this->final];
        }

        function afegirGossos(){
                $this->gossos = obtenirGossosDeFase($this->nom); 
        }

        function obtenirGuanyadors(): array{
                return obtenirGossosXFase($this->nom);
        }

        function obtenirGossos(){
            return $this->gossos;
        }

        function getNom(){
            return $this->nom;
        }

        

    }









?>