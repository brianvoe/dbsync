<?php

$promos_columns = array(
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
    'event_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => -1,
        'index' => 'yes'
    ),
    'festival_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => -1,
        'index' => 'yes'
    ),
    'group_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => -1,
        'index' => 'yes'
    ),
    'series_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0,
        'index' => 'yes'
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
        'index' => 'yes'
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
