<?php

// get vote from form
$vote = $_REQUEST['vote'];

// log in to database
if (! $db_conn = new mysqli('localhost', 'poll', 'poll', 'poll')) {
    echo 'Could not connect to db <br />';
    exit;
}

if (!empty($vote)) {
    $vote = addslashes($vote);
    $query = "update poll_results set num_votes = num_votes + 1 " .
             "where candidate = '$vote'";
    if (! ($result = @$db_conn->query($query))) {
        echo 'Could not connect to db <br />';
        exit;
    }
}

// get current result of poll, regardless of whether they voted
$query = 'select * from poll_results';
if (! ($result = @$db_conn->query($query))) {
    echo 'Could not connect to db <br />';
    exit;
}

$num_candidates = $result->num_rows;

// calculate total number of votes so far
$total_votes = 0;
while ($row = $result->fetch_object()) {
    $total_votes += $row->num_votes;
}
$result->data_seek(0);

putenv ('GDFONTPATH=/usr/share/fonts/truetype/freefont');
$width = 500;
$left_margin = 50;
$right_margin = 50;
$bar_height = 40;
$bar_spacing = $bar_height / 2;
$font = 'FreeSans';
$title_size = 16;
$main_size = 12;
$small_size = 12;
$text_indent = 10;

$x = $left_margin + 60;
$y = 50;
$bar_unit = ($width - $x - $right_margin) / 100;

// calculate height of graph - bars plus gaps plus some margin
$height = $num_candidates * ($bar_height + $bar_spacing) + 50;

$im = imagecreatetruecolor($width, $height);

$white = imagecolorallocate($im, 255, 255, 255);
$blue  = imagecolorallocate($im,   0,  64, 128);
$black = imagecolorallocate($im,   0,   0,   0);
$pink  = imagecolorallocate($im, 255,  78, 243);

$text_color = $black;
$percent_color = $black;
$bg_color = $white;
$line_color = $black;
$bar_color = $blue;
$number_color = $pink;

// Create "canvas" to draw on
imagefilledrectangle($im, 0, 0, $width, $height, $bg_color);

// Draw outline around canvas
imagerectangle($im, 0, 0, $width-1, $height-1, $line_color);

// Add title
$title = 'Poll Results';
$title_bbox = imagettfbbox($title_size, 0, $font, $title);
$title_length = $title_bbox[2] - $title_bbox[0];
$title_height = abs($title_bbox[7] - $title_bbox[1]);
$title_above_line = abs($title_bbox[7]);
$title_x = ($width - $title_length) / 2;
$title_y = ($y - $title_height) / 2 + $title_above_line;

imagettftext($im, $title_size, 0, $title_x, $title_y, $text_color, $font, $title);

// Draw a base line from a little above first bar location
// to a little below last
imageline($im, $x, $y-5, $x, $height-15, $line_color);

// Get each line of db data and draw corresponding bars
while ($row = $result->fetch_object()) {
    if ($total_votes > 0) {
        $percent = intval(100 * $row->num_votes / $total_votes);
    } else {
        $percent = 0;
    }

    // display percent for this value
    $percent_bbox = imagettfbbox($main_size, 0, $font, $percent . '%');
    $percent_length = $percent_bbox[2] - $percent_bbox[0];
    imagettftext($im, $main_size, 0, $width - $percent_length - $text_indent,
                $y + $bar_height / 2, $percent_color, $font, $percent . '%');

    // lehgth of bar for this value
    $bar_length = $x + $percent * $bar_unit;

    // draw bar for this value
    imagefilledrectangle($im, $x, $y-2, $bar_length, $y+$bar_height, $bar_color);

    // draw title for this value
    imagettftext($im, $main_size, 0, $text_indent, $y + $bar_height / 2,
                $text_color, $font, "$row->candidate");

    // display numbers
    imagettftext($im, $small_size, 0, $x + $bar_unit*100 - 50, $y + $bar_height/2,
                $number_color, $font, $row->num_votes . '/' . $total_votes);

    // draw outline showing 100%
    imagerectangle($im, $bar_length+1, $y-2, $x + $bar_unit*100,
                $y + $bar_height, $line_color);

    // move down to next bar
    $y = $y + $bar_height + $bar_spacing;
}


Header ('Content-type: image/png');
imagepng($im);

imagedestroy($im);
?>