<?php
require '../db_connect.php';

function getSelectedMonth() {
    $selected_month = isset($_POST['month']) ? $_POST['month'] : date('Y-m');
    return DateTime::createFromFormat('Y-m', $selected_month) ? $selected_month : date('Y-m');
}

function fetchTotalCertificates($conn, $selected_month, $table) {
    $query = "SELECT COUNT(*) as total FROM {$table} WHERE DATE_FORMAT(date_issued, '%Y-%m') = ? AND status = 'done'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $selected_month);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc()['total'];
}

function fetchDistinctMonths($conn) {
    $query = "
        SELECT DISTINCT DATE_FORMAT(date_issued, '%Y-%m') AS month_year 
        FROM clearance_cert 
        WHERE date_issued IS NOT NULL AND DATE(date_issued) > '0001-01-01'
        UNION 
        SELECT DISTINCT DATE_FORMAT(date_issued, '%Y-%m') AS month_year 
        FROM residency_cert 
        WHERE date_issued IS NOT NULL AND DATE(date_issued) > '0001-01-01'
        UNION 
        SELECT DISTINCT DATE_FORMAT(date_issued, '%Y-%m') AS month_year 
        FROM indigency_cert 
        WHERE date_issued IS NOT NULL AND DATE(date_issued) > '0001-01-01'
        UNION 
        SELECT DISTINCT DATE_FORMAT(date_issued, '%Y-%m') AS month_year 
        FROM business_cert 
        WHERE date_issued IS NOT NULL AND DATE(date_issued) > '0001-01-01'
        ORDER BY month_year DESC";
    
    return $conn->query($query);
}

function getMonthName($month_year) {
    $dateObj = DateTime::createFromFormat('Y-m', $month_year);
    return $dateObj ? $dateObj->format('F Y') : null;
}

function fetchCertificateDetails($conn) {
    $query = "
        SELECT CONCAT(fname, ' ', mname, ' ', lname) AS NAME, date_issued AS `DATE ISSUED`, 'Barangay Clearance' AS `Type of Certificate`, amount AS AMOUNT
        FROM clearance_cert WHERE status = 'done'
        UNION ALL
        SELECT businessName AS NAME, date_issued AS `DATE ISSUED`, 'Business Certificate' AS `Type of Certificate`, amount AS AMOUNT
        FROM business_cert WHERE status = 'done'
        UNION ALL
        SELECT CONCAT(fname, ' ', mname, ' ', lname) AS NAME, date_issued AS `DATE ISSUED`, 'Indigency Certificate' AS `Type of Certificate`, amount AS AMOUNT
        FROM indigency_cert WHERE status = 'done'
        UNION ALL
        SELECT CONCAT(fname, ' ', mname, ' ', lname) AS NAME, date_issued AS `DATE ISSUED`, 'Residency Certificate' AS `Type of Certificate`, amount AS AMOUNT
        FROM residency_cert WHERE status = 'done'
        ORDER BY NAME, `DATE ISSUED`";

    $result = $conn->query($query);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'NAME' => $row['NAME'],
            'DATE_ISSUED' => $row['DATE ISSUED'],
            'AMOUNT' => $row['AMOUNT'],
            'TYPE_OF_CERTIFICATE' => $row['Type of Certificate'],
        ];
    }
    return json_encode($data);
}

$selected_month = getSelectedMonth();
$total_clearance = fetchTotalCertificates($conn, $selected_month, 'clearance_cert');
$total_residency = fetchTotalCertificates($conn, $selected_month, 'residency_cert');
$total_indigency = fetchTotalCertificates($conn, $selected_month, 'indigency_cert');
$total_business = fetchTotalCertificates($conn, $selected_month, 'business_cert');
$month_result = fetchDistinctMonths($conn);
$certificate_data = fetchCertificateDetails($conn);
?>

<div class='p-3 w-full h-dvh bg-white'>
    <!-- Navigation -->
    <div class='bg-green-400 text-black p-2 rounded-md mb-4 w-[80px]'>
        <a href='../nx_pages/ReportPage.php' class=''>Go Back</a>
    </div>
    
    <!-- Document History Heading -->
    <div class='text-center'>
        <p class='text-2xl'>Document History</p>
    </div>
    
    <!-- Month Selection Form -->
    <form method="POST" action="">
        <select class='w-full p-3 border mt-3' name="month">
            <?php while ($row = $month_result->fetch_assoc()) { 
                $month_year = $row['month_year'];
                $month_name = getMonthName($month_year); 
                if ($month_name) { ?>
                    <option value="<?php echo $month_year; ?>" <?php if ($month_year == $selected_month) echo 'selected'; ?>>
                        <?php echo $month_name; ?>
                    </option>
                <?php } 
            } ?>
        </select>
        <div class='flex justify-between'>
            <button  class='bg-green-400 text-black p-2 rounded-md mb-4 mt-3'>Show Data</button>

        </div>
    </form>
    <button onclick='printDocuments()' class='bg-yellow-400 text-black p-2 rounded-md mb-4 mt-3'>
        <i class="fa-solid fa-print"></i> Print
    </button>
    <!-- Document Summary -->
    <div class='grid grid-cols-2 gap-4'>
        <div class='text-center bg-blue-600 text-white h-32 rounded-md p-3 drop-shadow-lg'>
            <i class="fa-solid fa-file text-[50px]"></i><br>
            <p class='text-lg'>Barangay Clearance Issued</p>
            <p>Total: <?php echo $total_clearance; ?></p>
        </div>
        <div class='text-center bg-red-600 text-white h-32 rounded-md p-3 drop-shadow-lg'>
            <i class="fa-solid fa-id-card text-[50px]"></i><br>
            <p class='text-lg'>Residency Certificate Issued</p>
            <p>Total: <?php echo $total_residency; ?></p>
        </div>
        <div class='text-center bg-yellow-600 text-white h-32 rounded-md p-3 drop-shadow-lg'>
            <i class="fa-solid fa-store text-[50px]"></i><br>
            <p class='text-lg'>Business Permits Issued</p>
            <p>Total: <?php echo $total_business; ?></p>
        </div>
        <div class='text-center bg-violet-600 text-white h-32 rounded-md p-3 drop-shadow-lg'>
            <i class="fa-solid fa-store text-[50px]"></i><br>
            <p class='text-lg'>Indigency Permits Issued</p>
            <p>Total: <?php echo $total_indigency; ?></p>
        </div>
    </div>
</div>

<script>

    function printDocuments() {
        const phpData = <?php echo $certificate_data; ?>;
        console.log("phpData:", phpData);  // Verify the data structure

        const monthSelect = document.querySelector('[name="month"]');

        const selectedMonth = monthSelect.options[monthSelect.selectedIndex].text;

        // Filter phpData, ignoring entries with an invalid DATE_ISSUED
        const filteredData = phpData.filter(function(item) {
            var dateIssued = new Date(item.DATE_ISSUED);

            var issuedMonthYear = dateIssued.toLocaleString('default', { month: 'long', year: 'numeric' });

            return issuedMonthYear === selectedMonth;
        });

        const dataString = encodeURIComponent(JSON.stringify(filteredData));
        const pdfUrl = `../nx_pages/nx_reports/print_query.php?month=${encodeURIComponent(selectedMonth)}&data=${dataString}`;
        window.open(pdfUrl, '_blank');
    }
</script>