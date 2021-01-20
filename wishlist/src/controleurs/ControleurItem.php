<?php

namespace wishlist\controleurs;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use wishlist\modeles\Item;
use wishlist\modeles\Liste;
use wishlist\vues\VueAjouterItem;
use wishlist\vues\VueItem;


class ControleurItem extends Controleur {

    //affichage d'un item selon son etat de reservation
    public function afficherItem(Request $rq, Response $rs, array $args): Response{
        $item = Item::where('token', '=', $args['token'])->first();
        $vue = new VueItem($item, $this->c);
        if ($item->reserve == 'non'){
            $rs->getBody()->write($vue->render(2));
        } elseif ($item->reserve == 'oui'){
            $rs->getBody()->write($vue->render(1));
        }
        return $rs;
    }

    //affichage du formulaire pour ajouter un item
    public function afficherFormulaireItem(Request $request, Response $response, array $args) : Response{
        $vue=new VueAjouterItem($this->c);
        $response->getBody()->write($vue->render(1));
        return $response;
    }

    //affichage du formulaire pour reserver un item
    public function afficherFormulaire (Request $request, Response $response, array $args) : Response{
        $i=Item::where('token', '=', $args['token'])->first();
        $vue = new VueItem($i, $this->c);
        $response->getBody()->write($vue->render(3));
        return $response;
    }

    //affichage des items d'une liste (pour modification)
    public function afficherChoixItemMod(Request $request, Response $response, array $args) : Response{
        $l=Liste::where('tokencreation','=',$args['tokencreation'])->first();
        $data['liste']=$l;
        $data['tokencreation']=$args['tokencreation'];
        $vue = new VueItem($data,$this->c);
        $response->getBody()->write($vue->render(4));
        return $response;
    }

    //affichage des items d'une liste (pour suppression)
    public function afficherChoixItemSup(Request $request, Response $response, array $args) : Response{
        $l=Liste::where('tokencreation','=',$args['tokencreation'])->first();
        $data['liste']=$l;
        $data['tokencreation']=$args['tokencreation'];
        $vue = new VueItem($data,$this->c);
        $response->getBody()->write($vue->render(6));
        return $response;
    }

    //affichage du formulaire pour modifier un item
    public function afficherFormulaireItemModification (Request $request, Response $response, array $args) : Response{
        $vue = new VueItem([], $this->c);
        $response->getBody()->write($vue->render(5));
        return $response;
    }

    //affichage du formulaire de suppression
    public function afficherFormulaireItemSuppression (Request $request, Response $response, array $args) : Response{
        $data['id']=$args['id'];
        $data['tokencreation']=$args['tokencreation'];
        $vue = new VueItem($data, $this->c);
        $response->getBody()->write($vue->render(7));
        return $response;
    }


    //methode qui cree un item et l'ajoute a la base de donnees
    public function creerItem (Request $request, Response $response, array $args) : Response{
        $titre=filter_var($request->getParsedBodyParam('titre'),FILTER_SANITIZE_STRING);
        $description=filter_var($request->getParsedBodyParam('descr'), FILTER_SANITIZE_STRING);
        $prix=filter_var($request->getParsedBodyParam('tarif'),FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $image=filter_var($request->getParsedBodyParam('img'),FILTER_SANITIZE_STRING);
        $urlexterne=filter_var($request->getParsedBodyParam('url'),FILTER_SANITIZE_STRING);
        $idListe=Liste::where('tokencreation','=',$args['tokencreation'])->first()->no;

        if($titre != '') {
            $i = new Item();
            $i->liste_id=$idListe;
            $i->nom = $titre;
            $i->descr = $description;
            $i->img = $image;
            $i->url = $urlexterne;
            $i->tarif = $prix;
            $i->token = bin2hex(openssl_random_pseudo_bytes(32));
            $i->tokencreation = bin2hex(openssl_random_pseudo_bytes(12));
            $i->save();
        }
        $url= $this->c->router->pathFor('modificationAjoutListe',['tokencreation'=>$args['tokencreation']]);
        return $response->withRedirect($url);
    }

    //methode pour reserver un item
    public function reserverItem(Request $request, Response $response, array $args) : Response{
        $i=Item::where('token', '=', $args['token'])->first();
        $i->reserve = 'oui';
        $participant= filter_var($request->getParsedBodyParam('participant'), FILTER_SANITIZE_STRING);
        $i->participant = $participant;
        $i->save();
        $tokenliste=Liste::where('no','=',$i->liste_id)->first()->token;
        $url = $this->c->router->pathFor('afficherListe',['token' => $tokenliste]);
        return $response->withRedirect($url);
    }

    //methode pour modifier un item
    public function modifierItem (Request $request, Response $response, array $args) : Response{
        $i=Item::where('id', '=', $args['id'])->first();
        $titre=filter_var($request->getParsedBodyParam('titre'),FILTER_SANITIZE_STRING);
        $description=filter_var($request->getParsedBodyParam('descr'), FILTER_SANITIZE_STRING);
        $prix=filter_var($request->getParsedBodyParam('tarif'),FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $image=filter_var($request->getParsedBodyParam('img'),FILTER_SANITIZE_STRING);
        $urlexterne=filter_var($request->getParsedBodyParam('url'),FILTER_SANITIZE_STRING);
        $idListe=Liste::where('tokencreation','=',$args['tokencreation'])->first()->no;
        if ($i->reserve == 'non') {
            if ($titre != '' && $titre != $i->nom) $i->nom = $titre;
            if ($description != '' && $description != $i->descr) $i->descr = $description;
            if ($image != '' && $image != $i->img) $i->img = $image;
            if ($urlexterne != '' && $urlexterne != $i->url) $i->url = $urlexterne;
            if ($prix != '' && $prix != $i->tarif) $i->tarif = $prix;
            $i->save();
        }
        $url = $this->c->router->pathFor('modificationAjoutListe',['tokencreation' => $args['tokencreation']]);
        return $response->withRedirect($url);
    }

    //methode pour supprimer une liste avec son token de creation
    public function supprimerItem(Request $request, Response $response, array $args) : Response{
        var_dump($args);
        Item::where('id','=',$args['id'])->first()->delete();



        $url = $this->c->router->pathFor('modificationAjoutListe',['tokencreation' => $args['tokencreation']]);
        return $response->withRedirect($url);

    }

}