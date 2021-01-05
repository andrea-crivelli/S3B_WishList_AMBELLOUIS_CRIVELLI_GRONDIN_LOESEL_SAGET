<?php

namespace wishlist\vues;


class VueCreateur {

    private $data;
    private $modeAffichage;

    public function __construct($data,$modeAffichage)
    {
        $this->data=$data;
        $this->modeAffichage=$modeAffichage;
    }

    public function htmlCreateList($url){
        $html="<section class='content'>Bravo votre liste a été créée. L'url est le suivant : .$url.</section>";
        return $html;
    }

    public function render(array $vars){
        switch ($this->modeAffichage){
            case 1 : $content=$this->htmlCreateListe($this->data);
                break;
        };
        $html=<<<END
        <!DOCTYPE html>
        <head>
       
        </head>
        <body>
            $content
        </body>
END;

        return $html;
    }
}