<?php
/**
 * Deploy by ZIP.
 * Crude. Insecure. Works.
 * @author Paweł Abramowicz
 */

// Destination folder
define('DESTINATION', './');
#TODO: check if trailing slash is in place

// Insert repo name here
define('REPO_NAME', 'pawelabrams/deploy-by-zip');

// Prepare an address to look for; this might change and break
define('REPO_ADDR', 'https://github.com/'.REPO_NAME.'/archive/master.zip');

// And repo's basename for folder's name
$tmp = explode('/', REPO_NAME);
#TODO: add an exit here if error
define('REPO_BASE', $tmp[1]);

// Temporary destination name - it'll autogenerate from zip's structure and is prone to breaking
define('TMP_DEST', DESTINATION.REPO_BASE."-master/");

// Get the zip from the source
$len = file_put_contents('deploy.zip', file_get_contents(REPO_ADDR));
$zip = new ZipArchive;
$msg = $zip->open('deploy.zip');

if ($msg === TRUE) {
		// extract
    $zip->extractTo(DESTINATION);
    $zip->close();

		// make a list to move
		$fns = array();
    $d = dir(TMP_DEST);
		while (false !== ($entry = $d->read())) {
				if (!in_array($entry, array('.', '..')))
						$fns[] = $entry;
		}
		$d->close();

		// move files to actual destination
		foreach ($fns as $f)
		    rename(TMP_DEST.$f, DESTINATION.$f);

		// delete tmp
		rmdir(TMP_DEST);
		unlink('deploy.zip');

    echo 'OK. Everything worked as expected.';
} else {
    echo 'FAIL. Something went wrong while opening the archive. ZipArchive error code: '.$msg;
}
