<?php
error_reporting(0);
// session_unset($_SESSION['admin']);
session_destroy();
header('location: index.php');