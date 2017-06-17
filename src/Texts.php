<?php

namespace markfullmer\gendered_text;

require_once '../vendor/autoload.php';

define('APPLICATION_NAME', 'Drive API PHP Quickstart');
define('CREDENTIALS_PATH', '../credentials/credentials.json');
define('CLIENT_SECRET_PATH', '../credentials/client_secret.json');
// If modifying these scopes, the previously saved credentials must be deleted
// and rebuilt.
define('SCOPES', implode(' ', [\Google_Service_Drive::DRIVE_READONLY]
));

/**
 * Class for dynamically process texts per user-supplied gender.
 */
class Texts {

  /**
   * The Google Drive API service object.
   *
   * @var object
   */
  protected $service;

  /**
   * Class constructor.
   */
  public function __construct() {
    $client = $this->getClient();
    $this->service = new \Google_Service_Drive($client);
  }

  /**
   * Retrieve the title & id of all texts in a Google Drive folder.
   *
   * @param string $folder_id
   *    The unique Google Drive folder id (e.g., 0BxeFmOHdUjWRbHBqM1kzLU9ES1k).
   *
   * @return array
   *    A key-value array of file_id => file title.
   */
  public function getFolder($folder_id, $limit = 100) {
    $optParams = array(
      'q' => "'" . $folder_id . "' in parents",
      'pageSize' => $limit,
      'fields' => 'nextPageToken, files(id, name, parents)',
    );
    $results = $this->service->files->listFiles($optParams);
    $output = [];
    if (count($results->getFiles()) == 0) {
      return $output;
    }
    else {
      foreach ($results->getFiles() as $file) {
        $name = $file->getName();
        $id = $file->getId();
        $output[$id] = $name;
      }
      return $output;
    }
  }

  /**
   * Retrieve the content of file in Google Drive.
   *
   * @param string $file_id
   *    The unique Google Drive folder id (e.g., 0BxeFmOHdUjWRbHBqM1kzLU9ES1k).
   *
   * @return array
   *    A key-value array of file_id => file title.
   */
  public function getText($file_id, $mime_type = 'text/html') {
    $response = $this->service->files->export($file_id, $mime_type);
    $stream = $response->getBody();
    $contents = $stream->getContents();
    $contents = $stream->getContents();
    $stream->rewind();
    $contents = $stream->getContents();
    return $this->getBody($contents);
  }

  /**
   * Returns an authorized API client.
   *
   * @return Google_Client
   *    The authorized client object.
   */
  protected function getClient() {
    $client = new \Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes(SCOPES);
    $client->setAuthConfig(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');

    // Load previously authorized credentials from a file.
    $credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);
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
  protected function expandHomeDirectory($path) {
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
  public function getBody($html) {
    preg_match("/<body[^>]*>(.*?)<\/body>/is", $html, $matches);
    if (isset($matches[1])) {
      return $matches[1];
    }
    return $html;
  }

}
