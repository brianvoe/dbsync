<?php

$files_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => true,
        'auto_increment' => true
    ),
    'ind_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true
    ),
    'price' => array(
        'type' => 'decimal',
        'constraint' => '10,2',
        'default' => '0.00',
        'null' => true
    ),
    'description' => array(
        'type' => 'VARCHAR',
        'constraint' => 140,
        'null' => true
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>