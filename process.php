<?php
/**
 * Inspired by http://www.setasign.com/products/fpdi/demos/concatenate-fake/
 * 
 * Made by github.com/tuj
 */

// Process:
// Get parameters from POST.
// Generate pdf.
// Send mail to receiver.
// Send succes result back to the frontend.

require_once('poempdf.php');

$pdf = new PoemPdf();
$pdf->addPageFromFile('pdfs/2.pdf', 7);
$pdf->addPageFromFile('pdfs/1.pdf', 350);

$pdf->Output('concat.pdf', 'D');
