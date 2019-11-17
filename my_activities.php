<?php
require_once 'data_source.php';
require_once 'input.php';

// set action to trigger
$action = get('action') ?: 'defaultAction';

// trigger the appropriate action
$action(getPDO());
