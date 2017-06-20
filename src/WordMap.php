<?php

namespace markfullmer\gendered_text;

/**
 * Class for dynamically process texts per user-supplied gender.
 */
class WordMap extends GoogleDriveBase {

  /**
   * Return a wordmap, either from a Google Sheet, or the default.
   *
   * @param string $sheet_id
   *    The Google Sheet UUID.
   *
   * @return array
   *    A machine-prepared word map.
   */
  public static function get($sheet_id = '') {
    if (!empty($sheet_id)) {
      $values = self::getFromGoogle($sheet_id);
    }
    else {
      $data = self::$defaultWordMap;
      foreach ($data as $key => $output) {
        $vals = array_values($output);
        array_unshift($vals, $key);
        $values[] = $vals;
      }
    }
    return self::parseOriginal($values);
  }

  /**
   * Retrieve a Google Sheet that matches the structure of a Gendered Text map.
   *
   * @param string $id
   *    A Google Sheet UUID.
   *
   * @return array
   *    A machine-prepared word map.
   */
  public static function getFromGoogle($id) {
    $client = self::getClient();
    $service = new \Google_Service_Sheets($client);
    // The 'range' (parameter 2) is hardcoded because the following preparation
    // requires a specific spreadsheet structure.
    $response = $service->spreadsheets_values->get($id, 'A5:G');
    return $response->getValues();
  }

  /**
   * Juggle the original array to match what is expected by GenderedText.
   *
   * @param array $values
   *    The original array.
   *    Example: https://docs.google.com/spreadsheets/d/1-GUMdQ8iMpOUSz8PddPFZgf0YZZnPkAqPp8tuS5kMfI/edit#gid=0 .
   *
   * @return array
   *    The juggled array.
   */
  public static function parseOriginal(array $values) {
    $output = [];
    foreach ($values as $key => $contents) {
      $data = array_values($contents);
      $pos = $data[0];
      // Get female word (column "1" & "4").
      if (isset($data[1])) {
        $female_word = $data[1];
        $output[$female_word] = ['gender' => 'female', 'pos' => $pos];
        if (isset($data[4])) {
          $output[$female_word]['output'] = $data[4];
        }
      }
      // Get male word (column "2" & "5").
      if (isset($data[2])) {
        $male_word = $data[2];
        $output[$male_word] = ['gender' => 'male', 'pos' => $pos];
        if (isset($data[5])) {
          $output[$male_word]['output'] = $data[5];
        }
      }
      // Get trans word (columns "3" & "6").
      if (isset($data[3])) {
        $trans_word = $data[3];
        $output[$trans_word] = ['gender' => 'trans', 'pos' => $pos];
        if (isset($data[6])) {
          $output[$trans_word]['output'] = $data[6];
        }
      }

    }
    return $output;
  }

  /**
   * The default.
   *
   * @var array
   */
  public static $defaultWordMap = [
    'sex' => ['female' => 'she', 'male' => 'he', 'trans' => 'ze'],
    'gender' => ['female' => 'her', 'male' => 'him', 'trans' => 'hir'],
    'plural' => ['female' => 'herd', 'male' => 'hisd', 'trans' => 'hird', 'female_display' => 'her', 'male_display' => 'his', 'trans_display' => 'hir'],
    'formal plural' => ['female' => 'hers', 'male' => 'his', 'trans' => 'hirs'],
    'parent' => ['female' => 'herself', 'male' => 'himself', 'trans' => 'hirself'],
    'spouse' => ['female' => 'female', 'male' => 'male', 'trans' => 'nonbinary'],
    'child' => ['female' => 'woman', 'male' => 'man', 'trans' => 'person'],
    'offspring' => ['female' => 'women', 'male' => 'men', 'trans' => 'men and women'],
    'kid' => ['female' => 'ladies', 'male' => 'gentlemen', 'trans' => 'ladies and gentlemen'],
    'sibling' => ['female' => 'mother', 'male' => 'father', 'trans' => 'parent'],
    'sovereign' => ['female' => 'wife', 'male' => 'husband', 'trans' => 'spouse'],
    'ruler' => ['female' => 'girl', 'male' => 'boy', 'trans' => 'youngster'],
    'cousin' => ['female' => 'daughter', 'male' => 'son', 'trans' => 'child'],
    'servant' => ['female' => 'lass', 'male' => 'lad', 'trans' => 'kid'],
    'hair salon' => ['female' => 'sister', 'male' => 'brother', 'trans' => 'sibling'],
    'insult' => ['female' => 'princess', 'male' => 'prince', 'trans' => 'sovereign'],
    'honorific1' => ['female' => 'queen', 'male' => 'king', 'trans' => 'ruler'],
    'honorific2' => ['female' => 'niece', 'male' => 'nephew', 'trans' => 'siblings child'],
    'honorific3' => ['female' => 'housekeeper', 'male' => 'butler', 'trans' => 'servant'],
    'clothes1' => ['female' => 'beauty parlor', 'male' => 'barber shop', 'trans' => 'hair salon'],
    'clothes2' => ['female' => 'bitch', 'male' => 'bastard', 'trans' => 'asshole'],
    'clothes3' => ['female' => 'ma-am', 'male' => 'sir', 'trans' => 'your honor1', 'trans_display' => 'your honor'],
    'affectionate' => ['female' => 'lady', 'male' => 'lord', 'trans' => 'your honor2', 'trans_display' => 'your honor'],
    'high voice' => ['female' => 'duchess', 'male' => 'duke', 'trans' => 'your honor3', 'trans_display' => 'your honor'],
    'med voice' => ['female' => 'skirt', 'male' => 'trousers', 'trans' => 'trousersn', 'trans_display' => 'trousers'],
    'low voice' => ['female' => 'dress', 'male' => 'suit', 'trans' => 'suitn', 'trans_display' => 'suit'],
    'pal' => ['female' => 'gown', 'male' => 'tuxedo', 'trans' => 'outfit'],
    'Wild Card' => ['female' => 'sweetie', 'male' => 'sonny', 'trans' => 'dear'],
    'subject' => ['female' => 'soprano', 'male' => 'tenor', 'trans' => 'high pitched voice'],
    'object' => ['female' => 'contralto', 'male' => 'baritone', 'trans' => 'medium pitched voice'],
    'determiner' => ['female' => 'alto', 'male' => 'bass', 'trans' => 'low pitched voice'],
    'possessive' => ['female' => 'dame', 'male' => 'fellow', 'trans' => 'pal'],
    'reflexive' => ['female' => 'calamity jane', 'male' => 'wild bill hickock', 'trans' => 'wild card'],
    'title' => ['female' => 'ms.', 'male' => 'mr.', 'trans' => 'm.'],
  ];

}
