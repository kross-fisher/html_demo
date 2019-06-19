<html>
    <head>
        <title>File Details</title>
    </head>
    <body>
        <?php
        $file = $_REQUEST['file'];

        $current_dir = '/uploads/';
        $file = basename($file);  // strip off directory info for security
        $file = $current_dir . $file;

        echo "<h1>Details of file: $file</h1>";

        echo "<h2>File data:</h2>";
        echo "File last accessed: " . date('j F Y H:i', fileatime($file)) . '<br/>';
        echo "File last modified: " . date('j F Y H:i', filemtime($file)) . '<br/>';

        $user = posix_getpwuid(fileowner($file));
        echo "File owner: " . $user['name'] . '<br/>';

        $group = posix_getgrgid(filegroup($file));
        echo "File group: " . $group['name'] . '<br/>';

        echo "File permissions: " . decoct(fileperms($file)) . '<br/>';
        echo "File type: " . filetype($file) . '<br/>';
        echo "File size: " . filesize($file) . '<br/>';

        echo "<h2>file tests</h2>";
        echo "is_dir: " . (is_dir($file) ? 'true' : 'false') . '<br/>';
        echo "is_executable: " . (is_executable($file) ? 'true' : 'false') . '<br/>';
        echo "is_file: " . (is_file($file) ? 'true' : 'false') . '<br/>';
        echo "is_link: " . (is_link($file) ? 'true' : 'false') . '<br/>';
        echo "is_readable: " . (is_readable($file) ? 'true' : 'false') . '<br/>';
        echo "is_writable: " . (is_writable($file) ? 'true' : 'false') . '<br/>';

        ?>
    </body>
</html>