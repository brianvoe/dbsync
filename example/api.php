<?php

$api_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => '1',
        'auto_increment' => TRUE
    ),
    'user_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => 'yes'
    ),
    'type' => array(
        'type' => 'ENUM',
        'constraint' => "'t','c'"
    ),
    'key' => array(
        'type' => 'VARCHAR',
        'constraint' => 10
    ),
    'secret' => array(
        'type' => 'VARCHAR',
        'constraint' => 15
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>