<?php

$barcodes_columns = array(
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
    'assigned_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true
    ),
    'participant_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true
    ),
    'event_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true,
        'default' => 0
    ),
    'festival_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true,
        'default' => 0
    ),        
    'package_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true,
        'default' => 0
    ),
    'barcode' => array(
        'type' => 'VARCHAR',
        'constraint' => 15
    )
);

?>
