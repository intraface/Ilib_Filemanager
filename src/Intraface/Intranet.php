<?php

class FakeIntranet {

    public $values;
    
    public function __construct() {
        $this->values = array(
            'id' => 0,
            'public_key' => 'file');
    }
    
    public function get($key) {
        // if id should be other than 0 you need to add options to the use of Ilib classes with 'intranet_id = ?'
        return $this->values[$key];
    }
}
