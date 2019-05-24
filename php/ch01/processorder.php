<?php
    define('TIRE_PRICE', 100);
    define('OIL_PRICE', 10);
    define('SPARK_PRICE', 4);

    $tireqty = $_POST['tireqty'];
    $oilqty = $_POST['oilqty'];
    $sparkqty = $_POST['sparkqty'];
    $address = $_POST['address'];
    $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
    $date = date('H:i, j F Y');
?>
<html>
    <head>
        <title>Bob's Auto Parts - Order Results</title>
    </head>
    <body>
        <h1>Bob's Auto Parts</h1>
        <h2>Order Results</h2>
        <?php
            echo "<p>Order processed at $date.</p>";

            $totalqty = 0;
            $totalqty = $tireqty + $oilqty + $sparkqty;

            if ($totalqty == 0) {
                echo "<p>You did not order anything ...</p>";
            } else {
                echo "<p>Your order is as following: </p><ul>";
                if ($tireqty > 0) {
                    echo "<li>$tireqty tires</li>";
                }
                if ($oilqty > 0) {
                    echo "<li>$oilqty bottles of oil</li>";
                }
                if ($sparkqty > 0) {
                    echo "<li>$sparkqty spark plugs</li>";
                }
                echo "</ul>";
            }

            $totalamount = 0.00;
            $totalamount = $tireqty * TIRE_PRICE +
                    $oilqty * OIL_PRICE + $sparkqty * SPARK_PRICE;
            echo "<p>Subtotal: $" . number_format($totalamount, 2) . ", ";

            $taxrate = 0.10;
            $totalamount = $totalamount * (1 + $taxrate);
            echo "Total including tax: $" .
                number_format($totalamount, 2) . "</p>";

            $outputstr = $date . "\t" . $tireqty . " tires\t"
                . $oilqty . " oil\t" . $sparkqty . " spark plugs\t$"
                . $totalamount . "\t" . $address . "\n";

            @ $fp = fopen("$DOCUMENT_ROOT/../orders/orders.txt", 'ab');

            if ( ! $fp) {
                echo "<p><strong>" . 
                "Your orders could not be processed at this time. " . 
                "Please try again later.</strong></p>" . 
                "</body></html>";
                exit;
            }
            flock($fp, LOCK_EX);

            fwrite($fp, $outputstr, strlen($outputstr));
            flock ($fp, LOCK_UN);
            fclose($fp);

            echo "<p>Order written.</p>";
        ?>
    </body>
</html>