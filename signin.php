<html lang="en">

<head>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <link href="css/signin.css" rel="stylesheet" type="text/css" media="screen, projection">
</head>
<body>

    <?php 
        $invalid = "";

        include("globals.php");
        
        if(isset($_POST['signin'])){

           
            $uname = $_POST['username'];
            $pw = $_POST['password'];
            
            //echo $dbhost . $dbuser . $dbpass . $dbname;
            
            
            $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
            if (!$conn) {
                die('Could not connect: ' . mysqli_error($conn));
            }
            
            

            $sql = "SELECT * FROM login WHERE username = '$uname' AND password = '$pw' ";

            $retval = mysqli_query($conn, $sql);
            if (mysqli_num_rows($retval)==0) {
                $invalid = 'Invalid username/password';
            }
            else {
                $invalid = "";
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $uname;
                header('Location: index.php');
                
            }
            
            mysqli_close($conn); 
            //header('Location: index.php');
        } 
    ?>

    <div class="container">
    
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card">MySports</p>
            <form class="form-signin" method="post" action="signin.php">
                <span id="reauth-email" class="reauth-email"></span>
                <?php echo '<span class="err">' . $invalid .'</span>'; ?>
                <input type="username" id="inputEmail" class="form-control" placeholder="username" name="username" required autofocus>
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
                
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div> 
                <input name="signin" class="btn btn-lg btn-primary btn-block btn-signin" type="submit" ></input>
            </form><!-- /form -->
            
            <a href="login.php" class="register">
                Register Here
            </a> 
            
        </div><!-- /card-container -->
    </div><!-- /container -->
    <script src="vendor/jquery/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Google Maps API Key - Use your own API key to enable the map feature. More information on the Google Maps API can be found at https://developers.google.com/maps/ -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false"></script>
    <script src="js/signin.js"> </script>

   
</body>

</html>

