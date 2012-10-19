<?php

$users_columns = array(
    'id' => array(
        'type' => 'INT',
        'constraint' => 11,
        'primary' => true,
        'auto_increment' => true
    ),
    'post_data' => array(
        'type' => 'TEXT',
        'null' => true
    ),
    'created' => array(
        'type' => 'DATETIME'
    )
);

?>