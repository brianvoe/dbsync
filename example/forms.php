<?php

$forms_columns = array(
   'id' => array(
        'type' => 'INT',
        'constraint' => 10,
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
    'required' => array(
        'type' => 'TINYINT',
        'constraint' => 4,
        'default' => 1
    ),
    'perreg' => array(
        'type' => 'TINYINT',
        'constraint' => 1,
        'default' => 1
    ),
    'title' => array(
        'type' => 'VARCHAR',
        'constraint' => 100
    ),
    'question' => array(
        'type' => 'TEXT'
    ),
    'answers' => array(
        'type' => 'TEXT'
    ),
    'type' => array(
        'type' => 'ENUM',
        'constraint' => "'field','dropdown','checkbox','radio'",
        'default' => 'field'
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>
