<?php

//We are going to need a database connection:
$db = mysql_connect('localhost', 'root', 'newpwd');
mysql_select_db('twitter_alerts', $db);
//Now, two possibilities: if we don't have a start parameter, we print the last ten tweets.
//Otherwise, we print all the tweets with IDs bigger than start, if any
$start = mysql_real_escape_string($_GET['start']);
if (!$start) {
    mysql_query("CREATE VIEW top10sentiment AS SELECT * FROM tweets ORDER BY id DESC LIMIT 0,10");
    $query1 = "SELECT COUNT(*) AS positive FROM top10sentiment WHERE sentiment='positive'";
    $query2 = "SELECT COUNT(*) AS negative FROM top10sentiment WHERE sentiment='negative'";
    $query3 = "SELECT COUNT(*) AS neutral FROM top10sentiment WHERE sentiment='neutral'";
    //mysql_query("DROP VIEW top10sentiment");
} else {
    mysql_query("CREATE VIEW top10sentiment AS SELECT * FROM tweets WHERE id>" . $start . " ORDER BY id DESC LIMIT 0,10");
    $query1 = "SELECT COUNT(*) AS positive FROM top10sentiment WHERE sentiment='positive'";
    $query2 = "SELECT COUNT(*) AS negative FROM top10sentiment WHERE sentiment='negative'";
    $query3 = "SELECT COUNT(*) AS neutral FROM top10sentiment WHERE sentiment='neutral'";
    //mysql_query("DROP VIEW top10sentiment");
}   

$result1 = mysql_query($query1);
$result2 = mysql_query($query2);
$result3 = mysql_query($query3);
$data = array(); //Initializing the results array

while (($row1 = mysql_fetch_assoc($result1)) && ($row2= mysql_fetch_assoc($result2)) && ($row3 = mysql_fetch_assoc($result3))) {
    array_push($data, $row1, $row2, $row3);
}
$json = json_encode($data);
mysql_query("DROP VIEW top10sentiment");
print $json;
//echo $json;
?>
