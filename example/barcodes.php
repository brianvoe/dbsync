<?php

$barcodes_columns = array(
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
    'assigned_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => 'yes'
    ),
    'participant_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => 'yes'
    ),
    'event_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => 'yes',
        'default' => 0
    ),
    'festival_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => 'yes',
        'default' => 0
    ),        
    'package_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => 'yes',
        'default' => 0
    ),
    'barcode' => array(
        'type' => 'VARCHAR',
        'constraint' => 15
    )
);

?>
