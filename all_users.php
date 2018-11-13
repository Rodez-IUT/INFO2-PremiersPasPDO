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
// set globlal variable needed for the display
$searchStmt = null ;

// link to controllers
require_once 'users/UsersController.php';
require_once 'util/DefaultController.php';

?>

<h1>All Users</h1>

<form action="all_users.php" method="get">
    <input hidden name="action" value="defaultAction">
    Start with letter:
    <input name="start_letter" type="text" value="<?php echo $_GET["start_letter"] ?>">
    and status is:
    <select name="status_id">
        <option value="1" <?php if ($_GET['status_id'] == 1) echo 'selected' ?>>Waiting for account validation</option>
        <option value="2" <?php if ($_GET['status_id'] == 2) echo 'selected' ?>>Active account</option>
        <option value="3" <?php if ($_GET['status_id'] == 3) echo 'selected' ?>>Waiting for account deletion</option>
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
                <a href="all_users.php?status_id=3&user_id=<?php echo $row['user_id']?>&action=askDeletion">Ask deletion</a>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>



</body>
</html>