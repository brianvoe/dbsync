<?php

$divisions_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => true,
        'auto_increment' => TRUE
    ),
    'event_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true
    ),
    'title' => array(
        'type' => 'VARCHAR',
        'constraint' => 50
    ),
    'agemin' => array(
        'type' => 'TINYINT',
        'constraint' => 3,
        'default' => 0
    ),
    'agemax' => array(
        'type' => 'TINYINT',
        'constraint' => 3,
        'default' => 0
    ),
    'sizemin' => array(
        'type' => 'TINYINT',
        'constraint' => 3
    ),
    'sizemax' => array(
        'type' => 'TINYINT',
        'constraint' => 3
    )
);

?>
