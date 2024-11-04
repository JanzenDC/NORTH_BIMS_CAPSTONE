<?php

$id = $_GET['id'];

// Assuming you have a connection to your database
$sqlQuery = "SELECT * FROM `vehicle_cert` WHERE id = '$id'";
$result = mysqli_query($conn, $sqlQuery);
$row = mysqli_fetch_assoc($result); // Fetch the row data
$dateIssued = $row['date'];
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
        <main style="flex: 1; padding: 24px; overflow-y: auto;">
            <div style="display: flex; justify-content: center;" id='printableArea'>
                <div style="position: relative; width: 816px; height: 1344px; background: white; overflow: hidden; font-family: 'Times New Roman', Times, serif;">
                    <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; opacity: 0.3;">
                        <div style="width: 430px; height: 430px; background: url('./assets/images/north.png') no-repeat center; background-size: contain;"></div>
                    </div>
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
                            <div style="margin-top: 30px; text-align: center;">BILIHAN NG MOTOR</div>
                        </h1>
                    </div>

                    <div style="margin: 0 90px;">
                        <div>DAPAT ALAMIN NG LAHAT:</div>

                        <p style="text-align: justify; margin-top: 5px; word-spacing: -1px;">
                            <span style="margin-left: 50px;"></span>AKO, <b><?= $row['sellerName'] ?></b>, sapat ang gulang, Pilipino at naninirahan sa <?= $row['sellerAddress'] ?>, bilang <b><u>NAGBENTA,</u></b> alang-alang sa halangang <b><u><?= $row['amount_words'] ?> (<?= $row['amount'] ?>)</u></b> salaping Pilipino na sa akin ay ibinayad ni <b><u><?= $row['buyerName'] ?></u></b>, sapat ang gulang, Pilipino, <?= $row['buyerAddress'] ?> bilang <b><u>BUMILI</u></b> ay <b>NAGBIBILI, NAGLILIPAT AT NAGSASALIN,</b> sa isang sasakyan, na lalong makikilala sa pamamagitan ng sumusunod na paglalarawan:
                        </p>

                        <div style="display: flex; justify-content: center; margin-top: 30px;">
                            <div style="margin-right: 60px; max-width: 300px; text-align: start;">
                                MAKE:<br>
                                PLATE NUMBER:<br>
                                ENGINE NUMBER:<br>
                                CHASIS NUMBER:<br>
                                DENOMINATION:<br>
                                FUEL:<br>
                                BODY TYPE:<br>
                                CR No.:
                            </div>
                            <div style="margin-left: 90px; max-width: 300px;">
                                <?= $row['make'] ?><br>
                                <?= $row['plateNum'] ?><br>
                                <?= $row['engineNum'] ?><br>
                                <?= $row['chasisNum'] ?><br>
                                <?= $row['denomination'] ?><br>
                                <?= $row['fuel'] ?><br>
                                <?= $row['bodyType'] ?><br>
                                <?= $row['crNo'] ?>
                            </div>
                        </div>

                        <p style="text-align: justify;">
                            <span style="margin-left: 50px;"></span>Na aking pinatutunayan sa nabanggit na si, na AKO <b><u><?= $row['buyerName'] ?></u></b> ang bago at lubos na nagmamay-ari ng sasakyang sinasaysay sa itaas, na ligtas sa anumang sagutin o pananagutan sa sinumang tao o samahan. Ngayong Ika- <b><u><?= $day ?></u></b> ng <b><u><?= $filipinoMonth ?>,</u></b> <?= $year ?>.
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

                        <div style="margin-top: 20px;">Mga Saksi:</div>
                         
                        <div style="width: 350px; display: flex; align-items: center; margin-left: 80px; margin-top: 10px;">   
                            <b style="margin-right: 50px;">Sherlita Caluducan</b>
                            <b>Rosemarie O. Garcia</b>
                        </div>

                        <p style="text-align: justify; margin-top: 20px;">
                            <span style="margin-left: 50px;"></span>Nilagdaan at sinumpaan sa harap ko ngayong Ika- <b><u><?= $day ?></u></b> ng <b><u><?= $filipinoMonth ?>,</u></b> <?= $year ?>, dito sa Tanggapan ng Punong Barangay ng Barangay North Poblacion, Gabaldon, Nueva Ecija.
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
