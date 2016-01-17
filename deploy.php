<?php
/**
 * Deploy by ZIP.
 * Crude. Insecure. Works.
 * @author Paweł Abramowicz
 */

// Destination folder
define('DESTINATION', '.');

// Insert repo name here
define('REPO_NAME', 'pawelabrams/deploy-by-zip');

// Prepare an address to look for; this might change and break
define('REPO_ADDR', 'https://github.com/'.REPO_NAME.'/archive/master.zip');

// Get the ZIP from the source
$zip = new ZipArchive;
if ($zip->open(REPO_ADDR) === TRUE) {
    $zip->extractTo(DESTINATION);
    $zip->close();
    echo 'OK. Everything worked as expected.';
} else {
    echo 'FAIL. Something went wrong while opening the archive.';
}
