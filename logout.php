<?php
session_start();
require './assets/connection/connection.php';
$_SESSION = [];
session_unset();
session_destroy();
header("Location:index.php");
?>