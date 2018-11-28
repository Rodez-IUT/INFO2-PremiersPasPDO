<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All users</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>

<?php


// Connexion to the database

$host = 'localhost';
$port = '8889';
$db = 'my_activities';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo $e->getMessage();
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

function get($name) {
    return isset($_GET[$name]) ? $_GET[$name] : null;
}

// set action to trigger
$action = get('action') ?: 'searchUsers';

$searchStmt = null;

// trigger the appropriate action
$action($pdo);

function searchUsers($pdo){
    global $searchStmt;
    $status_id = (int)get('status_id') ?: 2;
    $start_letter = htmlspecialchars(get('start_letter') . '%') ?: '%';
    $sql = "select users.id as user_id, username, email, s.name as status, s.id as status_id 
            from users join status s on users.status_id = s.id 
            where username like :start_letter and status_id = :status_id order by username";
    $searchStmt = $pdo->prepare($sql);
    $searchStmt->execute(['start_letter' => $start_letter, 'status_id' => $status_id]);
}

function askDeletion($pdo){
    $user_id = (int)get("user_id");
    // insert log
    $sql2 = "insert into action_log (action_date, action_name, user_id) 
              values (CURRENT_TIME(),'askDeletion',?)";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([$user_id]);
    // update user
    $sql1 = "update users set status_id = 3 where id = ?";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute([$user_id]);
    // update user list
    searchUsers($pdo);
}

?>


<h1>All Users</h1>

<form action="all_users.php" method="get">
    <input hidden name="action" value="searchUsers">
    Start with letter:
    <input name="start_letter" type="text" value="<?php echo $_GET["start_letter"] ?>">
    and status is:
    <select name="status_id">
        <option value="1" <?php if (get('status_id') == 1) echo 'selected' ?>>Waiting for account validation</option>
        <option value="2" <?php if (get('status_id') == 2) echo 'selected' ?>>Active account</option>
        <option value="3" <?php if (get('status_id') == 3) echo 'selected' ?>>Waiting for account deletion</option>
    </select>
    <input type="submit" value="OK">
</form>


<table>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Email</th>
        <th>Status</th>
        <th></th>
    </tr>
    <?php while ($row = $searchStmt->fetch()) { ?>
        <tr>
            <td><?php echo $row['user_id'] ?></td>
            <td><?php echo $row['username'] ?></td>
            <td><?php echo $row['email'] ?></td>
            <td><?php echo $row['status'] ?></td>
            <td>
                <?php if ($row['status_id'] != 3) { ?>
                    <a href="all_users.php?status_id=3&user_id=<?php echo $row['user_id'] ?>&action=askDeletion">Ask
                        deletion</a>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>


</body>
</html>