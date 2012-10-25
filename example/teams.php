<?php

$teams_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => '1',
        'auto_increment' => TRUE
    ),
    'user_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0,
        'index' => 'yes'
    ),
    'participant_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0,
        'index' => 'yes'
    ),
    'event_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0,
        'index' => 'yes'
    ),
    'assigned_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0,
        'index' => 'yes'
    ),
    'leader' => array(
        'type' => 'INT',
        'constraint' => 11,
        'default' => 0,
        'index' => 'yes'
    ),
    'team_name' => array(
        'type' => 'VARCHAR',
        'constraint' => 50,
        'index' => 'yes'
    )
);

?>
