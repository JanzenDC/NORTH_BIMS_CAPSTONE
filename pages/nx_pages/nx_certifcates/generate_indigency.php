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

// Determine the suffix for the day
$suffix = 'th';
if ($day % 10 == 1 && $day % 100 != 11) {
    $suffix = 'st';
} elseif ($day % 10 == 2 && $day % 100 != 12) {
    $suffix = 'nd';
} elseif ($day % 10 == 3 && $day % 100 != 13) {
    $suffix = 'rd';
}
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

                <div style="margin: 85px 100px 0 100px; line-height: 2;">
                    <h1>TO WHOM IT MAY CONCERN:</h1>
                    <div style="word-spacing: 5.5px;"><span style="margin-left: 50px;"></span>This is to certify that <b><?= $fullname ?>, <?= $row['age'] ?> years old</b> resident of Purok Banaba, Barangay North Poblacion, Gabaldon, Nueva Ecija.</div>
                    <div style="word-spacing: 5.5px; margin-top: 20px;"><span style="margin-left: 50px;"></span>This further certifies that <b><?= $fullname ?>,</b> the above-named person belongs to indigent families as per record kept in this Barangay.</div>
                    <div style="word-spacing: 5.5px; margin-top: 20px;"><span style="margin-left: 50px;"></span>This certification is issued upon request of <b><?= $fullname ?>,</b> for medical assistance purposes and for whatever legal purposes it may serve.</div>
                    <div style="word-spacing: 5.5px; margin-top: 20px;"><span style="margin-left: 50px;"></span>Given this <?= $day ?><sup><?= $suffix ?></sup> day of <?= $month ?>, <?= $year ?>, here at Barangay North Poblacion, Gabaldon, Nueva Ecija.</div>
                </div>

                <div style="margin-top: 40px;">
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