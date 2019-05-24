
<?php
$page_title = 'Indicadores';
require_once 'menu.php';
?>    
      
    
    <body style="background-color: #343a40;" >
        <div class="Conten">
            <main role="main">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">

                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <?php include 'gf3.php' ?>            
                        </div>
                        <div class="carousel-item ">
                            <?php include 'gf1.php' ?>            
                        </div>
                        <div class="carousel-item">
                            <?php include 'gf2.php' ?> 
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
             <?php require_once 'foot.php';?>
    </body>
</html>