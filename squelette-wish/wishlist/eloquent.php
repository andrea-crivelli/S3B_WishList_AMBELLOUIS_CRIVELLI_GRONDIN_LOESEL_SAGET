<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;

//gestionnaire de connexions
$db=new DB();

print ("eloquent est installé\n");

$config=parse_ini_file(__DIR__ . '/conf/db.config.ini');

if ($config) $db->addConnection($config);

$db->setAsGlobal();
//demarrer eloquent
$db->bootEloquent();

print ("eloquent est démarré \n");
