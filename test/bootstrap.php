<?php

/**
 * @file
 * Bootstrap requirements for testing.
 */

define('APPLICATION_NAME', getenv('APPLICATION_NAME'));
define('CREDENTIALS_PATH', getenv('CREDENTIALS_PATH'));
define('CLIENT_SECRET_PATH', getenv('CLIENT_SECRET_PATH'));
define('DRIVE_FOLDER', getenv('DRIVE_FOLDER'));
define('WORDMAP_SHEET_ID', getenv('WORDMAP_SHEET_ID'));
define('GOOGLE_CREDENTIAL', getenv('GOOGLE_CREDENTIAL'));
define('GOOGLE_CLIENT', getenv('GOOGLE_CLIENT'));

require_once 'vendor/autoload.php';
