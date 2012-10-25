<?php

$cheese_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => '1',
        'auto_increment' => TRUE
    ),
    'user_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true
    ),
    'title' => array(
        'type' => 'VARCHAR',
        'constraint' => 32,
        'null' => true
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>