<?php
/**
 * Made by github.com/tuj
 */

require_once('poempdf.php');
 
$pdf = new PoemPdf();

$name = $_GET["name"];

echo $pdf->countPagesInFile('pdfs/' . $name);