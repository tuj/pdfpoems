<?php
/**
 * Made by github.com/tuj
 */

$fi = new FilesystemIterator(__DIR__ . "/pdfs", FilesystemIterator::SKIP_DOTS);
$numberOfItems = iterator_count($fi);
echo $numberOfItems;
