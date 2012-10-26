<?php

$waivers_columns = array(
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