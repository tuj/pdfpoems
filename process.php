<?php
/**
 * Made by github.com/tuj
 */

require_once('poempdf.php');
require_once('PHPMailer-master/class.phpmailer.php');

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

$mail = new PHPMailer();

$mail->SetFrom('test@example.com', '');

$mail->AddAddress($data->email, "");

$mail->Subject = "Digt";

$mail->msgHTML(file_get_contents('mail/contents.html'), dirname(__FILE__));

$attachment= $pdf->Output('digt.pdf', 'S');

$mail->AddStringAttachment($attachment, 'digt.pdf');

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
