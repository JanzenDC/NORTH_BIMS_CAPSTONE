<?php

$id = $_GET['id'];

// Assuming you have a connection to your database
$sqlQuery = "SELECT * FROM `livestock_cert` WHERE id = '$id'";
$result = mysqli_query($conn, $sqlQuery);
$row = mysqli_fetch_assoc($result); // Fetch the row data
$dateIssued = $row['date_of_pickup'];
$timestamp = strtotime($dateIssued);
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
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body style="background-color: #e5e7eb; overflow: hidden;">
    <div style="display: flex; height: 100vh;">
        <main style="flex: 1; padding: 1.5rem; overflow-y: auto;">
            <div style="display: flex; justify-content: center;" id='printableArea'>
                <div style="position: relative; width: 816px; height: 1344px; background: white; overflow: hidden; font-family: 'Times New Roman', Times, serif;">
                    <img src="../../assets/images/north.png" style="width: 125px; height: 125px; position: absolute; top: 100px; left: 80px;" />
                    <div style="display: flex; justify-content: center; margin-top: 120px; margin-bottom: 10px;">
                        <div style="text-align: center; font-size: 16px;">
                            Republika ng Pilipinas <br />Lalawigan ng Nueva Ecija <br />
                            Bayang ng Gabaldon <br />Barangay <span style="font-weight: bold;">NORTH POBLACION</span><br />
                        </div>
                    </div>
                    <div style="position: relative; height: 5px; width: 320px; margin: auto; display: flex; justify-content: center;">
                        <div style="position: absolute; top: 0; width: 100%; height: 2px; background: black;"></div>
                        <div style="position: absolute; bottom: 0; width: 100%; height: 2px; background: black;"></div>
                    </div>
                    <div style="display: flex; justify-content: center; margin-top: 8px;">
                        <h1 style="font-weight: bold; text-align: center;">
                            TANGGAPAN NG PUNONG BARANGAY
                            <div style="margin-top: 30px; text-align: center;">BILIHAN NG HAYOP</div>
                        </h1>
                    </div>

                    <div style="margin: 0 90px;">
                        <div>DAPAT ALAMIN NG LAHAT:</div>

                        <p style="text-align: justify; margin-top: 5px;">
                            <span style="margin-left: 50px;"></span>AKO,
                            <b><u><?= $row['sellerName'] ?></u></b> sapat ang gulang, Pilipino,
                            naninirahan sa NORTH POBLACION, bilang
                            <b>NAGBENTA,</b> alang-alang sa
                            <b><u><?= $row['amount_words'] ?> (<?= $row['amount'] ?>),</u></b> salaping
                            Pilipino, nasa akin ay ibinayad ni
                            <b><u><?= $row['buyerName'] ?></u></b> bilang <b>BUMILI,</b> sapat ang
                            gulang, Pilipino, naninirahan sa
                            <b>CUYAPA GABALDON Nueva Ecija</b> ay <b>NAGBIBILI</b> sa
                            nabanggit na <b>HAYOP,</b> na lalong makikilala sa pamamagitan
                            ng sumusunod na paglalarawan:
                        </p>

                        <div style="margin-left: 90px; margin-top: 30px;">
                            <b><u>[1] <?= $row['itemSold'] ?></u></b>
                            <br />Age:<b><u> <?= $row['age'] ?></u></b> Sex:<b><u> (1) <?= $row['sex'] ?></u></b>
                            <br />
                            Cowlicks: <u><?= $row['cowlicks'] ?></u>
                        </div>

                        <div style="text-align: center; margin-top: 10px;">
                            Brand of Municipality: <u><?= $row['brandMun'] ?></u> Brand of Owner:
                            <u><?= $row['brandOwn'] ?></u>
                        </div>
                        <p style="text-align: justify;">
                            <span style="margin-left: 50px;"></span>Ayon sa mga nagbilihan ay
                            wala pang hiro ang nasabing hayop at ang nakabili na lamang ang
                            magpapahiro.
                        </p>

                        <p style="text-align: justify; margin-top: 10px;">
                            <span style="margin-left: 50px;"></span>SA KATUNAYAN NG LAHAT,
                            kami ay lumagda sa itaas ng aming pangalan sa ibaba nito,
                            ngayong <b>ika-<?= $day ?> ng <?= $filipinoMonth ?>, 2024</b> dito sa Barangay North
                            Poblacion Bayan ng Gabaldon, Lalawigan ng Nueva Ecija, Republika
                            ng Pilipinas.
                        </p>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; text-align: center; margin-top: 50px;">
                            <div>
                                <div style="text-align: start;">
                                    <b><u><?= $row['sellerName'] ?></u></b><br /><span style="margin-left: 50px;">Nagbenta</span>
                                </div>
                            </div>
                            <div>
                                <div style="text-align: end;">
                                    <b><u><?= $row['buyerName'] ?></u></b><br /><span style="margin-right: 65px;">Bumili</span>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 20px;">Saksi:</div>
                         
                        <div style="width: 350px; text-align: center; margin-top: 30px;">   
                            <b>SHERLITA C. CALUDUCAN</b><br />
                            <span>Barangay Secretary</span>
                        </div>

                        <p style="text-align: justify; margin-top: 20px;">
                            <span style="margin-left: 50px;"></span>
                            Nilagdaan at sinumpaan sa harap ko ngayong <b>ika-<?= $day ?> ng <?= $filipinoMonth ?>, 2024,</b> dito sa Tanggapan ng Punong Barangay ng Barangay North Poblacion, Gabaldon, Nueva Ecija.
                        </p>

                        <div style="margin-top: 25px; margin-bottom: 25px;">PATUNAY:</div>
                        <div>
                            <b><u>EDWIN P. PARUNGAO</u></b><br />
                            Punong Barangay
                        </div>
                    </div>
                </div>
            </div>
        </main>
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
