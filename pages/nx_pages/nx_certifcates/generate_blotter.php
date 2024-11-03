<?php

$id = $_GET['id'];

// Assuming you have a connection to your database
$sqlQuery = "SELECT * FROM tblblotter WHERE id = '$id'";
$result = mysqli_query($conn, $sqlQuery);
$row = mysqli_fetch_assoc($result); // Fetch the row data

$dateIssued = $row['date'];
$timestamp = strtotime($dateIssued);

// Get the day, month, and year
$day = date('j', $timestamp);
$year = date('Y', $timestamp);

// Get the day of the week
$dayOfWeek = date('l', $timestamp); // Full day name (e.g., "Wednesday")

// Map the English day names to Filipino equivalents
$daysInFilipino = [
    "Monday" => "LUNES",
    "Tuesday" => "MARTES",
    "Wednesday" => "MIYERKULES",
    "Thursday" => "HUWEBES",
    "Friday" => "Biyernes",
    "Saturday" => "SABADO",
    "Sunday" => "LINGGO"
];

$filipinoDay = $daysInFilipino[$dayOfWeek];

// Map the English month names to Filipino equivalents
$monthsInFilipino = [
    "January" => "Enero",
    "February" => "Pebrero",
    "March" => "Marso",
    "April" => "Abril",
    "May" => "Mayo",
    "June" => "Hunyo",
    "July" => "Hulyo",
    "August" => "Agosto",
    "September" => "Setyembre",
    "October" => "Oktubre",
    "November" => "Nobyembre",
    "December" => "Disyembre"
];

$month = date('F', $timestamp);
$filipinoMonth = $monthsInFilipino[$month];

// Fetch supporting details from tblblotter_pagpapatunay
$supportingDetails = []; // An array to hold supporting details
$supportingQuery = "SELECT * FROM tblblotter_pagpapatunay WHERE id = '$id'";
$supportingResult = mysqli_query($conn, $supportingQuery);

while ($detail = mysqli_fetch_assoc($supportingResult)) {
    $supportingDetails[] = $detail['descriptionn']; // Store the descriptions
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        body {
            background-color: rgb(229, 231, 235);
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: auto;
            border: 1px solid black;
            padding: 32px;
            max-height: 90vh; /* Set maximum height for scrolling */
            overflow-y: auto; /* Enable vertical scrolling */
            background: white;
        }
        .center {
            text-align: center;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="container" id="printableArea">
        <div style="display: flex; align-items: center; margin-bottom: 32px; margin-left: 50px;">
            <img alt="Barangay North Poblacion Logo" height="100" src="../../assets/images/north.png" width="100" style="margin-right: 16px;"/>
            <div style="text-align: center;">
                <p style="font-size: 14px;">Republika ng Pilipinas</p>
                <p style="font-size: 14px;">Lalawigan ng Nueva Ecija</p>
                <p style="font-size: 14px;">Bayan ng Gabaldon</p>
                <p style="font-size: 14px;">Barangay North Poblacion</p>
                <h1 style="font-size: 18px; font-weight: bold; margin-top: 16px;">TANGGAPAN NG LUPONG TAGAPAMAYAPA</h1>
            </div>
        </div>

        <div>
            <p style="font-weight: bold;"><?= $row['complainant'] ?></p>
            <p>(Nagsusumbong)</p>
            <p style="margin-top: 16px;">Laban Kay:</p>
            <p style="font-weight: bold;"><?= $row['personToComplaint'] ?></p>
            <p>(Inireklamo)</p>

            <div style="text-align: right; margin-top: 16px;">
                <p style="margin: 0;">(Ipinagsusumbong)</p>
                <p style="margin: 0;">Para sa:</p>
                <p style="font-weight: bold; margin: 0;"><?= $row['complaint'] ?></p>
            </div>
            
            <div class="center">
                <h2 style="font-size: 18px; font-weight: bold;">PAGPAPATUNAY PARA MAGHAIN NG FORMAL NA SAKDAL</h2>
                <p>(Certificate to File Action)</p>
            </div>
            
            <p style="font-weight: bold;">ITO AY PAGPAPATUNAY:</p>
            <ol style="list-style-type: decimal; padding-left: 20px;">
                <?php
                // Check if there are supporting details
                if (!empty($supportingDetails)) {
                    $counter = 1; // Initialize the counter
                    foreach ($supportingDetails as $detail) {
                        echo "<li>$counter. $detail</li>"; // Display each supporting detail with the counter
                        $counter++; // Increment the counter
                    }
                } else {
                    echo "<li>Walang mga detalye na magagamit.</li>"; // Message for no details
                }
                ?>
            </ol>


            <p>Ngayong ika-<?= $day ?> ng <?= $filipinoMonth ?>, araw ng <?= $filipinoDay ?> <?= $year ?>.</p>
        </div>

        <div style="margin-bottom: 32px;">
            <p style="margin-bottom: 32px;">Inihanda ni:</p>
            <div style="display: flex; align-items: center;">
                <div>
                    <p style="font-weight: bold;">SHERLITA CATUDUCAN</p>
                    <p>Lupon Secretary</p>
                </div>
            </div>
        </div>
        <div style="margin-bottom: 150px;">
            <p style="font-weight: bold;">NAGPAPATUNAY:</p>
            <p style="font-weight: bold;">KGG. EDWIN P. PARUNGAO</p>
            <p>Lupon Chairman</p>
        </div>
    </div>
</body>
</html>

<script>
    function printDiv() {
        var printContents = document.getElementById('printableArea').innerHTML; // Use the correct ID
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
