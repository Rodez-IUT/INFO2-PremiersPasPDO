<?php
namespace controllers;

use Exception;
use services\UsersService;
use yasmf\HttpHelper;
use yasmf\View;

class HomeController {

    private $usersService;

    public function __construct()
    {
        $this->usersService = UsersService::getDefaultUsersService();
    }

    public function index($pdo) {
        $status_id = (int)HttpHelper::getParam('status_id') ?: 2 ;
        if ($status_id == 3) {
            throw new Exception("Not authorized!!");
        }
        $start_letter = htmlspecialchars(HttpHelper::getParam('start_letter').'%') ?: '%';
        $searchStmt = $this->usersService->findUsersByUsernameAndStatus($pdo, $start_letter, $status_id) ;
        $view = new View("DUTInfo2/views/all_users");
        $view->setVar('searchStmt',$searchStmt);
        return $view;
    }

    public function askDeletion($pdo) {
        throw new Exception("Not authorized!!");
        $user_id = (int)HttpHelper::getParam("user_id");
        // ask deletion
        $this->usersService->askUserDeletion($pdo, $user_id);
        // update user list
        return $this->index($pdo);
    }

}


