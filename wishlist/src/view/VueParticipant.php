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
    private function htmlListeSouhait($listes)  : string{
        $liste=null;
        $html="<<<END
            <section class='content'>
            <ul>";
        foreach ( $listes as $liste){
                $html."<li>{$liste->titre}</li>";
        };
        $html."</ul></section>END;";
        return $html;
    }

    //afficher les items de la liste en parametre
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

    //afficher un item
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



<<<<<<< HEAD
=======
        switch ($modeAffichage){
            case 1 : $this->htmlListeSouhait($item);
            break;
            case 2 : $this->htmlListeItems($item);
            break;
            case 3 : $this->__htmlItem($item);
            break;
        }
    }
>>>>>>> 8ea4366a5507c456f9d7f5b0085a2a4531305535


    public function __render(array $vars){
       switch ($this->modeAffichage){
            case 1 : $content=$this->htmlListeSouhait($this->data);
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