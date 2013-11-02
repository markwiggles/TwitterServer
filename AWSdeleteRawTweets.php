<?php

//for testing purposes
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

/*
  gets the tweets from the AWS database
 */

require 'AWSSDKforPHP/aws.phar';

use Aws\DynamoDb\DynamoDbClient;

$client = DynamoDbClient::factory(array(
            'key' => 'AKIAIK7RCPMWTZVQWJIA',
            'secret' => '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',
            'region' => 'us-west-2'
        ));

$tableName = 'MSrawTweets';
$rangeId = strtotime("-1 day"); 

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

print_r($result['Items']);

foreach($result['Items'] as $item) {
    $client->deleteItem(array(
        'TableName' => $tableName,
        'Key' => array(
            'indexId'   => array('S' => $item['indexId']['S']),
            'rangeId' => array('N' => $item['rangeId']['N'])
        )
    ));
}
?>
