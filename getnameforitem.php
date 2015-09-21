<?php

require_once('poempdf.php');

$pdf = new PoemPdf();

$index = $_GET["index"];

echo $pdf->getNameForIndex($index);