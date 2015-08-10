<?php
require_once('poempdf.php');

$numberOfSamples = $_GET['samples'];

$pdf = new PoemPdf();

$numberOfFiles = $pdf->getNumberOfFiles();

for ($i = 0; $i < $numberOfSamples; $i++) {
  $workIndex = mt_rand() % $numberOfFiles;
  $workName = $pdf->getNameForIndex($workIndex);  
  
  $workPages = $pdf->countPagesInFile('pdfs/' . $workName);
  
  $selectedPage = mt_rand() % $workPages + 1;
  
  $pdf->addPageFromFile('pdfs/' . $workName, $selectedPage);
}

$pdf->Output('concat.pdf', 'D');