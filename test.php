<?php

// Code for testing purposes - Jamie Stinson 23/09/2021

use Src\Boot;
use Src\Engine\Dictionary\Dictionary;
use Src\Engine\Scrabble;

require_once 'Src/Boot.php';

$boot = new Boot();

$dictionary = new Dictionary($boot);

$scrabble = new Scrabble($dictionary);

echo $scrabble->removeNonAlphaCharacters("Hello123# my na8me is J---am9ie");