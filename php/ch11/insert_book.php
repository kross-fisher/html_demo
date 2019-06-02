<html>
    <head>
        <title>Book-O-Rama Book Entry Results</title>
    </head>
    <body>
        <h1>Book-O-Rama Book Entry Results</h1>
        <?php
            $isbn = $_POST['isbn'];
            $author = $_POST['author'];
            $title = $_POST['title'];
            $price = $_POST['price'];

            if (!$isbn || !$author || !$title || !$price) {
                echo "You have not entered all the required details.<br />"
                    . "Please go back and try agin.";
                exit;
            }

            if (!get_magic_quotes_gpc()) {
                $isbn = addslashes($isbn);
                $author = addslashes($author);
                $title = addslashes($title);
                $price = doubleval($price);
            }

            @ $db = mysqli_connect('localhost', 'bookorama', 'helo123', 'books');

            if (mysqli_connect_error()) {
                echo "Error: Could not connect to database. Please try again later.";
                exit;
            }

            $query = "insert into books values (?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, "sssd", $isbn, $author, $title, $price);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo mysqli_affected_rows($db)
                    . " books inserted into database.";
            } else {
                echo "An error has occurred. The item was not added.";
            }

            mysqli_stmt_close($stmt);
            mysqli_close($db);
        ?>
    </body>
</html>