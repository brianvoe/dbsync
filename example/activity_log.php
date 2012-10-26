<?php

$activity_log_columns = array(
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
    'ind_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true
    ),
    'par_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true
    ),
    'reg_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => '0'
    ),
    'event_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => '0',
        'index' => true
    ),
    'festival_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => '0',
        'index' => true
    ),
    'title' => array(
        'type' => 'VARCHAR',
        'constraint' => 32,
        'null' => true
    ),
    'description' => array(
        'type' => 'VARCHAR',
        'constraint' => 140,
        'null' => true
    ),
    'before_after' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'post_data' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'get_data' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'execution_time' => array(
        'type' => 'DECIMAL',
        'constraint' => '5,4',
        'default' => '0.0000'
    ),
    'memory_usage' => array(
        'type' => 'BIGINT',
        'constraint' => 20,
        'default' => '0'
    ),
    'uri_string' => array(
        'type' => 'VARCHAR',
        'constraint' => 32,
        'null' => true
    ),
    'class_method' => array(
        'type' => 'VARCHAR',
        'constraint' => 32,
        'null' => true
    ),
    'db_queries' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>