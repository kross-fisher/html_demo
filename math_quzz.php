<html>
    <head>
        <title>Math Quzz</title>
        <style type="text/css">
            .page {
                width: 21cm;
                max-height: 29cm;
            }
            table {
                width: 90%;
                margin: 2.2cm auto auto auto;
                border: 1px dashed gray;
                border-bottom: none;
                padding: 0;
            }
            td {
                width: 3.0%;
                padding: 0.36cm 0;
                text-align: center;
                border-bottom: 1px dashed gray;
            }
            td.rs {
                width: 8.0%;
                border-right: 1px dashed gray;
            }
            td.rs.last {
                border-right: none;
            }
            td.pad {
                width: 4.8%;
            }
        </style>
    </head>
    <body>
        <div class="page">
        <table>
            <?php system(
                'sh /home/feixy/math_quzz_gen.sh < /home/feixy/quzz_raw'); ?>
        </table>
        </div>
    </body>
</html>