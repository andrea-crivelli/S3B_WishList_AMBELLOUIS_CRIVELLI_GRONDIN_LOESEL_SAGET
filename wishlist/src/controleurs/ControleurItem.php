<?php

namespace wishlist\controleurs;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use wishlist\modeles\Item;
use wishlist\vues\VueAjouterItem;
use wishlist\vues\VueItem;


class ControleurItem extends Controleur {

    public function afficherItem(Request $rq, Response $rs, array $args): Response{
        $item = Item::where('token', '=', $args['token'])->first();
        $vue = new VueItem($item, $this->c);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }

    public function afficherFormulaireItem(Request $request, Response $response, array $args) : Response{
        $response->getBody()->write("Affichage du formulaire");
        $vue=new VueAjouterItem($this->c);
        $response->getBody()->write($vue->render(1));
        return $response;
    }

    public function creerItem (Request $request, Response $response, array $args) : Response{
        $titre=filter_var($request->getParsedBody('titre'),FILTER_SANITIZE_STRING);
        $description=filter_var($request->getParsedBody('descr'), FILTER_SANITIZE_STRING);
        $prix=filter_var($request->getParsedBody('prix'),FILTER_SANITIZE_STRING);
        $image=filter_var($request->getParsedBody('image'),FILTER_SANITIZE_STRING);
        $urlexterne=filter_var($request->getParsedBody('url'),FILTER_SANITIZE_STRING);
        $idListe=Liste::where('tokencreation','=',$args['tokencreation'])->first()->no;

        if($titre != '') {
            $i = new Item();
            $i->titre = $titre;
            $i->descr = $description;
            $i->img = $image;
            $i->url = $urlexterne;
            $i->tarif = $prix;
            $i->token = bin2hex(openssl_random_pseudo_bytes(32));
            $i->tokencreation = bin2hex(openssl_random_pseudo_bytes(12));
            $i->save();
        }

        $url= $this->c->router->pathFor('validationCreation');
        return $response->withRedirect($url);
    }
}