<?php


namespace wishlist\vue;


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

    private function htmlItem(){

    }

    public function affichage(){

    }
}