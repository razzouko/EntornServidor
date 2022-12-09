<?php 


     class Gos {

        private $nom;
        private $amo;
        private $raça;
        private $imatge_url;

        public function __construct(string $nom , string $amo , string $raça , string $imatge_url )
        {
            $this->nom = $nom;
            $this->amo = $amo;
            $this->raça = $raça;
            $this->imatge_url = $imatge_url;
        }

        function dadesFormatArr(): array{
            return [$this->nom , $this->amo , $this->raça , $this->imatge_url];
        }



    } 




?>