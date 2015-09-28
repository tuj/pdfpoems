<?php
/**
 * Inspired by http://www.setasign.com/products/fpdi/demos/concatenate-fake/
 *
 * Made by github.com/tuj
 */
require_once('poempdf.php');

// Process:
// Get parameters from POST.
$input = file_get_contents('php://input');
$data = json_decode($input);
$items = $data->items;

// Generate pdf.
$pdf = new PoemPdf();
$pdf->AddPage();
$pdf->SetFont('Courier', 'B', 14);
$pdf->Cell(40, 10, 'Author');
$pdf->Ln();
$pdf->Ln();
for ($i = 0; $i < count($items); $i++) {
  $pdf->Cell(40, 10, 'Side ' . $items[$i]->page . ' fra "' . $items[$i]->title . '"');
  $pdf->Ln();
}


for ($i = 0; $i < count($items); $i++) {
  $pdf->addPageFromFile('pdfs/' . $items[$i]->title, $items[$i]->page);
}

// Send mail to receiver.
// Send succes result back to the frontend.

$pdf->Output('concat.pdf', 'D');
