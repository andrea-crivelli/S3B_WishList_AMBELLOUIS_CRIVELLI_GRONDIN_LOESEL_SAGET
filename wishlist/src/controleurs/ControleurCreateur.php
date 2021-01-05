<?php

namespace wishlist\controleurs;

use wishlist\model\Liste;


class ControleurCreateur {


    public function creerListe($titre,$description,$date_expi){
        Liste::creerListe($titre,$description,$date_expi);
        //generation de token
    }
}