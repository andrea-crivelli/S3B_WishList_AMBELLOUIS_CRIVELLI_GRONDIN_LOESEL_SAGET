<?php

namespace wishlist\controleurs;

use DateTime;
use Exception;
use http\Message;
use wishlist\modeles\Liste;
use wishlist\modeles\Messages;
use wishlist\vues\VueCreateurListe;
use wishlist\vues\VueParticipant;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class ControleurListe extends Controleur {

    //afficher toutes les listes de la base de donnees
    public function afficherListes(Request $rq, Response $rs, array $args): Response{
        $rs->getBody()->write("Affichage de la liste des listes");
        $listl = Liste::all();
        $vue = new VueParticipant($listl, $this->c);
        $rs->getBody()->write($vue->render(1));
        return $rs;

    }

    //afficher une liste en particulier
    public function afficherListe(Request $rq, Response $rs, array $args): Response{
        $data['token'] = $args['token'];
        $listl = Liste::where('token', '=', $args['token'])->first();
        $data['liste']=$listl;
        $vue = new VueParticipant($data, $this->c);
        $rs->getBody()->write($vue->render(2));
        return $rs;
    }

    //affiche le formulaire pour la creation d'une liste
    public function afficherFormulaire(Request $rq,Response $rs, array $args) : Response{
        $vue=new VueCreateurListe($this->c,[]);
        $rs->getBody()->write($vue->render(1),[]);
        return $rs;
    }

    //affichage de la page de validation avec les liens de modification et de partage
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

    //affichage de la page qui laisse le choix au createur des actions a faire sur la liste
    public function afficherModifAjoutListe(Request $rq, Response $rs, array $args) : Response
    {
        $data['tokencreation']=$args['tokencreation' ];
        $data[0]=$this->c->router->pathFor('formulaireItem',['tokencreation'=>$args['tokencreation']]);
        $data[1]=$this->c->router->pathFor('afficherFormulaireModification',['tokencreation'=>$args['tokencreation']]);
        $data[2]=$this->c->router->pathFor('choixModification',['tokencreation'=>$args['tokencreation']]);
        $data[3]=$this->c->router->pathFor('choixSuppression',['tokencreation'=>$args['tokencreation']]);
        $data[4]=$this->c->router->pathFor('afficherFormulaireSuppression',['tokencreation'=>$args['tokencreation']]);
        $v=new VueCreateurListe($this->c,$data);
        $rs->getBody()->write($v->render(3));
        return $rs;
    }

    //affichage du formulaire permettant la modification de la liste
    public function afficherFormulaireModification(Request $rq, Response $rs, array $args) : Response {
        $data['tokencreation']=$args['tokencreation'];
        $vue=new VueCreateurListe($this->c,$data);
        $rs->getBody()->write($vue->render(4));
        return $rs;
    }

    //affichage du formulaire permettant la modification de la liste
    public function afficherFormulaireSuppression(Request $rq, Response $rs, array $args) : Response {
        $vue=new VueCreateurListe($this->c,['tokencreation'=>$args['tokencreation']]);
        $rs->getBody()->write($vue->render(5));
        return $rs;
    }

    //methode qui cree une liste et l'ajoute a la base de donnees
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

    //methode qui permet d'ajouter un message public a une liste
    public function creerMessageListe(Request $request,Response $response, array $args) : Response {
        $message = filter_var($request->getParsedBodyParam('msg'), FILTER_SANITIZE_STRING);
        $prenom = filter_var($request->getParsedBodyParam('prenom'), FILTER_SANITIZE_STRING);

        $idListe=Liste::where('token','=',$args['token'])->first()->no;

        if($message != ''){
            $m = new Messages();
            $m->idListe = $idListe;
            $m->message=$message;
            $m->participant=$prenom;
            $m->save();
        }
        $url = $this->c->router->pathFor('afficherListe',['token' => $args['token']]);
        return $response->withRedirect($url);
    }

    //methode pour modifier les informations generales d'une liste
    public function modifierListe(Request $request, Response $response, array $args) : Response {
        $titre = filter_var($request->getParsedBodyParam('titre'), FILTER_SANITIZE_STRING);
        $description = filter_var($request->getParsedBodyParam('descr'), FILTER_SANITIZE_STRING);
        $dateExpiration = $request->getParsedBodyParam('dateExpi');
        if (new DateTime() > new DateTime($dateExpiration)){
            throw new Exception("La date d'expiration est antérieure à la date courante.");
        }
        $l=Liste::where('tokencreation','=',$args['tokencreation'])->first();
        if ($titre != '' && $titre!=$l->titre) $l->titre=$titre;
        if($description != ''&& $description != $l->description) $l->description=$description;
        if ($dateExpiration != '' && new DateTime($dateExpiration)!= $l->expiration) $l->expiration=new DateTime($dateExpiration);
        $l->save();

        $url = $this->c->router->pathFor('modificationAjoutListe',['tokencreation' => $args['tokencreation']]);
        return $response->withRedirect($url);
    }

    //methode pour supprimer une liste avec son token de creation
    public function supprimerListe(Request $request, Response $response, array $args) : Response{
        Liste::where('tokencreation','=',$args['tokencreation'])->delete();

        $url = $this->c->router->pathFor('modificationAjoutListe',['tokencreation' => $args['tokencreation']]);
        return $response->withRedirect($url);

    }



}