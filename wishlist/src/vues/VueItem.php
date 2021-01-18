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

    private function htmlAfficherItem()  : string{
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
                      </div>
                    </div>
                    </div>
                </main> ";

        return $html;
    }

    public function htmlReserverItem() :string {
        $html = "\"<main class='container'>
                  <div class='pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center'>
                    <h1 class='display-4'>Nom du produit</h1>
                    <img src='img.jpg'>
                  </div>


                    <div class='col'>
                      <div class='card mb-4 shadow-sm'>
                      <div class='card-header''>
                        <h4 class='my-0 fw-normal'>Nom produit</h4>
                      </div>
                      <div class='card-body'>
                        <h1 class='card-title pricing-card-title'>Prix Produit</h1>
                        <ul class='list-unstyled mt-3 mb-4'>
                          <p>Description Produit</p>
                        </ul>
                      </div>
                    </div>
                    </div>
                </main> \";";
        return $html;
    }
    public function render(int $select)
    {
        switch ($select){
            case 1 : {
                $content=$this->htmlAfficherItem();
                break;
            }case 2 : {
                $content=$this->htmlReserverItem();
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

              <!-- Page Content -->
              <div class="container">
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