<?php
$name = $_POST['name'];
$email = $_POST['email'];
$feedback = $_POST['feedback'];

$to_address = "swolves@yeah.net";
$subject = "Feedback from web site";
$mailcontent = "Customer name: $name\n" . 
               "Customer email: $email\n" . 
               "Customer comments: \n$feedback\n";

$from_address = "From: 1255035985@qq.com";

mail($to_address, $subject, $mailcontent, $from_address);
?>
<html>
    <head>
        <title>Bob's Auto Parts - Feedback Submitted</title>
    </head>
    <body>
        <h1>Feedback submitted</h1>
        <p>Your feedback has been sent.</p>
        <?php
            echo "<pre>$mailcontent</pre>";
        ?>
    </body>
</html>