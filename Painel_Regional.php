
<?php




$page_title = 'Indicadores';
include 'menu_local.php';
?>
<!doctype html>
<html lang="pt">

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">	
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>	
         <link rel="stylesheet"  type="text/css" href="css/stylepaineis.css" media="screen"/>
    </head>
    <body style="background-color: #343a40">
        <div class="Conten">
            <main role="main">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    
                    <div class="carousel-inner">

                        <div class="carousel-item active">
                            <?php include 'graf_ansl.php' ?>            
                        </div>

                        <div class="carousel-item" >
                            <?php include 'gf6.php' ?>          
                        </div>

                        <div class="carousel-item ">
                            <?php include 'graf7.php' ?>            
                        </div>

                    </div>

                    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </main>
        </div>
        <script src="js/jquery.js"></script>
        <script src="js/jquery_1.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>