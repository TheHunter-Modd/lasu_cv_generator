<?php
require_once 'config_session.inc.php';

session_start();
session_unset();
session_destroy();

header("Location: ../login.php");
die();