<?php

namespace markfullmer\gendered_text;

define('APPLICATION_NAME', 'Drive API PHP Quickstart');
define('CREDENTIALS_PATH', '../credentials/credentials.json');
define('CLIENT_SECRET_PATH', '../credentials/client_secret.json');
// If modifying these scopes, the previously saved credentials must be deleted
// and rebuilt.
define('SCOPES', implode(' ', ['https://www.googleapis.com/auth/drive.readonly']
));

/**
 * Base Class to retrieve data from Google Drive.
 */
class GoogleDriveBase {

  /**
   * Returns an authorized API client.
   *
   * @return Google_Client
   *    The authorized client object.
   */
  protected static function getClient() {
    $client = new \Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes(SCOPES);
    $client->setAuthConfig(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');

    // Load previously authorized credentials from a file.
    $credentialsPath = self::expandHomeDirectory(CREDENTIALS_PATH);
    if (file_exists($credentialsPath)) {
      $accessToken = json_decode(file_get_contents($credentialsPath), TRUE);
    }
    else {
      return FALSE;
    }
    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
      $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
      file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
    }
    return $client;
  }

  /**
   * Expands the home directory alias '~' to the full path.
   *
   * @param string $path
   *    The path to expand.
   *
   * @return string
   *    The expanded path.
   */
  protected static function expandHomeDirectory($path) {
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
      $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
  }

  /**
   * Strip HTML wrapping elements, if present.
   *
   * @return string
   *    HTML with not <html> or <body> tags.
   */
  public static function getBody($html) {
    preg_match("/<body[^>]*>(.*?)<\/body>/is", $html, $matches);
    if (isset($matches[1])) {
      return $matches[1];
    }
    return $html;
  }

}
