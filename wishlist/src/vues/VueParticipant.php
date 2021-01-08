<?php

namespace wishlist\vues;

use wishlist\model\Liste;


class VueParticipant {

    private $data;
    private $container;

    public function __construct($data, $container)
    {
        $this->data=$data;
        $this->container=$container;
    }


    //afficher toutes les listes de souhaits
    private function __htmlListeSouhait()  : string{
        $liste=null;
        $html="<section class='content'>
            <ul>";
        foreach ( $this->data as $liste){
                $html=$html."<li>".$liste->titre."</li>";
        }
        $html."</ul></section>";
        return $html;
    }

    //afficher les items de la liste en parametre
    private function __htmlListeItems(Liste $liste) : string{
        $items=$liste->items();
        $item=null;
        $html="<section class='content'>
            <h2>{$liste->titre}</h2>
            <ul>";
        foreach ($items as $item){
                $html=$html."<li>".$item->nom."</li>";
        }
        $html."</ul></section>";
        return $html;

    }

    //afficher un item
    private function __htmlItem($item){
        $html = "<section class ='content'>";
        foreach ($item as $i) {
            $html=$html."<h3>" . $i->nom . "</h3>
        <p>" . $i->descr . "</p>
        <h4>tarif :" . $i->tarif . "</h4>";
        }
        $html."</section>";
        return $html;
    }



    public function render(int $select){
       switch ($select){
            case 1 : $content=$this->__htmlListeSouhait();
                break;
            case 2 : $content=$this->__htmlListeItems($this->data);
                break;
            case 3 : $content=$this->__htmlItem($this->data);
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