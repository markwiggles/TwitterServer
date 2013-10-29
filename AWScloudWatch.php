<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//for testing purposes
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);

require 'AWSSDKforPHP/aws.phar';

use Aws\CloudWatch\CloudWatchClient;

//the client connection
$client = CloudWatchClient::factory(array(
            'key' => 'AKIAIK7RCPMWTZVQWJIA',
            'secret' => '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',
            'region' => 'us-west-2'
        ));

function putMetricAlarm($client) {

    $result = $client->putMetricAlarm(array(
    // AlarmName is required
    'AlarmName' => 'string',
    'AlarmDescription' => 'string',
    'ActionsEnabled' => true || false,
    'OKActions' => array('string', ... ),
    'AlarmActions' => array('string', ... ),
    'InsufficientDataActions' => array('string', ... ),
    // MetricName is required
    'MetricName' => 'string',
    // Namespace is required
    'Namespace' => 'string',
    // Statistic is required
    'Statistic' => 'one of: SampleCount|Average|Sum|Minimum|Maximum',
    'Dimensions' => array(
    array(
    // Name is required
    'Name' => 'string',
    // Value is required
    'Value' => 'string',
    ),
    // ... repeated
    ),
    // Period is required
    'Period' => integer,
    'Unit' => 'one of: Seconds|Microseconds|Milliseconds|Bytes|Kilobytes|Megabytes|Gigabytes|Terabytes|Bits|Kilobits|Megabits|Gigabits|Terabits|Percent|Count|Bytes/Second|Kilobytes/Second|Megabytes/Second|Gigabytes/Second|Terabytes/Second|Bits/Second|Kilobits/Second|Megabits/Second|Gigabits/Second|Terabits/Second|Count/Second|None',
    // EvaluationPeriods is required
    'EvaluationPeriods' => integer,
    // Threshold is required
    'Threshold' => integer,
    // ComparisonOperator is required
    'ComparisonOperator' => 'one of: GreaterThanOrEqualToThreshold|GreaterThanThreshold|LessThanThreshold|LessThanOrEqualToThreshold',
    ));
}

?>
