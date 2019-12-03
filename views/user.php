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

<h1>Edit user</h1>

<form action="my_activities.php" method="post">
    <input hidden name="action" value="saveUser">
    <input hidden name="user_id" value="<?php echo $user["user_id"] ?>">
    <table>
        <tr>
            <td>id</td>
            <td><?php echo $user["user_id"] ?></td>
        </tr>
        <tr>
            <td>username</td>
            <td><input name="username" value="<?php echo $user['username'] ?>"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Save"></td>
        </tr>
    </table>
</form>


</body>
</html>