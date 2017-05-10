<html lang="en">
<?php
    session_start();
   
if ($_SESSION['loggedin'] === true) {
        include('globals.php');

        //remove all session variables
} else {
        header('Location: signin.php');
}
    
if (isset($_POST['logout'])) {
        
        // remove all session variables
        session_unset();

        // destroy the session
session_destroy();     
        
        
        header('Location: signin.php');
        
}
    
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
        die('Could not connect: ' . mysqli_error($conn));
}

    $sql = "SELECT league_name FROM league";
    $sql1 = "SELECT team_name FROM team";
    $sql2 = "SELECT `f_name`, `l_name` FROM players";
    
 
    $teams = mysqli_query($conn, $sql1); //contains all teams
    
    
    mysqli_close($conn);
    
 
        
      
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Favorite</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <!-- Theme CSS -->
    <link href="css/grayscale.css" rel="stylesheet">
    <link href="css/stylesheet.css" rel="stylesheet">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">
                    Welcome, <?php echo $_SESSION['username'] ?>
                </a>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                   
                        
                        <form class="page-scroll" method="post" action="index.php"> 
                            <button class="btn btn-primary logoutbutton" type="submit" name="logout">log out</button>
                        </form>
                    </li>

                        
                    
                </ul>
                
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Header -->
    <header class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="brand-heading">Erol Sports</h1>
                        <p class="intro-text">Presents</p>
                        <a href="#about" class="btn btn-circle page-scroll">
                            <i class="fa fa-angle-double-down animated"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- League Information -->
     <section id="download" class="content-section text-center">
        <div class="download-section">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2><?php
echo $_SESSION['username'] ?> Favorite team  </h2>
                    <p>Team information</p>
<?php
ob_start();
echo $_SESSION['username'] ;
$getname = ob_get_contents();
ob_end_clean();

                            $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
                                echo "here";
}
                    $sql3 = "SELECT * from team where team_name =(select fav from login where username='${getname}')";
                    
                            
                        
                            $teaminfo = mysqli_query($conn, $sql3); //contains all team columns
                            
                            mysqli_close($conn);
                            
                            $teamtable = '
                            <div class="col-md-7">
                                <div class="table-responsive">          
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th>Team</th>
                                            <th>Country</th>
                                            <th>Stadium</th>
                                            <th>City</th>
                                            <th>coach</th>
                                            <th>league name</th>
                                            
                                          </tr>
                                        </thead>
                                        <tbody>';
                            
                            echo $teamtable;
                            
                            echo '<tr>';
while ($row = $teaminfo->fetch_assoc()){
                                echo '<th>' . $row['team_name'] . '</th>' .
                                     '<th>' . $row['country'] . '</th>' .
                                     '<th>' . $row['stadium'] . '</th>' .
                                     '<th>' . $row['city'] . '</th>' .
                                     '<th>' . $row['coach'] . '</th>' .
                                     '<th>' . $row['league_name'] . '</tr>' .
                                     '<th' . $row['league_id'] . '</th>';
                            }  
                            echo '</tr>'; 
                            $teamtable2 = '
                                        </tbody>
                                    </table>
                                </div>
                            </div> ';
                            echo $teamtable2;
                         
                    
                    
                    ?>
	                
                	      
                </div>
            </div>
        </div>
                	      
                </div>
            </div>
        </div>
    </section>
 <!-- League Information -->
    <section id="about" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Up coming  Match  Fixture</h2>
                <p>
                <!-- This would just be a select * from League -->  
                <?php 
                    
                    
                    
                    
                    $leagueform = '<form action="favorite.php" method="post">
Select Month Of Upcoming Matches?
 <select class="form-control" name="month">
                            <option value="january"> january </option>
                            <option value="febuary">febuary </option>
                            <option value="march">march </option>
                            <option value="april">april </option>
                            <option value="may">may </option>
                            <option value="june">june </option>
                            <option value="july">july </option>
                            <option value="august">august</option>
                            <option value="september">september </option>
                            <option value="october">october </option>
                            <option value="november">november </option>
                            <option value="december">december </option>
                        </select>
<input type="submit" name="formSubmit" value="Submit">
</form>';                            
                         
                    
echo $leagueform;
if($_POST['formSubmit'] == "Submit")
{
$month = $_POST['month'];
echo $month;

}
                    

                ?>
                    
                    
                    
                    
                    
<?php
            
                                $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                                if (!$conn) {
                                    echo "here";
                                } 

                                $fixsql1 = "SELECT * FROM fixture WHERE month ='${month}'and  team1 =(select fav from login where username='${getname}') or team2=(select fav from login where username='${getname}')";


                                $fixinfo = mysqli_query($conn, $fixsql1); 
                    
                

                                mysqli_close($conn);
                    mysqli_close($conn);
                            
                            $fixtable = '
                            <div class="col-md-7">
                                <div class="table-responsive">          
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th>Month</th>
                                            <th>Day</th>
                                            <th>Home Team</th>
                                            <th>Away Team</th>
                                                                            
                                          </tr>
                                        </thead>
                                        <tbody>';
                            
                            echo $fixtable;
                                                echo '<tr>';
while ($row = $fixinfo->fetch_assoc()){
                                echo '<th>' . $row['month'] . '</th>' .
                                     '<th>' . $row['day'] . '</th>' .
                                     '<th>' . $row['team1'] . '</th>' .
                                     '<th>' . $row['team2'] . 
                                      '<tr>';
                                
                            } 
                    
                    ?>
                
                
                
                  
            </div>
        </div>
    </section>


    <!-- Map Section -->
    <div class="hidden" id="map"></div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>Made for IT635</p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Google Maps API Key - Use your own API key to enable the map feature. More information on the Google Maps API can be found at https://developers.google.com/maps/ -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false"></script>

    <!-- Theme JavaScript -->
    <script src="js/grayscale.min.js"></script>
    
    <!-- Main Javascript -->
    <script src="js/main.js"></script>
    

</body>

</html>
