<?php

//For testing purposes
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

/*
  Deletes raw tweets from MSrawTweets table
 * of DynamoDB in the past hour
 */

require 'AWSSDKforPHP/aws.phar';

use Aws\DynamoDb\DynamoDbClient;

//Setup client connection to DynamoDB
$client = DynamoDbClient::factory(array(
            'key' => 'AKIAIK7RCPMWTZVQWJIA',
            'secret' => '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',
            'region' => 'us-west-2'
        ));

//Function call to delete tweets
//while (true) {
//    deleteOldTweets($client);
//    sleep(60);
//}

/*
 * Function to get older raw tweets from MSrawTweets table
 * in the past hour and delete them
 */

deleteOldTweets($client);

function deleteOldTweets($client) {
    
    //Name of the DynamoDB table which stores
    //raw tweets from the twitter stream
    $tableName = 'MSrawTweets';
    
    //Specify the time limit
    $rangeId = strtotime("-30 minutes");

    //We get the posts in the last hour from the database
    $result = $client->query(array(
        'TableName' => $tableName,
        'KeyConditions' => array(
            'indexId' => array(
                'AttributeValueList' => array(
                    array('S' => 'tweets')
                ),
                'ComparisonOperator' => 'EQ'
            ),
            'rangeId' => array(
                'AttributeValueList' => array(
                    array('N' => $rangeId),
                ),
                'ComparisonOperator' => 'LE'
            )
        ),
        'ScanIndexForward' => false
    ));

    //Delete results returned from the query 
    //based on range id condition
    foreach ($result['Items'] as $item) {
        $client->deleteItem(array(
            'TableName' => $tableName,
            'Key' => array(
                'indexId' => array('S' => $item['indexId']['S']),
                'rangeId' => array('N' => $item['rangeId']['N'])
            )
        ));
    }
}//end of deleteOldTweets()

?>
