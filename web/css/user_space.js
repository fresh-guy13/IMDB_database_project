

$(document).ready(function() {
    cook = (document.cookie.split(';')[0]);
    cook = cook.split('=')[1];
    $('#show_title').append(`<h3>Welcome to `+ cook +`'s Space&#128512;!</h3>`);
    $('#search_movie').submit(function(e) {
        data = $(this).serialize();
        console.log(data);
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataTyte: 'json',
            url: '../php/user_space.php',
            data: data,
            success: function (data) {
                $('div.search_movie').empty();
                console.log("SUCCESS : ", data);
                data = JSON.parse(data);
                if (data.length === 0) {
                    appendStr = "The database doesn't contain this movie!";
                }
                else {
                    appendStr = `
                <table>
                    <tr>
                        <th>Movie_id</th>
                        <th>Title</th>
                        <th>Runtime</th>
                        <th>Average Rating</th>
                        <th>Start Year</th>
                        <th>End Year</th>
                    </tr>`
                for(i=0; i<data.length; i++) {
                    if (data[i]['Runtime'] === "\\N") {
                        data[i]['Runtime'] = "N/A";
                    }
                    if (data[i]['end_year'] === "\\N") {
                        data[i]['end_year'] = "N/A";
                    }
                    appendStr += `<tr>`;
                    appendStr += (`<th>`+data[i]['Movie_id'] +'</th>');
                    appendStr += (`<th>`+data[i]['Title'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['Runtime'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['AverageRating'] +'</th>');
                    appendStr += (`<th>`+data[i]['start_year'] +'</th>');
                    appendStr += (`<th>`+data[i]['end_year'] +'</th>');  
                    appendStr += `</tr>`;
                }
                appendStr += `</table>`
                }
                $('div.search_movie').append(appendStr);
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
       });
     });
    $('#addBtn').click(function(e) {
        data = $('form#insert_genre').serialize();
        data += "&method=add"
        console.log(data);
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataTyte: 'json',
            url: '../php/user_space.php',
            data: data,
            success: function (data) {
                $('div.insert_genre').empty();
                console.log("SUCCESS : "+data);
                $('div.insert_genre').append(data);
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
       });
     });

     $('#deleteBtn').click(function(e) {
        data = $('form#insert_genre').serialize();
        data += "&method=delete"
        console.log(data);
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataTyte: 'json',
            url: '../php/user_space.php',
            data: data,
            success: function (data) {
                $('div.insert_genre').empty();
                console.log("SUCCESS : "+data);
                $('div.insert_genre').append("Successfully delete genre");
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
       });
     });
     $('#insert_watched').submit(function(e) {
        data = $(this).serialize();
        console.log(data);
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataTyte: 'json',
            url: '../php/user_space.php',
            data: data,
            success: function (data) {
                $('div.insert_watched').empty();
                console.log("SUCCESS : ", data);
                data = JSON.parse(data);
                if (data[0]['Title'] === null) appendStr = "Movie id does not exist!";
                else appendStr = "Successfully added " + data[0]['Title'] + " to wateched movies with rate " + data[0]['AverageRating'];

                $('div.insert_watched').append(appendStr);
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
       });
     });
     $('#see_watched').submit(function(e) {
        data = $(this).serialize();
        console.log(data);
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataTyte: 'json',
            url: '../php/user_space.php',
            data: data,
            success: function (data) {
                $('div.see_watched').empty();
                console.log("SUCCESS : ", data);
                data = JSON.parse(data);
                if (data[0]['Empty']) appendStr = "<h3>You don't have any record!</h3>";
                else {
                    appendStr = `
                <table>
                    <tr>
                        <th>Movie_id</th>
                        <th>Title</th>
                        <th>Runtime</th>
                        <th>Your Rating</th>
                    </tr>`
                for(i=0; i<data.length; i++) {
                    if (data[i]['Runtime'] === "\\N") {
                        data[i]['Runtime'] = "N/A";
                    }
                    appendStr += `<tr>`;
                    appendStr += (`<th>`+data[i]['Movie_id'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['Title'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['Runtime'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['YourRating'] +'</th>'); 
                    appendStr += `</tr>`;
                }
                appendStr += `</table>`
                }
                $('div.see_watched').append(appendStr);
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
       });
     });
     $('#insert_directed').submit(function(e) {
        data = $(this).serialize();
        console.log(data);
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataTyte: 'json',
            url: '../php/user_space.php',
            data: data,
            success: function (data) {
                $('div.insert_directed').empty();
                if (document.cookie.substr(-1) === '0') $('div.insert_directed').append("You are not a Director!");
                else {
                    console.log("SUCCESS : ", data);
                    data = JSON.parse(data);
                    appendStr = "Successfully added " + data[0]['Title'] + " to new movies with movie id = " + data[0]['Newid'];
                    $('div.insert_directed').append(appendStr);
                }
                
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
       });
     });
     $('#HighestRate').submit(function(e) {
        data = $(this).serialize();
        console.log(data);
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataTyte: 'json',
            url: '../php/Searching.php',
            data: data,
            success: function (data) {
                $('div.HighestRate').empty();
                console.log("SUCCESS : ", data);
                data = JSON.parse(data);
                appendStr = `
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Runtime</th>
                        <th>Average Rating</th>
                    </tr>`
                for(i=0; i<data.length; i++) {
                    if (data[i]['Runtime'] === "\\N") {
                        data[i]['Runtime'] = "N/A";
                    }
                    appendStr += `<tr>`;
                    appendStr += (`<th>`+data[i]['Title'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['Runtime'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['AverageRating'] +'</th>'); 
                    appendStr += `</tr>`;
                }
                appendStr += `</table>`

                $('div.HighestRate').append(appendStr);
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
       });
     });
     $('#dirMovie').submit(function(e) {
        data = $(this).serialize();
        console.log(data);
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataTyte: 'json',
            url: '../php/Searching.php',
            data: data,
            success: function (data) {
                $('div.dirMovie').empty();
                console.log("SUCCESS : ", data);
                data = JSON.parse(data);
                appendStr = `
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Runtime</th>
                        <th>Average Rating</th>
                    </tr>`
                for(i=0; i<data.length; i++) {
                    if (data[i]['Runtime'] === "\\N") {
                        data[i]['Runtime'] = "N/A";
                    }
                    appendStr += `<tr>`;
                    appendStr += (`<th>`+data[i]['Title'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['Runtime'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['AverageRating'] +'</th>'); 
                    appendStr += `</tr>`;
                }
                appendStr += `</table>`

                $('div.dirMovie').append(appendStr);
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
       });
     });
});
