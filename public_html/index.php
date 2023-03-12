<?php

/**
 * @file
 * The entrypoint.
 */

// Material for head.
$title = 'Gendered Text Project: Keep the plot. Keep the prose. Change the pronouns.';
$url = 'https://genderedtextproject.com/';
$description = 'Dynamically rewrite the gender of character in texts. Explore implicit bias about gender.';
$og_image = 'https://genderedtextproject.com/images/demo.png';
global $title;
global $url;
global $description;
global $og_image;

require '../vendor/autoload.php';

include 'header.php';
?>
<br>
<h1><a href="https://www.goodreads.com/book/show/6324725-politics-and-the-english-language">George Orwell</a> argued that clichéd language produces clichéd thinking. So let's change the language.</h1>
<article>
<h4>Purpose</h4>
<ul>
<li>Dynamically rewrite the gender of personae in texts</li>
<li>Challenge unconscious biases about gender and characters</li>
</ul>
<a role="button" href="/read.php">View texts</a>
</article>
