<?php
    $button_text = $_REQUEST['button_text'];
    $color = $_REQUEST['button_color'];

    if (empty($button_text) || empty($color)) {
        echo 'Could not create image - form not filled out correctly!';
        exit;
    }

    // create an image of the right background and check size
    $im = imagecreatefrompng($color . '-button.png');

    $width_image = imagesx($im);
    $height_image = imagesy($im);

    $margin_adj = 22; // Our images need an margin adjustment
    $width_image_wo_margins = $width_image - $margin_adj * 2;
    $height_image_wo_margins = $height_image - $margin_adj * 2;

    // Work out if the font size will fit and make it smaller unti it does
    // Start out with the biggest size that will reasonably fit on out buttons
    $font_size = 33;

    // you need to tell GD2 where your fonts reside
    putenv ('GDFONTPATH=/usr/share/fonts/truetype/freefont');
    $font_name = 'FreeSans';

    do {
        $font_size--;
        // find out the size of the text at that font size
        $bbox = imagettfbbox($font_size, 0, $font_name, $button_text);

        $text_left = $bbox[0];
        $text_right = $bbox[2];
        $width_text = $text_right - $text_left;
        $height_text = abs($bbox[7] - $bbox[1]);
    } while ( $font_size > 8 && (
        $height_text > $height_image_wo_margins ||
        $width_text  >  $width_image_wo_margins)
    );

    if ($height_text  > $height_image_wo_margins
        || $width_text > $width_image_wo_margins) {
        // no readable font size will fit on button
        echo 'Text given will not fit on button.<br />';
    } else {
        // We have found a font size that will fit
        // Now work out where to put it

        $text_x = $width_image/2.0 - $width_text/2.0;
        $text_y = $height_image/2.0 - $height_text/2.0;

        if ($text_left < 0) {
            $text_x += abs($text_left);
        }

        $above_line_text = abs($bbox[7]);  // how far above the baseline
        $text_y += $above_line_text;       // add baseline factor

        $text_y += 2;   // adjustment factor for shape of our template

        $white = imagecolorallocate($im, 255, 255, 255);

        imagettftext($im, $font_size, 0, $text_x, $text_y, $white,
            $font_name, $button_text);

        Header ('Content-type: image/png');
        imagepng($im);
    }

    imagedestroy($im);
?>