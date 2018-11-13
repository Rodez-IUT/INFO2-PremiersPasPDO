<?php
require_once 'UsersDAF.php';

/**
 * @param $pdo the pdo object
 */
function defaultAction($pdo) {
    global $searchStmt ;
    $status_id = (int)$_GET['status_id'] ?: 2 ;
    $start_letter = htmlspecialchars($_GET['start_letter'].'%') ?: '%';
    $searchStmt = findUsersByUsernameAndStatus($pdo, $start_letter, $status_id) ;
};

/**
 * @param $pdo the pdo object
 */
function askDeletion($pdo) {
    $user_id = (int)$_GET["user_id"];
    // ask deletion
    askUserDeletion($pdo, $user_id);
    // update user list
    defaultAction($pdo);
}

