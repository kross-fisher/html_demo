<?php
$userid = $_POST['userid'];
$password = $_POST['password'];

session_start();

if (isset($userid) && isset($password)) {

    $db_conn = new mysqli('localhost', 'webauth', 'webauth', 'auth');

    if (mysqli_connect_errno()) {
        echo 'Connection to database failed: ' . mysqli_connect_error();
        exit();
    }

    $query = 'select * from authorized_users '
           . "where name = '$userid' and password = "
           . "sha1('$password')";

    $result = $db_conn->query($query);
    if ($result->num_rows) {
        $_SESSION['valid_user'] = $userid;
    }
    $db_conn->close();
}
?>
<html>
<body>
<h1>Home page</h1>
<?php
if (isset($_SESSION['valid_user'])) {
    echo 'You are logged in as: ' . $_SESSION['valid_user'] . ' <br/>';
    echo '<a href="logout.php">Log out</a><br/>';
} else {
    if (isset($userid)) {
        echo 'Could not log you in.<br/>';
    } else {
        echo 'You are not logged in.<br/>';
    }
    ?>
    <form method="post" action="authmain.php">
    <table>
    <tr><td>Userid:</td>
    <td><input type="text" name="userid"></td></tr>
    <tr><td>Password:</td>
    <td><input type="password" name="password"></td></tr>
    <tr><td colspan="2" align="center">
    <input type="submit" value="Log in"></td></tr>
    </table></form>
    <?php
}
?>
<br />
<a href="members_only.php">Members section</a>
</body>
</html>
