<?php

namespace markfullmer\gendered_text;

/**
 * Class for dynamically process texts per user-supplied gender.
 */
class GenderedText {

  /**
   * Main function for dynamically altering the gender of a text.
   *
   * @return string
   *   The gendered text variant.
   */
  public static function process($text) {
    $legend = self::legend($text);
    $placeholders = self::placeholders($text);
    $text = self::removeLegend($text);
    $modified = self::replace($text, $placeholders, $legend);
    return $modified;
  }

  public static function replace($text, $placeholders, $legend) {

    foreach ($placeholders as $key => $placeholder) {
      if (empty($placeholder)) {
        $legend_map = $legend[$key];
        $name = $key;
        if ($legend_map['gender'] == 'male') {
          $name = $legend_map['names'][1];
        }
        elseif ($legend_map['gender'] == 'trans') {
          $name = $legend_map['names'][2];
        }
        $text = str_ireplace("{{ " . $key . " }}", $name, $text);
      }
      else {
        $replaceable = $placeholder[0];
        $pronoun = strtolower($placeholder[1]);
        if (in_array($pronoun, array_keys(self::$pronouns))) {
          $usage = self::$pronouns[$pronoun];
        }
        $id = $placeholder[2];
        if (in_array($id, array_keys($legend))) {
          $legend_map = $legend[$id];
        }
        $gender = $legend_map['gender'];
        $pos = self::$pronouns[$pronoun]['pos'];
        $replacement = self::$pronoun_map[$pos][$gender];
        $text = str_ireplace("{{ " . $placeholder[0] . " }}", $replacement, $text);
      }
    }
    return $text;
  }

  public static $pronoun_map = [
    'subject' => ['male' => 'he', 'female' => 'she', 'trans' => 'ze'],
    'object' => ['male' => 'him', 'female' => 'her', 'trans' => 'hir'],
    'determiner' => ['male' => 'his', 'female' => 'her', 'trans' => 'hir'],
    'possessive' => ['male' => 'his', 'female' => 'hers', 'trans' => 'hirs'],
    'reflexive' => ['male' => 'himself', 'female' => 'herself', 'trans' => 'hirself'],
  ];

  public static $pronouns = [
    'he' => ['gender' => 'male', 'pos' => 'subject'],
    'she' => ['gender' => 'female', 'pos' => 'subject'],
    'ze' => ['gender' => 'trans', 'pos' => 'subject'],
    'him' => ['gender' => 'male', 'pos' => 'object'],
    'her' => ['gender' => 'female', 'pos' => 'object'],
    'hir' => ['gender' => 'trans', 'pos' => 'object'],
    'his' => ['gender' => 'male', 'pos' => 'determiner'],
    'herd' => ['gender' => 'female', 'pos' => 'determiner'],
    'hir' => ['gender' => 'trans', 'pos' => 'determiner'],
    'hisp' => ['gender' => 'male', 'pos' => 'possessive'],
    'hers' => ['gender' => 'female', 'pos' => 'possessive'],
    'hirs' => ['gender' => 'trans', 'pos' => 'possessive'],
    'herself' => ['gender' => 'female', 'pos' => 'reflexive'],
    'himself' => ['gender' => 'male', 'pos' => 'reflexive'],
    'hirself' => ['gender' => 'trans', 'pos' => 'reflexive'],
  ];

  /**
   * Clean up: remove the legend string from the original text.
   *
   * @return string
   *   The text, minus the legend string, if it exists.
   */
  public static function removeLegend($text) {
    preg_match("/\[\[(.*)\]\]/", $text, $legend_string);
    if (isset($legend_string[0])) {
      return str_replace($legend_string[0], "", $text);
    }
    return $text;
  }

  /**
   * Parse the text legend; if absent, return an empty array.
   *
   * @return array
   *   The gendered text variant.
   */
  public static function legend($text) {
    $legend = [];
    $legend['names'] = [];
    preg_match("/\[\[(.*)\]\]/", $text, $legend_string);
    if (isset($legend_string[0])) {
      preg_match("/\[(.*)\]/", $legend_string[0], $no_brackets);
      preg_match_all("/\[[^\]]*\]/", $no_brackets[1], $personae);
      foreach ($personae[0] as $persona) {
        preg_match("/\[(.*)\]/", $persona, $values_no_brackets);
        $values = preg_split("/:/", $values_no_brackets[1]);
        if (isset($values[0])) {
          $names = preg_split("/\//", $values[0]);
        }
        $key = $names[0];
        $legend[$key] = [
          'names' => $names,
          'gender' => $values[1],
        ];
        $legend['names'][] = $names;
      }
      // Flatten the 'names' array so we can easily do a string match.
      $legend['names'] = call_user_func_array('array_merge', $legend['names']);
      return $legend;
    }
    return [];
  }

  /**
   * Parse the placeholders.
   *
   * @return array
   *   The placeholders to check/replace.
   */
  public static function placeholders($text) {
    preg_match_all("/\{\{\s*(.*?)\s*\}\}/", $text, $placeholders);
    if (isset($placeholders[1])) {
      foreach ($placeholders[1] as $item) {
        preg_match("/(.*?)\((.*?)\)/", $item, $placholders_split);
        $return[$item] = $placholders_split;
      }
      return $return;
    }
    return [];
  }

}
