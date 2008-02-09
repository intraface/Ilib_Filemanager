<?php
require_once 'Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));

Doctrine_Manager::connection('mysql://root:@localhost/pear');

require_once 'Doctrine/Migration.php';
$migration = new Doctrine_Migration('./migration');
echo $migration->getCurrentVersion();

$migration->migrate(1);

echo $migration->getCurrentVersion();