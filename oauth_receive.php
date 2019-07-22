<html>
    <head>
        <title>OAuth2.0 Handler</title>
    </head>
    <h1>OAuth2.0 Handler</h1>
    <?php
        $code = $_REQUEST['code'];
        $client_id='d2bec8256d6d6820869d';
        $client_secret = '7843dbe00539131e85d78a2a28fc6c8bded322af';
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $token_url = 'https://github.com/login/oauth/access_token'
                    . '?client_id=' . $client_id
                    . '&client_secret=' . $client_secret 
                    . '&code=' . $code;

        echo 'returned code is: ' . $code . '<br/>';

        //$access_token = '29f1795b398f55ebc4513e65e79ccab94ba77c76';

        if ( ! isset($access_token)) {
            $options = [ 'http' => [
                'header' => 'accept: application/json'
            ]];
            $context = stream_context_create($options);
            $result = file_get_contents($token_url, false, $context);

            if ($result == false) {
                echo "requesting for token failed!!";
                exit();
            }

            $data = json_decode($result);
            $access_token = $data->access_token;
            echo 'token is: ' . $access_token . '<br/>';
        }

        $options = [
            'http'  => [
                'header' => [
                    'Authorization: token ' . $access_token,
                    'User-Agent: ' . $user_agent,
                ]
            ]
        ];
        $user_api = 'https://api.github.com/user';
        $context = stream_context_create($options);
        $result = file_get_contents($user_api, false, $context);

        echo 'user-agent: <pre>' . $user_agent . '</pre><br/>';

        if ($result == false) {
            echo '<br/>requesting for user info failed!!<br/>';
            exit();
        }
        echo '<pre>' . $result . '</pre>';
    ?>
</html>