<!--Template Name:citreat
File Name:menucard.html
Author Name: ThemeVault
Author URI: http://www.themevault.net/
License URI: http://www.themevault.net/license/-->
<!DOCTYPE html>
<html>
    <head>
    <title>Resto Finder</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="images/favicon.png" rel="icon"/>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/scrolling-nav.css" rel="stylesheet">
        
        <link href="css/magnific-popup.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">
        <script src= "js/jquery.min.js" type= "text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/magnific-popup.js" type="text/javascript"></script>
        <script src="js/scrolling-nav.js" type="text/javascript"></script>
        <script src="js/custom.js" type="text/javascript"></script>

        <style>
            #search{
                margin-top: 70px;
                margin-left: 175px; margin-right:75%;
            }

            #search-input{
                width: 200px;
            }

            #search-button{
                margin-left: 210px;
                margin-top: -55px;
            }

            #list{
                width:75%;
                margin-left: 175px;
                margin-right:150px;
            }

            #buttons{
                margin-left: 175px;
                margin-top: 10px;
                margin-bottom: 20px;
            }

            #buttons button{
                background-color: #fc4e03;
            }
            button{
                background-color: #fc4e03;
            }


        </style>
    </head>

    <body>

          <!--Header Section-->
          <header>
            <nav class="navbar navbar-default navbar-fixed-top tv-navbar-custom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="navbar-header text-center">
                            <a href="home.html" class="navbar-brand tv-citreat-logo">Resto Finder</a>
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#tv-navbar">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="collapse navbar-collapse" id="tv-navbar">
                                <ul class="nav navbar-nav text-center tv-small-bg tv-active-menu">
                                    <li class=""><a href="home.html" class="tv-menu">Home</a></li>
                                    <li class=""><a href="aboutus.html" class="tv-menu">About Us</a></li>
                                    <li class=""><a href="list-restaurants.php" class="tv-menu">List of Restaurants</a></li>
                                    <li class=""><a href="best-quality.php" class="tv-menu">Best Quality</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!--Banner Section-->
            <div class="tv-inner-banner-image" style="background: rgba(0, 0, 0, 0) url('images/Image1.png') no-repeat scroll center top / cover;">
                <div class="tv-opacity-medium tv-bg-black"></div>
                <div class="tv-banner-title">
                    <h1>List of Restaurants</h1>
                </div>
            </div>
            <!--End Banner Section-->
        </header>
        <!--End Header Section-->

            
        

        <form action ="" id="search" method="GET">
        <input id="search-input" class="form-control me-sm-2" type="text" name="query" placeholder="Search">
        <button id="search-button" class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>

        

        <div id="buttons">
            <form action="" method="GET">
        <button type="submit" name='all' class="btn btn-primary">All</button></a>
        <button type="submit" name='borough' value="Brooklyn" class="btn btn-primary">Brooklyn</button></a>
        <button type="submit" name='borough' value="Bronx" class="btn btn-primary">Bronx</button></a>
        <button type="submit" name='borough' value="Manhattan" class="btn btn-primary">Manhattan</button></a>
        <button type="submit" name='borough' value="Queens" class="btn btn-primary">Queens</button></a>
        <button type="submit" name='borough' value="Staten Island" class="btn btn-primary">Staten Islands</button></a>
        </form>
        </div>

     

        <?php 
                        require_once __DIR__ . "/vendor/autoload.php";
                        $client = new MongoDB\Client("mongodb+srv://katrinanardo:finalsadvbase@cluster0.m7jxgip.mongodb.net/test");
                        $db = $client->sample_restaurants;
                        $collection = $db->restaurants;
                        $cursor = $collection->aggregate([['$unwind' => ['path' => '$grades']], ['$project' => ['name' => 1, 'grades' => 1, 'borough' => 1, 'cuisine' => 1, 'address'=>1]]]);

                        if(array_key_exists('borough', $_GET)){
                            $cursor = $collection->aggregate([['$unwind' => ['path' => '$grades']], ['$project' => ['name' => 1, 'grades' => 1, 'borough' => 1, 'cuisine' => 1, 'address'=>1]], ['$match' => ['borough' => $_GET['borough']]]]);
                        }elseif(array_key_exists('query', $_GET)){
                            $cursor = $collection->aggregate([['$unwind' => ['path' => '$grades']], ['$project' => ['name' => 1, 'grades' => 1, 'borough' => 1, 'cuisine' => 1, 'address'=>1]], 
                            ['$match' => ['$or' => [['name'=> new MongoDB\BSON\Regex('^'.$_GET['query'], 'i')],/*['borough'=>new MongoDB\BSON\Regex('^'.$_GET['query'])],*/
                            ['cuisine'=>new MongoDB\BSON\Regex('^'.$_GET['query'], 'i')]]]]]);
                        }
                        else{
                            $cursor = $collection->aggregate([['$unwind' => ['path' => '$grades']], ['$project' => ['name' => 1, 'grades' => 1, 'borough' => 1, 'cuisine' => 1, 'address'=>1]]]);
                        }
                
                        
                            echo '<table id="list" class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Name</th>";
                                        echo "<th>Cuisine</th>";
                                        echo "<th>Borough</th>";
                                        echo "<th>Address</th>";
                                        echo "<th>Grades</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach ($cursor as $document){
                                    echo "<tr>";
                                        echo "<td>" . $document['name'] . "</td>";
                                        echo "<td>" . $document['cuisine'] . "</td>";
                                        echo "<td>" . $document['borough'] . "</td>";
                                        echo "<td>";
                                            echo $document['address']['building']. ", ";
                                            echo $document['address']['street'].", ";
                                            echo $document['address']['zipcode'];
                                        echo "</td>";
                                        echo "<td>";
                                            echo $document['grades']['date']. ", ";
                                            echo $document['grades']['grade'].", ";
                                            echo $document['grades']['score'];
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                        
                    ?>
        <!--Footer Section-->
        <footer class="tv-section-padding">
            <div class="tv-fixed-img tv-section-footer-padding" style="background-image:url('images/Image7.png')">
                <div class="tv-footer-bg tv-bg-citreat"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="tv-footer-title">
                            <a href="home.html">Resto Finder</a>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="tv-footer-desc">
                                <ul class="list-unstyled footer-menu">
                                    <li class=""><a class="tv-menu">home</a></li>
                                    <li class=""><a class="tv-menu">Restaurants</a></li>
                                    <li class=""><a class="tv-menu">About Us</a></li>
                                    <li class=""><a class="tv-menu">Best Quality</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="tv-footer-copyright text-center">
                                <p>&copy; Resto Finder</a> </p>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </footer>
        <!--End Footer Section-->

        <a id="back-to-top" style="display: none;"><img src="images/groceries.png" /></a>
    </body>
</html>
