<?php


namespace wishlist\view;


use wishlist\model\Liste;

class VueParticipant
{
    private $data;

    public function __construct($data)
    {
        $this->data=$data;
    }


    private function htmlListeSouhait($listes)  : string{
        $liste=null;
        $html=<<<END
            <section class='content'>
            <ul>
            {foreach ( $listes as $liste){
                <li>{$liste->titre}</li>
            }
            </ul>
            </section>
END;
        return $html;
    }

    private function htmlListeItems(Liste $liste) : string{
        $items=$liste->items();
        $item=null;
        $html=<<<END
            <section class='content'>
            <h2>{$liste->titre}</h2>
            <ul>
            {foreach ($items as $item){
                <li>{$item->nom}</li>
            }
            </ul>
            </section>
END;
        return $html;

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
        $html=<<<END
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