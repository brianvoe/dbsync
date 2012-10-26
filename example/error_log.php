<?php

$error_log_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => true,
        'auto_increment' => TRUE
    ),
    'ind_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0,
        'index' => true
    ),
    'error' => array(
        'type' => 'VARCHAR',
        'constraint' => 15
    ),
    'level' => array(
        'type' => 'VARCHAR',
        'constraint' => 35
    ),
    'message' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
    ),
    'ip_address' => array(
        'type' => 'VARCHAR',
        'constraint' => 30,
        'default' => 0
    ),
    'user_agent' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => 0
    ),
    'uri' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'default' => 0
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>
