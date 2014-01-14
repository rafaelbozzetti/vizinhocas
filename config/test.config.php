<?php
return array(
  'db' => array(
    'driver' => 'PDO',
    'dsn'    => 'mysql:dbname=vizinhocas_test;host=localhost',
    'username' => 'root',
    'password' => 'juazeir0',
    'driver_options' => array(
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
    ),
));