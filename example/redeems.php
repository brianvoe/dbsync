<?php

$redeems_columns = array(
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
    'event_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true
    ),
    'participant_id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'index' => true
    ),
    'code' => array(
        'type' => 'VARCHAR',
        'constraint' => 45
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>
