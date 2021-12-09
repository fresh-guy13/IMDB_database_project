<?php
    $servername = "127.0.0.1";
    $username = "admin";
    $password = "1234";
    $Uname = $_POST['uname'];
    $pass = $_POST['psw'];
    $conn = new mysqli($servername, $username, $password, "movie");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    else {
        $sql = "SELECT * FROM user where Username = '$Uname';";
        $result = $conn->query($sql);
        if (mysqli_num_rows($result) === 0) {
            echo "The username or password is incorrect <br> Rdirect to previous page in 3 seconds";
            header("Refresh: 3; url= ../web/landing.html"); 
        }else {
            $row = $result->fetch_assoc();
            setcookie('username', $row['Username'], time() + (86400 * 30), "/");
            setcookie('First', $row['FirstName'], time() + (86400 * 30), "/");
            setcookie('Last', $row['LastName'], time() + (86400 * 30), "/");
            setcookie('isDir', $row['IsDirector'] , time() + (86400 * 30), "/");
            echo "Succefully Login! <br> Rdirect to main page in 2 seconds";
            header("Refresh: 2; url= ../web/main.html"); 
        }
        
    }
    

?>