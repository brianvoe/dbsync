<?php

$users_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => true,
        'auto_increment' => TRUE
    ),
    'parent' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0
    ),
    'type' => array(
        'type' => 'ENUM',
        'constraint' => "'s','a','t','c','m','p'",
        'default' => 'c'
    ),
    'username' => array(
        'type' => 'VARCHAR',
        'constraint' => 50
    ),
    'password' => array(
        'type' => 'VARCHAR',
        'constraint' => 255
    ),
    'email' => array(
        'type' => 'VARCHAR',
        'constraint' => 100
    ),
    'subscribe' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1
    ),
    'activated' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1
    ),
    'up_pwd' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 0
    ),
    'banned' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 0
    ),
    'ban_reason' => array(
        'type' => 'VARCHAR',
        'constraint' => 255,
        'null' => true
    ),
    'new_password_key' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => true
    ),
    'new_password_requested' => array(
        'type' => 'DATETIME',
        'null' => true
    ),
    'new_email' => array(
        'type' => 'VARCHAR',
        'constraint' => 100,
        'null' => true
    ),
    'new_email_key' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => true
    ),
    'last_ip' => array(
        'type' => 'VARCHAR',
        'constraint' => 40
    ),
    'last_login' => array(
        'type' => 'DATETIME'
    ),
    'created' => array(
        'type' => 'DATETIME'
    ),
    'modified' => array(
        'type' => 'TIMESTAMP',
        'default' => 'CURRENT_TIMESTAMP'
    )
);

?>
