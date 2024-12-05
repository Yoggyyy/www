<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Hero.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Armor.inc.php');

const hero1 = new Hero('Spiderman', 'humano', 'ninguna', 50, 10, 10);

const nanotecnology = new Armor('NanoTecnology', 100);

$armor = hero1->addArmor(nanotecnology);

2ºprint($armor);
echo ($armor);
