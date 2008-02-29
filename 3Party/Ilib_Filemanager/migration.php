<?php
require_once 'Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));

Doctrine_Manager::connection('mysql://root:@localhost/pear');

require_once 'Doctrine/Migration.php';
$migration = new Doctrine_Migration('./migration');

$migrate_to = 1;

if ($migration->getCurrentVersion() >= $migrate_to) {
    exit('Database scheme is already at least at version ' . $migration->getCurrentVersion());
}

$migration->migrate($migrate_to);

exit('Now the database scheme is at version ' . $migration->getCurrentVersion());