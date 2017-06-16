<?php

/**
 * @file
 * Gendered word map.
 */

$replacements = [
  'male' => ['gender' => 'male', 'pos' => 'sex'],
  'female' => ['gender' => 'female', 'pos' => 'sex'],
  'nonbinary' => ['gender' => 'trans', 'pos' => 'sex'],

  'man' => ['gender' => 'male', 'pos' => 'gender'],
  'woman' => ['gender' => 'female', 'pos' => 'gender'],
  'person' => ['gender' => 'trans', 'pos' => 'gender'],

  'men' => ['gender' => 'male', 'pos' => 'plural'],
  'women' => ['gender' => 'female', 'pos' => 'plural'],
  'men and women' => ['gender' => 'trans', 'pos' => 'plural'],

  'gentlemen' => ['gender' => 'male', 'pos' => 'formal plural'],
  'ladies' => ['gender' => 'female', 'pos' => 'formal plural'],
  'ladies and gentlemen' => ['gender' => 'trans', 'pos' => 'formal plural'],

  'father' => ['gender' => 'male', 'pos' => 'parent'],
  'mother' => ['gender' => 'female', 'pos' => 'parent'],
  'parent' => ['gender' => 'trans', 'pos' => 'parent'],

  'husband' => ['gender' => 'male', 'pos' => 'spouse'],
  'wife' => ['gender' => 'female', 'pos' => 'spouse'],
  'spouse' => ['gender' => 'trans', 'pos' => 'spouse'],

  'boy' => ['gender' => 'male', 'pos' => 'child'],
  'girl' => ['gender' => 'female', 'pos' => 'child'],
  'child' => ['gender' => 'trans', 'pos' => 'child'],

  'lad' => ['gender' => 'male', 'pos' => 'kid'],
  'lass' => ['gender' => 'female', 'pos' => 'kid'],
  'kid' => ['gender' => 'trans', 'pos' => 'kid'],

  'brother' => ['gender' => 'male', 'pos' => 'sibling'],
  'sister' => ['gender' => 'female', 'pos' => 'sibling'],
  'sibling' => ['gender' => 'trans', 'pos' => 'sibling'],

  'son' => ['gender' => 'male', 'pos' => 'offspring'],
  'daughter' => ['gender' => 'female', 'pos' => 'offspring'],
  'child' => ['gender' => 'trans', 'pos' => 'offspring'],

  'prince' => ['gender' => 'male', 'pos' => 'sovereign'],
  'princess' => ['gender' => 'female', 'pos' => 'sovereign'],
  'sovereign' => ['gender' => 'trans', 'pos' => 'sovereign'],

  'king' => ['gender' => 'male', 'pos' => 'ruler'],
  'queen' => ['gender' => 'female', 'pos' => 'ruler'],
  'ruler' => ['gender' => 'trans', 'pos' => 'ruler'],

  'nephew' => ['gender' => 'male', 'pos' => 'cousin'],
  'niece' => ['gender' => 'female', 'pos' => 'cousin'],
  'siblings child' => ['gender' => 'trans', 'pos' => 'cousin'],

  'footman' => ['gender' => 'male', 'pos' => 'servant'],
  'maid' => ['gender' => 'female', 'pos' => 'servant'],
  'servant' => ['gender' => 'trans', 'pos' => 'servant'],

  'barber shop' => ['gender' => 'male', 'pos' => 'hair salon'],
  'beauty parlor' => ['gender' => 'female', 'pos' => 'hair salon'],
  'hair salon' => ['gender' => 'trans', 'pos' => 'hair salon'],

  'butler' => ['gender' => 'male', 'pos' => 'servant'],
  'housekeeper' => ['gender' => 'female', 'pos' => 'servant'],
  'servant' => ['gender' => 'trans', 'pos' => 'servant'],

  'bastard' => ['gender' => 'male', 'pos' => 'insult'],
  'bitch' => ['gender' => 'female', 'pos' => 'insult'],
  'asshole' => ['gender' => 'trans', 'pos' => 'insult'],

  'sir' => ['gender' => 'male', 'pos' => 'honorific1'],
  'ma-am' => ['gender' => 'female', 'pos' => 'honorific1'],
  'your honor1' => ['gender' => 'trans', 'pos' => 'honorific1', 'output' => 'your honor'],

  'lord' => ['gender' => 'male', 'pos' => 'honorific2'],
  'lady' => ['gender' => 'female', 'pos' => 'honorific2'],
  'your honor2' => ['gender' => 'trans', 'pos' => 'honorific2', 'output' => 'your honor'],

  'duke' => ['gender' => 'male', 'pos' => 'honorific3'],
  'duchess' => ['gender' => 'female', 'pos' => 'honorific3'],
  'your honor3' => ['gender' => 'trans', 'pos' => 'honorific3', 'output' => 'your honor'],

  'trousers' => ['gender' => 'male', 'pos' => 'clothes1'],
  'skirt' => ['gender' => 'female', 'pos' => 'clothes1'],
  'trousersn' => ['gender' => 'trans', 'pos' => 'clothes1', 'output' => 'trousers'],

  'suit' => ['gender' => 'male', 'pos' => 'clothes2'],
  'dress' => ['gender' => 'female', 'pos' => 'clothes2'],
  'suitn' => ['gender' => 'trans', 'pos' => 'clothes2', 'output' => 'trousers'],

  'tuxedo' => ['gender' => 'male', 'pos' => 'clothes3'],
  'gown' => ['gender' => 'female', 'pos' => 'clothes3'],
  'outfit' => ['gender' => 'trans', 'pos' => 'clothes3'],

  'sonny' => ['gender' => 'male', 'pos' => 'affectionate'],
  'sweetie' => ['gender' => 'female', 'pos' => 'affectionate'],
  'dear' => ['gender' => 'trans', 'pos' => 'affectionate'],

  'tenor' => ['gender' => 'male', 'pos' => 'high voice'],
  'soprano' => ['gender' => 'female', 'pos' => 'high voice'],
  'high pitched voice' => ['gender' => 'trans', 'pos' => 'high voice'],

  'baritone' => ['gender' => 'male', 'pos' => 'med voice'],
  'contralto' => ['gender' => 'female', 'pos' => 'med voice'],
  'medium pitched voice' => ['gender' => 'trans', 'pos' => 'med voice'],

  'bass' => ['gender' => 'male', 'pos' => 'low voice'],
  'alto' => ['gender' => 'female', 'pos' => 'low voice'],
  'low pitched voice' => ['gender' => 'trans', 'pos' => 'low voice'],

  'fellow' => ['gender' => 'male', 'pos' => 'pal'],
  'dame' => ['gender' => 'female', 'pos' => 'pal'],
  'pal' => ['gender' => 'trans', 'pos' => 'pal'],

  'wild bill hickock' => ['gender' => 'male', 'pos' => 'Wild Card'],
  'calamity jane' => ['gender' => 'female', 'pos' => 'Wild Card'],
  'wild card' => ['gender' => 'trans', 'pos' => 'Wild Card'],

  'he' => ['gender' => 'male', 'pos' => 'subject'],
  'she' => ['gender' => 'female', 'pos' => 'subject'],
  'ze' => ['gender' => 'trans', 'pos' => 'subject'],
  'him' => ['gender' => 'male', 'pos' => 'object'],
  'her' => ['gender' => 'female', 'pos' => 'object'],
  'hir' => ['gender' => 'trans', 'pos' => 'object'],
  'hisd' => ['gender' => 'male', 'pos' => 'determiner', 'output' => 'his'],
  'herd' => ['gender' => 'female', 'pos' => 'determiner', 'output' => 'her'],
  'hird' => ['gender' => 'trans', 'pos' => 'determiner'],
  'his' => ['gender' => 'male', 'pos' => 'possessive'],
  'hers' => ['gender' => 'female', 'pos' => 'possessive'],
  'hirs' => ['gender' => 'trans', 'pos' => 'possessive'],
  'herself' => ['gender' => 'female', 'pos' => 'reflexive'],
  'himself' => ['gender' => 'male', 'pos' => 'reflexive'],
  'hirself' => ['gender' => 'trans', 'pos' => 'reflexive'],
  'mr.' => ['gender' => 'male', 'pos' => 'title'],
  'ms.' => ['gender' => 'female', 'pos' => 'title'],
  'm.' => ['gender' => 'trans', 'pos' => 'title'],
];
