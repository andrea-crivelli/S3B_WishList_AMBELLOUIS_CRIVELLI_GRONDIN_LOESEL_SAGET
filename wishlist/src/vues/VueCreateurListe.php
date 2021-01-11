<?php


namespace wishlist\vues;


class VueCreateurListe
{

    private $titre, $descr, $dateExpi;
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function render(array $vars)
    {

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
              <link href="public/html/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            
              <!-- Custom styles for this template -->
              <link href="public/html/css/shop-homepage.css" rel="stylesheet">
            
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
            
            <!-- Données pour créer une liste -->
            
            <button class="navbar-toggler" name="titre">
            <button class="navbar-toggler" name="description">
            <button class="navbar-toggler" name="DateExpiration">
            
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