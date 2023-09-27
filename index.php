<?php
require('NumberToWords.php');

$myNum = 502019;

echo number_format($myNum);

echo '<br>';

$obj = new NumberToWords();

echo ($obj->convert($myNum, 'en'));

echo '<br>';

echo ($obj->convert($myNum, 'af'));

echo '<br>';
