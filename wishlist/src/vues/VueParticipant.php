<?php

namespace wishlist\vues;

    use wishlist\modeles\Liste;


    class VueParticipant {

        private $data;
        private $container;

        public function __construct($data, $container)
        {
            $this->data=$data;
            $this->container=$container;
        }



    //afficher toutes les listes de souhaits
    private function htmlListeSouhait()  : string{
        $html= '';
        foreach ( $this->data as $liste){
            $url_liste = $this->container->router->pathFor('afficherListe', ['token' => $liste->token]);
            $html.="<section class='content'>
                            <li>{$liste->titre}</li>
                            <a class=\"nav-link\" href=\"$url_liste\">Afficher liste</a>
                        </section>";
        }
        return $html;
    }

    //afficher les items de la liste en parametre
    private function htmlListeItems() : string{
        $token=$this->data[0];
        $url_message = $this->container->router->pathFor('creerMessageListe',['token'=>$token]);

        $html='';
        $html.= "<section class='content'>
                    <h2 align='center'>{$this->data->titre}</h2>
                        <p><strong>Description </strong>: {$this->data->description}</p>
                        <p><strong>Date d'expiration </strong>: {$this->data->expiration}</p>
                        <p>Items de la liste : </p>";

        foreach ($this->data->items as $item){
            $url_item = $this->container->router->pathFor('afficherItem', ['token' => $item->token]);
            $html.= "<ul><li><a class=\"nav - link\" href=\"$url_item\">{$item->nom}</a></li></ul>";
        }

        $html.= "<br>
                Messages de la liste :<br><ul>";

                    foreach ($this->data->message as $message){
                    $html.= "<li> {$message->participant} a écrit : {$message->message}</li>";
                    }

        $html.="</ul><form method=post>
                <br>
                <p> Ajouter un message : </p>
                <textarea type=text id='msg', name='msg'></textarea>
                <p> Prenom : </p>             
                <input type='text', id='prenom', name='prenom'>
                </section>
                <br>
                <a href='$url_message'><button>Envoyer Message</button></a>
                </form>";
        return $html;
    }


        public function render(int $select){
           switch ($select){
                case 1 : {
                    $content=$this->htmlListeSouhait();
                    break;
                }
                case 2 : {
                    $content=$this->htmlListeItems();
                    break;
                }
            }

            $url_accueil = $this->container->router->pathFor('accueil');
            $url_listes = $this->container->router->pathFor('afficherListes');
            $url_creationl = $this->container->router->pathFor('creationListe');


            $html = <<<END
                <!DOCTYPE html>
                <html lang="fr">
                
                <head>
                
                  <meta charset="utf-8">
                  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                  <meta name="description" content="">
                  <meta name="author" content="">
                
                  <title>MyWishlist</title>
                
                  <!-- Bootstrap core CSS -->
                  <link href="../public/html/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
                
                  <!-- Custom styles for this template -->
                  <link href="../public/html/css/shop-homepage.css" rel="stylesheet">
                
                </head>
                
                <body>
                
                  <!-- Navigation -->
                  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                    <div class="container">
                      <a class="navbar-brand" href="$url_accueil">MyWishlist</a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse" id="navbarResponsive">
                        <ul class="navbar-nav ml-auto">
                          <li class="nav-item active">
                            <a class="nav-link" href="$url_accueil">Accueil
                              <span class="sr-only">(current)</span>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="$url_listes">Listes</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="$url_creationl">Créer une liste</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Compte</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </nav>
                
                 <div class="m-3">
              $content
                </div>
                
                <!-- Footer -->
                <footer class="py-5 bg-dark">
                <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; MyWishlist 2021</p>
                </div>
                <!-- /.container -->
                </footer>
                
                  <!-- Bootstrap core JavaScript -->
                  <script src="../public/html/vendor/jquery/jquery.min.js"></script>
                  <script src="../public/html/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                
                </body>
                
                </html>
END;

            return $html;
        }
    }