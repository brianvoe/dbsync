<?php

$teams_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => true,
        'auto_increment' => TRUE
    ),
    'user_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0,
        'index' => true
    ),
    'participant_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0,
        'index' => true
    ),
    'event_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0,
        'index' => true
    ),
    'assigned_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0,
        'index' => true
    ),
    'leader' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0,
        'index' => true
    ),
    'team_name' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'index' => true
    )
);

?>
