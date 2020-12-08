<?php


namespace wishlist\vue;


class VueParticipant
{
    private $data;

    public function __construct($data)
    {
        $this->data=$data;
    }

    private function __affichageListeSouhait()  : string{

    }

    private function __htmlListeItems(){

    }

    private function __htmlItem($item){
        $html = <<<END
        <section class ="content">
        <h3>{$item->nom}</h3>
        <p>{$item->descr}</p>
        <h4>tarif : {$item->tarif}</h4>
        </section>
END;
        return $html;
    }


    public function affichage($modeAffichage,$item){

        switch ($modeAffichage){
            case 1 : $this->__affichageListeSouhait();
            break;
            case 2 : $this->__htmlListeItems();
            break;
            case 3 : $this->__htmlItem($item);
            break;
        }
    }


    public function __render(array $vars){
        $content = $this->__htmlItem($this->data[0]);
        $html = <<<END 
        <!DOCTYPE html>
        <head>
        <link rel="stylesheet" href="{$vars['basepath']}/wish.css"
        </head>
        <body>
        $content
</body>
END;

        return $html;
    }
}