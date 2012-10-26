<?php

$promos_columns = array(
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
    'event_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => -1,
        'index' => true
    ),
    'festival_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => -1,
        'index' => true
    ),
    'group_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => -1,
        'index' => true
    ),
    'series_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0,
        'index' => true
    ),
    'active' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1
    ),
    'numofuses' => array(
        'type' => 'VARCHAR',
        'constraint' => 11,
        'default' => '--'
    ),
    'title' => array(
        'type' => 'VARCHAR',
        'constraint' => 25
    ),
    'code' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'index' => true
    ),
    'amount' => array(
        'type' => 'DECIMAL',
        'constraint' => '11,2'
    ),
    'startdate' => array(
        'type' => 'DATE'
    ),
    'enddate' => array(
        'type' => 'DATE'
    ),
    'type' => array(
        'type' => 'ENUM',
        'constraint' => "'flat','percentage'"
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>
