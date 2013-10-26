<?php

require_once('lib/TwitterSentimentAnalysis.php');
// Configure your Datumbox API Key. 
define('DATUMBOX_API_KEY', '78006b9cafa5dbd4f0b57f6ae0c897d7');
        
function storeTweetsInDatabase($tweet) {

//We're going to store the data in the database, so, let's open a connection:
    $db = mysql_connect('localhost', 'root', 'newpwd');
    mysql_select_db('twitter_alerts', $db);

//Clean the inputs before storing
    $id = mysql_real_escape_string($tweet->{'id'});
    $text = mysql_real_escape_string($tweet->{'text'});
    $screen_name = mysql_real_escape_string($tweet->{'user'}->{'screen_name'});
    $profile_image_url = mysql_real_escape_string($tweet->{'user'}->{'profile_image_url'});
    $followers_count = mysql_real_escape_string($tweet->{'user'}->{'followers_count'});

    $TwitterSentimentAnalysis = new TwitterSentimentAnalysis(DATUMBOX_API_KEY);

    $sentiment=$TwitterSentimentAnalysis->sentimentAnalysis($text);
    
//We store the new post in the database, to be able to read it later
    $ok = mysql_query("INSERT INTO tweets (id ,text ,screen_name ,profile_image_url, followers_count, created_at, sentiment) VALUES ('$id', '$text', '$screen_name', '$profile_image_url', '$followers_count', NOW(), '$sentiment')");
    if (!$ok) {
        echo "Mysql Error: " . mysql_error();
    }
    flush();
}
?>



