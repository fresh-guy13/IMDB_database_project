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
    $genre = $_POST['genre'];
    $rate = $_POST['rating'];
    
    if (isset($_POST['genre'])) {                
        
        // Search movies with specific TODO: search for highest rate!
        $con_sql = "(SELECT Movie_id FROM Movie_genres WHERE genre = '$genre'  ))";
        $sql = "SELECT Movies.Title, Movies.Runtime, Movies.AverageRating FROM Movies where (Movies.AverageRating >= '$rate' AND Movies.Movie_id IN " . $con_sql . " limit 1000;";
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
        echo json_encode(randRow($arr));
    } else if (isset($_POST['start_year'])) {
        $start_year = $_POST['start_year'];
        // Search movies with specific TODO: search for highest rate!
        $sql = "SELECT Movies.Title, Movies.Runtime, Movies.AverageRating, Movies.StartDate FROM Movies where (Movies.AverageRating >= '$rate' AND Movies.StartDate >= '$start_year') limit 1000;";
        
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
                "StartDate" => $row['StartDate'],
                
            );
            array_push($arr, $tmp);
        }
        echo json_encode(randRow($arr));
    }else if (isset($_POST['end_year'])) {
        $end_year = $_POST['end_year'];
        // Search movies with specific TODO: search for highest rate!
        $sql = "SELECT Movies.Title, Movies.Runtime, Movies.AverageRating, Movies.EndDate FROM Movies where (Movies.AverageRating >= '$rate' AND Movies.EndDate <= '$end_year') limit 1000;";
        
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
                "EndDate" => $row['EndDate'],
            );
            array_push($arr, $tmp);
        }
        echo json_encode(randRow($arr));
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
    } else if (isset($_POST['director'])) {
        $director = $_POST['director'];
        // Search movies with specific TODO: search for highest rate!
        
        // $con_sql = "(SELECT director_movie.CrewID, director_movie.Movie_id, Directors.PrimaryName FROM director_movie INNER JOIN Directors ON director_movie.CrewID = Directors.CrewID) as t1";
        // $sql = "SELECT Movies.Title, Movies.Runtime, Movies.AverageRating FROM Movies INNER JOIN " . $con_sql . " where PrimaryName = '$director' limit 10;";
        # SELECT D1.CrewID, D1.PrimaryName, D2.Movie_id from ((SELECT CrewID, PrimaryName FROM Directors where PrimaryName = 'Christopher Nolan' limit 10) as D1 INNER JOIN director_movie as D2 ON D2.CrewID = D1.CrewID)
        #$con_sql = "(SELECT D1.CrewID, D1.PrimaryName, D2.Movie_id from ((SELECT CrewID, PrimaryName FROM Directors where PrimaryName = '$director' limit 10) as D1 INNER JOIN director_movie as D2 ON D2.CrewID = D1.CrewID)) as t1";
        $sql = "SELECT Movies.Title, Movies.Runtime, Movies.AverageRating FROM Movies INNER JOIN (SELECT D1.CrewID, D1.PrimaryName, D2.Movie_id from ((SELECT CrewID, PrimaryName FROM Directors where PrimaryName = '$director' limit 10) as D1 INNER JOIN director_movie as D2 ON D2.CrewID = D1.CrewID)) as t1 on t1.Movie_id = Movies.Movie_id;";
        $result = $conn -> query($sql);
        // Push data to front-end
        if ($conn->query($sql) === FALSE) {
            echo mysqli_error($conn);
        }
        #/*
        $arr = array();                        
        while($row = $result->fetch_assoc()) {
            $tmp = array(
                "Title" => $row['Title'],
                "Runtime" => $row['Runtime'],
                "AverageRating" => $row['AverageRating'],
            );
            array_push($arr, $tmp);
        }
        
        echo json_encode(randRow($arr));
        #*/
    }
?>
                