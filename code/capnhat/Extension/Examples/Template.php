<?php
require_once '../PHPWord.php';

$PHPWord = new PHPWord();

$document = $PHPWord->loadTemplate('formtuyendung01.doc');

$document->setValue('Value1', 'Sun');
$document->save('Solarsystem.doc');
?>