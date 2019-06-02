<html>
    <head>
        <title>Book-O-Rama Search Results</title>
    </head>
    <body>
        <h1>Book-O-Rama Search Results</h1>
        <?php
            $searchtype = $_POST['searchtype'];
            $searchterm = trim($_POST['searchterm']);

            if (!$searchtype || !$searchterm) {
                echo 'You have not entered search details. ';
                echo 'Please try agin.';
                exit;
            }

            if (!get_magic_quotes_gpc()) {
                $searchtype = addslashes($searchtype);
                $searchterm = addslashes($searchterm);
            }

            //query_mysql_oop($searchtype, $searchterm);
            //query_mysql_proc($searchtype, $searchterm);
            //query_mysql_proc_stmt($searchtype, $searchterm);
            query_generic($searchtype, $searchterm);

            function query_generic($searchtype, $searchterm) {
                require_once('MDB2.php');
                $user = 'bookorama';
                $pass = 'helo123';
                $host = 'localhost';
                $db_name = 'books';

                $dsn = "mysql://$user:$pass@$host/$db_name";

                $db =& MDB2::connect($dsn); // Not Fix Yet -> MDB2 Error: not found

                if (PEAR::isError($db)) {
                    echo "Pear isError **<br/>";
                    die($db->getMessage());
                }

                if (MDB2::isError($db)) {
                    echo $db->getMessage();
                    exit;
                }

                $query = "select * from books where $searchtype like '%$searchterm%'";
                $result = $db->query($query);

                if (MDB2::isError($result)) {
                    echo $db->getMessage();
                    exit;
                }

                $num_results = $result->numRows();
                echo "<p>Number of books found: $num_results</p>";

                /*
                $dsn = "mysql:host=$host;dbname=$db_name";
                $wildterm = "%$searchterm%";
                try {
                    $db = new PDO($dsn, $user, $pass);
                    $query = "select * from books where $searchtype like :xterm";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':xterm', $wildterm);
                    $stmt->execute();

                    $num_results = $stmt->rowCount();
                    echo "<p>Number of books found: $num_results</p>";

                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                    exit;
                } */

            }

            function query_mysql_proc_stmt($searchtype, $searchterm) {
                @ $db = mysqli_connect('localhost', 'bookorama', 'helo123', 'books');

                if (mysqli_connect_error()) {
                    echo 'Error: Could not connect to database. ';
                    echo 'Please try again later.';
                    exit;
                }

                $query = "select * from books where $searchtype like ?";
                $stmt = mysqli_prepare($db, $query);
                $wildterm = "%$searchterm%";

                mysqli_stmt_bind_param($stmt, "s", $wildterm);
                mysqli_stmt_bind_result($stmt, $isbn, $author, $title, $price);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                $num_results = mysqli_stmt_num_rows($stmt);
                echo "<p>Number of books found: $num_results</p>";

                for ($i = 0; $i < $num_results; $i++) {
                    mysqli_stmt_fetch($stmt);
                    echo "<p><strong>" . ($i+1) . ". ";
                    echo htmlspecialchars(stripslashes($title));
                    echo "</strong><br />\nAuthor: ";
                    echo stripslashes($author);
                    echo "<br />\nISBN: ";
                    echo stripslashes($isbn);
                    echo "<br />\nPrice: ";
                    echo stripslashes($price);
                    echo "</p>";
                }

                mysqli_stmt_close($stmt);
                mysqli_close($db);
            }

            function query_mysql_proc($searchtype, $searchterm) {
                @ $db = mysqli_connect('localhost', 'bookorama', 'helo123', 'books');

                if (mysqli_connect_error()) {
                    echo 'Error: Could not connect to database. ';
                    echo 'Please try again later.';
                    exit;
                }

                $query = "select * from books where $searchtype like '%$searchterm%'";
                $result = mysqli_query($db, $query);

                $num_results = mysqli_num_rows($result);
                echo "<p>Number of books found: $num_results</p>";

                for ($i = 0; $i < $num_results; $i++) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<p><strong>" . ($i+1) . ". ";
                    echo htmlspecialchars(stripslashes($row['title']));
                    echo "</strong><br />\nAuthor: ";
                    echo stripslashes($row['author']);
                    echo "<br />\nISBN: ";
                    echo stripslashes($row['isbn']);
                    echo "<br />\nPrice: ";
                    echo stripslashes($row['price']);
                    echo "</p>";
                }

                mysqli_free_result($result);
                mysqli_close($db);
            }

            function query_mysql_oop($searchtype, $searchterm) {
                @ $db = new mysqli('localhost', 'bookorama', 'helo123', 'books');

                if (mysqli_connect_error()) {
                    echo 'Error: Could not connect to database. ';
                    echo 'Please try again later.';
                    exit;
                }

                $query = "select * from books where $searchtype like '%$searchterm%'";
                $result = $db->query($query);

                echo "<p>Querying String:";
                echo "<pre>$query</pre></p>\n";

                $num_results = $result->num_rows;

                echo "<p>Number of books found: $num_results.</p>\n";

                for ($i = 0; $i < $num_results; $i++) {
                    $row = $result->fetch_assoc();
                    echo "<p><strong>" . ($i+1) . ". Title: ";
                    echo htmlspecialchars(stripslashes($row['title']));
                    echo "</strong><br />\nAuthor: ";
                    echo stripslashes($row['author']);
                    echo "<br />\nISBN: ";
                    echo stripslashes($row['isbn']);
                    echo "<br />\nPrice: ";
                    echo stripslashes($row['price']);
                    echo "</p>";
                }

                $result->free();
                $db->close();
            }
        ?>

    </body>
</html>