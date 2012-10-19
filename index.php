<?php
include 'dbsync.php';
$dbsync = new dbsync();
$dbsync->compile_itis_tables();
$dbsync->compile_want_tables();
$dbsync->compare_final();

?>