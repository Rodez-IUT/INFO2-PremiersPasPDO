<?php
require_once 'DataSource.php';

// set action to trigger
$action = $_GET['action'] ?: 'defaultAction';

// trigger the appropriate action
$action(getPDO());
