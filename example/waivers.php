<?php

$waivers_columns = array(
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
    'status' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1
    ),
    'title' => array(
        'type' => 'VARCHAR',
        'constraint' => 100
    ),
    'waiver' => array(
        'type' => 'TEXT'
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>