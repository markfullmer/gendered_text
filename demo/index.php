<?php

include 'header.php';
?>
<div class="section values">
  <div class="container">
    <div class="row">
      <div class="one-third column value">
        <h3 class="value-multiplier">Prepare</h3>
        <p class="value-heading">Replace gender markers in a standard text with placeholders to be used by the generator.</p>
        <a class="button button-primary" href="prepare.php">Prepare</a>
      </div>
      <div class="one-third column value">
        <h3 class="value-multiplier">Test</h3>
        <p class="value-description">Input a parameterized text, with a <a href="https://github.com/markfullmer/gendered_text">legend that defines each persona's gender</a>, and review the gendered output.</p>
        <a class="button button-primary" href="test.php">Test</a>
      </div>
      <div class="one-third column value">
        <h3 class="value-multiplier">Read</h3>
        <p class="value-description">Choose from a list of prepared texts and dynamically select the gender for each character.</p>
        <a class="button button-primary" href="read.php">Read</a>
      </div>
    </div>
  </div>
</div>

<?php
include 'footer.php';
