<?php

require '../vendor/autoload.php';

use markfullmer\gendered_text\GenderedText;

$tests = [
  ['{{ brother(Jude) }}', '[ [Julie/Jude/Juen:female] ]', 'sister'],
  ['{{ brother(Jude) }}', '[ [Julie/Jude/Juen:non-binary] ]', 'sibling'],
  ['{{ brother(Jude) }}', '[ [Julie/Jude/Juen:male] ]', 'brother'],
  ['{{ sister(Jude) }}', '[ [Julie/Jude/Juen:female] ]', 'sister'],
  ['{{ sister(Jude) }}', '[ [Julie/Jude/Juen:non-binary] ]', 'sibling'],
  ['{{ sister(Jude) }}', '[ [Julie/Jude/Juen:male] ]', 'brother'],
  ['{{ sibling(Jude) }}', '[ [Julie/Jude/Juen:female] ]', 'sister'],
  ['{{ sibling(Jude) }}', '[ [Julie/Jude/Juen:non-binary] ]', 'sibling'],
  ['{{ sibling(Jude) }}', '[ [Julie/Jude/Juen:male] ]', 'brother'],
  ['{{ he(Jude) }} goes ', '[ [Julie/Jude/Juen:female] ]', 'she goes '],
  ['{{ he(Jude) }} goes ', '[ [Julie/Jude/Juen:non-binary] ]', 'they go '],
  ['{{ he(Jude) }} goes ', '[ [Julie/Jude/Juen:male] ]', 'he goes '],
  ['{{ she(Jude) }} goes ', '[ [Julie/Jude/Juen:female] ]', 'she goes '],
  ['{{ she(Jude) }} goes ', '[ [Julie/Jude/Juen:non-binary] ]', 'they go '],
  ['{{ she(Jude) }} goes ', '[ [Julie/Jude/Juen:male] ]', 'he goes '],
  ['{{ they(Jude) }} go ', '[ [Julie/Jude/Juen:female] ]', 'she goes '],
  ['{{ they(Jude) }} go ', '[ [Julie/Jude/Juen:non-binary] ]', 'they go '],
  ['{{ they(Jude) }} go ', '[ [Julie/Jude/Juen:male] ]', 'he goes '],
  ['{{ She(Jude) }} go ', '[ [Julie/Jude/Juen:female] ]', 'She goes '],
];
foreach ($tests as $test) {
  $failure = FALSE;
  $expected = $test[2];
  $actual = GenderedText::process($test[0] . $test[1]);
  if ($expected !== $actual) {
    echo 'Expected: ' . $expected . ' | Actual: ' . $actual . ' | Data: ' . $test[0] . $test[1] . '<br />';
    $failure = TRUE;
  }
}
if (!$failure) {
  echo 'All ' . count($tests) . ' tests pass!';
}
