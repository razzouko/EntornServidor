<?php 
    include "gos";
    include "./PDO/pdoaccess.php";

    class Fase {


        private $nom;
        private $inici;
        private $final;
        private $gossos;



        public function __construct(string $nom)
        {
                $this->nom = $nom;
                $this->definirMaxiMin();
        }

        function dadesFormatArr(){
            return [$this->nom , $this->inici , $this->final];
        }

        function afegirGossos(Array $gossos): bool{
                $this->gossos = $gossos;
                return true;
        }

        function obtenirGuanyadors(): array{
                return obtenirGossosXFase($this->nom);
        }

        function isFinalitzada(): bool{
               // calcul amb dates (llibreria carbon php?) return ($this->inici - $this->final <=0 )? true : false ;
        }
        
        function nouInici(DateTime $data):bool{
                // comprovacions: cada fase es du a terme durant un mes, si l'inici solapa amb el mes següent o anterior no dexa i el final tambe
                
        }
        
        function finalFase(DateTime $dataFinal): bool{
                // comprovacions cada es pot posar un valor menor no major al que hi ha a la 
        }

        

    }









?>