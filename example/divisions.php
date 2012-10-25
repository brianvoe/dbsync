<?php

$divisions_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => '1',
        'auto_increment' => TRUE
    ),
    'event_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => 'yes'
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
