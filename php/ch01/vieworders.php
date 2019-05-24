<?php
    $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
?>
<html>
    <head>
        <title>Bob's Auto Parts - Customer Orders</title>
    </head>
    <body>
        <h1>Bob's Auto Parts</h1>
        <h2>Customer Orders</h2>
        <?php
            /* @ $fp = fopen("$DOCUMENT_ROOT/../orders/orders.txt", "rb");
            if ( ! $fp) {
                echo "<p><strong>No orders pending. " . 
                    "Please try again later.</strong></p>" . 
                    "</body></html>";
                exit;
            }
            flock($fp, LOCK_SH);

            while ( ! feof($fp)) {
                $order = fgets($fp, 999);
                if (strlen($order) > 0) {
                    echo "<pre>$order</pre>";
                }
            }

            flock($fp, LOCK_UN);
            fclose($fp); */

            $orders = file("$DOCUMENT_ROOT/../orders/orders.txt");

            $num_orders = count($orders);

            if ($num_orders == 0) {
                echo "<p><strong>No orders pending." . 
                    "Please try again later.</strong></p>";
                exit;
            }
        ?>
        <table border="1">
            <tr>
                <th bgcolor="#CCCCFF">Order Date</th>
                <th bgcolor="#CCCCFF">Tires</th>
                <th bgcolor="#CCCCFF">Oil</th>
                <th bgcolor="#CCCCFF">Spark Plugs</th>
                <th bgcolor="#CCCCFF">Total</th>
                <th bgcolor="#CCCCFF">Address</th>
            </tr>
            <?php
                for ($i = 0; $i < $num_orders; $i++) {
                    $line = explode("\t", $orders[$i]);

                    $line[1] = intval($line[1]);
                    $line[2] = intval($line[2]);
                    $line[3] = intval($line[3]);

                    echo '<tr>' . 
                            '<td align="right">' . $line[0] . '</td>' . 
                            '<td align="right">' . $line[1] . '</td>' . 
                            '<td align="right">' . $line[2] . '</td>' . 
                            '<td align="right">' . $line[3] . '</td>' . 
                            '<td align="right">' . $line[4] . '</td>' . 
                            '<td>' . $line[5] . '</td>' .
                            '</tr>';
                }
            ?>
        </table>
    </body>
</html>