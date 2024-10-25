<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Set font for the text
        $this->SetFont('Arial', 'B', 12);

        // Add the image
        $this->Image('../../../assets/images/north.png', 45, 8, 30); // Position image at x=10, y=10 with a width of 30

        // Set Y position for the text
        $this->SetY(10);

        // Calculate X position to center the text
        $pageWidth = $this->GetPageWidth();
        $textWidth = $this->GetStringWidth('Republic of the Philippines');
        $x = ($pageWidth - $textWidth) / 2;
        $this->SetX($x);

        // Print centered text
        $this->Cell($textWidth, 10, 'Republic of the Philippines', 0, 1, 'C');
        $this->Cell(0, 4, 'Province of Nueva Ecija', 0, 1, 'C');
        $this->Cell(0, 4, 'Municipality of Gabaldon', 0, 1, 'C');
        $this->Cell(0, 4, 'Barangay North Poblacion', 0, 1, 'C');

        // Move down for the title
        $this->Ln(10);

        // Title
        $this->SetFont('Arial', 'B', 15);

        // Line break
        $this->Ln(10);
    }
    
    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Table for Document History
    function DocumentHistoryTable($header, $data)
    {
        // Header
        $this->SetFont('Arial', 'B', 12);
        foreach ($header as $col) {
            $this->Cell(45, 10, $col, 1, 0, 'C');
        }
        $this->Ln();

        // Data
        $this->SetFont('Arial', '', 12);
        foreach ($data as $row) {
            $this->Cell(45, 10, $row['NAME'], 1);
            $this->Cell(45, 10, $row['DATE_ISSUED'], 1);
            $this->Cell(45, 10, $row['TYPE_OF_CERTIFICATE'], 1);
            $this->Cell(45, 10, $row['AMOUNT'], 1);
            $this->Ln();
        }
        $totalAmount = array_sum(array_column($data, 'AMOUNT'));
        
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(135, 10, 'Total Amount:', 1, 0, 'R');
        $this->Cell(45, 10, number_format($totalAmount), 1, 0, 'R');
    }
}

// Get values (could be coming from GET or database query)
$month = isset($_GET['month']) ? $_GET['month'] : 'N/A';
$data = isset($_GET['data']) ? json_decode($_GET['data'], true) : [];

// Instanciate PDF object
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Print Month Title
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Month: ' . $month, 0, 1, 'L');

// Column headers for the table
$header = ['Name', 'Date Issued', 'Type of Certificate', 'Amount'];

// Table with document history
$pdf->DocumentHistoryTable($header, $data);

// Output the PDF to browser
$pdf->Output();
?>
