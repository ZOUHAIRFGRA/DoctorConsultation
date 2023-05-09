<?php
$dsn = 'mysql:host=localhost;dbname=doctorBD';
$username = 'zouhair';
$password = 'admin';
$connection = new PDO($dsn, $username, $password, []);
$message = '';
