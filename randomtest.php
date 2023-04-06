<?php
$file = fopen('user.csv', 'r');
$data = fgetcsv($file,5000,';');
var_dump($data);
