


//global process id
pid = null;

// wait for the DOM to be loaded, then add ajax function to submit for starting tweets
$(document).ready(function() {

    $("#trackInput").submit(function(event) {

        event.preventDefault();
        

        var values = $(this).serialize();

        $.ajax({
            url: 'Start.php',
            method: 'post',
            data: values + "&pid=" + pid
        }).success(function(response) {
            alert("tweets started with pid:" + response);
            pid = response;
        }).fail(function() {
            // Whoops; show an error.
            //alert("oops nothing happening here");
        });
    });
});

// wait for the DOM to be loaded, then add ajax function to submit for stopping tweets
$(document).ready(function() {

    $("#stopTweets").submit(function(event) {

        event.preventDefault();
        
        console.log("last" + last);

        var values = 'stop=' + pid + "&last=" + last;

        console.log(values);

        $.ajax({
            url: 'Stop.php',
            method: 'post',
            data: values
        }).success(function(response) {
            alert(response);
        }).fail(function() {
            // Whoops; show an error.
            //alert("oops didn't stop for some reason");
        });
    });
});

$(document).ready(function() {
    window.onbeforeunload = function() {
        close();
        return "ALERT  stopped - please restart or ";
    };
});

function close() {

    var values = 'stop=' + pid;

    $.ajax({
        url: 'Stop.php',
        method: 'post',
        data: values
    }).success(function(response) {
        alert(response);
        console.log("closing");
    }).fail(function() {
        // Whoops; show an error.
        //alert("oops didn't stop for some reason");
    });

}


