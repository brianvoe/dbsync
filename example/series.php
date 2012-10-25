<?php

$series_columns = array(
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
        'constraint' => "'e','p','c','q','m','d','f'",
        'default' => 'e'
    ),
    'title' => array(
        'type' => 'VARCHAR',
        'constraint' => 25
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>
