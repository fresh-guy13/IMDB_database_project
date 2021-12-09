<?php
    function randRow($tmpArr, $randMax=1000) {
        $randarr = array();
        $randCount = 10;
        if(count($tmpArr) < $randMax) {
            $randMax = count($tmpArr);
        }
        if(count($tmpArr) < $randCount) {
            $randCount = count($tmpArr);
        }
        while(count($randarr) <$randCount) {
            $randnum = rand(0,$randMax-1);
            if(!in_array($randnum,$randarr)) {
                array_push($randarr, $randnum);
            } 
        }
        $result = array();
        foreach($randarr as $ele) {
            array_push($result, $tmpArr[$ele]);
        }
        return $result;
    }
    $servername = "127.0.0.1";
    $username = "admin";
    $password = "1234";
    // echo $_COOKIE['username'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, "movie");
    
    
    
    if (isset($_POST['genre'])) {      
        $genre = $_POST['genre'];
        $cook=$_COOKIE['username'];          
        if ($_POST['method'] === 'add'){
            $sql = "SELECT genre FROM fav_genres WHERE Username='$cook' AND genre='$genre';";
            $result = $conn -> query($sql);
            if(mysqli_num_rows($result) === 0) {
                $sql = " INSERT INTO fav_genres VALUES('$cook','$genre');";
                $result = $conn -> query($sql);
                if ($result === FALSE) {
                    echo mysqli_error($conn);
                } else {
                    echo "Successfully added $genre!";
                }
            } else {
                echo "$genre is already in your favorites";
            }
        } else if($_POST['method'] === 'delete') {
            $sql = "DELETE  FROM fav_genres where (username = '$cook' AND genre = '$genre');";
            $result = $conn -> query($sql);
            echo "$genre is deleted now";
        }
        
    } else if (isset($_POST['SMtitle'])) {
        $SMtitle = $_POST['SMtitle'];
        // Search movies with specific TODO: search for highest rate!
        $sql = "SELECT Movies.Movie_id, Movies.Title, Movies.Runtime, Movies.AverageRating, Movies.StartDate, Movies.EndDate FROM Movies where Movies.Title = '$SMtitle' limit 100;";
        $result = $conn -> query($sql);
        // Push data to front-end
        if ($conn->query($sql) === FALSE) {
            echo mysqli_error($conn);
        }
        $arr = array();                        
        while($row = $result->fetch_assoc()) {
            $tmp = array(
                "Movie_id" => $row['Movie_id'],
                "Title" => $row['Title'],
                "Runtime" => $row['Runtime'],
                "AverageRating" => $row['AverageRating'],
                "start_year" => $row['StartDate'],
                "end_year" => $row['EndDate'],
            );
            array_push($arr, $tmp);
        }
        echo json_encode(randRow($arr));
    }else if (isset($_POST['movie_id'])) {
        $MovieID = $_POST['movie_id'];
        $rate = $_POST['rating'];
        $cook=$_COOKIE['username']; 
        $Select_sql = "SELECT Movies.Movie_id, Movies.Title, Movies.AverageRating FROM Movies where Movies.Movie_id = '$MovieID';";
        $Select_res = $conn -> query($Select_sql);
        $row_sel = $Select_res->fetch_assoc();
        $title = $row_sel['Title'];
        if (!empty($title) ) {
            $sql = "INSERT INTO watched_movies VALUES('$MovieID', '$cook', '$rate', '$title');";
        }
        // Search movies with specific TODO: search for highest rate!
        // Push data to front-end
        if ($conn->query($sql) === FALSE) {
            echo mysqli_error($conn);
        }
        $arr = array();                        
        $tmp = array(
            "Title" => $title,
            "AverageRating" => $rate,
        );
        array_push($arr, $tmp);
        echo json_encode($arr);
    } else if (isset($_POST['numVotes'])) {
        $numVotes = $_POST['numVotes'];
        // Search movies with specific TODO: search for highest rate!
        $sql = "SELECT Movies.Title, Movies.Runtime, Movies.AverageRating FROM Movies where Movies.NumVotes >= '$numVotes' Order by Movies.AverageRating DESC limit 10;";
        $result = $conn -> query($sql);
        // Push data to front-end
        if ($conn->query($sql) === FALSE) {
            echo mysqli_error($conn);
        }
        $arr = array();                        
        while($row = $result->fetch_assoc()) {
            $tmp = array(
                "Title" => $row['Title'],
                "Runtime" => $row['Runtime'],
                "AverageRating" => $row['AverageRating'],
            );
            array_push($arr, $tmp);
        }
        #echo $sql;
        echo json_encode($arr);
    } else if (isset($_POST['genreD'])) {
        $Runtime = $_POST['Runtime'];
        $genre = $_POST['genreD'];
        $cook=$_COOKIE['username']; 
        $title = $_POST['title'];
        $startY = $_POST['startY'];
        $endY = $_POST['endY'];
        $PrimName = $_COOKIE['First'] . " ". $_COOKIE['Last'];
        // Search movies with specific TODO: search for highest rate!
        $con_sql = "SELECT Movie_id from Movies Order by Movie_id DESC limit 1";
        $Sel_result = $conn -> query($con_sql);
        $Movie_id_str = $Sel_result->fetch_assoc()['Movie_id'];
        $New_id = strval((int)substr($Movie_id_str, 2) + 2);
        $New_id = substr($Movie_id_str, 0, 2) . $New_id;
        $sql = "INSERT INTO Movies VALUES('$New_id', '$Runtime', '$title', '$startY', '$endY', 0, 0)";
        $result = $conn -> query($sql);
        $sql = "INSERT INTO NewMovie VALUES('$cook', '$New_id', '$title')";
        $result = $conn -> query($sql);
        $sql = "INSERT INTO Movie_genres VALUES('$New_id', '$genre')";
        $result = $conn -> query($sql);
        // Push data to front-end
        // if ($conn->query($sql) === FALSE) {
        //     echo mysqli_error($conn);
        // }
        #/*
        $arr = array();                        
        $tmp = array(
            "Title" => $title,
            "Newid" => $New_id,
        );
        array_push($arr, $tmp);
        echo json_encode($arr);
        #*/
    }
    else {
        // Search movies with specific TODO: search for highest rate!
        $cook=$_COOKIE['username']; 
        $con_sql = "SELECT Movie_id, Rating, primaryName FROM watched_movies where Username = '$cook';";
        $con_result = $conn -> query($con_sql);
        $arr = array();
        if (count($con_result) === 0) {
            $tmp = array('Empty' => 'Empty',);
            array_push($arr, $tmp);
        }
        else {
            while($row = $con_result->fetch_assoc()) {
                $Mid = $row['Movie_id'];
                $sql = "SELECT Movies.Title, Movies.Runtime from Movies where Movie_id = '$Mid';";
            
                $result = $conn -> query($sql);
                $row2 = $result->fetch_assoc();
                $tmp = array(
                    'Movie_id' => $Mid,
                    "Title" => $row['primaryName'],
                    "Runtime" => $row2['Runtime'],
                    "YourRating" => $row['Rating'],
                );
                array_push($arr, $tmp);
            }
        }
        echo json_encode(randRow($arr));
    }

?>
                