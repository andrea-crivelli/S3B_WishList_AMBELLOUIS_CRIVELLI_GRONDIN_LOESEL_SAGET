<?php

namespace wishlist\controleurs;

use wishlist\modeles\Liste;
use wishlist\vues\VueParticipant;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class ControleurListe extends Controleur {

    public function createListe (Request $request,Response $response, array $args) : Response{
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
        $l->tokenCreation = bin2hex(openssl_random_pseudo_bytes(12));
        $l->save();

        $url = $this->c->router->pathFor('afficherListe',['token'=>$l->token]);
    }


    public function createListe2(Request $request, Response $response, array $args): Response {
        try {
            $titre = filter_var($request->getParsedBodyParam('titre'), FILTER_SANITIZE_STRING);
            $description = filter_var($request->getParsedBodyParam('descr'), FILTER_SANITIZE_STRING);
            $dateExp = $request->getParsedBodyParam('dateExpi');

            if (mb_strlen($titre, 'utf8') < 4) throw new Exception("Le titre de la liste doit comporter au minimum 4 caractères.");
            if (new DateTime() > new DateTime($dateExp)) throw new Exception("La date d'expiration ne peut être déjà passée..");

            $this->loadCookiesFromRequest($request);

            $liste = new Liste();
            $liste->user_id = 0;
            $liste->titre = $titre;
            $liste->description = $description;
            $liste->expiration = $dateExp;
            $liste->token = bin2hex(openssl_random_pseudo_bytes(32));
            $liste->creationToken = bin2hex(openssl_random_pseudo_bytes(12));
            $liste->public = 0;
            $liste->save();

            $this->addCreationToken($liste->creationToken);
            $response = $this->createResponseCookie($response);
            $link = $this->router->pathFor('showListe', ['token' => $liste->token]);
            $this->flash->addMessage('success', "Votre liste a été créée! Cliquez <a href='$link'>ici</a> pour y accéder.");
            $response = $response->withRedirect($this->router->pathFor('home'));
        } catch (Exception $e) {
            $this->flash->addMessage('error', $e->getMessage());
            $response = $response->withRedirect($this->router->pathFor('home'));
        }
        return $response;
    }

    public function afficherListes(Request $rq, Response $rs, array $args): Response{
        $rs->getBody()->write("Affichage de la liste des listes");
        $listl = Liste::all();
        $vue = new VueParticipant($listl,1);
        $rs->getBody()->write($vue->render(array()));
        return $rs;
    }
}