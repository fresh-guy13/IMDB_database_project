

$(document).ready(function() {
    $('#genreform').submit(function(e) {
        data = $(this).serialize();
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataTyte: 'json',
            url: '../php/Searching.php',
            data: data,
            success: function (data) {
                $('div.genreform').empty();
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
                    appendStr += `<tr>`;
                    if (data[i]['Runtime'] === "\\N") {
                        data[i]['Runtime'] = "N/A";
                    }
                    appendStr += (`<th>`+data[i]['Title'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['Runtime'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['AverageRating'] +'</th>'); 
                    appendStr += `</tr>`;
                }
                appendStr += `</table>`

                $('div.genreform').append(appendStr);
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
       });
     });

     $('#startYform').submit(function(e) {
        data = $(this).serialize();
        console.log(data);
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataTyte: 'json',
            url: '../php/Searching.php',
            data: data,
            success: function (data) {
                $('div.startform').empty();
                console.log("SUCCESS : ", data);
                data = JSON.parse(data);
                appendStr = `
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Runtime</th>
                        <th>Average Rating</th>
                        <th>Start Year</th>
                    </tr>`
                for(i=0; i<data.length; i++) {
                    if (data[i]['Runtime'] === "\\N") {
                        data[i]['Runtime'] = "N/A";
                    }
                    appendStr += `<tr>`;
                    appendStr += (`<th>`+data[i]['Title'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['Runtime'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['AverageRating'] +'</th>');
                    appendStr += (`<th>`+data[i]['StartDate'] +'</th>');
                    appendStr += `</tr>`;
                }
                appendStr += `</table>`

                $('div.startform').append(appendStr);
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
       });
     });
     $('#endYform').submit(function(e) {
        data = $(this).serialize();
        console.log(data);
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataTyte: 'json',
            url: '../php/Searching.php',
            data: data,
            success: function (data) {
                $('div.endform').empty();
                console.log("SUCCESS : ", data);
                data = JSON.parse(data);
                appendStr = `
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Runtime</th>
                        <th>Average Rating</th>
                        <th>End Year</th>
                    </tr>`
                for(i=0; i<data.length; i++) {
                    if (data[i]['Runtime'] === "\\N") {
                        data[i]['Runtime'] = "N/A";
                    }
                    appendStr += `<tr>`;
                    appendStr += (`<th>`+data[i]['Title'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['Runtime'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['AverageRating'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['EndDate'] +'</th>');
                    appendStr += `</tr>`;
                }
                appendStr += `</table>`

                $('div.endform').append(appendStr);
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
                if (data.length === 0) {
                    appendStr = "This database doesn't contain movies of this director!";
                }
                else {
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
                }
            
                $('div.dirMovie').append(appendStr);
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
       });
     });


});
