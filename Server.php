<?php

//We are going to need a database connection:
$db = mysql_connect('localhost', 'root', 'newpwd');
mysql_select_db('twitter_alerts', $db);

//Now, two possibilities: if we don't have a start parameter, we print the last ten tweets.
//Otherwise, we print all the tweets with IDs bigger than start, if any

//get the start value which has been sent by the ajax method
$start = mysql_real_escape_string($_GET['start']);

if (!$start) { //if no value there
    
    //get last ten tweets in ascending order of id
    $query = "SELECT * FROM (SELECT * FROM tweets ORDER BY id DESC LIMIT 0,10) AS last_ten ORDER BY id ASC";
   
} else {
    
    //get last tweets in descending order, commencing from the start value
    $query = "SELECT * FROM (SELECT * FROM tweets WHERE id>" . $start . " ORDER BY id DESC LIMIT 0,10) AS new_tweets ORDER BY id ASC";
    
}

$result = mysql_query($query);
$data = array(); //Initializing the results array

//iterate through the result, and push items onto an array
while ($row = mysql_fetch_assoc($result)) {
    array_push($data, $row);
}
//send the result as a JSON array
$json = json_encode($data);
print $json;


?>
