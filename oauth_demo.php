<html>
    <head>
        <title>Login with Github</title>
    </head>
    <h1>Login with Github</h1>
    <?php
        session_start();

        $client_id = 'd2bec8256d6d6820869d';
        $client_secret = '7843dbe00539131e85d78a2a28fc6c8bded322af';
        $callback='http://localhost/demo/oauth_demo.php';

        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            $client_id = '854c1d839e9326c04ac5';
            $client_secret = 'ac9fe5b29c7b01edfae3ccec205f6194854e7bde';
            $callback='https://www.melabear.cn/demo/oauth_demo.php';
        }

        $github_login = 'https://github.com/login/oauth/authorize?'
            . "client_id=$client_id&redirect_uri=$callback";
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        if (isset($_REQUEST['logout'])) {
            if (isset($_SESSION['user_name'])) {
                echo '<p>Bye ' . $_SESSION['user_name'] . ' ~</p>';
                unset($_SESSION['access_token']);
                unset($_SESSION['user_name']);
                session_destroy();
            }
        }

        echo '<p>Session ID is: ' . $_COOKIE['PHPSESSID'] . '</p>';

        if (isset($_SESSION['user_name'])) {
            $user_name  = $_SESSION['user_name'];
            $user_login = $_SESSION['user_login'];
            $user_email = $_SESSION['user_email'];

            echo '<h4>Welcome, ' . $user_name . ' (' . $user_login . '), ';
            echo 'your email is: ' . $user_email . '</h4>';
            echo '<p><a href="/demo/oauth_demo.php?logout=1">logout</a></p>';
            echo '</html>';
            exit();
        }

        if (! isset($_SESSION['access_token'])) {
            if (! isset($_REQUEST['code'])) {
                echo '<a href="' . $github_login
                    . '">Please login with your github account</a>';
                exit();
            }

            $auth_code = $_REQUEST['code'];

            $token_url = 'https://github.com/login/oauth/access_token'
                        . '?client_id=' . $client_id
                        . '&client_secret=' . $client_secret 
                        . '&code=' . $auth_code;
            $context = stream_context_create([ 'http' => [
                'header' => [
                    'Accept: application/json',
                    'User-Agent: ' . $user_agent,
                ]
            ]]);
            $result = file_get_contents($token_url, false, $context);

            if ($result == false) {
                echo '<p>Requesting for token failed!!!</p>';
                exit();
            }

            $data = json_decode($result);
            $access_token = $data->access_token;
            echo '<p>Authorization token: ' . $access_token . '</p>';

            if (strlen($access_token) >= 40) {
                $_SESSION['access_token'] = $access_token;
            }
        } else {
            $access_token = $_SESSION['access_token'];
            echo '<p>Reusing existing token: ' . $access_token . '</p>';
        }

        $user_api = 'https://api.github.com/user';
        $context = stream_context_create([ 'http' => [
            'header' => [
                'User-Agent: ' . $user_agent,
                'Authorization: token ' . $access_token,
            ]
        ]]);
        $result = file_get_contents($user_api, false, $context);

        if ($result == false) {
            echo '<p>Requesting for user info failed !!!</p>';
            exit();
        }

        $user_info = json_decode($result);
        $user_name  = $user_info->name;
        $user_login = $user_info->login;
        $user_email = $user_info->email;

        $_SESSION['user_name']  = $user_name;
        $_SESSION['user_login'] = $user_login;
        $_SESSION['user_email'] = $user_email;

        echo '<h4>Welcome, ' . $user_name . ' (' . $user_login . '), ';
        echo 'your email is: ' . $user_email . '</h4>';
        echo '<p><a href="/demo/oauth_demo.php?logout=1">logout</a></p>';
    ?>
</html>