<?php

namespace wishlist\controleurs;

use wishlist\modeles\Liste;
use wishlist\vues\VueCreateurListe;
use wishlist\vues\VueParticipant;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class ControleurListe extends Controleur {

    public function afficherListes(Request $rq, Response $rs, array $args): Response{
        $rs->getBody()->write("Affichage de la liste des listes");
        $listl = Liste::all();
        $vue = new VueParticipant($listl, $this->c);
        $rs->getBody()->write($vue->render(1));
        return $rs;

    }

    public function afficherListe(Request $rq, Response $rs, array $args): Response{
        $listl = Liste::where('token', '=', $args['token'])->first();
        $vue = new VueParticipant($listl, $this->c);
        $rs->getBody()->write($vue->render(2));
        return $rs;
    }

    public function afficherFormulaire(Request $rq,Response $rs, array $args) : Response{
        $rs->getBody()->write("Affichage du formulaire");
        $vue=new VueCreateurListe($this->c);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }


    public function creerListe (Request $request,Response $response, array $args) : Response{
        $titre = filter_var($request->getParsedBodyParam('titre'), FILTER_SANITIZE_STRING);
        $description = filter_var($request->getParsedBodyParam('descr'), FILTER_SANITIZE_STRING);
        $dateExpiration = $request->getParsedBodyParam('dateExpi');
        if (new DateTime() > new DateTime($dateExpiration)){
            throw new Exception("La date d'expiration est antérieure à la date courante.");
        }
        $l=new Liste();
        $l->titre=$titre;
        $l->description=$description;
        $l->expiration=$dateExpiration;
        $l->token = bin2hex(openssl_random_pseudo_bytes(32));
        $l->save();

        $url = $this->c->router->pathFor('valdiationCreation');
        return $response->withRedirect($url);
    }
}