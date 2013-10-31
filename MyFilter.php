<?php

require_once('lib/Phirehose.php');
require_once('lib/OauthPhirehose.php');

require_once ('AWSinsertRawTweets.php');

require_once ('Thread.php');

/**
 * class using Phirehose to display a live filtered stream using track words 
 */
class FilterTrackConsumer extends OauthPhirehose {

    /**
     * Enqueue each status
     * @param string $status
     */  
    
    public function enqueueStatus($status) {     
        
        //print  $status."\n\n";
        storeRawTweetsInDatabase($status);

    }
}


// The OAuth credentials
define("TWITTER_CONSUMER_KEY", "svZXJI1VwflpveNZcLKgw");
define("TWITTER_CONSUMER_SECRET", "NR6GEcj09DCBn1K2nNtfYM4wp7bBHXnRkD2ekuI");
define("OAUTH_TOKEN", "543781426-Q2Y6IugeGaoA9tGh5PrpkPH00MFtQ2PbqsiVHRN6");
define("OAUTH_SECRET", "hVNkoq7IbpzmD3wi57gF2tUU8bbgZ3Kv9wKJ2JPk2o");

//gets the trackwords from the command live ie the exec command in Start.php
//$trackWords = unserialize($argv[1]);
//$boundingBox = unserialize($argv[2]);

//$trackWords = array('the'); //testing only ie no-one more popular than Justin is there?
//$boundingBox = "-28.03728,152.452799,-26.7775,153.55292";

// Create the stream object from above class and start streaming
$sc = new FilterTrackConsumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_SAMPLE);
$sc->setLang('en');
//$sc->setTrack($trackWords);
//$sc->setLocations(array(array($boundingBox)));
$sc->consume();


// test to see if threading is available
if( ! Thread::available() ) {
    die( 'Threads not supported' );
}
 
// define the function to be run as a separate thread
function processDatabaseUpdate() {
   
    // delete the tweets in the db every 10 minutes
    
    
    
    
}
//- See more at: http://blog.motane.lu/2009/01/02/multithreading-in-php/#sthash.uqx3nAP5.dpuf



?>