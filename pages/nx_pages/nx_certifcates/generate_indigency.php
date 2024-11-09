<?php

$id = $_GET['id'];

// QUERY
$sqlQuery = "SELECT * FROM indigency_cert WHERE id = '$id'";
$result = mysqli_query($conn, $sqlQuery);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $fullname = $row['fname'] . " " . $row['mname'] . " " . $row['lname'];
}

$dateIssued = $row['date_issued'];
$timestamp = strtotime($dateIssued);

// Get the day, month, and year
$day = date('j', $timestamp); // Day without leading zeros
$month = date('F', $timestamp); // Full month name
$year = date('Y', $timestamp); // Full year

// Tagalog month translations
$months = [
    'January' => 'Enero',
    'February' => 'Pebrero',
    'March' => 'Marso',
    'April' => 'Abril',
    'May' => 'Mayo',
    'June' => 'Hunyo',
    'July' => 'Hulyo',
    'August' => 'Agosto',
    'September' => 'Setyembre',
    'October' => 'Oktubre',
    'November' => 'Nobyembre',
    'December' => 'Disyembre'
];

// Convert day number to Tagalog words
function convertDayToTagalog($day) {
    $tagalogNumbers = [
        1 => 'isa', 2 => 'dalawa', 3 => 'tatlo', 4 => 'apat', 5 => 'lima', 6 => 'anim', 7 => 'pito', 8 => 'walo', 9 => 'siyam',
        10 => 'sampu', 11 => 'labing isa', 12 => 'labindalawa', 13 => 'labintatlo', 14 => 'labing apat', 15 => 'labing lima',
        16 => 'labing anim', 17 => 'labimpito', 18 => 'labing walo', 19 => 'labingsiyam', 20 => 'dalawampu', 21 => 'dalawampu’t isa',
        22 => 'dalawampu’t dalawa', 23 => 'dalawampu’t tatlo', 24 => 'dalawampu’t apat', 25 => 'dalawampu’t lima', 26 => 'dalawampu’t anim',
        27 => 'dalawampu’t pito', 28 => 'dalawampu’t walo', 29 => 'dalawampu’t siyam', 30 => 'tatlumpu', 31 => 'tatlumpu’t isa'
    ];

    // Convert the day to Tagalog words if it exists in the array
    return isset($tagalogNumbers[$day]) ? $tagalogNumbers[$day] : $day;
}
$suffix = 'th';
if ($day % 10 == 1 && $day % 100 != 11) {
    $suffix = 'st';
} elseif ($day % 10 == 2 && $day % 100 != 12) {
    $suffix = 'nd';
} elseif ($day % 10 == 3 && $day % 100 != 13) {
    $suffix = 'rd';
}
$dayInWords = convertDayToTagalog($day);

// Translate the month to Tagalog
$monthTagalog = isset($months[$month]) ? $months[$month] : $month;
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="background-color: #e5e7eb; overflow: hidden;">
    <div style="display: flex; height: 100vh;">
     <main style="flex: 1; padding: 1.5rem; overflow-y: auto; margin-bottom: 1.5rem;">
        <div style="display: flex; justify-content: center;" id='contents'>
            <div style="position: relative; width: 816px; height: 1056px; background-color: white; overflow: hidden; font-family: 'Times New Roman', Times, serif;"> 
                <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; z-index: 0; opacity: 0.3;">
                    <div style="width: 790px; height: 790px; background: url('../../assets/images/north.png') no-repeat center; background-size: contain;"></div>
                </div>
                <img src="../../assets/images/north.png" style="position: absolute; top: 100px; left: 80px; width: 125px; height: 125px;">
                <div style="display: flex; justify-content: center; margin-top: 120px;">
                    <div style="font-size: 16px; text-align: center;">Republic of the Philippines <br>Barangay <span style="font-weight: 600;">NORTH POBLACION </span><br>Gabaldon, Nueva Ecija</div>
                </div>
                <div style="position: relative; height: 5px; width: 320px; margin: 0 auto; display: flex; justify-content: center;">
                    <div style="position: absolute; top: 0; width: 100%; height: 2px; background: black;"></div>
                    <div style="position: absolute; bottom: 0; width: 100%; height: 2px; background: black;"></div>
                </div>
                <div style="display: flex; justify-content: center; margin-top: 8px;">
                    <h1 style="font-weight: 600;">OFFICE OF THE PUNONG BARANGAY 
                        <div style="margin-top: 30px; text-align: center;">BARANGAY INDIGENCY</div>
                    </h1>
                </div>

                <div style="margin: 85px 100px 0 100px;">
                    <h1>TO WHOM IT MAY CONCERN:</h1>
                    <div style="word-spacing: 5.5px;"><span style="margin-left: 50px;"></span>This is to certify that <b>MARICAR SOMERA, 43 years old</b> resident of Purok Banaba,</div>
                    <div style="word-spacing: 5.5px; margin-top: 20px;"><span style="margin-left: 50px;"></span>Barangay North Poblacion, Gabaldon, Nueva Ecija. This further certify that <b>MARICAR SOMERA,</b> the above name person belongs to indigent families as per record kept in this Barangay.</div>
                    <div style="word-spacing: 5.5px; margin-top: 20px;"><span style="margin-left: 50px;"></span>This certification is issued upon request of <b>MARICAR SOMERA,</b> for medical assistance purposes and for whatever legal purposes it may serve.</div>

                    <div style="word-spacing: 5.5px; margin-top: 20px;"><span style="margin-left: 50px;"></span>Given this <?= $day ?><sup><?= $suffix ?></sup> day of <?= $month ?>, <?= $year ?>, here at Barangay North Poblacion, Gabaldon, Nueva Ecija.</div>
                </div>



                <div>
                    <div style="text-align: center; margin-left: 50px;">Prepared by:</div>
                    <div style="margin-top: 20px; margin-left: 300px; font-weight: bold; line-height: 1.2;">SHERLITA C. CALUDUCAN<br><span style="font-weight: normal;">Barangay Secretary</span></div>
                </div>

                <div style="text-align: center; margin-left: 50px;">Certified by:</div>
                <div style="margin-top: 20px; margin-left: 300px; font-weight: bold; line-height: 1.2;">HON. EDWIN P. PARUNGAO<br><span style="font-weight: normal;">Punong Barangay</span></div>

                <div style="text-align: start; font-size: 11.5px; margin-left: 100px;">
                    <i style="font-weight: bold; text-align: center;">NOT VALID<br>WITHOUT<br>DRY SEAL</i>
                </div>
            </div>
        </div>
     </main>
    </div>
</body>
</html>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(
            divName).innerHTML;
        var originalContents = document.body
            .innerHTML;
        console.log(printContents)
        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>