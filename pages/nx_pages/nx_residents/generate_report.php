<?php
// Include FPDF library (assuming the library is installed correctly)
require('fpdf/fpdf.php');  // Make sure the path to fpdf.php is correct

// Database connection parameters
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "north"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the 'purok' parameter from the URL
$purokss = isset($_GET['area']) ? $_GET['area'] : '';  

// SQL query to fetch residents based on the 'purok' value
$sql = "SELECT * FROM tblresident WHERE purok = '$purokss' ORDER BY houseNo, head_fam DESC"; 

// Execute the query and check for errors
$result = $conn->query($sql);

// Check if query execution was successful
if (!$result) {
    die("Error executing query: " . $conn->error);  // Optional: Handle error more gracefully in production
}

// Group residents by their houseNo
$households = [];
while ($row = mysqli_fetch_assoc($result)) {
    $houseNo = $row['houseNo'];
    if (!isset($households[$houseNo])) {
        $households[$houseNo] = [];
    }
    $households[$houseNo][] = $row;
}

// Close connection after retrieving data
$conn->close();

// Start output buffering to prevent accidental output
ob_start();

// Extend the FPDF class to include the custom header function
class PDF extends FPDF {
    // Header function to add the custom header
    function Header() {
        global $purokss;  // Access the global $purokss variable

        // Set font for the text
        $this->SetFont('Arial', 'B', 12);

        // Add the image
        $this->Image('../../../assets/images/north.png', 45, 8, 30); // Position image at x=45, y=8 with a width of 30

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
        $this->Cell(0, 4, 'RECORD OF BARANGAY INHABITANTS', 0, 1, 'C');

        // Move down for the title
        $this->Ln(10);

        // Title with dynamic Purok value
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Purok: ' . strtoupper($purokss), 0, 1, 'C'); 

        // Line break
        $this->Ln(10);
    }
}

// Initialize PDF object from the custom PDF class
$pdf = new PDF('L', 'mm', 'Legal');  // 'L' for landscape, 'mm' for millimeters, 'Legal' for paper size
$pdf->SetAutoPageBreak(true, 10); // Set auto page break with 10mm margin at the bottom
$pdf->AddPage();

// Set font for table headers
$pdf->SetFont('Arial', 'B', 8); // Reduced font size for headers to fit text
$pdf->SetFillColor(200, 220, 255);  // Light blue fill color for headers

// Table headers with line breaks manually inserted
$header = [
    'HOUSEHOLD HEAD', 
    'RELATION TO HOUSEHOLD HEAD', 
    'DATE OF BIRTH', 
    'AGE', 
    'SEX', 
    'CIVIL STATUS', 
    'OCCUPATION', 
    'EDUCATIONAL ATTAINMENT', 
    'REGISTERED VOTERS'
];

// Adjust column widths for landscape (Legal paper)
$colWidths = [45, 45, 45, 20, 20, 30, 30, 45, 30]; // Widths for each column, adjusted for Legal size

// Table header loop with line breaks for headers
$pdf->Cell($colWidths[0], 7, 'HOUSEHOLD HEAD', 1, 0, 'C', true);
$pdf->Cell($colWidths[1], 7, 'RELATION TO HOUSEHOLD HEAD', 1, 0, 'C', true);
$pdf->Cell($colWidths[2], 7, 'DATE OF BIRTH', 1, 0, 'C', true);
$pdf->Cell($colWidths[3], 7, 'AGE', 1, 0, 'C', true);
$pdf->Cell($colWidths[4], 7, 'SEX', 1, 0, 'C', true);
$pdf->Cell($colWidths[5], 7, 'CIVIL STATUS', 1, 0, 'C', true);
$pdf->Cell($colWidths[6], 7, 'OCCUPATION', 1, 0, 'C', true);
$pdf->Cell($colWidths[7], 7, 'EDUCATIONAL ATTAINMENT', 1, 0, 'C', true);
$pdf->Cell($colWidths[8], 7, 'REGISTERED VOTERS', 1, 0, 'C', true);
$pdf->Ln(); // New line after header row

// Set font for table content
$pdf->SetFont('Arial', '', 8); // Smaller font size for table rows to fit text

// Loop through households and display family data
foreach ($households as $houseNo => $members) {
    // First loop to show household head only once
    foreach ($members as $index => $member) {
        if ($member['head_fam'] === 'Yes') {
            // Check if the current position is too close to the bottom of the page, if so, add a page
            if ($pdf->GetY() > 250) {  // 250mm is a safe threshold before the bottom of a Legal page
                $pdf->AddPage();  // Add new page
                // Reprint header on the new page
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->SetFillColor(200, 220, 255);
                $pdf->Cell($colWidths[0], 7, 'HOUSEHOLD HEAD', 1, 0, 'C', true);
                $pdf->Cell($colWidths[1], 7, 'RELATION TO HOUSEHOLD HEAD', 1, 0, 'C', true);
                $pdf->Cell($colWidths[2], 7, 'DATE OF BIRTH', 1, 0, 'C', true);
                $pdf->Cell($colWidths[3], 7, 'AGE', 1, 0, 'C', true);
                $pdf->Cell($colWidths[4], 7, 'SEX', 1, 0, 'C', true);
                $pdf->Cell($colWidths[5], 7, 'CIVIL STATUS', 1, 0, 'C', true);
                $pdf->Cell($colWidths[6], 7, 'OCCUPATION', 1, 0, 'C', true);
                $pdf->Cell($colWidths[7], 7, 'EDUCATIONAL ATTAINMENT', 1, 0, 'C', true);
                $pdf->Cell($colWidths[8], 7, 'REGISTERED VOTERS', 1, 0, 'C', true);
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 8);
            }

            // Print row content
            $pdf->Cell($colWidths[0], 6, $member['fname'] . ' ' . $member['mname'] . ' ' . $member['lname'] . ' ' . $member['suffix'], 1);
            $pdf->Cell($colWidths[1], 6, '', 1); // Empty for 'Relation to Household Head'
            $pdf->Cell($colWidths[2], 6, $member['bday'], 1);
            $pdf->Cell($colWidths[3], 6, $member['age'], 1);
            $pdf->Cell($colWidths[4], 6, $member['gender'], 1);
            $pdf->Cell($colWidths[5], 6, $member['civil_status'], 1);
            $pdf->Cell($colWidths[6], 6, $member['occupation'], 1);
            $pdf->Cell($colWidths[7], 6, $member['education'], 1);
            $pdf->Cell($colWidths[8], 6, $member['voter'], 1);
            $pdf->Ln();
        }
    }

    // Loop through other family members
    foreach ($members as $index => $member) {
        if ($member['head_fam'] !== 'Yes') {
            // Print row content for non-head family members
            $pdf->Cell($colWidths[0], 6, '', 1); // Empty for 'Household Head'
            $pdf->Cell($colWidths[1], 6, $member['relation'], 1);
            $pdf->Cell($colWidths[2], 6, $member['bday'], 1);
            $pdf->Cell($colWidths[3], 6, $member['age'], 1);
            $pdf->Cell($colWidths[4], 6, $member['gender'], 1);
            $pdf->Cell($colWidths[5], 6, $member['civil_status'], 1);
            $pdf->Cell($colWidths[6], 6, $member['occupation'], 1);
            $pdf->Cell($colWidths[7], 6, $member['education'], 1);
            $pdf->Cell($colWidths[8], 6, $member['voter'], 1);
            $pdf->Ln();
        }
    }
}
// Add some vertical space before signatures
$pdf->Ln(20);

// Set font for signature lines
$pdf->SetFont('Arial', 'B', 10);

// Calculate positions for 4 signature fields
$pageWidth = $pdf->GetPageWidth();
$signatureWidth = 80;
$spacing = ($pageWidth - (4 * $signatureWidth)) / 5;
$y = $pdf->GetY();

// Add sample values for signature fields
$signatures = [
    'Respondent' => '_______________',
    'Purok Leader' => '_______________',
    'BRGY SECRETARY' => 'SHERLITA C. CALUDUCAN',
    'PUNONG BARANGAY' => 'EDWIN P. PARUNGAO'
];

// Draw sample values and labels for each signature field
for ($i = 0; $i < 4; $i++) {
    $x = ($spacing + $signatureWidth) * $i + $spacing;
    
    // Position for the name text (sample value)
    $pdf->SetXY($x, $y);
    $pdf->Cell($signatureWidth, 10, $signatures[array_keys($signatures)[$i]], 0, 0, 'C');
    
    // Position for the label text (slightly below the name)
    $pdf->SetXY($x, $y + 10);
    
    // Set the label text based on position
    $label = array_keys($signatures)[$i];
    
    $pdf->Cell($signatureWidth, 10, $label, 0, 0, 'C');
}
// End output buffering and clean it
ob_end_clean();

$filename = 'PUROK_' . strtoupper($purokss) . '_householdreport_' . date('Ymd') . '.pdf';

// Output the PDF with the generated filename
$pdf->Output('I', $filename);
?>
