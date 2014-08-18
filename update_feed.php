<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$data = $_GET['name'];

$objDateTime = new DateTime('NOW');
$time =  $objDateTime->format('d-m-Y H:i:s');

header('Content-Type: application/json');
echo json_encode(array('time' => $time,'name'=> $data));