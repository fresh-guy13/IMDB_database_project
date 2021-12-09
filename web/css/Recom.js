

$(document).ready(function() {
    cook = (document.cookie.split(';')[0]);
    cook = cook.split('=')[1];
    $('#recommend').submit(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            dataTyte: 'json',
            url: '../php/Recom.php',
            success: function (data) {
                $('div.recommend').empty();
                les = 0;
                console.log("SUCCESS : ", data);
                data = JSON.parse(data);
                appendStr = `
                <table>
                    <tr>
                        <th>Movie_id</th>
                        <th>Title</th>
                        <th>Runtime</th>
                        <th>Average Rating</th>
                        <th>Genre</th>
                    </tr>`
                for(i=0; i<data.length; i++) {
                    if (data[i] === null) {
                        les = 1;
                        continue;
                    }
                    if (data[i]['Runtime'] === "\\N") {
                        data[i]['Runtime'] = "N/A";
                    }
                    appendStr += `<tr>`;
                    appendStr += (`<th>`+data[i]['Movie_id'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['Title'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['Runtime'] +'</th>'); 
                    appendStr += (`<th>`+data[i]['AverageRating'] +'</th>');
                    appendStr += (`<th>`+data[i]['genre'] +'</th>'); 
                    appendStr += `</tr>`;
                }
                appendStr += `</table>`

                $('div.recommend').append(appendStr);
                if (les === 1) $('div.recommend').append("\n <h3>There are less than 10 movies, please add more genres and try again! <\h3>");

            },
            error: function (e) {
                console.log("ERROR : ", e);
                $('div.recommend').append("Please Try Again!");
            }   
        });
    });
    $('#show_title').append(`<h3>Welcome to `+ cook +`'s Space&#128512;!</h3>`);
});
