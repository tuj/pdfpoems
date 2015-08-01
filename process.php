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

require_once('fpdf17/fpdf.php');
require_once('FPDI-1.5.4/fpdi.php');

class ConcatPdf extends FPDI {
  public function addPageFromFile($file, $page) {
    $pageCount = $this->setSourceFile($file);
    $tplIdx = $this->ImportPage($page);
    $s = $this->getTemplatesize($tplIdx);
    $this->AddPage($s['w'] > $s['h'] ? 'L' : 'P', array($s['w'], $s['h']));
    $this->useTemplate($tplIdx);
  }
}

$pdf = new ConcatPdf();
$pdf->addPageFromFile('pdfs/2.pdf', 7);
$pdf->addPageFromFile('pdfs/1.pdf', 7);

$pdf->Output('concat.pdf', 'D');