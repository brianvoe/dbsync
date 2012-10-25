<?php

$currency_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => '1',
        'auto_increment' => TRUE
    ),
    'title' => array(
        'type' => 'VARCHAR',
        'constraint' => 100
    ),
    'abv' => array(
        'type' => 'VARCHAR',
        'constraint' => 5
    ),
    'symbol' => array(
        'type' => 'VARCHAR',
        'constraint' => 1
    )
);

?>