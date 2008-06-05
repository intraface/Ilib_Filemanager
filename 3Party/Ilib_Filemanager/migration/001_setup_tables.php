<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * This is the inital database schema for Ilib_FileHandler
 */
class AddFileHandler extends Doctrine_Migration
{
    public function up()
    {
        $this->createTable('file_handler', array (
                'id' => array (
                'alltypes' => array (
                    0 => 'integer',
                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => true,
                'notnull' => true,
                'autoincrement' => true,
                'type' => 'integer',
                'length' => 4,
            ),
            'intranet_id' => array (
                'alltypes' => array (
                    0 => 'integer',
                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,
            ),
            'user_id' => array (
                'alltypes' => array (
                    0 => 'integer',
                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,
            ),
            'date_created' => array (
                'alltypes' => array (
                    0 => 'timestamp',
                ),
                'ntype' => 'datetime',
                'values' => array (),
                'primary' => false,
                'default' => '0000-00-00 00:00:00',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'timestamp',
                'length' => 25,
            ),
            'date_changed' => array (
                'alltypes' => array (
                    0 => 'timestamp',
                ),
                'ntype' => 'datetime',
                'values' => array (),
                'primary' => false,
                'default' => '0000-00-00 00:00:00',
                'notnull' => false,
                'autoincrement' => false,
                'type' => 'timestamp',
                'length' => 25,
            ),
            'description' => array (
                'alltypes' => array (
                    0 => 'string'
                ),
                'ntype' => 'text',
                'fixed' => false,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'string',
                'length' => 2147483647,
            ),
            'file_name' => array (
                'alltypes' => array (
                    0 => 'string',
                ),
                'ntype' => 'varchar(100)',
                'fixed' => false,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'string',
                'length' => 100,
            ),
            'server_file_name' => array (
                'alltypes' => array (
                    0 => 'string',
                ),
                'ntype' => 'varchar(255)',
                'fixed' => false,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'string',
                'length' => 255,
            ),
            'file_size' => array (
                'alltypes' => array (
                    0 => 'integer',
                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,
            ),
            'file_type_key' => array (
                'alltypes' => array (
                    0 => 'integer',
                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,
            ),
            'accessibility_key' => array (
                'alltypes' => array (
                    0 => 'integer',
                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'access_key' => array (
                'alltypes' => array (
                    0 => 'string',
                ),
                'ntype' => 'varchar(255)',
                'fixed' => false,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'string',
                'length' => 255,
            ),
            'width' => array (
                'alltypes' => array (
                    0 => 'integer',
                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'notnull' => false,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,
            ),
            'height' => array (
                'alltypes' => array (
                    0 => 'integer',
                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'notnull' => false,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,
            ),
            'active' => array (
                'alltypes' => array (
                    0 => 'integer',
                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '1',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,
            ),
            'temporary' => array (
                'alltypes' => array (
                    0 => 'integer',
                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,
            ),
        ), array (
            'indexes' => array (),
            'primary' => array (
                0 => 'id',

            ),

        ));

        $this->createTable('filehandler_append_file', array (
            'id' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => true,
                'notnull' => true,
                'autoincrement' => true,
                'type' => 'integer',
                'length' => 4,

            ),
            'intranet_id' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'date_created' => array (
                'alltypes' => array (
                    0 => 'timestamp',

                ),
                'ntype' => 'datetime',
                'values' => array (),
                'primary' => false,
                'default' => '0000-00-00 00:00:00',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'timestamp',
                'length' => 25,

            ),
            'date_updated' => array (
                'alltypes' => array (
                    0 => 'timestamp',

                ),
                'ntype' => 'datetime',
                'values' => array (),
                'primary' => false,
                'default' => '0000-00-00 00:00:00',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'timestamp',
                'length' => 25,

            ),
            'belong_to_key' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'belong_to_id' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'file_handler_id' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'description' => array (
                'alltypes' => array (
                    0 => 'string',

                ),
                'ntype' => 'varchar(255)',
                'fixed' => false,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'string',
                'length' => 255,

            ),
            'active' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(1)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '1',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),

        ), array (
            'indexes' => array (),
            'primary' => array (
                0 => 'id',

            ),

        ));

        $this->createTable('file_handler_instance', array (
            'id' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => true,
                'notnull' => true,
                'autoincrement' => true,
                'type' => 'integer',
                'length' => 4,

            ),
            'intranet_id' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'file_handler_id' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'type_key' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'date_created' => array (
                'alltypes' => array (
                    0 => 'timestamp',

                ),
                'ntype' => 'datetime',
                'values' => array (),
                'primary' => false,
                'default' => '0000-00-00 00:00:00',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'timestamp',
                'length' => 25,

            ),
            'date_changed' => array (
                'alltypes' => array (
                    0 => 'timestamp',

                ),
                'ntype' => 'datetime',
                'values' => array (),
                'primary' => false,
                'default' => '0000-00-00 00:00:00',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'timestamp',
                'length' => 25,

            ),
            'server_file_name' => array (
                'alltypes' => array (
                    0 => 'string',

                ),
                'ntype' => 'varchar(255)',
                'fixed' => false,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'string',
                'length' => 255,

            ),
            'width' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(255)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'height' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(255)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '0',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'file_size' => array (
                'alltypes' => array (
                    0 => 'string',

                ),
                'ntype' => 'varchar(20)',
                'fixed' => false,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'string',
                'length' => 20,

            ),
            'crop_parameter' => array (
                'alltypes' => array (
                    0 => 'string',

                ),
                'ntype' => 'varchar(255)',
                'fixed' => false,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'string',
                'length' => 255,

            ),
            'active' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '1',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),

        ), array (
            'indexes' => array (),
            'primary' => array (
                0 => 'id',

            ),

        ));

        $this->createTable('file_handler_instance_type', array (
            'id' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => true,
                'notnull' => true,
                'autoincrement' => true,
                'type' => 'integer',
                'length' => 4,

            ),
            'intranet_id' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'name' => array (
                'alltypes' => array (
                    0 => 'string',

                ),
                'ntype' => 'varchar(255)',
                'fixed' => false,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'string',
                'length' => 255,

            ),
            'type_key' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'max_height' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'max_width' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'resize_type_key' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),
            'active' => array (
                'alltypes' => array (
                    0 => 'integer',

                ),
                'ntype' => 'int(11)',
                'unsigned' => 0,
                'values' => array (),
                'primary' => false,
                'default' => '1',
                'notnull' => true,
                'autoincrement' => false,
                'type' => 'integer',
                'length' => 4,

            ),

        ), array (
            'indexes' => array (),
            'primary' => array (
                0 => 'id',

            ),

        ));
        }

    public function down()
    {
        $this->dropTable('file_handler');
        $this->dropTable('filehandler_append_file');
        $this->dropTable('file_handler_instance');
        $this->dropTable('file_handler_instance_type');
    }
}