<?php

$id = $_GET['id'];

// Assuming you have a connection to your database
$sqlQuery = "SELECT * FROM `land_cert` WHERE id = '$id'";
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
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body style="background-color: #e5e7eb; overflow: hidden;">
    <div style="display: flex; height: 100vh;">
      <main style="flex: 1; padding: 1.5rem; overflow-y: auto; margin-bottom: 1.5rem;">
        <div style="display: flex; justify-content: center;" id='printableArea'>
          <div style="position: relative; width: 816px; height: 1344px; background: white; overflow: hidden; font-family: 'Times New Roman', Times, serif;">
            <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; z-index: 0; opacity: 0.3;"></div>
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
                <div style="margin-top: 30px; text-align: center;">KASUNDUAN</div>
              </h1>
            </div>

            <div style="margin: 0 90px;">
              <div>DAPAT ALAMIN NG LAHAT:</div>

              <p style="text-align: justify; margin-top: 10px;">
                <span style="margin-left: 50px;"></span>
                Na kami, <b><u><?= $row['sellerName'] ?></u></b> may sapat na gulang, naninirahan sa <u style="word-spacing: 3px;"><?= $row['sellerAddress'] ?></u> bilang IKALAWANG PANIG ay kusang loob at Malaya na walang sinumang namilit o nanakot upang magbigay ng salaysay na gaya ng mga sumusunod:
              </p>

              <p style="text-align: justify; margin-top: 10px;">
                <span style="margin-left: 50px;"></span>
                NA, ako/kami <b><u><?= $row['sellerName'] ?></u></b> ay mayroong pag-aaring lupa na lalong makikilala sa sukat na humigit kumulang <b><u><?= $row['landArea'] ?></u></b> na matatagpuan sa <?= $row['propertySold'] ?> na nasasakupan ng Barangay NORTH POBLACION, GABALDON, NUEVA ECIJA. Na ang nabanggit na lupa sa itaas ay aming binenta at aming binibigyan ng karapatan si/sinya <b><?= $row['buyerName'] ?></b> upang kaniyang magamit sa anumang layuning legal kapalit ang halagang <b><u><?= $row['amount_words'] ?>( <?= $row['amount'] ?> )</u></b> na ibabayad ni <b><u><?= $row['buyerName'] ?></u></b>.
              </p>

              <p style="text-align: justify; margin-top: 10px;">
                <span style="margin-left: 50px;"></span>
                NA, ako/kami <b><u><?= $row['buyerName'] ?></u></b> ay nagbigay ng halagang <b><u><?= $row['amount_words'] ?>( <?= $row['amount'] ?> )</u></b> ngayon ika-<?= $day ?> ng <?= $filipinoMonth ?> <?= $year ?> bilang kabuuang kabayaran sa lupang binili na may kabuuang halaga na <b><u><?= $row['amount_words'] ?>( <?= $row['amount'] ?> ).</u></b>
              </p>

              <p style="text-align: justify; margin-top: 10px;">
                <span style="margin-left: 50px;"></span>
                NA, ako/kami <b><u><?= $row['sellerName'] ?></u></b> ay kusang loob na tinatanggap ang halagang <b><u><?= $row['amount_words'] ?>( <?= $row['amount'] ?> )</u></b> ngayon ika-<?= $day ?> ng <?= $filipinoMonth ?> <?= $year ?> bilang kabuang bayad ng <b><u><?= $row['amount_words'] ?>( <?= $row['amount'] ?> )</u></b> mula kay/kina <b><u><?= $row['buyerName'] ?>.</u></b>
              </p>

              <p style="text-align: justify; margin-top: 30px;">
                <span style="margin-left: 50px;"></span>
                Sa katunayan ng lahat ng ito kami ay lumagda ng aming mga pangalan sa ibaba nito ngayong <b><u>ika-<?= $day ?> NG <?= $filipinoMonth ?>, <?= $year ?></u></b> dito sa Barangay North Poblacion, Gabaldon, Nueva Ecija.
              </p>

              <div style="display: grid; grid-template-columns: 1fr 1fr; text-align: center; margin-top: 30px;">
                <div>
                  <div style="text-align: start;">
                    <b><u><?= $row['sellerName'] ?></u></b><br /><span style="margin-left: 50px;">Unang Panig</span>
                  </div>
                </div>
                <div>
                  <div style="text-align: end;">
                    <b><u><?= $row['buyerName'] ?></u></b><br /><span style="margin-right: 65px;">Ikalawang Panig</span>
                  </div>
                </div>
              </div>

              <div style="margin-top: 20px;">MGA SAKSI:</div>

              <div style="width: 350px; text-align: center; margin-top: 5px; margin-left: 10px;">
                <b>ROMMEL DL. DALACAT</b><br />
              </div>

              <p style="text-align: justify; margin-top: 20px;">
                <span style="margin-left: 50px;"></span>
                Nilagdaan at sinumpaan sa harap ko ngayong ika- <i><b><u><?= $day ?> ng <?= $filipinoMonth ?> <?= $year ?></u></b></i> dito sa Tanggapan ng Punong Barangay ng Barangay North Poblacion, Gabaldon, Nueva Ecija.
              </p>

              <div style="margin-top: 25px; margin-bottom: 10px;">Binigyang Pansin:</div>
              <div style="display: grid; grid-template-columns: 1fr 1fr; text-align: center; margin-top: 30px;">
                <div>
                  <div style="text-align: start;">
                    <b><u>EDWIN P. PARUNGAO</u></b><br /><span>Punong Barangay</span>
                  </div>
                </div>
                <div>
                  <div style="text-align: end;">
                    <b><u>ERNESTO SANTOS</u></b><br /><span style="margin-right: 30px;">BARC Chairman</span>
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
    function printDiv() {
        var printContents = document.getElementById('printableArea').innerHTML; // Use the correct ID
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
