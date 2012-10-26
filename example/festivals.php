<?php

$festivals_columns = array(
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
    'checkout_time' => array(
        'type' => 'TINYINT',
        'constraint' => 5,
        'default' => 0
    ),
    'api_id' => array(
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
    'ship_fee' => array(
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
    'minage' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 14
    ),
    'reg_start' => array(
        'type' => 'DATETIME'
    ),
    'reg_end' => array(
        'type' => 'DATETIME'
    ),
    'endtrans' => array(
		'type' => 'DATETIME',
		'null' => true
	),
    'barcode_waiver_id' => array(
        'type' => 'INT',
        'constraint' => 11,
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
    'image' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => true
    ),
    'questions' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'free_products' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'products' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'charities' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'social' => array(
        'type' => 'VARCHAR',
        'constraint' => 250,
        'null' => true
    ),
    'modified' => array(
        'type' => 'DATETIME'
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>
