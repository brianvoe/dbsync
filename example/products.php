<?php

$products_columns = array(
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
    'active' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1
    ),
    'title' => array(
        'type' => 'TEXT'
    ),
    'cost' => array(
        'type' => 'DECIMAL',
        'constraint' => '10,2'
    ),
    'description' => array(
        'type' => 'TEXT'
    ),
    'product_path' => array(
        'type' => 'TEXT'
    ),
    'minmax' => array(
        'type' => 'VARCHAR',
        'constraint' => 15
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>
