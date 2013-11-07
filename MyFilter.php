<?php

require_once('lib/Phirehose.php');
require_once('lib/OauthPhirehose.php');
require_once ('AWSinsertRawTweets.php');


/**
 * Class using Phirehose to display a live stream 
 * of tweets from twitter 
 */
class FilterTrackConsumer extends OauthPhirehose {

    /**
     * Enqueue each status
     * Function implemented from OauthPhirehose
     */  
    
    public function enqueueStatus($status) {     
        
        //Store tweets from the stream into 
        //MSrawTweets of DynamoDB
        storeRawTweetsInDatabase($status);
    }
}//end of class


// The OAuth credentials
define("TWITTER_CONSUMER_KEY", "svZXJI1VwflpveNZcLKgw");
define("TWITTER_CONSUMER_SECRET", "NR6GEcj09DCBn1K2nNtfYM4wp7bBHXnRkD2ekuI");
define("OAUTH_TOKEN", "543781426-Q2Y6IugeGaoA9tGh5PrpkPH00MFtQ2PbqsiVHRN6");
define("OAUTH_SECRET", "hVNkoq7IbpzmD3wi57gF2tUU8bbgZ3Kv9wKJ2JPk2o");

// Create the stream object from above class and start streaming
$sc = new FilterTrackConsumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_SAMPLE);
//Set tweet text language to English
$sc->setLang('en');

//Delete tweets from MSrawTweets table
//from the past hour
$cmd = "php AWSdeleteRawTweets.php";
$pid = exec("nohup $cmd > /dev/null 2>&1 & echo $!");

//Begin receiving tweets from the twitter stream
$sc->consume();
?>