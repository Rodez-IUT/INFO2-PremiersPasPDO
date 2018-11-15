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
    PDO::ATTR_EMULATE_PREPARES => false,
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

?>

<h1>All Users</h1>

<form action="all_users.php" method="get">
    Start with letter:
    <input name="start_letter" type="text" value="<?php echo get("start_letter") ?>">
    and status is:
    <select name="status_id">
        <option value="1" <?php if (get("status_id") == 1) echo 'selected' ?>>Waiting for account validation</option>
        <option value="2" <?php if (get("status_id") == 2) echo 'selected' ?>>Active account</option>
    </select>
    <input type="submit" value="OK">
</form>

<?php
$start_letter = htmlspecialchars(get("start_letter").'%');
$status_id = (int)get("status_id");
$sql = "select users.id as user_id, username, email, s.name as status from users join status s on users.status_id = s.id where username like :start_letter and status_id = :status_id order by username";
$stmt = $pdo->prepare($sql);
$stmt->execute(['start_letter' => $start_letter, 'status_id' => $status_id]);
?>
<table>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Email</th>
        <th>Status</th>
    </tr>
    <?php while ($row = $stmt->fetch()) { ?>
        <tr>
            <td><?php echo $row['user_id'] ?></td>
            <td><?php echo $row['username'] ?></td>
            <td><?php echo $row['email'] ?></td>
            <td><?php echo $row['status'] ?></td>
        </tr>
    <?php } ?>
</table>


</body>
</html>