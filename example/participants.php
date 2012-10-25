<?php

$participants_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => '1',
        'auto_increment' => TRUE
    ),
    'parent' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0
    ),
    'user_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => 'yes'
    ),
    'cim_id' => array(
        'type' => 'VARCHAR',
        'constraint' => 32,
        'default' => 0
    ),
    'firstname' => array(
        'type' => 'VARCHAR',
        'constraint' => 50
    ),
    'lastname' => array(
        'type' => 'VARCHAR',
        'constraint' => 50
    ),
    'address' => array(
        'type' => 'VARCHAR',
        'constraint' => 100
    ),
    'address2' => array(
        'type' => 'VARCHAR',
        'constraint' => 100,
        'null' => true
    ),
    'city' => array(
        'type' => 'VARCHAR',
        'constraint' => 50
    ),
    'state' => array(
        'type' => 'VARCHAR',
        'constraint' => 10
    ),
    'zip' => array(
        'type' => 'VARCHAR',
        'constraint' => 10
    ),
    'country' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'default' => 'United States'
    ),
    'phone' => array(
        'type' => 'VARCHAR',
        'constraint' => 25
    ),
    'birthdate' => array(
        'type' => 'DATE'
    ),
    'gender' => array(
        'type' => 'ENUM',
        'constraint' => "'M','F'"
    ),
    'avatarpath' => array(
        'type' => 'VARCHAR',
        'constraint' => 50
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>
