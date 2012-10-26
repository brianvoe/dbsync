<?php

$api_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => true,
        'auto_increment' => TRUE
    ),
    'user_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true
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