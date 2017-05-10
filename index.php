<html lang="en">
<?php 
    
    session_start();
   
    if($_SESSION['loggedin'] === true) {
        include('globals.php');

        //remove all session variables
    } else {
        header('Location: signin.php');
    } 
    
    if(isset($_POST['logout'])){
        
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
    
    $leagues = mysqli_query($conn, $sql); //contains all leagues
    $teams = mysqli_query($conn, $sql1); //contains all teams
    
    $players = mysqli_query($conn,$sql2); //contains all players
    
    
    mysqli_close($conn);
    
    if(isset($_POST['submitmatch'])){
        
        $team_1 = $_POST['team1'];
        $team_2 = $_POST['team2'];
        $team_1score = intval($_POST['score1']);
        $team_2score= intval($_POST['score2']);
        $match_month = $_POST['month'];
        $match_day = intval($_POST['day']);
        $match_year = intval($_POST['year']);
        
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error($conn));
        }
        
        $matchquery = "INSERT INTO match_day ( `team_1`,`team_2`,`team_1score`,`team_2score`,`match_month`,`match_day`,`match_year`) " .  
        "VALUES ('${team_1}','${team_2}','${team_1score}','${team_2score}','${match_month}','${match_day}','${match_year}')"; 
        
        
        $retval = mysqli_query($conn,$matchquery); 
        
        mysqli_close($conn);
       
    }
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MySports</title>

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
                    <li>
                        <a class="page-scroll" href="#about">League</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#download">Team</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#players">Players</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#matches">Matches</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="favorite.php">Favorite</a>
                    </li>
                    
                    <li>
                        
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
                        <h1 class="brand-heading">MySports</h1>
                        <p class="intro-text">I display information about players, matches, and teams.</p>
                        <a href="#about" class="btn btn-circle page-scroll">
                            <i class="fa fa-angle-double-down animated"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- League Information -->
    <section id="about" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>League(s) Information</h2>
                <p>Browse through various leagues, teams, and players.
                <!-- This would just be a select * from League -->  
                <?php 
                    
                    
                    
                    
                    $leagueform = '<form class="col-md-4" method="post" action="index.php">
                        <div class="">
                            Choose a League
                            <!-- 
                                Pull all leagues from the backend and populate the selection form

                                if the submit button is set,
                                    make a select statement to the back with those values
                                    populate the table with information on the leagues
                            -->
                    
                    
                            <select multiple name="myleague" class="form-control searchboxes" id="sel2">';
                    
                    $leagueform2 = '</select>
                        </div> 

                        <button type="submit" class="btn btn-primary" name="submitleague">Search</button>
                    </form>'; 
                    echo $leagueform;
                
                    
                    while ($row = $leagues->fetch_assoc()){
                        echo '<option value="' . $row['league_name'] .'">' . $row['league_name'] . '</option>';
                    }
                    
                    echo $leagueform2;
                    
                    if(isset($_POST['submitleague'])){
                            $curleague = $_POST['myleague'];
                            $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                            if (!$conn) {
                                echo "here";
                                die();
                            } 
                            
                            $sql4 = "SELECT * FROM league WHERE league_name='${curleague}'";
                            
                        
                            $leagueinfo = mysqli_query($conn, $sql4); //contains all team columns
                            
                            mysqli_close($conn);
                            
                            $leaguetable = '
                            <div class="col-md-7">
                                <div class="table-responsive">          
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th>League Name</th>
                                            <th>Country</th>
                                            <th>Federation</th>
                                            <th>President</th>
                                            <th>Continent</th>
                                          </tr>
                                        </thead>
                                        <tbody>';
                            
                            echo $leaguetable;
                            
                            echo '<tr>';
                            while ($row = $leagueinfo->fetch_assoc()){
                                echo '<td>' . $row['league_name'] . '</td>' .
                                     '<td>' . $row['country'] . '</td>' .
                                     '<td>' . $row['Federation'] . '</td>' .
                                     '<td>' . $row['President'] . '</td>' .
                                     '<td>' . $row['Continent'] . '</td>';
                            }  
                            echo '</tr>'; 
                            $leaguetable2 = '
                                        </tbody>
                                    </table>
                                </div>
                            </div> ';
                            echo $leaguetable2;
                        }  
                ?>
                
                
                
                  
            </div>
        </div>
    </section>

    <!-- Team Information -->
    <section id="download" class="content-section text-center">
        <div class="download-section">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2>Team(s) Information</h2>
                    <p>Look up different things about teams</p>
                    <?php 
                    
                    
                        $teamform = '<form class="col-md-4" method="post" action="index.php">
                            <div class="">
                                Choose a Team
                                <select name="myteam" multiple name="curleague" class="form-control searchboxes" id="sel2">';

                        $teamform2 = '</select>
                            </div> 

                            <button type="submit" class="btn btn-primary" name="submitteam">Search</button>
                        </form>'; 
                        echo $teamform;

                        
                        while ($row = $teams->fetch_assoc()){
                            echo '<option value="' . $row['team_name'] .'">' . $row['team_name'] . '</option>';
                        }

                        echo $teamform2;
                        echo '<div class="col-md-1"> &nbsp;</div>';
                    
                        if(isset($_POST['submitteam'])){
                            $curteam = $_POST['myteam'];
                            $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                            if (!$conn) {
                                echo "here";
                            } 
                            
                            $sql3 = "SELECT * FROM team WHERE team_name='${curteam}'";
                            
                        
                            $teaminfo = mysqli_query($conn, $sql3); //contains all team columns
                            
                            mysqli_close($conn);
                            
                            $teamtable = '
                            <div class="col-md-7">
                                <div class="table-responsive">          
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th>team_name</th>
                                            <th>country</th>
                                            <th>stadium</th>
                                            <th>city</th>
                                            <th>coach</th>
                                            <th>league name</th>
                                            <th>league ID</th>
                                          </tr>
                                        </thead>
                                        <tbody>';
                            
                            echo $teamtable;
                            
                            echo '<tr>';
                            while ($row = $teaminfo->fetch_assoc()){
                                echo '<td>' . $row['team_name'] . '</td>' .
                                     '<td>' . $row['country'] . '</td>' .
                                     '<td>' . $row['stadium'] . '</td>' .
                                     '<td>' . $row['city'] . '</td>' .
                                     '<td>' . $row['coach'] . '</td>' .
                                     '<td>' . $row['league_name'] . '</td>' .
                                     '<td>' . $row['league_id'] . '</td>';
                            }  
                            echo '</tr>'; 
                            $teamtable2 = '
                                        </tbody>
                                    </table>
                                </div>
                            </div> ';
                            echo $teamtable2;
                        }  
                    
                    
                    ?>
	                
                	      
                </div>
            </div>
        </div>
    </section>

    <!-- Look Up Players -->
    <section id="players" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Look Up Player(s)</h2>
                <?php
                
                        $playerform = '<form class="col-md-4" method="post" action="index.php">
                        <div class="">
                            <select name="myplayer" multiple class="form-control searchboxes" id="sel2">';

                        $playerform2 = '</select>
                            </div> 

                            <button type="submit" class="btn btn-primary" name="submitplayers">Search</button>
                        </form>'; 
                        echo $playerform;

                        
                        while ($row = $players->fetch_assoc()){
                            echo '<option value="' . $row['f_name'] .'">' . $row['f_name'] . ' ' . $row['l_name'] . '</option>';
                        }

                        echo $playerform2;   
                
                        if(isset($_POST['submitplayers'])){
                            $curplayer = $_POST['myplayer'];
                            $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                            if (!$conn) {
                                echo "here";
                                die();
                            } 
                            
                            $sql5 = "SELECT * FROM players WHERE f_name='${curplayer}'";
                            
                        
                            $playerinfo = mysqli_query($conn, $sql5); //contains all team columns
                            
                            mysqli_close($conn);
                            
                            $playertable = '
                            <div class="col-md-7">
                            
                                <div class="table-responsive">          
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Games Played</th>
                                            <th>Goals Scored</th>
                                            <th>Date of Birth</th>
                                            <th>Team Name</th>
                                            
                                          </tr>
                                        </thead>
                                        <tbody>';
                            
                            echo $playertable;
                            
                            echo '<tr>';
                            while ($row = $playerinfo->fetch_assoc()){
                                echo '<td>' . $row['f_name'] . '</td>' .
                                     '<td>' . $row['l_name'] . '</td>' .
                                     '<td>' . $row['gp'] . '</td>' .
                                     '<td>' . $row['gs'] . '</td>' .
                                     '<td>' . $row['dob'] . '</td>' .
                                     '<td>' . $row['team_name'] . '</td>';
                                     
                            }  
                            echo '</tr>'; 
                            $playertable2 = '
                                        </tbody>
                                    </table>
                                </div>
                            </div> ';
                            echo $playertable2;
                        }  
                    
                
                ?>

            </div>
        </div>
    </section>
    
    <section id="matches" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <form method="post" action="index.php">
                    <div class="form-group">
                        <legend style="color:white;">Submit A Match</legend>
                        <label>Select Team 1</label>
                        <select name="team1" class="form-control">
                            <?php
                                $allteamsquery = "SELECT team_name FROM team";
                                $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                                if (!$conn) {
                                    die('Could not connect: ' . mysqli_error($conn));
                                }
                                $allteams = mysqli_query($conn, $allteamsquery);
                                
                                while ($row = $allteams->fetch_assoc()){
                                    echo '<option value="' . $row['team_name'] .'">' . $row['team_name'] . '</option>';
                                }
                            
                            
                            ?>
                        </select>

                        <label>
                        Enter Score for Team one     
                        </label>
                        <input type="text" name="score1" class="form-control">
                        <br>

                        <label>
                        Select team two 
                        </label>
                        <select name="team2" class="form-control">
                            <?php
                                $allteamsquery = "SELECT team_name FROM team";
                                $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                                if (!$conn) {
                                    die('Could not connect: ' . mysqli_error($conn));
                                }
                                $allteams = mysqli_query($conn, $allteamsquery);
                                
                                while ($row = $allteams->fetch_assoc()){
                                    echo '<option value="' . $row['team_name'] .'">' . $row['team_name'] . '</option>';
                                }                        
                            
                            
                            ?>
                        </select>

                        <label>
                        Enter Score for Team Two      
                        </label>
                        <input type="text" name="score2" class="form-control">
                        <br>
                        <label>
                         
                        Select a month 
                        </label>
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
                        <br>
                        <label>
                        Enter match day      
                        </label>
                        <input type="text" name="day" style="color:black;">
                        <br>
                        <label>
                        Select the year 
                        </label>
                        <select name="year" class="form-control">
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                            <option value="2016">2016</option>
                            <option value="2015">2015</option>
                            <option value="2014">2014</option>
                            <option value="2013">2013</option>
                            <option value="2012">2012</option>
                            <option value="2011">2011</option>
                            <option value="2010">2010</option>
                            <option value="2009">2009</option>
                            <option value="2008">2008</option>
                            <option value="2007">2007</option>
                        </select>




                        <button class="btn btn-primary" type="submit" name="submitmatch"> submit match </button> 
                        
                        <?php 
                            if(isset($_POST['submitmatch'])){
                                 echo '<p>Submitted Succesfully </p>';        
                            }
                        
                        ?>
                        
                        <?php
            
                                $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                                if (!$conn) {
                                    echo "here";
                                } 

                                $matchdaysql = "SELECT * FROM match_day ";


                                $matchinfo = mysqli_query($conn, $matchdaysql); 

                                mysqli_close($conn);

                                $matchtable = '
                            <div class="col-md-7">
                            
                                <div class="table-responsive">          
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th>team_1</th>
                                            <th>team_2</th>
                                            <th>team_1score</th>
                                            <th>team_2score</th>
                                            <th>match_month</th>
                                            <th>match_day</th>
                                            <th>match_year</th>
                                            
                                          </tr>
                                        </thead>
                                        <tbody>';
                            
                            echo $matchtable;
                            
                            
                            while ($row = $matchinfo->fetch_assoc()){
                                echo '<tr>';
                                echo '<td>' . $row['team_1'] . '</td>' .
                                     '<td>' . $row['team_2'] . '</td>' .
                                     '<td>' . $row['team_1score'] . '</td>' .
                                     '<td>' . $row['team_2score'] . '</td>' .
                                     '<td>' . $row['match_month'] . '</td>' .
                                     '<td>' . $row['match_day'] . '</td>' .
                                     '<td>' . $row['match_year'] . '</td>';
                                 echo '</tr>'; 
                            }  
                           
                            $matchtable2 = '
                                        </tbody>
                                    </table>
                                </div>
                            </div> ';
                            echo $matchtable2;

                                
                            ?>
                        
                        
                        
                    </div>
                </form>
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
