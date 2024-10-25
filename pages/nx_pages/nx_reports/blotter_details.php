<?php
require('fpdf/fpdf.php');
require '../../db_connect.php';

class PDF extends FPDF
{
    private $category;

    function __construct($category, $width = 297, $height = 210) {
        parent::__construct('P', 'mm', [$width, $height]);
        $this->category = $category;
    }
    
    // Page header
    function Header()
    {
        $this->Image('../../../assets/images/north.png', 45, 8, 30);
        $this->SetFont('Arial', 'B', 12);
        $this->SetY(10);

        $pageWidth = $this->GetPageWidth();
        $textWidth = $this->GetStringWidth('Republic of the Philippines');
        $x = ($pageWidth - $textWidth) / 2;
        $this->SetX($x);

        $this->Cell($textWidth, 10, 'Republic of the Philippines', 0, 1, 'C');
        $this->Cell(0, 4, 'Province of Nueva Ecija', 0, 1, 'C');
        $this->Cell(0, 4, 'Municipality of Gabaldon', 0, 1, 'C');
        $this->Cell(0, 4, 'Barangay North Poblacion', 0, 1, 'C');
        
        $this->Ln(10);
        
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Blotter Report', 0, 1, 'C');
        
        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Get the selected year from GET
$selectedYear = $_GET['year'] ?? '';

// Query to fetch blotter data
$query = "SELECT complainant, personToComplaint, date, complaint FROM tblblotter";
if ($selectedYear) {
    // Using prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT complainant, personToComplaint, date, complaint FROM tblblotter WHERE YEAR(date) = ?");
    $stmt->bind_param('i', $selectedYear);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = mysqli_query($conn, $query);
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Instantiate PDF
$pdf = new PDF("Blotter", 300, 200);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$increment = 1; 
foreach ($data as $row) {
    // Check if the current Y position is too close to the bottom
    if ($pdf->GetY() > 250) {
        $pdf->AddPage();
    }
    
    // Increment number
    $pdf->Cell(0, 10, "{$increment}. {$row['complainant']}", 0, 1, 'L');
    
    // Bold text for Person to Complaint
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Person to Complaint: {$row['personToComplaint']}", 0, 1, 'L');
    
    // Reset font for date
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, date('Y-m-d', strtotime($row['date'])) ?? '', 0, 1, 'L');
    
    // Complaint text
    $pdf->MultiCell(0, 10, $row['complaint'] ?? '', 0, 'L');
    
    // Add a line break after each entry
    $pdf->Ln(5);
    
    $increment++;
}

// Output the PDF
$pdf->Output();
?>
