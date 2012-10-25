<?php

$emails_columns = array(
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
    'active' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1
    ),
    'type' => array(
        'type' => 'ENUM',
        'constraint' => "'confirm','refund','remind'",
        'default' => 'confirm'
    ),
    'replyto' => array(
        'type' => 'VARCHAR',
        'constraint' => 150,
        'null' => true
    ),
    'title' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'subject' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'message' => array(
        'type' => 'LONGTEXT',
        'null' => true
    ),
    'created' => array(
        'type' => 'DATETIME'
    ),
);

?>
