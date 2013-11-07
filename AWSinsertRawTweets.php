<?php

//For testing purposes
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

/*
  Stores the tweets from the stream into
 * MSrawTweets table of DynamoDB
 */

require 'AWSSDKforPHP/aws.phar';

use Aws\DynamoDb\DynamoDbClient;

/*
 * Function to insert the tweets into the AWS database, 
 * as raw JSON format with timestamp
 */
function storeRawTweetsInDatabase($rawTweet) {

    //Setup client connection to DynamoDB
    $client = DynamoDbClient::factory(array(
                'key' => 'AKIAIK7RCPMWTZVQWJIA',
                'secret' => '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',
                'region' => 'us-west-2'
    ));

    //Set indexId which acts as a hash key
    //Contains a fixed value
    $indexId = 'tweets';
    //Set rangeId which acts as a range key
    //Contains timestamp of when row was inserted
    $rangeId = time();
    
    //Name of the DynamoDB table which stores
    //raw tweets from the twitter stream
    $tableName = 'MSrawTweets';

    //We store the new post in the DynamoDB
    $result = $client->putItem(array(
        'TableName' => $tableName,
        'Item' => array(
            'indexId' => array('S' => $indexId),
            'rangeId' => array('N' => $rangeId),
            'rawTweet' => array('S' => $rawTweet)
            ),
    ));

    flush();
}//end of storeRawTweetsInDatabase()

?>
