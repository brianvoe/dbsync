<?php

$products_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => true,
        'auto_increment' => TRUE
    ),
    'user_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true,
        'extra' => 'unsigned'
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
    'modified' => array(
        'type' => 'TIMESTAMP',
        'default' => 'current_timestamp',
        'on_update_time' => true
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>
