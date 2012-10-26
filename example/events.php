<?php

$events_columns = array(
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
    'active' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1
    ),
    'api_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0
    ),
    'temp' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 0
    ),
    'title' => array(
        'type' => 'VARCHAR',
        'constraint' => 100,
        'null' => true
    ),
    'title_abv' => array(
        'type' => 'VARCHAR',
        'constraint' => 25
    ),
    'description' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'address' => array(
        'type' => 'VARCHAR',
        'constraint' => 100,
        'null' => true
    ),
    'city' => array(
        'type' => 'VARCHAR',
        'constraint' => 35,
        'null' => true
    ),
    'state' => array(
        'type' => 'VARCHAR',
        'constraint' => 6,
        'null' => true
    ),
    'zip' => array(
        'type' => 'VARCHAR',
        'constraint' => 15,
        'null' => true
    ),        
    'country' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => 'United States',
        'null' => true
    ),
    'cur' => array(
        'type' => 'TINYINT',
        'constraint' => 2,
        'default' => 1,
        'index' => true
    ),
    'fee' => array(
        'type' => 'DECIMAL',
        'constraint' => '10,2',
        'default' => '0.00'
    ),
    'percfee' => array(
        'type' => 'DECIMAL',
        'constraint' => '10,2',
        'default' => '5.50'
    ),
    'perparfee' => array(
        'type' => 'DECIMAL',
        'constraint' => '10,2',
        'default' => '5.32'
    ),
    'teams' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => 'no'
    ),
    'minage' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 14
    ),
    'reservetime' => array(
        'type' => 'TINYINT',
        'constraint' => 5,
        'default' => 0
    ),
    'allowtrans' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1
    ),
    'endtrans' => array(
        'type' => 'DATETIME'
    ),
    'barcode_waiver_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0
    ),
    'tiered_prices' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'regstartend' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => true
    ),
    'spacewave' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1
    ),
    'datestimes' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'products' => array(
        'type' => 'VARCHAR',
        'constraint' => 150,
        'null' => true
    ),
    'freeproducts' => array(
        'type' => 'TEXT'
    ),
    'forms' => array(
        'type' => 'VARCHAR',
        'constraint' => 150,
        'null' => true
    ),
    'donations' => array(
        'type' => 'VARCHAR',
        'constraint' => 150,
        'null' => true
    ), 
    'otherdonation' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 0
    ),
    'website' => array(
        'type' => 'VARCHAR',
        'constraint' => 250,
        'null' => true
    ),
    'email' => array(
        'type' => 'VARCHAR',
        'constraint' => 100,
        'null' => true
    ),
    'phone' => array(
        'type' => 'VARCHAR',
        'constraint' => 15,
        'null' => true
    ),
    'event_path' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => true
    ),
    'social' => array(
        'type' => 'VARCHAR',
        'constraint' => 250,
        'null' => true
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>
