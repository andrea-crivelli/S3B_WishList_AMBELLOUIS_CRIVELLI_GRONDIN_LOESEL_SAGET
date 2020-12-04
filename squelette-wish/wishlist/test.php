<?php
require_once __DIR__ . '/vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DB;
use wishlist\model\Item;
use wishlist\model\Liste;

$db=new DB();
$config=parse_ini_file(__DIR__ . '/conf/db.config.ini');
if ($config) $db->addConnection($config);
$db->setAsGlobal();
//demarrer eloquent
$db->bootEloquent();


Item::ListerItem();
Liste::ListerListeSouhait();
$id=$_GET["id"];
Item::afficherItem($id);
Item::creerEtAjouterItem(1,"Boule Disco");

//truc screen du prof
$item=new Item();
print $item->liste()->first()->titre."<br>";

print $item->liste()->no."<br>";

$list=Liste::where('no','=',3)->first();
print $list->titre."<br>";

foreach ($list->items()->get() as $item) {
    print $item->nom." : ";
    print $item->descr."<br>";

}