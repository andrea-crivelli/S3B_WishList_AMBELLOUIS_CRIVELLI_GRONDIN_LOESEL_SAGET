<?php


namespace wishlist\view;


use wishlist\model\Liste;

class VueParticipant
{
    private $data;
    private $modeAffichage;

    public function __construct($data,$modeAffichage)
    {
        $this->data=$data;
        $this->modeAffichage=$modeAffichage;
    }


    //afficher toutes les listes de souhaits
    private function __htmlListeSouhait($listes)  : string{
        $liste=null;
        $html="<<<END
            <section class='content'>
            <ul>";
        foreach ( $listes as $liste){
                $html."<li>".$liste->titre."</li>";
        }
        $html."</ul></section>END;";
        return $html;
    }

    //afficher les items de la liste en parametre
    private function __htmlListeItems(Liste $liste) : string{
        $items=$liste->items();
        $item=null;
        $html="<<<END
            <section class='content'>
            <h2>{$liste->titre}</h2>
            <ul>";
        foreach ($items as $item){
                $html."<li>".$item->nom."</li>";
        }
        $html."</ul></section>END;";
        return $html;

    }

    //afficher un item
    private function __htmlItem($item){
        $html = "<<<END
        <section class ='content'>";
        foreach ($item as $i) {
            $html."<h3>" . $i->nom . "</h3>
        <p>" . $i->descr . "</p>
        <h4>tarif :" . $i->tarif . "</h4>";
        }
        $html."</section>END;";
        return $html;
    }



    public function __render(array $vars){
       switch ($this->modeAffichage){
            case 1 : $content=$this->__htmlListeSouhait($this->data);
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
        //<link rel="stylesheet" href="{$vars['basepath']}/wish.css"

        return $html;
    }
}