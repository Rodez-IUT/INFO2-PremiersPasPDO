<?php
namespace controllers;

use yasmf\HttpHelper;
use yasmf\View;

class UsersController {

    private $usersService;

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->usersService = UsersService::getDefaultUsersService();
    }

    public function defaultAction($pdo) {
        $status_id = (int)HttpHelper::get('status_id') ?: 2 ;
        $start_letter = htmlspecialchars(HttpHelper::get('start_letter').'%') ?: '%';
        $searchStmt = $this->usersService->findUsersByUsernameAndStatus($pdo, $start_letter, $status_id) ;
        $view = new View("/users/all_users");
        $view->setVar('searchStmt',$searchStmt);
        return $view;
    }

    public function askDeletion($pdo) {
        $user_id = (int)HttpHelper::get("user_id");
        // ask deletion
        $this->usersService->askUserDeletion($pdo, $user_id);
        // update user list
        return defaultAction($pdo);
    }

}


