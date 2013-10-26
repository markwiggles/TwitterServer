<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$chartData = array(
    'positive' => 3,
    'neutral' => 1,
    'negative' => 1,
    't1' => -0.3,
    't2' => 0.6,
    't3' => 0.4,
    't4' => 0.2,
    't5' => 0.4
    );

print json_encode($chartData);
?>
