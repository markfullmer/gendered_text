<?php

namespace markfullmer\gendered_text;

/**
 * Class for dynamically process texts per user-supplied gender.
 */
class Texts extends GoogleDriveBase {

  /**
   * Retrieve the title & id of all texts in a Google Drive folder.
   *
   * @param string $folder_id
   *    The unique Google Drive folder id (e.g., 0BxeFmOHdUjWRbHBqM1kzLU9ES1k).
   *
   * @return array
   *    A key-value array of file_id => file title.
   */
  public static function getFolder($folder_id, $limit = 100) {
    $client = self::getClient();
    try {
      $service = new \Google_Service_Drive($client);
      $optParams = array(
        'q' => "'" . $folder_id . "' in parents",
        'pageSize' => $limit,
        'fields' => 'nextPageToken, files(id, name, parents, mimeType)',
      );
      $results = $service->files->listFiles($optParams);
      $output = [];
      if (count($results->getFiles()) == 0) {
        return $output;
      }
      else {
        foreach ($results->getFiles() as $file) {
          $type = $file->getMimeType();
          if (strpos($type, 'document') !== FALSE) {
            $name = $file->getName();
            $id = $file->getId();
            $output[$id] = $name;
          }
        }
        return $output;
      }
    }
    catch (\Google_Service_Exception $e) {
      echo 'Well. We were not able to find any texts. Better check with app
      administrators about this one.';
      // Uncomment to see error message.
      // $e->getMessage();
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
  public static function getText($file_id, $mime_type = 'text/html') {
    $client = self::getClient();
    $service = new \Google_Service_Drive($client);

    try {
      $response = $service->files->export($file_id, $mime_type);
      $stream = $response->getBody();
      $contents = $stream->getContents();
      $contents = $stream->getContents();
      $stream->rewind();
      $contents = $stream->getContents();
      return self::getBody($contents);
    }
    catch (\Google_Service_Exception $e) {
      echo 'Hrmm. there was a problem retrieving that text. If you think this is
        in error, please report the problem to app administrators.';
      // Uncomment to see error message.
      // $e->getMessage();
    }
  }

}
