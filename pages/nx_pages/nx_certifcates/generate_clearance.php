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
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
</head>
<body class="bg-gray-200 overflow-hidden" >

    <div id='capture'>
        <main class="flex-1 b p-6 overflow-y-auto mb-6 " >
            <div class="flex justify-center" >
                <div class="document shadow-md flex items-center h-full justify-center">
                    
                    <div class="border1 flex items-center h-full justify-center">
                    <div class="border2 flex items-center h-full justify-center">
                    <div class="border3 ">
                    <!-- Background Image Div -->
                <div class="absolute inset-0 flex items-center justify-center z-0 opacity-30">
                    <div class="background-image"></div>
                </div>

                    <div class="content">
                    <img src="../../assets/images/north.png" class="w-[125px] h-[125px] logo">
                        <div class="text-center mt-10" >
                            <div class="text-[14px]" style="letter-spacing:-0.5px;">Republic Of the Philippines<br>Provice of Nueva Ecija<br>Municipality of Gabaldon <br><span class="font-bold">Barangay North Poblacion</span></div>
                            <div class="text-[14px] cursive-font mt-[50px] font-bold" style="letter-spacing:-0.5px;" >Office of the Punong Barangay <br><span class="font-bold">BARANGAY CLEARANCE</span> <br><span>BC No. <span><u><?= $row['bcNo'];?></u></span></span></div>
                            
                        </div>
                    <div class="grid grid-cols-1 lg:grid-cols-[0.8fr_2fr]  mt-6" >
                        <div class="barangay-officials  ml-[5px]">
                            <div class="bg-gray-100 pt-[3px] pb-[50px]">
                            <div class="text-center font-bold bg-[#d6e3bc] m-1px text-[15px]">
                                BARANGAY OFFICIALS <br>2024
                                <div class="mt-[30px] ">EDWIN P. PARUNGAO <br><i class="font-normal">Punong Barangay</i></div>
                                <div class="mt-[30px] ">JEORGE C. BUCANEG <br><i class="font-normal">Committee on Education</i></div>
                                <div class="mt-[30px] ">JOEY L. ORDONEZ <br><i class="font-normal">Committee on Peace and Order</i></div>
                                <div class="mt-[30px] ">RODRIGO P. DANAO JR. <br><i class="font-normal">Committee on Agriculture</i></div>
                                <div class="mt-[30px] ">ENGRACIA G. SUMAWANG <br><i class="font-normal">Committee on Health</i></div>
                                <div class="mt-[30px] ">JEFREY MORENO <br><i class="font-normal">Committee on Intra.</i></div>
                                <div class="mt-[30px] ">ROMMEL DALACAT<br><i class="font-normal">Committee on Transpo.</i></div>
                                <div class="mt-[30px] "> MA. VICTORIA DIOZON<br><i class="font-bold">SK Chairperson</i></div>
                                <div class="mt-[30px] ">NELSON G. VILLACILLO<br><i class="font-normal">Barangay Treasurer</i></div>
                                <div class="mt-[30px] "> <u>SHERLITA CALUDUCAN</u> <br><i class="font-normal">Barangay Secretary</i></div>
                                <div class="mt-[30px] "> <u>ROSEMARIE O. GARCIA</u> <br><i class="font-normal">Barangay Clerk</i></div>
                            </div>
                        </div>
                            
                        </div>
                        <div class="mr-[15px]">
                        <div class="text-[13px] mt-[20px]">TO WHOM IT MAY CONCERN:</div>
                        <div class="mt-[20px] text-[13px]" style="word-spacing:10px;"> This is to certify that <u class="font-bold">&nbsp;<?= $fullname ?> <span class="text-[14px] font-bold"><?= $row['age'] ?>&nbsp;,</span></u></span><span> &nbsp;,</span> <br> <span class="font-bold text-[13px]">Single/Married/widow/widower</span> a bonafide resident of<span><i class="font-bold text-[13px]" style="word-spacing:1px;"> Barangay North Poblacion, <u>Gabaldon</u>  Nueva Ecija,</i></span> 
                            <div class="mt-[40px] " style="word-spacing:2.5px;">
                                This is to certify that <u class="font-bold">&nbsp;<?= $fullname ?></u> has no derogatory record on file of Barangay <i><u class="font-bold">North Poblacion,</u></i>, Gabaldon, Nueva Ecija.
                            </div>
                            <div class="mt-[24px] text-[13px]" style="word-spacing:2px;">
                            This is certification is issued upon request of the above-mentioned person for: <br>
                            <div class="ml-[60px]">
                                <?= $row['purpose'] ?>
                            </div>

                            <div class="mt-[25px]">
                            Effectively of this certification is valid only for <u> Ninety (90) Days</u> <br> From date of issuance and after its expiration is null and void.
                            </div>

                        <div class="mt-[20px] relative">Done in Barangay <i class="font-bold"><u>North Poblacion</u></i> Hall this <?= $day ?><span class='absolute -top-1'><?= $suffix ?></span><span class='ms-6'>on <?= $month ?> <?= $year ?>.</span></div>

                        </div>
                    
                        </div>
                        <div class="flex justify-end mt-[20px] mr-[30px]">
                            <table >
                                <tr class="text-center text-[13px]" >
                                    <td class="px-[15px]">Left Thumb mark</td>
                                    <td class="px-[15px]">Right Thumb mark</td>
                                </tr>
                                <tr>
                                    <td class="h-[80px]"></td>
                                    <td class="h-[80px]"></td>
                                </tr>
                            </table>
                        </div>

                        <div class="mt-[15px] text-[13px]">
                        <u class="font-bold "><?= $fullname ?></u> <br>
                        Signature Of Applicant

                        <div class="mt-[10px]">
                        Res. Cert: <?= $row['clearanceNo']  ?> <br>
                        Date Issue : <?= $row['date_issued'] ?> <br>
                        <span class="font-bold">Issued at : Gabaldon, Nueva Ecija</span> <div class="text-center flex justify-end" style="position:absolute; bottom:320px; right:150px;" >NOT VALID <br>WITHOUT <br>DRY <br>SEAL</div>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2  mt-[50px] flex">
                            <div>
                            Attested by:
                            <div class="mt-[50px]">
                            <u class="font-bold">ROSEMARIE O. GARCIA </u> <br>
                            Barangay Secretary/Clerk 
                            </div>
                            </div>
                            <div>
                            <span>Approved by:</span>
                            <div class="mt-[50px]">
                            <u class="font-bold">HON. EDWIN P. PARUNGAO </u> <br>
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
    </div>
</body>
</html>

<style>

    .document {
      position: relative; /* Position relative to allow absolute positioning of the overlay */
      width: 816px;
      height: 1344px;
     background: white; /* Fallback background color */
     overflow: hidden; /* Prevents overflow */
    }

    /* Background image settings */
    .background-image {
        width: 500px;
        height: 500px;
        background: url('../../assets/images/north.png') no-repeat center;
        background-size: contain;
        opacity: 0.2;
        z-index: 0;
    }

.border1{
    border: 1px solid #006400;
    height:94%;
    width:92%;
}
.border2{
    border: 4px solid #006400;
    height:99.9%;
    width:99.9%;
}
.border3{
    border: 1px solid #006400;
    height:99.8%;
    width:99.5%;
}

.logo{
    position:absolute;
    top:80px;
    left:80px;
    
}

.content {
    font-family: "Times New Roman", Times, serif;
        z-index:1 !important;
}
.cursive-font {
     font-family: 'Dancing Script';
}

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
