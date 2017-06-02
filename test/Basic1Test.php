<?php

namespace markfullmer\gendered_text;

use PHPUnit\Framework\TestCase;

/**
 * Test words are stemmed correctly.
 */
class Basic1Test extends TestCase {

  /**
   * Provides data.
   */
  public function basicDataProvider() {
    $texts[] = ['{{ She(Mindy) }} sells seashells[[Mindy/Mork:male]]', 'He sells seashells'];
    $texts[] = ['{{ She(Mindy) }} sells seashells[[Mindy/Mork:female]]', 'She sells seashells'];
    $texts[] = ['{{ She(Mork) }} sells seashells[[Mindy/Mork:female]]', 'She sells seashells'];
    $texts[] = ['{{She(Mork)}} sells seashells[[Mindy/Mork:female]]', 'She sells seashells'];
    $texts[] = ['{{Mork}} sells seashells[[Mindy/Mork:female]]', 'Mindy sells seashells'];
    $texts[] = ['{{ Mork }} sells seashells[[Mindy/Mork:female]]', 'Mindy sells seashells'];
    $texts[] = ['{{ Mork }} sells seashells', '{{ Mork }} sells seashells'];
    $texts[] = ['{{ Mork }} sells seashells[ [Mindy/Mork:female] ]', 'Mindy sells seashells'];
    return $texts;
  }

  /**
   * Test assertions.
   *
   * @dataProvider basicDataProvider
   */
  public function testBasic1($text, $expected) {
    $result = GenderedText::process($text);
    $this->assertEquals($expected, $result);
  }

}
