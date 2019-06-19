<html>
    <head>
        <title>Command-line Interaction</title>
    </head>
    <body>
        <?php

        chdir('/uploads/');

        echo '<pre>';
        exec('ls -la', $result);
        foreach ($result as $line) {
            echo "$line\n";
        }
        echo '</pre>';
        echo '<br/><hr/><br/>';

        echo '<pre>';
        passthru('ls -la');
        echo '</pre>';
        echo '<br/><hr/><br/>';

        echo '<pre>';
        $result = system('ls -la');
        echo '</pre>';
        echo '<br/><hr/><br/>';

        echo '<pre>';
        $result = `ls -la`;
        echo $result;
        echo '</pre>';

        ?>
    </body>
</html> 