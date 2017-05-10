<head>
  <link rel="stylesheet" href="signin.php">
</head>
<body>
<form id='register' action='login.php' method='post'
accept-charset='UTF-8'>
<fieldset >
<legend>Register</legend>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<label for='username' >
Username:</label>
<input type='text' name='username' id='username' maxlength="50" />
<br>
<label for='username' >
Password:</label>
<input type='text' name='password' id='' maxlength="50" />
<br>
<label for='password' >
Favorite Team:</label>
<input type='text' name='team' id='team' maxlength="50" />
<input type='submit' name='Submit' value='Submit' />
</fieldset>
</form>
<?php

ob_start();
echo $_POST['username'] ;
$username = ob_get_contents();
ob_end_clean();
    
ob_start();
echo $_POST['password'] ;
$password= ob_get_contents();
ob_end_clean();
    
ob_start();
echo $_POST['team'] ;
$fav= ob_get_contents();
ob_end_clean();
    //if (isset($_POST['submit'])) {
//    $options = array("cost"=>4);
    //$username = $_POST['username'];
    //$password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
    //$favorite = $_POST['team'];
    
//}

include('globals.php');
 $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
                                    echo "here";
}
    $register= "insert into login (username,password,fav) VALUES ('$username', '$password', '$fav')";


$fixinfo = mysqli_query($conn, $register); 
mysqli_close($conn);

    
    ?>
    