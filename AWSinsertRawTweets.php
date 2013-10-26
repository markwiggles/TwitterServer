<?php

//for testing purposes
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

require 'AWSSDKforPHP/aws.phar';

use Aws\DynamoDb\DynamoDbClient;


function storeRawTweetsInDatabase($rawTweet) {

    //the client connection
    $client = DynamoDbClient::factory(array(
                'key' => 'AKIAIK7RCPMWTZVQWJIA',
                'secret' => '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',
                'region' => 'us-west-2'
    ));

    //idexId and the created_at time
    $indexId = 'tweets';
    $rangeId = time();
    $created_at = date("D M j G:i:s" ,time());
    
    $tableName = 'MSrawTweets';

    //We store the new post in the database AWS dynamoDb
    $result = $client->putItem(array(
        'TableName' => $tableName,
        'Item' => array(
            'indexId' => array('S' => $indexId),
            'rangeId' => array('N' => $rangeId),
            'rawTweet' => array('S' => $rawTweet)
            ),
    ));

    flush();
}

?>
