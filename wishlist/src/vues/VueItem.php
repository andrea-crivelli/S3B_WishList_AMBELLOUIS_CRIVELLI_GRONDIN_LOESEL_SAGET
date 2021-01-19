<?php


namespace wishlist\vues;


class VueItem
{
    
    private $data;
    private $container;
    
    public function __construct($dt, $c)
    {
        $this->data = $dt;
        $this->container = $c;
    }

    private function htmlAfficherItemReserve()  : string{
        $html= "<main class='container'>
                  <div class='pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center'>
                    <h1 class='display-4'>{$this->data->nom}</h1>
                    <img src='../public/img/{$this->data->img}'>
                  </div>


                    <div class='col'>
                      <div class='card mb-4 shadow-sm'>
                      <div class='card-header''>
                        <h4 class='my-0 fw-normal'>{$this->data->nom}</h4>
                      </div>
                      <div class='card-body'>
                        <h1 class='card-title pricing-card-title'>{$this->data->tarif}€</h1>
                        <ul class='list-unstyled mt-3 mb-4'>
                          <p>{$this->data->descr}</p>
                        </ul>
                      </div>
                      <div>
                       <ul class='list-unstyled mt-3 mb-4'>
                          <p><a href='{$this->data->url}'>{$this->data->url}</a></p>
                          <p>Participant : {$this->data->participant}</p>
                        </ul>
                      </div>
                    </div>
                    </div>
                </main> ";

        return $html;
    }

    private function htmlAfficherItemNonReserve() :string {
        $url_reservation = $this->container->router->pathFor('afficherReservation',['token' => $this->data['token']]);
        $html= "<main class='container'>
                  <div class='pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center'>
                    <h1 class='display-4'>{$this->data->nom}</h1>
                    <img src='../public/img/{$this->data->img}'>
                  </div>


                    <div class='col'>
                      <div class='card mb-4 shadow-sm'>
                      <div class='card-header''>
                        <h4 class='my-0 fw-normal'>{$this->data->nom}</h4>
                      </div>
                      <div class='card-body'>
                        <h1 class='card-title pricing-card-title'>{$this->data->tarif}€</h1>
                        <ul class='list-unstyled mt-3 mb-4'>
                          <p>{$this->data->descr}</p>
                        </ul>
                      </div>
                      <div>
                       <ul class='list-unstyled mt-3 mb-4'>
                          <p><a href='{$this->data->url}'>{$this->data->url}</a></p>
                          
                        </ul>
                        <button><a  href='$url_reservation'>Réserver</a></button>
                      </div>
                    </div>
                    </div>
                </main> ";
        return $html;
    }

    private function afficherReservation() {
        $url_participer = $this->container->router->pathFor('reserverItem', ['token' => $this->data['token']]);
        $html= "<main class='container'>
                <form method=post>
                <br>
                <p> Participant : </p>             
                <input type='text', id='participant', name='participant'>
                </section>
                <br>
                <a href='$url_participer'><button>Participer</button></a>
                </form>
                </main> ";

        return $html;
    }

    //fonction qui affiche les items qui peuvent etre modifies
    private function afficherItemModifier(){
        $html="<section class ='content'>
        <h1 align='center'>Items de la liste</h1>
        Voici les items que vous pouvez modifier :
        <ul>";
        foreach ($this->data['liste']->items as $item){
            $url_item = $this->container->router->pathFor('formulaireModificationItem', ['id' => $item->id, 'tokencreation'=>$this->data['tokencreation']]);
            $html.= "<li><a class=\"nav - link\" href=\"$url_item\">{$item->nom}</a></li>";
        }
        $html.= "</ul>
    </section>";
    return $html;
    }

    //fonction qui affiche le formulaire de modification de l'item
    private function htmlFormulaireModification()
    {
        $html = <<<END
        <section class='content'>
        <h1 align="center">Modification des items </h1>
        Veuillez rentrer les informations que vous souhaitez modifier sur cet item :
        <!-- Données pour créer une liste -->
                <form method="post">
                    <div>
                        <label><strong>Titre :</strong></label><br>
                        <input type="text" id="name" name="titre">
                    </div>
                    <div>
                        <label><strong>Description :</strong></label><br>
                        <textarea type="texte" id="descr" name="descr"></textarea>
                    </div>
                    <div>
                        <label><strong>Image :</strong></label><br>
                        <input id="img" name="img">
                    </div>
                    <div>
                        <label><strong>Prix :</strong></label><br>
                        <input type="text" id="tarif" name="tarif">
                    </div>
                    <div>
                        <label><strong>Url externe du produit :</strong></label><br>
                        <input id="url" name="url">
                    </div>
                    
                    <div>
                    <br><button id="valider">Valider </button></a>
                    </div>
                </form>
        </section>
END;
        return $html;
    }

    //fonction qui affiche les items qui peuvent etre modifies
    private function afficherItemSupprimer(){
        $html="<section class ='content'>
        <h1 align='center'>Items de la liste</h1>
        Voici les items que vous pouvez supprimer :
        <ul>";
        foreach ($this->data['liste']->items as $item){
            $url_item = $this->container->router->pathFor('formulaireSuppressionItem', ['id' => $item->id, 'tokencreation'=>$this->data['tokencreation']]);
            $html.= "<li><a class=\"nav - link\" href=\"$url_item\">{$item->nom}</a></li>";
        }
        $html.= "</ul>
    </section>";
        return $html;
    }

        //fonction qui affiche le formulaire de suppression de l'item
        private function htmlFormulaireSuppression(){
            $url_oui = $this->container->router->pathFor('suppressionItem', ['id' => $this->data['id'], 'tokencreation'=>$this->data['tokencreation']]);
            $url_non=$this->container->router->pathFor('modificationAjoutListe', ['tokencreation'=>$this->data['tokencreation']]);
            $html=<<<END
        <section class='content'>
        <h1 align="center">Suppression des items </h1>
       Voulez-vous réellement supprimer cet item ?
       <button><a href="$url_oui">Oui</a></button>
       <button><a href="$url_non">Non</a></button>
        </section>
END;
            return $html;
        }


    public function render(int $select)
    {
        switch ($select){
            case 1 : {
                $content=$this->htmlAfficherItemReserve();
                $link1="../public/html/vendor/bootstrap/css/bootstrap.min.css";
                $link2="../public/html/css/shop-homepage.css";
                $link3="../public/html/vendor/jquery/jquery.min.js";
                $link4="../public/html/vendor/bootstrap/js/bootstrap.bundle.min.js";

                break;
            }case 2 : {
                $content=$this->htmlAfficherItemNonReserve();
                $link1="../public/html/vendor/bootstrap/css/bootstrap.min.css";
                $link2="../public/html/css/shop-homepage.css";
                $link3="../public/html/vendor/jquery/jquery.min.js";
                $link4="../public/html/vendor/bootstrap/js/bootstrap.bundle.min.js";

            break;
            }case 3 : {
                $content=$this->afficherReservation();
                $link1="../public/html/vendor/bootstrap/css/bootstrap.min.css";
                $link2="../public/html/css/shop-homepage.css";
                $link3="../public/html/vendor/jquery/jquery.min.js";
                $link4="../public/html/vendor/bootstrap/js/bootstrap.bundle.min.js";
            break;
            }case 4 : {
                $content=$this->afficherItemModifier();
                $link1="../../../public/html/vendor/bootstrap/css/bootstrap.min.css";
                $link2="../../../public/html/css/shop-homepage.css";
                $link3="../../../public/html/vendor/jquery/jquery.min.js";
                $link4="../../../public/html/vendor/bootstrap/js/bootstrap.bundle.min.js";
            break;
            }case 5: {
                $content=$this->htmlFormulaireModification();
                $link1="../../../../public/html/vendor/bootstrap/css/bootstrap.min.css";
                $link2="../../../../public/html/css/shop-homepage.css";
                $link3="../..§../../public/html/vendor/jquery/jquery.min.js";
                $link4="../../../../public/html/vendor/bootstrap/js/bootstrap.bundle.min.js";
            break;
            }case 6:

        {
            $content = $this->afficherItemSupprimer();
            $link1 = "../../../public/html/vendor/bootstrap/css/bootstrap.min.css";
            $link2 = "../../../public/html/css/shop-homepage.css";
            $link3 = "../../../public/html/vendor/jquery/jquery.min.js";
            $link4 = "../../../public/html/vendor/bootstrap/js/bootstrap.bundle.min.js";
            break;
        }
        case 7:
        {
            $content = $this->htmlFormulaireSuppression();
            $link1 = "../../../../public/html/vendor/bootstrap/css/bootstrap.min.css";
            $link2 = "../../../../public/html/css/shop-homepage.css";
            $link3 = "../..§../../public/html/vendor/jquery/jquery.min.js";
            $link4 = "../../../../public/html/vendor/bootstrap/js/bootstrap.bundle.min.js";
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
              <link href=$link1 rel="stylesheet">
            
              <!-- Custom styles for this template -->
              <link href=$link2 rel="stylesheet">

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

              <!-- Page Content -->
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
              <script src=$link3></script>
              <script src=$link4></script>

            </body>

            </html>


END;
    return $html;
    }
}