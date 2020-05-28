<?php
/*
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/*
 * @package GDocs Multipage
 * @copyright 2020 Matt Bury (https://matbury.com/)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//
$post_vars_set = false;
$iframe_width = '500';
$iframe_height = '500';
$gdocs_urls = array();
$gdocs_divs = '';

// Sanitise POST vars for iframe width & height
if(isset($_POST['iframewidth'])) {
    $iframewidth = filter_input(INPUT_POST, 'iframewidth', FILTER_SANITIZE_NUMBER_INT);
    if(mb_strlen($iframewidth) < 5) {
        $iframe_width = $iframewidth;
    }
}

if(isset($_POST['iframeheight'])) {
    $iframeheight = filter_input(INPUT_POST, 'iframeheight', FILTER_SANITIZE_NUMBER_INT);
    if(mb_strlen($iframeheight) < 5) {
        $iframe_height = $iframeheight;
    }
}

// Sanitise POST array of GDocs URLs
if(isset($_POST['gdocurls'])) {
    $post_urls_array   = filter_input(INPUT_POST, 'gdocurls', FILTER_SANITIZE_URL, FILTER_REQUIRE_ARRAY);
    $len = count($post_urls_array);
    for($i = 0; $i < $len; $i++) {
        array_push($gdocs_urls, $post_urls_array[$i]);
        $post_vars_set = true;
    }
}

// Print input form or multipage
if($post_vars_set) {
    // Print GDocs Multipage
    print_divs();
    print_multipage();
} else {
    // Print URLs input form
    print_input_page();
}

/*
 * Assembles <div> & <iframe> code for each GDoc URL & concatenates them
 */
function print_divs() {
    global $gdocs_urls, $gdocs_divs, $iframe_width, $iframe_height;
    $len = count($gdocs_urls);
    for($i = 0; $i < $len; $i++) {
        $gdocs_divs.= '<div>'
                . '<iframe class="gdocframe" src="'.$gdocs_urls[$i].'" width="'.$iframe_width.'" height="'.$iframe_height.'">iframes not supported</iframe>'
                . '<p><a href="'.$gdocs_urls[$i].'" target="_blank" />Open in new tab</p>'
                . '</div>';
    }
}

/*
 * Print page with GDoc iframes
 */
function print_multipage() {
    global $gdocs_divs;
    $output_page = ' <!DOCTYPE html>
    <html>
        <head>
            <title>GDocs Multipage</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="style.css">
            <script type="text/javascript">
            </script>
        </head>
        <body>
            '.$gdocs_divs.'
            <div style="width: 100%; height: 50px;">&nbsp;</div>
        </body>
    </html>';
    echo $output_page;
}

/*
 * Print HTML input form
 */
function print_input_page() {
    echo ' <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>GDocs Multipage</title>
            <link rel="stylesheet" type="text/css" href="style.css">
            <script type="text/javascript"> 
            </script> 
        </head>
        <body>
        <p><strong>Ctest Instructions: Please enter a single paragraph of text which contains at least 3 sentences and is at least 250 characters long.</strong></p>
                <p>&nbsp;</p>
                <form action="index.php" method="post">
                <fieldset>
                    <legend>GDocs Multipage</legend>
                    <label for="iframewidth">Width:</label><input type="text" id="iframewidth" name="iframewidth" value="700" size="5"><br>
                    <label for="iframeheight">Height:</label><input type="text" id="iframeheight" name="iframeheight" value="700" size="5"><br>
                    <!-- Minimum 2 URLs, up to 8 maximum, sent as POST array -->
                    <label for="url0">URL:</label><input type="text" id="gdocurls0" name="gdocurls[]" size="100" required><br>
                    <label for="url1">URL:</label><input type="text" id="gdocurls1" name="gdocurls[]" size="100" required><br>
                    <label for="url1">URL:</label><input type="text" id="gdocurls2" name="gdocurls[]" size="100" ><br>
                    <label for="url1">URL:</label><input type="text" id="gdocurls3" name="gdocurls[]" size="100" ><br>
                    <label for="url1">URL:</label><input type="text" id="gdocurls4" name="gdocurls[]" size="100" ><br>
                    <label for="url1">URL:</label><input type="text" id="gdocurls5" name="gdocurls[]" size="100" ><br>
                    <label for="url1">URL:</label><input type="text" id="gdocurls6" name="gdocurls[]" size="100" ><br>
                    <label for="url1">URL:</label><input type="text" id="gdocurls7" name="gdocurls[]" size="100" ><br>
                    <input type="submit" value="Submit"><input type="reset">
                </fieldset>
                </form>
                <p>&nbsp;</p>
                <p><strong>GDocs Multipage</strong></p>
                <ul>
                <li><i>By Matt Bury <a href="https://matbury.com/" target="_blank">https://matbury.com/</a></li>
                <li>Available under a GNU GPL v3 open software licence 
                <a href="https://www.gnu.org/copyleft/gpl.html" target="_blank">https://www.gnu.org/copyleft/gpl.html</a></li>
                <li>Source code is at <a href="https://github.com/matbury" target="_blank">https://github.com/matbury</a></li>
                </ul>
        </body>
    </html> ';
}
