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
    $cook=$_COOKIE['username'];   
    $servername = "127.0.0.1";
    $username = "admin";
    $password = "1234";
    // echo $_COOKIE['username'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, "movie");
    $sql = "SELECT genre FROM fav_genres WHERE Username='$cook'";
    $result = $conn -> query($sql);

    $genreArr = array();
    
    while($row = $result->fetch_assoc()) {
        array_push($genreArr, array("genre" => $row['genre'],));
    }
    $genreCount = count($genreArr);
    $sql = "SELECT birthday FROM user WHERE Username='$cook';";
    $result = $conn -> query($sql);
    
    $numVotes=50000;
    $rate=6;

    $row = $result->fetch_assoc();
    #$birthday = (int)substr($row['birthday'], 0, 4);
    $birthday = $row['birthday'];
    $start = strval($birthday-20);
    $end = strval($birthday+20);
    if($genreCount === 0) {
        $sql = "SELECT Movie_id, Title, Runtime, AverageRating FROM Movies WHERE (NumVotes>=$numVotes AND AverageRating >= $rate AND StartDate >= '$start' AND EndDate <= '$end');";
        $result = $conn -> query($sql);
        $tmpArr = array();
        while($row = $result->fetch_assoc()) {
            $tmp = array(
                "Movie_id" => $row['Movie_id'],
                "Title" => $row['Title'],
                "Runtime" => $row['Runtime'],
                "AverageRating" => $row['AverageRating'],
            );
            array_push($tmpArr, $tmp);
        }
        echo json_encode(randRow($tmpArr));
    } else {
        $genreData = array();
        for($i=0; $i < $genreCount; $i++) {
            $tmpArr = array();
            $genTemp = $genreArr[$i]['genre'];
            $con_sql = "(SELECT Movie_id FROM Movie_genres WHERE genre='$genTemp'))";
            $sql = "SELECT Movies.Movie_id, Movies.Title, Movies.Runtime, Movies.AverageRating FROM Movies where (Movies.NumVotes>=$numVotes AND Movies.AverageRating >= $rate AND Movies.StartDate >= '$start' AND Movies.EndDate <= '$end' AND Movies.Movie_id IN " . $con_sql . " limit 100;";
            $result = $conn -> query($sql);
            while($row = $result->fetch_assoc()) {
                $tmp = array(
                    "Movie_id" => $row['Movie_id'],
                    "Title" => $row['Title'],
                    "Runtime" => $row['Runtime'],
                    "AverageRating" => $row['AverageRating'],
                    "genre" => $genTemp,
                );
                array_push($tmpArr, $tmp);
            }
            array_push($genreData, $tmpArr);
        }
        $result = array();
        for($counter=0; $counter < 10; $counter++) {
            $tmp = $genreData[$counter%$genreCount];
            $t = $counter;
            while (count($tmp) === 0) {
                $t += 1;
                $tmp = $genreData[$t%$genreCount];
            }
            $randNum = rand(0, count($tmp)-1);
            array_push($result,$tmp[$randNum]);
            unset($genreData[$t%$genreCount][$randNum]);
        }

        echo json_encode($result);
    }
?>
                