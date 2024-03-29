<?php

/**
 * @file
 * The entrypoint.
 */

// Material for head.
$title = 'Read texts: Gendered Text Project';
$url = 'https://genderedtextproject.com/read.php';
$description = 'Choose a text, then select a gender, then read.';
$og_image = 'https://genderedtextproject.com/images/demo.png';
global $title;
global $url;
global $description;
global $og_image;

require '../vendor/autoload.php';

include 'header.php';
use markfullmer\gendered_text\GenderedText;

$directory = '../data/texts/';

if (empty($_GET['text'])) {
  echo '<h1>Choose a text</h1>';
  $texts = array_diff(scandir($directory), array('..', '.'));
  asort($texts);
  echo '<div id="choices"><div class="big"><input class="search" placeholder="Search title, author, genre" />
  <a href="#" role="button" class="sort" data-sort="genre">Sort by genre</a>
  <a href="#" role="button" class="sort" data-sort="author">Sort by author</a>
  <a href="#" role="button" class="sort" data-sort="title">Sort by title</a>
  </div>
  ';
  echo '<table><thead><th>Genre<th>Author</th><th>Title</th><th>Action</th>';
  echo '<tbody class="list">';
  foreach ($texts as $filename) {
    $parts = explode('.', $filename);
    echo '<tr><td class="genre">' . $parts[0] . '</td><td class="author"> ' . $parts[1] . '</td><td class="title"> ' . $parts[2] . '<td><a role="button" href="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '?text=' . $filename . '">Read</a></td></tr>';
  }
  echo '</tbody></table></div>';
}
elseif (!empty($_GET['text']) && empty($_POST['characters'])) {
  // Allow the user to assign genders.
  $text = file_get_contents($directory . $_GET['text']);
  if ($text) {
    $legend_string = GenderedText::findLegend($text);
    $legend = GenderedText::parseLegend($legend_string);
    if (empty($legend)) {
      echo '<h4>This text does not appear to have a character legend. The code
      cannot proceed.</h4>';
    }
    else {
      $set = [];
      echo '<form class="big" action="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '" method="POST">';
      $genders = ['male', 'female', 'non-binary'];
      unset($legend['names']);
      foreach ($legend as $key => $values) {
        $default = $values['names'][$values['gender']];
        if ($key === $default) {
          $list = implode('/', $values['names']);
          if (!in_array($list, $set)) {
            echo '<label style="display:block;" for="characters[' . $list . ']">Gender for "' . $default . '": ';
            echo '<select name="characters[' . $list . ']">';
            foreach ($genders as $gender) {
              echo '<option value="' . $gender . '"';
              if ($gender == $values['gender']) {
                echo ' selected="selected"';
              }
              echo '>' . ucfirst($gender) . '</option>';
            }
            echo '<option value="random">Surprise me!</option>';
            echo '</select>';
            echo '</label>';
            $set[] = $list;
          }
        }
      }
      echo '<input type="submit" name="submit" value="Read the text" />';
      echo '
        </form>
      </div>';
    }
  }

}
elseif (!empty($_GET['text']) && !empty($_POST['characters'])) {
  // Display the text!
  $file_contents = file($directory . $_GET['text']);
  $content = [];
  foreach($file_contents as $line) {
    if (strpos($line, '##') === 0) {
      $line = substr($line, 2);
      $content[] = '<h2>' . $line . '</h2>';
    }
    else {
      $content[] = '<p>' . $line . '</p>';
    }
  }
  $text = implode('', $content);
  if ($text) {
    $legend_string = GenderedText::findLegend($text);
    $text = GenderedText::removeLegend($text, $legend_string);
    $legend = GenderedText::buildLegend($_POST['characters']);
    echo '<br><p><a role="button" href="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '">&#8592; Back to gender selector</a></p>';
    echo '<div class="text">' . GenderedText::process($text . $legend) . '</div>';
  }
}
?>
</body>
   <script src="/list.min.js"></script>
  <script>
    var options = {
      valueNames: [ 'author', 'title', 'genre' ]
    };
    var choiceList = new List('choices', options);
  </script>
</html>
