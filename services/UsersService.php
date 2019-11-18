<?php


namespace users;


class UsersService
{
    /**
     * @param $pdo the pdo object
     * @param $likeUsername the string the username should contain
     * @param $statusId the status id
     * @return the statement referencing the result set
     */
    public function findUsersByUsernameAndStatus($pdo, $likeUsername, $statusId)
    {
        $sql = "select users.id as user_id, username, email, s.name as status, s.id as status_id 
            from users join status s on users.status_id = s.id 
            where username like :likeUsername and status_id = :statusId order by username";
        $searchStmt = $pdo->prepare($sql);
        $searchStmt->execute(['likeUsername' => $likeUsername, 'statusId' => $statusId]);
        return $searchStmt;
    }

    /**
     * @param $pdo the pdo object
     * @param $userId the id of the user to be deleted
     */
    public function askUserDeletion($pdo, $userId)
    {
        try {
            // begin transaction
            $pdo->beginTransaction();
            // insert log
            $sql2 = "insert into action_log (action_date, action_name, user_id) 
              values (CURRENT_TIME(),'askDeletion',?)";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute([$userId]);
            // update user
            $sql1 = "update users set status_id = 3 where id = ?";
            $stmt1 = $pdo->prepare($sql1);
            $stmt1->execute([$userId]);
            // commit transaction
            $pdo->commit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    private static $defaultUsersService ;
    public static function getDefaultUsersService()
    {
        if (UsersService::$defaultUsersService == null) {
            UsersService::$defaultUsersService = new UsersService();
        }
        return UsersService::$defaultUsersService;
    }
}