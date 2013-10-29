<?php

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

use Aws\AutoScaling\AutoScalingClient;


//the client connection
$client = AutoScalingClient::factory(array(
            'key' => 'AKIAIK7RCPMWTZVQWJIA',
            'secret' => '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',
            'region' => 'us-west-2'
        ));


echo"test";

putScalingPolicy($client);

describeAutoScalingGroups($client);

function createLaunchConfiguration($client) {

    $result = $client->createLaunchConfiguration(array(
        // LaunchConfigurationName is required
        'LaunchConfigurationName' => 'MSlaunchConfig',
        // ImageId is required
        'ImageId' => 'ami-1c27be2c',
        'KeyName' => 'sentimentKeyPair',
        'SecurityGroups' => array('Node Server'),
        //'UserData' => 'string',
        // InstanceType is required
        'InstanceType' => 't1.micro'
            //'KernelId' => 'string',
            //'RamdiskId' => 'string',
            //'BlockDeviceMappings' => array(
            //   array(
//            'VirtualName' => 'string',
//            // DeviceName is required
//            'DeviceName' => 'string',
//            'Ebs' => array(
//                'SnapshotId' => 'string',
//                'VolumeSize' => integer,
//            ),
//        ),
//        // ... repeated
//    ),
//    'InstanceMonitoring' => array(
//        'Enabled' => true || false,
//    ),
//    'SpotPrice' => 'string',
//    'IamInstanceProfile' => 'string',
//    'EbsOptimized' => true || false,
//    'AssociatePublicIpAddress' => true || false,
    ));

    var_dump($result);
}

function createAutoScalingGroup($client) {

    $result = $client->createAutoScalingGroup(array(
        // AutoScalingGroupName is required
        'AutoScalingGroupName' => 'MSscalingGroup',
        // LaunchConfigurationName is required
        'LaunchConfigurationName' => 'MSlaunchConfig',
        // MinSize is required
        'MinSize' => 1,
        // MaxSize is required
        'MaxSize' => 1,
        //'DesiredCapacity' => integer,
        'DefaultCooldown' => 300,
        'AvailabilityZones' => array('us-west-2a', 'us-west-2b', 'us-west-2c'),
        'LoadBalancerNames' => array('MSloadBalancer')
            //'HealthCheckType' => 'string',
            //'HealthCheckGracePeriod' => integer,
            //'PlacementGroup' => 'string',
            //'VPCZoneIdentifier' => 'string',
            //'TerminationPolicies' => array('string', ... ),
//    'Tags' => array(
//    array(
//    'ResourceId' => 'string',
//    'ResourceType' => 'string',
//    // Key is required
//    'Key' => 'string',
//    'Value' => 'string',
//    'PropagateAtLaunch' => true || false,
//    ),
//    // ... repeated
//    ),
    ));

    var_dump($result);
}

function putScalingPolicy($client) {

    $result = $client->putScalingPolicy(array(
        // AutoScalingGroupName is required
        'AutoScalingGroupName' => 'MSscalingGroup',
        // PolicyName is required
        'PolicyName' => 'MSscalingPolicyDown',
        // ScalingAdjustment is required
        'ScalingAdjustment' => -1,
        // AdjustmentType is required
        'AdjustmentType' => 'ChangeInCapacity',
        'Cooldown' => 300
            //'MinAdjustmentStep' => integer,
    ));
    var_dump($result);
}

function describeAutoScalingGroups($client) {
    
    $result = $client->describeAutoScalingGroups(array(
    'AutoScalingGroupNames' => array('MSscalingGroup'),
    //'NextToken' => 'string',
    //'MaxRecords' => integer,
    ));
    
    var_dump($result);
    
}



?>
