<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    private $category;

    function __construct($category) {
        parent::__construct('L'); // Landscape orientation
        $this->category = $category;
    }

    // Page header
    function Header()
    {
        // Add the image
        $this->Image('../../../assets/images/north.png', 45, 8, 30); // Position image at x=10, y=10 with a width of 30

        
        // Set font for the text
        $this->SetFont('Arial', 'B', 12);
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
        
        // Line break
        $this->Ln(10);
        
        // Category
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Category: ' . ucfirst($this->category), 0, 1, 'L');
        
        // Table header
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(60, 10, 'Name', 1, 0, 'C');
        $this->Cell(20, 10, 'Age', 1, 0, 'C');
        $this->Cell(30, 10, 'Gender', 1, 0, 'C');
        $this->Cell(25, 10, 'Voter', 1, 0, 'C');
        $this->Cell(50, 10, 'Occupation', 1, 0, 'C');
        $this->Cell(70, 10, 'Educational Attainment', 1, 0, 'C');
        $this->Ln();
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Get data from URL parameters
$category = $_GET['category'] ?? 'Unknown';
$jsonData = $_GET['data'] ?? '[]';
$data = json_decode(urldecode($jsonData), true);

// Instantiate PDF
$pdf = new PDF($category);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Add table content
foreach ($data as $row) {
    $pdf->Cell(60, 10, $row['name'] ?? '', 1, 0, 'L');
    $pdf->Cell(20, 10, $row['age'] ?? '', 1, 0, 'C');
    $pdf->Cell(30, 10, $row['gender'] ?? '', 1, 0, 'C');
    $pdf->Cell(25, 10, $row['voter'] ?? '', 1, 0, 'C');
    $pdf->Cell(50, 10, $row['occupation'] ?? '', 1, 0, 'C');
    $pdf->Cell(70, 10, $row['education'] ?? '', 1, 0, 'L');
    $pdf->Ln();
}

$pdf->Output();
?>