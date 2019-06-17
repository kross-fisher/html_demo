<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Uploading...</title>
    </head>
    <body>
        <h1>Uploading file...</h1>
        <?php

        $userfile = $_FILES['userfile'];

        if ($userfile['error'] > 0) {
            echo "Problem: ";
            switch ($userfile['error']) {
                case 1:
                    echo 'File exceeded upload_max_filesize';
                    break;
                case 2: 
                    echo 'File exceeded max_file_size';
                    break;
                case 3:
                    echo 'File only partially uploaded';
                    break;
                case 4:
                    echo 'No file uploaded';
                    break;
                case 6:
                    echo 'Cannot upload file: No temp directory specified';
                    break;
                case 7:
                    echo 'Upload failed: Cannot write to disk';
                    break;
            }
            exit;
        }

        // Does the file have the right MIME type?
        if ($userfile['type'] != 'text/plain') {
            echo 'Problem: file is not plain text';
            echo '- current is: ' . $userfile['type'];
            exit;
        }

        // put the file where we'd like it
        $upfile = '/uploads/' . $userfile['name'];

        if (is_uploaded_file($userfile['tmp_name'])) {
            if (!move_uploaded_file($userfile['tmp_name'], $upfile)) {
                echo 'Problem: Could not move file to destination directory';
                exit;
            }
        } else {
            echo 'Problem: Possible file upload attack. Filename: ';
            echo $userfile['name'];
            exit;
        }

        echo 'File uploaded successfully<br/><br/>';

        // remove possible HTML and PHP tags from the file's contents
        $contents = file_get_contents($upfile);
        $contents = strip_tags($contents);
        file_put_contents($upfile, $contents);

        // show what was uploaded
        echo '<p>Preview of uploaded file contents:<br/><hr/>';
        //echo nl2br($contents);
        echo '<pre>' . $contents . '</pre>';
        echo '<br/><hr/>';
        ?>
    </body>
</html>