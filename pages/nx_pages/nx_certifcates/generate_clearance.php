<?php

$id = $_GET['id'];

// QUERY
$sqlQuery = "SELECT * FROM clearance_cert WHERE id = '$id'";
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
</head>
<body style="background-color: rgb(229, 231, 235); overflow: hidden;">
    <div style="display: flex; height: 100vh;" >
     <main style="flex: 1; padding: 1.5rem; overflow-y: auto; margin-bottom: 1.5rem;">
        <div style="display: flex; justify-content: center;" id='contents'>
            <div class="document" style="position: relative; width: 816px; height: 1344px; background: white; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); display: flex; align-items: center; justify-content: center;">
                <div class="border1" style="display: flex; align-items: center; height: 94%; width: 92%; justify-content: center; border: 1px solid #006400;">
                <div class="border2" style="display: flex; align-items: center; height: 99.9%; width: 99.9%; justify-content: center; border: 4px solid #006400;">
                <div class="border3" style="border: 1px solid #006400; height: 99.8%; width: 99.5%;">
                    <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; z-index: 0; opacity: 0.3;">
                        <div style="width: 500px; height: 500px; background: url('../../assets/images/north.png') no-repeat center; background-size: contain; opacity: 0.2; z-index: 0;"></div>
                    </div>
               
                    <div style="font-family: 'Times New Roman', Times, serif; z-index: 1;">
                        <img src="../../assets/images/north.png" style="position: absolute; top: 80px; left: 80px; width: 125px; height: 125px;">
                        <div style="text-align: center; margin-top: 2.5rem;">
                            <div style="font-size: 14px; letter-spacing: -0.5px;">Republic Of the Philippines<br>Provice of Nueva Ecija<br>Municipality of Gabaldon <br><span style="font-weight: bold;">Barangay North Poblacion</span></div>
                            <div style="font-size: 14px; font-family: 'Dancing Script'; margin-top: 50px; font-weight: bold; letter-spacing: -0.5px;">Office of the Punong Barangay <br><span style="font-weight: bold;">BARANGAY CLEARANCE</span> <br><span>BC No. <span><u><?= $row['bcNo'] ?></u></span></span></div>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 0.8fr 2fr; margin-top: 1.5rem;">
                            <div style="margin-left: 5px;">
                                <div style="background-color: rgb(243, 244, 246); padding-top: 3px; padding-bottom: 50px;">
                                    <div style="text-align: center; font-weight: bold; background-color: #d6e3bc; margin: 1px; font-size: 15px;">
                                        BARANGAY OFFICIALS <br>2024
                                        <div style="margin-top: 30px;">EDWIN P. PARUNGAO <br><i style="font-weight: normal;">Punong Barangay</i></div>
                                        <div style="margin-top: 30px;">JEORGE C. BUCANEG <br><i style="font-weight: normal;">Committee on Education</i></div>
                                        <div style="margin-top: 30px;">JOEY L. ORDONEZ <br><i style="font-weight: normal;">Committee on Peace and Order</i></div>
                                        <div style="margin-top: 30px;">RODRIGO P. DANAO JR. <br><i style="font-weight: normal;">Committee on Agriculture</i></div>
                                        <div style="margin-top: 30px;">ENGRACIA G. SUMAWANG <br><i style="font-weight: normal;">Committee on Health</i></div>
                                        <div style="margin-top: 30px;">JEFREY MORENO <br><i style="font-weight: normal;">Committee on Intra.</i></div>
                                        <div style="margin-top: 30px;">ROMMEL DALACAT<br><i style="font-weight: normal;">Committee on Transpo.</i></div>
                                        <div style="margin-top: 30px;">MA. VICTORIA DIOZON<br><i style="font-weight: bold;">SK Chairperson</i></div>
                                        <div style="margin-top: 30px;">NELSON G. VILLACILLO<br><i style="font-weight: normal;">Barangay Treasurer</i></div>
                                        <div style="margin-top: 30px;"><u>SHERLITA CALUDUCAN</u><br><i style="font-weight: normal;">Barangay Secretary</i></div>
                                        <div style="margin-top: 30px;"><u>ROSEMARIE O. GARCIA</u><br><i style="font-weight: normal;">Barangay Clerk</i></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div style="margin-right: 15px;">
                                <div style="font-size: 13px; margin-top: 20px;">TO WHOM IT MAY CONCERN:</div>
                                <div style="margin-top: 20px; font-size: 13px; word-spacing: 10px;">
                                    This is to certify that <u style="font-weight: bold;">&nbsp;<?= $fullname ?>, <span style="font-size: 14px; font-weight: bold;"><?= $row['age'] ?> years old&nbsp;,</span></u></span><span>&nbsp;,</span>
                                    <br><span style="font-weight: bold; font-size: 13px;">Single/Married/widow/widower</span> a bonafide resident of<span><i style="font-weight: bold; font-size: 13px; word-spacing: 1px;"> Barangay North Poblacion, <u>Gabaldon</u> Nueva Ecija,</i></span>
                                </div>
                                
                                <div style="margin-top: 40px; word-spacing: 2.5px;">
                                    This is to certify that <u style="font-weight: bold;">&nbsp;<?= $fullname ?></u> has no derogatory record on file of Barangay <i><u style="font-weight: bold;">North Poblacion,</u></i>, Gabaldon, Nueva Ecija.
                                </div>
                                
                                <div style="margin-top: 24px; font-size: 13px; word-spacing: 2px;">
                                    This is certification is issued upon request of the above-mentioned person for: <br>
                                    <div style="margin-left: 60px;">
                                        <?= $row['purpose'] ?>
                                    </div>
                                </div>

                                <div style="margin-top: 25px;">
                                    Effectively of this certification is valid only for <u>Ninety (90) Days</u><br>
                                    From date of issuance and after its expiration is null and void.
                                </div>

                                <div style="margin-top: 20px;">
                                    Done in Barangay <i style="font-weight: bold;"><u>North Poblacion</u></i> Hall this <?= $day ?> <sup><?= $suffix ?></sup> Day of <?= $month ?> <?= $year ?>
                                </div>

                                <div style="display: flex; justify-content: flex-end; margin-top: 20px; margin-right: 30px;">
                                    <table style="border-collapse: collapse;">
                                        <tr style="text-align: center; font-size: 13px;">
                                            <td style="padding: 0 15px; border: 1px solid black;">Left Thumb mark</td>
                                            <td style="padding: 0 15px; border: 1px solid black;">Right Thumb mark</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 80px; border: 1px solid black;"></td>
                                            <td style="height: 80px; border: 1px solid black;"></td>
                                        </tr>
                                    </table>
                                </div>

                                <div style="margin-top: 15px; font-size: 13px;">
                                    <u style="font-weight: bold;"><?= $fullname ?></u><br>
                                    Signature Of Applicant

                                    <div style="margin-top: 10px;">
                                        Res. Cert: <?= $row['clearanceNo'] ?><br>
                                        Date Issue: <?= $row['date_issued'] ?><br>
                                        <span style="font-weight: bold;">Issued at: Gabaldon, Nueva Ecija</span>
                                    </div>

                                    <div style="text-align: center; position: absolute; bottom: 320px; right: 150px;">
                                        NOT VALID<br>WITHOUT<br>DRY<br>SEAL
                                    </div>

                                    <div style="display: grid; grid-template-columns: 1fr 1fr; margin-top: 50px;">
                                        <div>
                                            Attested by:
                                            <div style="margin-top: 50px;">
                                                <u style="font-weight: bold;">ROSEMARIE O. GARCIA</u><br>
                                                Barangay Secretary/Clerk
                                            </div>
                                        </div>
                                        <div>
                                            <span>Approved by:</span>
                                            <div style="margin-top: 50px;">
                                                <u style="font-weight: bold;">HON. EDWIN P. PARUNGAO</u><br>
                                                Barangay Captain
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
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
