<html>
    <head>
        <title>Browse Directories</title>
    </head>
    <body>
        <h1>Browsing</h1>
        <?php

        $curr_dir = '/uploads/';
        /* $dir = opendir($curr_dir);

        echo "<p>Upload directory is $curr_dir</p>";
        echo "<p>Directory Listing:</p><ul>";

        while (false !== ($file = readdir($dir))) {
            // strip out the two entries of . and ..
            if ($file != '.' && $file != '..') {
                echo "<li>$file</li>";
            }
        }
        echo '</ul>';
        closedir($dir); */

        /*
        $dir = dir($curr_dir);

        echo "<p>Handle is $dir->handle</P>";
        echo "<p>Upload directory is $dir->path</p>";
        echo "<p>Directory Listing:</p><ul>";

        while (false !== ($file = $dir->read())) {
            if ($file != '.' && $file != '..') {
                echo "<li>$file</li>";
            }
        }
        echo '</ul>';
        $dir->close(); */

        $files1 = scandir($curr_dir);
        $files2 = scandir($curr_dir, 1);

        echo "<p>Upload directory is $curr_dir</p>";
        echo "<p>Directory Listing in alphabetical order, ascending:</p><ul>";

        foreach ($files1 as $file) {
            if ($file != '.' && $file != '..') {
                echo "<li><a href=\"filedetails.php?file=$file\">$file</a></li>";
            }
        }
        echo '</ul>';

        echo "<p>Upload directory is $curr_dir</p>";
        echo "<p>Directory Listing in alphabetical order, descending:</p><ul>";

        foreach ($files2 as $file) {
            if ($file != '.' && $file != '..') {
                echo "<li>$file</li>";
            }
        }
        echo '</ul>';

        ?>
    </body>
</html>