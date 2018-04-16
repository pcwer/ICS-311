<?php
// Database info
define("DATABASE_HOST", 'localhost');
define("DATABASE_USER", 'root');
define("DATABASE_PASSWORD", '');
define("DATABASE_SCHEMA", 'dbms_project');

$connection = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_SCHEMA);

?>