<?php
/**
 * Inspired by http://www.setasign.com/products/fpdi/demos/concatenate-fake/
 *
 * Made by github.com/tuj
 */
require_once('poempdf.php');

// Process:
// Get parameters from POST.
$works = htmlspecialchars($_POST["works"]);
$pages = htmlspecialchars($_POST["pages"]);

$workTitles = array();

// Generate pdf.
$pdf = new PoemPdf();

for ($i = 0; $i < count($works); $i++) {
  $workIndex = $works[$i];
  $workTitles[$i] = $pdf->getNameForIndex($workIndex);
  $pdf->addPageFromFile('pdfs/' . $workTitles[$i], $pages[$i]);
}

// Generate cover page.
$pdf->AddPage('P');
$pdf->SetDisplayMode(real,'default');

$pdf->SetXY (10,50);
$pdf->SetFontSize(10);
$pdf->Write(5,'Congratulations! You have generated a PDF.');

// Send mail to receiver.
// Send succes result back to the frontend.

/*
require_once('poempdf.php');

$pdf = new PoemPdf();
$pdf->addPageFromFile('pdfs/2.pdf', 7);
$pdf->addPageFromFile('pdfs/1.pdf', 350);
*/
$pdf->Output('concat.pdf', 'D');
