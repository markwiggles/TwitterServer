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
/**************************************************************************/
/*BUILD METHODS*/
//createLaunchConfiguration($client); //creates MSlaunchConfiguration
//createAutoScalingGroup($client); //creates MSscaling Group
//putScalingPolicyUp($client); //creates scaling policy for scaling up by 1
//putScalingPolicyDown($client);//creates scaling policy for scaling down by 1

/**************************************************************************/
/*TEAR DOWN METHODS*/
//updateAutoScalingGroup($client); //set min/max instance size to 0
//deleteAutoScalingGroup($client); //deletes the MSscalingGroup
//deleteLaunchConfiguration($client); //deletes MSlaunchConfig

/**************************************************************************/
/*DESCRIBE GROUPS AND POLICIES*/
//$description = describeAutoScalingGroups($client);
//print_r(describeAutoScalingInstances($client));
//$json_array = $description['AutoScalingGroups'][0];
//print_r($json_array);
//print_r(describePolicies($client));


/**************************************************************************/


function createLaunchConfiguration($client) {
    $result = $client->createLaunchConfiguration(array(      
        'LaunchConfigurationName' => 'MSlaunchConfig',
        'ImageId' => 'ami-ce30a8fe',
        'KeyName' => 'sentimentKeyPair',
        'SecurityGroups' => array('MSsecurityGroup'),
        'InstanceType' => 't1.micro'
    ));
    return $result;
}

function createAutoScalingGroup($client) {
    $result = $client->createAutoScalingGroup(array(
        'AutoScalingGroupName' => 'MSscalingGroup',
        'LaunchConfigurationName' => 'MSlaunchConfig',
        'MinSize' => 1,
        'MaxSize' => 10,
        'DefaultCooldown' => 300,
        'AvailabilityZones' => array('us-west-2a', 'us-west-2b', 'us-west-2c'),
        'LoadBalancerNames' => array('MSloadBalancer')
    ));
    return $result;
}

function putScalingPolicyUp($client) {
    $result = $client->putScalingPolicy(array(
        'AutoScalingGroupName' => 'MSscalingGroup',
        'PolicyName' => 'MSscalingPolicyUp',
        'ScalingAdjustment' => 1,
        'AdjustmentType' => 'ChangeInCapacity',
        'Cooldown' => 300
    ));
    return $result;
}

function putScalingPolicyDown($client) {
    $result = $client->putScalingPolicy(array(
        'AutoScalingGroupName' => 'MSscalingGroup',
        'PolicyName' => 'MSscalingPolicyDown',
        'ScalingAdjustment' => -1,
        'AdjustmentType' => 'ChangeInCapacity',
        'Cooldown' => 300
    ));
    return $result;
}



function updateAutoScalingGroup($client) {
    $result = $client->updateAutoScalingGroup(array(
        'AutoScalingGroupName' => 'MSscalingGroup',
        'LaunchConfigurationName' => 'MSlaunchConfig',
        'MinSize' => 0,
        'MaxSize' => 0,
//    'DesiredCapacity' => integer,
//    'DefaultCooldown' => integer,
//    'AvailabilityZones' => array('string', ... ),
//    'HealthCheckType' => 'string',
//    'HealthCheckGracePeriod' => integer,
//    'PlacementGroup' => 'string',
//    'VPCZoneIdentifier' => 'string',
//    'TerminationPolicies' => array('string', ... ),
    ));
    return $result;
}

function terminateInstanceInAutoScalingGroup($client) {

    $result = $client->terminateInstanceInAutoScalingGroup(array(
        'InstanceId' => 'string',
        // ShouldDecrementDesiredCapacity is required
        'ShouldDecrementDesiredCapacity' => true || false,
    ));
    return $result;
}

function deleteAutoScalingGroup($client) {
    $result = $client->deleteAutoScalingGroup(array(
        'AutoScalingGroupName' => 'MSscalingGroup',
        'ForceDelete' => true,
    ));
    return $result;
}

function deleteLaunchConfiguration($client) {
    $result = $client->deleteLaunchConfiguration(array(
        'LaunchConfigurationName' => 'MSlaunchConfig'
    ));
   return $result;
}

function describeAutoScalingGroups($client) {

    $result = $client->describeAutoScalingGroups(array(
        'AutoScalingGroupNames' => array('MSscalingGroup'),
    ));
    return $result;
}

function describePolicies($client) {
    $result = $client->describePolicies(array(
        'AutoScalingGroupName' => 'MSscalingGroup',
        'PolicyNames' => array('MSscalingPolicyUp'),
    ));
    return $result;
}

function describeAutoScalingInstances($client) {

    $result = $client->describeAutoScalingInstances(array(
    'InstanceIds' => array(),
    ));

    return $result;
}

?>



?>
