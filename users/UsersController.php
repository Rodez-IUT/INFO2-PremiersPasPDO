<?php
require_once 'UsersDAF.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/util/input.php';

/**
 * @param $pdo the pdo object
 */
function defaultAction($pdo) {
    global $searchStmt ;
    $status_id = (int)get('status_id') ?: 2 ;
    $start_letter = htmlspecialchars(get('start_letter').'%') ?: '%';
    $searchStmt = findUsersByUsernameAndStatus($pdo, $start_letter, $status_id) ;
};

/**
 * @param $pdo the pdo object
 */
function askDeletion($pdo) {
    $user_id = (int)get("user_id");
    // ask deletion
    askUserDeletion($pdo, $user_id);
    // update user list
    defaultAction($pdo);
}


