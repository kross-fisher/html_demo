<?php
    session_start();

    if (isset($_SESSION['valid_user'])) {
        $old_user = $_SESSION['valid_user'];
        unset($_SESSION['valid_user']);
        session_destroy();
    }
?>
<html>
<body>
<h1>Log out</h1>
<?php
    if (! empty($old_user)) {
        echo 'Logged out.<br/>';
        echo 'Bye ' . $old_user . ' ~<br/>';
    } else {
        echo 'You were not logged in, and so have not been logged out.<br/>';
    }
?>
<a href="authmain.php">Back to main page</a>
</body>
</html>