<?php

$donations_columns = array(
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
    'sendemail' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 0
    ),
    'title' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => true
    ),
    'name' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => true
    ),
    'description' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'contactname' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => true
    ),
    'contactphone' => array(
        'type' => 'VARCHAR',
        'constraint' => 25,
        'null' => true
    ),
    'contactemail' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => true
    ),
    'website' => array(
        'type' => 'VARCHAR',
        'constraint' => 75,
        'null' => true
    ),
    'acceptdonations' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1,
    ),
    'prices' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'otherdonation' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 0
    ),
    'image' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => true
    ),
    'questions' => array(
        'type' => 'TEXT'
    ),
    'startdate' => array(
        'type' => 'DATE',
    ),
    'enddate' => array(
        'type' => 'DATE',
    ),
    'created' => array(
        'type' => 'DATETIME',
    )
);

?>
