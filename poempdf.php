<?php
require_once('fpdf17/fpdf.php');
require_once('FPDI-1.5.4/fpdi.php');

class PoemPdf extends FPDI {
  public function addPageFromFile($file, $page) {
    $pageCount = $this->setSourceFile($file);
    $tplIdx = $this->ImportPage($page);
    $s = $this->getTemplatesize($tplIdx);
    $this->AddPage($s['w'] > $s['h'] ? 'L' : 'P', array($s['w'], $s['h']));
    $this->useTemplate($tplIdx);
  }

  public function countPagesInFile($file) {
    $pageCount = $this->setSourceFile($file);
	return $pageCount;
  }
  
  public function getNumberOfFiles() {
    $fi = new FilesystemIterator(__DIR__ . "/pdfs", FilesystemIterator::SKIP_DOTS);
	$numberOfItems = iterator_count($fi);
	return $numberOfItems;
  }
  
  public function getNameForIndex($index) {
    $fi = new FilesystemIterator(__DIR__ . "/pdfs", FilesystemIterator::SKIP_DOTS);
	$fi->seek($index);
	
	if ($fi->valid()) {
      return $fi->getFilename();
	} else {
	  echo 'No file at position ' . $index;
	}
  }
}
