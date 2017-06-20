<?php

namespace markfullmer\gendered_text;

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
    // If modifying these scopes, the previously saved credentials must be
    // deleted and rebuilt.
    $scopes = implode(' ', [\Google_Service_Drive::DRIVE_READONLY]);
    $client = new \Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes($scopes);

    if (!file_exists(CLIENT_SECRET_PATH)) {
      file_put_contents(CLIENT_SECRET_PATH, GOOGLE_CLIENT);
    }

    $client->setAuthConfig(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');

    if (file_exists(CREDENTIALS_PATH)) {
      $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), TRUE);
    }
    elseif (!empty(GOOGLE_CREDENTIAL)) {
      $accessToken = (array) json_decode(GOOGLE_CREDENTIAL);
    }
    else {
      return FALSE;
    }
    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
      $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
      file_put_contents(CREDENTIALS_PATH, json_encode($client->getAccessToken()));
    }
    return $client;
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
