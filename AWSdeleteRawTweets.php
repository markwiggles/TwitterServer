<?php

//for testing purposes
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);


require 'AWSSDKforPHP/aws.phar';

use Aws\DynamoDb\DynamoDbClient;

$client = DynamoDbClient::factory(array(
            'key' => 'AKIAIK7RCPMWTZVQWJIA',
            'secret' => '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',
            'region' => 'us-west-2'
        ));

while (true) {
    
    deleteOldTweets($client);
    sleep(60);
}





/*
  gets the older tweets from the AWS database
 */

function deleteOldTweets($client) {

    $tableName = 'MSrawTweets';
    
    //specify how old
    $rangeId = strtotime("-1 minutes");

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

    //print_r($result['Items']);

//delete results returned from the query based on range condition
    foreach ($result['Items'] as $item) {
        $client->deleteItem(array(
            'TableName' => $tableName,
            'Key' => array(
                'indexId' => array('S' => $item['indexId']['S']),
                'rangeId' => array('N' => $item['rangeId']['N'])
            )
        ));
    }
}

?>
