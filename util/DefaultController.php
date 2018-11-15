<?php
require_once 'DataSource.php';
require_once 'Input.php';

// set action to trigger
$action = get('action') ?: 'defaultAction';

// trigger the appropriate action
$action(getPDO());
