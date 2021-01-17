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
    private function htmlListe(){

        $html = <<<END
            <section class ='content'>
         <!-- Données pour créer une liste -->
                <form method="post">
                    <div>
                        <label>Titre :</label>
                        <input type="text" id="name" name="titre">
                    </div>
                    <div>
                        <label>Description :</label>
                        <textarea type="texte" id="descr" name="descr"></textarea>
                    </div>
                    <div>
                        <label>DateExpiration :</label>
                        <input id="dateExpir" name="dateExpi">
                    </div>
                    
                    <div>
                    <button>Valider </button></a>
                    </div>
                </form>
END;
        return $html;
    }


    //afficher le lien qui envoie sur la nouvelle liste créée
    private function htmlLienListe(){

        //$url_creationItem = $this->container->router->pathFor('formulaireItem');
        $url_modification=$this->data[0];
        $url_partage=$this->data[1];
        $html = <<<END
            <a class ='content'>
                <h2>Votre liste a été créée.</h2><br>
                Si vous voulez la modifier, il vous fait utiliser l'url suivant :<br><a href="$url_modification">$url_modification</a><br><br>
                Si vous souhaitez la partager, envoyer l'url suivant aux personnes concernées :<br> <a href = "$url_partage">$url_partage</a><br>

           
           <button><a  href="url_creationItem">Modifier/Ajouter Item</button></a>
</section>
END;
        return $html;
    }



    public function render(int $select){
        switch ($select) {
            case 1 :
            {
                $content = $this->htmlListe();
                break;
            }
            case 2 :
            {
                $content = $this->htmlLienListe();
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
            
                $content
            
              <!-- Footer -->
              <footer class="py-5 bg-dark">
                <div class="container">
                  <p class="m-0 text-center text-white">Copyright &copy; MyWishlist 2021</p>
                </div>
                <!-- /.container -->
              </footer>
            
              <!-- Bootstrap core JavaScript -->
              <script src="public/html/vendor/jquery/jquery.min.js"></script>
              <script src="public/html/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            
            </body>
            
            </html>

END;

        return $html;
    }


}