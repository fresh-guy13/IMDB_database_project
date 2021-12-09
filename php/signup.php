<?php
$servername = "127.0.0.1";
$username = "admin";
$password = "1234";

// Create connection
$conn = new mysqli($servername, $username, $password, "movie");
$Uname = $_POST['uname'];
$pass = $_POST['psw'];
$Fname = $_POST['F-Name'];
$Lname = $_POST['L-Name'];
$email = $_POST['email'];
$birth = $_POST['birthdate'];
$isDirect = isset($_POST['isDir']) ? 1 : 0;

$sql = "SELECT * FROM user WHERE username = '$Uname' ";
$result = $conn -> query($sql);

if (mysqli_num_rows($result) > 0) {
    echo "The username has already been used! <br> Rdirect to previous page in 3 seconds";
    header("Refresh: 3; url= ../web/landing.html"); 
    exit();
}
if ($pass !== $_POST['psw-repeat']) {
    echo "The password is not consistent! <br> Rdirect to previous page in 3 seconds";
    header("Refresh: 3; url= ../web/landing.html"); 
}
else {
    #Insert to user table
    $Insert_sql = "INSERT INTO user VALUES('$Uname', '$pass', '$Fname', '$Lname', '$isDirect', '$birth', '$email' )";
    #Insert to fav genres
    
    if ($conn->query($Insert_sql) === FALSE) {
        echo "Failed to create account please try again! <br> Redirect to previous page in 3 seconds";
        header("Refresh: 3; url= ../web/landing.html"); 
        exit();
    }
    if(!empty($_POST['gen'])) {
        foreach($_POST['gen'] as $value){
            $genre_sql = "INSERT INTO fav_genres VALUES('$Uname ', '$value')";
            $conn->query( $genre_sql);
        }
    }
    echo "Succesfully create account!! <br> Rdirect to main page in 3 seconds";
    setcookie('username', $Uname, time() + (86400 * 30), "/");
    setcookie('First', $Fname, time() + (86400 * 30), "/");
    setcookie('Last', $Lname, time() + (86400 * 30), "/");
    setcookie('isDir', $isDirect , time() + (86400 * 30), "/");
    header("Refresh: 3; url= ../web/main.html");
    
}

?>