<?php

namespace markfullmer\gendered_text;

use PHPUnit\Framework\TestCase;

/**
 * Test the legend is parsed correctly.
 */
class LegendParseTest extends TestCase {

  /**
   * Provides data.
   */
  public function basicDataProvider() {
    $texts[] = [
      '[[Fortunato/Felicity:male][Sebastian/Silvia:female][Mary/Marcus:female][Harold/Harriet:male][Robert/Roberta:male][Dego/Dulce:male]]',
      ['Fortunato', 'Felicity', 'Sebastian', 'Silvia', 'Mary', 'Marcus', 'Harold', 'Harriet', 'Robert', 'Roberta', 'Dego', 'Dulce'],
    ];
    $texts[] = [
      '[ [Fortunato/Felicity:male][Sebastian/Silvia:female][Mary/Marcus:female][Harold/Harriet:male][Robert/Roberta:male][Dego/Dulce:male] ]',
      ['Fortunato', 'Felicity', 'Sebastian', 'Silvia', 'Mary', 'Marcus', 'Harold', 'Harriet', 'Robert', 'Roberta', 'Dego', 'Dulce'],
    ];
    $texts[] = [
      '[ [Fortunato/Felicity:male] [Sebastian/Silvia:female][Mary/Marcus:female][Harold/Harriet:male][Robert/Roberta:male][Dego/Dulce:male] ]',
      ['Fortunato', 'Felicity', 'Sebastian', 'Silvia', 'Mary', 'Marcus', 'Harold', 'Harriet', 'Robert', 'Roberta', 'Dego', 'Dulce'],
    ];
    return $texts;
  }

  /**
   * Test assertions.
   *
   * @dataProvider basicDataProvider
   */
  public function testBasic1($text, $expected) {
    $legend_string = GenderedText::findLegend($text);
    $result = GenderedText::parseLegend($legend_string);
    $this->assertEquals($expected, $result['names']);
  }

}
