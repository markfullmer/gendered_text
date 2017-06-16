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
    $legend_string = self::findLegend($text);
    $legend = self::parseLegend($legend_string);
    $placeholders = self::placeholders($text);
    $map = self::transform_replacements();
    // Strip the legend from the output.
    $text = self::removeLegend($text, $legend_string);
    // Perform text replacements.
    $modified = self::replace($text, $placeholders, $legend, $map);
    return $modified;
  }

  /**
   * Swap out placeholders for real text, using the legend.
   *
   * @return string
   *   The string-replaced text.
   */
  public static function replace($text, $placeholders, $legend, $map) {
    foreach ($placeholders as $key => $placeholder) {
      if (empty($placeholder)) {
        // The placeholder only contains the name. Replace it with the
        // appropriate gendered name.
        if (!empty($legend[$key])) {
          $legend_map = $legend[$key];
        }
        if (!empty($legend_map)) {
          $gender = $legend_map['gender'];
          if (!empty($legend_map['names'][$gender])) {
            $name = $legend_map['names'][$gender];
          }
          $text = preg_replace("/{{\s*" . $key . "\s*}}/i", $name, $text);
        }
      }
      else {
        // Deal with pronouns and other replacements.
        $replaceable = $placeholder[0];
        $replacement = $placeholder[1];
        $identifier = strtolower($placeholder[1]);
        $persona = $placeholder[2];
        if (in_array($identifier, array_keys(self::replacements())) && in_array($persona, array_keys($legend))) {
          $replacements = self::replacements();
          $pos = $replacements[$identifier]['pos'];
          $legend_item = $legend[$persona];
          $gender = $legend_item['gender'];
          // The real action: find which replacement should be used.
          $replacement = $map[$pos][$gender];
        }
        if (self::is_capitalized($placeholder[1])) {
          $replacement = ucfirst($replacement);
        }
        $text = preg_replace("/{{\s*" . preg_quote($placeholder[0]) . "\s*}}/", $replacement, $text);
      }
    }
    return $text;
  }

  /**
   * Create a mapping from self::$replacements.
   *
   * @return array
   *   A traversable array of parts of speech.
   */
  public static function transform_replacements() {
    $map = [];
    foreach (self::replacements() as $id => $attributes) {
      $pos = $attributes['pos'];
      $gender = $attributes['gender'];
      $output = !empty($attributes['output']) ? $attributes['output'] : $id;
      $map[$pos][$gender] = $output;
    }
    return $map;
  }

  /**
   * Replace pronouns and other words with placeholder markers.
   *
   * @return array
   *   A traversable array of parts of speech.
   */
  public static function addPlaceholders($text) {
    foreach (array_keys(self::replacements()) as $replacement) {

      $text = preg_replace("/\s(" . preg_quote($replacement) . ")([^a-zA-Z])(s*)/", " {{ $1(person) }}$2$3", $text);
      $text = preg_replace("/\s(" . ucfirst(preg_quote($replacement)) . ")([^a-zA-Z])(s*)/", " {{ $1(person) }}$2$3", $text);
    }
    return $text;
  }

  /**
   * Given an array of character names => gender, construct the legend string.
   *
   * @return string
   *   A standard legend string format [[character:gender][character:gender]].
   */
  public static function buildLegend($POST) {
    $legend = '';
    foreach ($POST as $character => $gender) {
      $legend .= '[' . $character . ':' . $gender . ']';
    }
    return '[' . $legend . ']';
  }

  /**
   * Machine-first mapping of all words.
   *
   * @return array
   *   The built list of all word mapping replacements.
   */
  public static function replacements() {
    $path = dirname(__FILE__) . '/WordMap.php';
    include $path;
    // Local development configuration.
    if (file_exists(dirname(__FILE__) . '/Extensions.php')) {
      include dirname(__FILE__) . '/Extensions.php';
      $replacements = array_merge($replacements, $extensions);
    }
    return $replacements;
  }

  /**
   * Clean up: remove the legend string from the original text.
   *
   * @return string
   *   The text, minus the legend string, if it exists.
   */
  public static function removeLegend($text, $legend) {
    return str_replace($legend, "", $text);
  }

  /**
   * Retrieve the string that identifies the legend.
   *
   * @return string
   *   The legend string, if it exists.
   */
  public static function findLegend($text) {
    // Find text matching [[STRING][STRING]].
    preg_match("/\[\s*\[(.*)\]\s*\]/", $text, $legend_string);
    if (isset($legend_string[0])) {
      return $legend_string[0];
    }
    return '';
  }

  /**
   * Parse the text legend; if absent, return an empty array.
   *
   * @return array
   *   The gendered text variant.
   */
  public static function parseLegend($legend_string) {
    $legend = [];
    $legend['names'] = [];
    if ($legend_string != '') {
      preg_match("/\[(.*)\]/", $legend_string, $no_brackets);
      preg_match_all("/\[[^\]]*\]/", $no_brackets[1], $personae);
      foreach ($personae[0] as $persona) {
        preg_match("/\[(.*)\]/", $persona, $values_no_brackets);
        $values = preg_split("/:/", $values_no_brackets[1]);
        if (isset($values[0])) {
          $names = preg_split("/\//", $values[0]);
        }
        foreach ($names as $key => $value) {
          $legend[$value]['names']['female'] = $names[0];
          $legend[$value]['names']['male'] = $names[1];
          if (isset($names[2])) {
            $legend[$value]['names']['trans'] = $names[2];
          }
          $legend[$value]['gender'] = $values[1];
        }
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
    $return = [];
    preg_match_all("/\{\{\s*(.*?)\s*\}\}/", $text, $placeholders);
    if (isset($placeholders[1])) {
      foreach ($placeholders[1] as $item) {
        preg_match("/(.*?)\((.*?)\)/", $item, $placholders_split);
        $return[$item] = $placholders_split;
      }
    }
    return $return;
  }

  /**
   * Determine whether a word is capitalized.
   *
   * @return bool
   *   Whether the word is capitalized.
   */
  public static function is_capitalized($string) {
    $first_letter = substr($string, 0, 1);
    return ctype_upper($first_letter);
  }

}
