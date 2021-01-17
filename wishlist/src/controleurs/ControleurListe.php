<?php

namespace wishlist\controleurs;

use DateTime;
use Exception;
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
        $vue=new VueCreateurListe($this->c,[]);
        $rs->getBody()->write($vue->render(1),[]);
        return $rs;
    }


    public function creerListe (Request $request,Response $response, array $args) : Response{
        $titre = filter_var($request->getParsedBodyParam('titre'), FILTER_SANITIZE_STRING);
        $description = filter_var($request->getParsedBodyParam('descr'), FILTER_SANITIZE_STRING);
        $dateExpiration = $request->getParsedBodyParam('dateExpi');
        if (new DateTime() > new DateTime($dateExpiration)){
            throw new Exception("La date d'expiration est antérieure à la date courante.");
        }
        if($titre != '') {
            $l = new Liste();
            $l->titre = $titre;
            $l->description = $description;
            $l->expiration = $dateExpiration;
            $l->token = bin2hex(openssl_random_pseudo_bytes(32));
            $l->tokencreation=bin2hex(openssl_random_pseudo_bytes(12));
            $l->save();
        }
        $url = $this->c->router->pathFor('validationCreation',['tokencreation' => $l->tokencreation,'token' => $l->token]);
        return $response->withRedirect($url);
    }

    public function afficherPageValidation(Request $rq, Response $rs, array $args) : Response{
        //tokencreation
        $data[0]=$args['tokencreation'];
        //url de modification
        $data[1]=$this->c->router->pathFor('modificationAjoutListe',['tokencreation' => $args['tokencreation']]);
        //url de partage
        $data[2]=$this->c->router->pathFor('afficherListe',['token' => $args['token']]);
        $v=new VueCreateurListe($this->c,$data);
        $rs->getBody()->write($v->render(2));
        return $rs;
    }

    public function afficherModifAjoutListe(Request $rq, Response $rs, array $args) : Response
        {
            $data['tokencreation']=$args['tokencreation' ];
            $data[0]=$this->c->router->pathFor('formulaireItem',['tokencreation'=>$args['tokencreation']]);
            $data[1]=$this->c->router->pathFor('modifierListe',['tokencreation'=>$args['tokencreation']]);
            $v=new VueCreateurListe($this->c,$data);
            $rs->getBody()->write($v->render(3));
            return $rs;
        }
    }