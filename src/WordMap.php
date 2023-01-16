<?php

namespace markfullmer\gendered_text;

/**
 * Class for dynamically process texts per user-supplied gender.
 */
class WordMap {

  /**
   * Return a wordmap, either from a Google Sheet, or the default.
   *
   * @param string $sheet_id
   *    The Google Sheet UUID.
   *
   * @return array
   *    A machine-prepared word map.
   */
  public static function get() {
    $data = self::$defaultWordMap;
    foreach ($data as $key => $output) {
      $vals = array_values($output);
      array_unshift($vals, $key);
      $values[] = $vals;
    }
    return self::parseOriginal($values);
  }

  /**
   * Juggle the original array to match what is expected by GenderedText.
   *
   * @param array $values
   *    The original array.
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
      // Get non-binary word (columns "3" & "6").
      if (isset($data[3])) {
        $non_binary_word = $data[3];
        $output[$non_binary_word] = ['gender' => 'non-binary', 'pos' => $pos];
        if (isset($data[6])) {
          $output[$non_binary_word]['output'] = $data[6];
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
    'sex' => ['female' => 'she', 'male' => 'he', 'non-binary' => 'ze'],
    'gender' => ['female' => 'her', 'male' => 'him', 'non-binary' => 'hir'],
    'plural' => ['female' => 'herd', 'male' => 'hisd', 'non-binary' => 'hird', 'female_display' => 'her', 'male_display' => 'his', 'non-binary_display' => 'hir'],
    'formal plural' => ['female' => 'hers', 'male' => 'his', 'non-binary' => 'hirs'],
    'parent' => ['female' => 'herself', 'male' => 'himself', 'non-binary' => 'hirself'],
    'spouse' => ['female' => 'female', 'male' => 'male', 'non-binary' => 'nonbinary'],
    'child' => ['female' => 'woman', 'male' => 'man', 'non-binary' => 'person'],
    'offspring' => ['female' => 'women', 'male' => 'men', 'non-binary' => 'men and women'],
    'kid' => ['female' => 'ladies', 'male' => 'gentlemen', 'non-binary' => 'ladies and gentlemen'],
    'sibling' => ['female' => 'mother', 'male' => 'father', 'non-binary' => 'parent'],
    'sovereign' => ['female' => 'wife', 'male' => 'husband', 'non-binary' => 'spouse'],
    'ruler' => ['female' => 'girl', 'male' => 'boy', 'non-binary' => 'youngster'],
    'cousin' => ['female' => 'daughter', 'male' => 'son', 'non-binary' => 'child'],
    'servant' => ['female' => 'lass', 'male' => 'lad', 'non-binary' => 'kid'],
    'hair salon' => ['female' => 'sister', 'male' => 'brother', 'non-binary' => 'sibling'],
    'insult' => ['female' => 'princess', 'male' => 'prince', 'non-binary' => 'sovereign'],
    'honorific1' => ['female' => 'queen', 'male' => 'king', 'non-binary' => 'ruler'],
    'honorific2' => ['female' => 'niece', 'male' => 'nephew', 'non-binary' => 'siblings child'],
    'honorific3' => ['female' => 'housekeeper', 'male' => 'butler', 'non-binary' => 'servant'],
    'clothes1' => ['female' => 'beauty parlor', 'male' => 'barber shop', 'non-binary' => 'hair salon'],
    'clothes2' => ['female' => 'bitch', 'male' => 'bastard', 'non-binary' => 'asshole'],
    'clothes3' => ['female' => 'ma-am', 'male' => 'sir', 'non-binary' => 'your honor1', 'non-binary_display' => 'your honor'],
    'affectionate' => ['female' => 'lady', 'male' => 'lord', 'non-binary' => 'your honor2', 'non-binary_display' => 'your honor'],
    'high voice' => ['female' => 'duchess', 'male' => 'duke', 'non-binary' => 'your honor3', 'non-binary_display' => 'your honor'],
    'med voice' => ['female' => 'skirt', 'male' => 'trousers', 'non-binary' => 'trousersn', 'non-binary_display' => 'trousers'],
    'low voice' => ['female' => 'dress', 'male' => 'suit', 'non-binary' => 'suitn', 'non-binary_display' => 'suit'],
    'pal' => ['female' => 'gown', 'male' => 'tuxedo', 'non-binary' => 'outfit'],
    'Wild Card' => ['female' => 'sweetie', 'male' => 'sonny', 'non-binary' => 'dear'],
    'subject' => ['female' => 'soprano', 'male' => 'tenor', 'non-binary' => 'high pitched voice'],
    'object' => ['female' => 'contralto', 'male' => 'baritone', 'non-binary' => 'medium pitched voice'],
    'determiner' => ['female' => 'alto', 'male' => 'bass', 'non-binary' => 'low pitched voice'],
    'possessive' => ['female' => 'dame', 'male' => 'fellow', 'non-binary' => 'pal'],
    'reflexive' => ['female' => 'calamity jane', 'male' => 'wild bill hickock', 'non-binary' => 'wild card'],
    'title' => ['female' => 'ms.', 'male' => 'mr.', 'non-binary' => 'm.'],
  ];

}
