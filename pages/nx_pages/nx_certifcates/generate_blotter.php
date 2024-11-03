<?php

$id = $_GET['id'];

// QUERY
$sqlQuery = "SELECT * FROM tblblotter WHERE id = '$id'";
$result = mysqli_query($conn, $sqlQuery);


$dateIssued = $row['date'];
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
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <body style="background-color: rgb(229, 231, 235); overflow: hidden; font-family: 'Times New Roman', Times, serif;">
    <div style="display: flex; height: 100vh;">
      <main style="flex: 1; padding: 1.5rem; overflow-y: auto; margin-bottom: 1.5rem;">
        <div style="display: flex; justify-content: center;">
          <div style="position: relative; width: 816px; height: 1056px; background: white; overflow: hidden;">
            <div style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; z-index: 0; opacity: 0.3;">
              <div style="width: 790px; height: 790px; background: url('../../assets/images/north.png') no-repeat center; background-size: contain; opacity: 0.3; z-index: 0;"></div>
            </div>
            
            <img src="../../assets/images/north.png" style="position: absolute; top: 100px; left: 80px; width: 125px; height: 125px;" />
            
            <div style="display: flex; justify-content: center; margin-top: 120px;">
              <div style="font-size: 16px; text-align: center;">
                Republic of the Philippines <br />Barangay
                <span style="font-weight: 600;">NORTH POBLACION </span><br />Gabaldon, Nueva Ecija
              </div>
            </div>
            
            <div style="width: 320px; margin: 0 auto; display: flex; justify-content: center; position: relative; height: 5px;">
              <div style="position: absolute; top: 0; width: 100%; height: 2px; background: black;"></div>
              <div style="position: absolute; bottom: 0; width: 100%; height: 2px; background: black;"></div>
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