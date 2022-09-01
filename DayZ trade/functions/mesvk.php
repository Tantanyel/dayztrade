<?php 
include("connect.php");

if (!isset($_REQUEST)) { 
  return; 
} 

$confirmation_token = '76bb711f'; 

$token = '0f5c825f96d8e41b257ec39d14840b6b0b882f429317a8848a2262a870617126e73f455a960d620b0a475'; 

$data = json_decode(file_get_contents('php://input')); 

switch ($data->type) {
  case 'confirmation': 
    echo $confirmation_token; 
    break; 
} 
?> 