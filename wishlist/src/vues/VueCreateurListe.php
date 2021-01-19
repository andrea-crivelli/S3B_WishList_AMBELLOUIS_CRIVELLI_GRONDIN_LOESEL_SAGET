<?php


namespace wishlist\vues;


class VueCreateurListe
{

    private $container,$data;

    public function __construct($container,$data)
    {
        $this->container = $container;
        $this->data=$data;
    }

    //afficher la création de la liste
    private function htmlCreationListe(){

        $html = <<<END
            <section class ='content'>
            <h1 align = center>Création d'une nouvelle liste</h1>
            Veuillez rentrer les informations la liste que vous souhaitez créer :

         <!-- Données pour créer une liste -->
                <form method="post">
                    <div>
                        <label><strong>Titre* :</strong></label><br>
                        <input type="text" id="name" name="titre" class="creationListe">
                    </div>
                    <div>
                        <label><strong>Description :</strong></label><br>
                        <textarea type="texte" id="descr" name="descr" class="creationListe"></textarea>
                    </div>
                    <div>
                        <label><strong>DateExpiration :</strong></label><br>
                        <input type="date" id="dateExpir" name="dateExpi" class ="creationListe">
                    </div>
                    
                    <div>
                    <br> <button>Valider </button></a>
                    </div>
                </form>
</section>
END;
        return $html;
    }


    //afficher le lien qui envoie sur la nouvelle liste créée
    private function htmlLienListe(){
        $tokencreation=$this->data[0];
        $url_modifAjout = $this->container->router->pathFor('modificationAjoutListe',['tokencreation'=>$tokencreation]);
        $url_modification=$this->data[1];
        $url_partage=$this->data[2];

        $html = <<<END
            <section class ='content'>
                <h2>Votre liste a été créée.</h2><br>
                Si vous voulez la modifier, il vous fait utiliser l'url suivant :<br><a href="$url_modification">$url_modification</a><br><br>
                Si vous souhaitez la partager, envoyer l'url suivant aux personnes concernées :<br> <a href = "$url_partage">$url_partage</a><br>

           
           <br><button><a  href="$url_modifAjout">Modifier/Ajouter Item</a></button></section>
</section>
END;
        return $html;
    }

    private function htmlModifAjout()
    {
        $url_ajout = $this->data[0];
        $url_modif = $this->data[1];

        $html = <<<END
            <section class ='content'>
                <h2 align="center">Modification / ajout d'items</h2>
                Souhaitez-vous ajouter des items à votre liste ou modifier la liste ?<br><br>
                
                <button align = "center"><a href="$url_modif">Modifier la liste</a></button>
                <button><a href="$url_ajout">Ajouter des items</a> </button>
                <button>Modifier des items</button>
                <button>Supprimer des items</button>

           
</section>
END;
        return $html;
    }

    private function htmlFormulaireModification(){
        $html = <<<END
            <section class ='content'>
            <h1 align = center>Modification de votre liste</h1>
            Veuillez rentrer les informations que vous souhaitez modifier sur cette liste :

         <!-- Données pour créer une liste -->
                <form method="post">
                    <div>
                        <label><strong>Titre* :</strong></label><br>
                        <input type="text" id="name" name="titre" class="creationListe">
                    </div>
                    <div>
                        <label><strong>Description :</strong></label><br>
                        <textarea type="texte" id="descr" name="descr" class="creationListe"></textarea>
                    </div>
                    <div>
                        <label><strong>DateExpiration :</strong></label><br>
                        <input type="date" id="dateExpir" name="dateExpi" class ="creationListe">
                    </div>
                    
                    <div>
                    <br> <button>Valider </button></a>
                    </div>
                </form>
</section>
END;
        return $html;
    }


    public function render(int $select){
        switch ($select) {
            case 1 :
            {
                $content = $this->htmlCreationListe();
                $link1="../public/html/vendor/bootstrap/css/bootstrap.min.css";
                $link2="../public/html/css/shop-homepage.css";
                $link3="../public/html/vendor/jquery/jquery.min.js";
                $link4="../public/html/vendor/bootstrap/js/bootstrap.bundle.min.js";
                break;
            }
            case 2 :
            {
                $content = $this->htmlLienListe();
                $link1="../../../../public/html/vendor/bootstrap/css/bootstrap.min.css";
                $link2="../../../../public/html/css/shop-homepage.css";
                $link3="../../../../public/html/vendor/jquery/jquery.min.js";
                $link4="../../../../public/html/vendor/bootstrap/js/bootstrap.bundle.min.js";
                break;
            }
            case 3 :
            {
                $content = $this->htmlModifAjout();
                $link1="../../../public/html/vendor/bootstrap/css/bootstrap.min.css";
                $link2="../../../public/html/css/shop-homepage.css";
                $link3="../../../public/html/vendor/jquery/jquery.min.js";
                $link4="../../../public/html/vendor/bootstrap/js/bootstrap.bundle.min.js";
                break;
            }

            case 4 :
            {
                $content = $this->htmlFormulaireModification();
                $link1="../../../public/html/vendor/bootstrap/css/bootstrap.min.css";
                $link2="../../../public/html/css/shop-homepage.css";
                $link3="../../../public/html/vendor/jquery/jquery.min.js";
                $link4="../../../public/html/vendor/bootstrap/js/bootstrap.bundle.min.js";
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