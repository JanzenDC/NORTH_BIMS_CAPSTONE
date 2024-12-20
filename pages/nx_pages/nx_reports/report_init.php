<?php
require '../db_connect.php';

// Queries to get the counts for resident statistics
$query_male = "SELECT COUNT(*) as total FROM tblresident WHERE gender='Male'";
$query_female = "SELECT COUNT(*) as total FROM tblresident WHERE gender='Female'";
$query_voters = "SELECT COUNT(*) as total FROM tblresident WHERE voter='Yes'";
$query_non_voters = "SELECT COUNT(*) as total FROM tblresident WHERE voter='No'";
$query_age_0_3 = "SELECT COUNT(*) as total FROM tblresident WHERE age BETWEEN 0 AND 3";
$query_age_4_12 = "SELECT COUNT(*) as total FROM tblresident WHERE age BETWEEN 4 AND 12";
$query_age_13_19 = "SELECT COUNT(*) as total FROM tblresident WHERE age BETWEEN 13 AND 19";
$query_age_20_up = "SELECT COUNT(*) as total FROM tblresident WHERE age >= 20";
$query_blotter = "SELECT yearRecorded, COUNT(*) as total FROM tblblotter GROUP BY yearRecorded";
$result_blotter = mysqli_query($conn, $query_blotter);


// Queries for employment status
$query_employed = "SELECT COUNT(*) as total FROM tblresident WHERE occupation='Employed'";
$query_unemployed = "SELECT COUNT(*) as total FROM tblresident WHERE occupation='Unemployed'";

// Queries for education levels
$query_college_undergraduate = "SELECT COUNT(*) as total FROM tblresident WHERE education='College, Undergraduate'";
$query_bachelors_degree = "SELECT COUNT(*) as total FROM tblresident WHERE education='Bachelors degree'";

$result_male = mysqli_query($conn, $query_male);
$result_female = mysqli_query($conn, $query_female);
$result_voters = mysqli_query($conn, $query_voters);
$result_non_voters = mysqli_query($conn, $query_non_voters);
$result_age_0_3 = mysqli_query($conn, $query_age_0_3);
$result_age_4_12 = mysqli_query($conn, $query_age_4_12);
$result_age_13_19 = mysqli_query($conn, $query_age_13_19);
$result_age_20_up = mysqli_query($conn, $query_age_20_up);

$result_employed = mysqli_query($conn, $query_employed);
$result_unemployed = mysqli_query($conn, $query_unemployed);

$result_college_undergraduate = mysqli_query($conn, $query_college_undergraduate);
$result_bachelors_degree = mysqli_query($conn, $query_bachelors_degree);

$total_male = mysqli_fetch_assoc($result_male)['total'];
$total_female = mysqli_fetch_assoc($result_female)['total'];
$total_voters = mysqli_fetch_assoc($result_voters)['total'];
$total_non_voters = mysqli_fetch_assoc($result_non_voters)['total'];
$total_age_0_3 = mysqli_fetch_assoc($result_age_0_3)['total'];
$total_age_4_12 = mysqli_fetch_assoc($result_age_4_12)['total'];
$total_age_13_19 = mysqli_fetch_assoc($result_age_13_19)['total'];
$total_age_20_up = mysqli_fetch_assoc($result_age_20_up)['total'];

$total_employed = mysqli_fetch_assoc($result_employed)['total'];
$total_unemployed = mysqli_fetch_assoc($result_unemployed)['total'];
$total_college_undergraduate = mysqli_fetch_assoc($result_college_undergraduate)['total'];
$total_bachelors_degree = mysqli_fetch_assoc($result_bachelors_degree)['total'];
$blotter_data = [];
$blotter_years = [];

while ($row = mysqli_fetch_assoc($result_blotter)) {
    $blotter_years[] = $row['yearRecorded'];
    $blotter_data[] = $row['total'];
}
?>

            <div class="md:flex  md:justify-between mb-3">
                <div class='text-2xl'>
                    Reports
                </div>
                <div class="flex gap-2">
                    <a href='../nx_pages/ReportPage.php?page=report_stats' class='bg-green-600 rounded-md p-3 text-white cursor-pointer'>
                        Resident Statistics
                    </a>
                    <div id='openDialogButton' class='bg-green-600 rounded-md p-3 text-white cursor-pointer'>
                        Blotter Report
                    </div>
                    <a href='../nx_pages/ReportPage.php?page=document_stats' class='bg-green-600 rounded-md p-3 text-white cursor-pointer'>
                        Document Statistics
                    </a>
                    <select class="bg-green-600 text-white rounded-md p-3 cursor-pointer" onchange="generateReport(this.value)">
                        <option value="" disabled selected>Select Purok</option>
                        <option value="Acadia">Villa Gabriel</option>
                        <option value="mulawin">Mulawin</option>
                        <option value="Kamagong">Camagong</option>
                        <option value="banaba">Banaba</option>
                        <option value="narra">Narra</option>
                        <option value="calumpit">Calumpit</option>
                        <option value="mabolo">Mabolo</option>
                        <!-- Add more options here if necessary -->
                    </select>

                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Gender Distribution Pie Chart -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <canvas id="genderChart"></canvas>
                </div>

                <!-- Voters vs Non-Voters Doughnut Chart -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <canvas id="voterChart"></canvas>
                </div>

                <!-- Age Groups Bar Chart -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <canvas id="ageChart"></canvas>
                </div>

                <!-- Employment Status Pie Chart -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <canvas id="employmentChart"></canvas>
                </div>

                <!-- Education Levels Pie Chart -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <canvas id="educationChart"></canvas>
                </div>

                <!-- Blotter Records Line Chart -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <canvas id="blotterChart"></canvas>
                </div>
            </div>

<div id="blotterDialog" title="Blotter Report Filter" style="display:none;">
    <div class="mb-3">
        <label for="yearFilter" class="form-label">Select Year</label>
        <select class="w-full p-3" id="monthYearFilter" name="monthYear" required>
            <option value="" disabled selected>Choose a month and year...</option>
            <?php
            // Fetch available months and years with counts from the database
            $monthYearQuery = "
                SELECT DATE_FORMAT(date, '%M, %Y') AS monthYear, COUNT(*) AS count,date
                FROM tblblotter 
                GROUP BY MONTH(date), YEAR(date) 
                ORDER BY YEAR(date) DESC, MONTH(date) DESC
            ";
            $monthYearResult = mysqli_query($conn, $monthYearQuery);

            while ($row = mysqli_fetch_assoc($monthYearResult)) {
                echo '<option value="' . htmlspecialchars($row['date']) . '">' . htmlspecialchars($row['monthYear']) . ' - ' . htmlspecialchars($row['count']) . ' entries</option>';
            }
            ?>
        </select>


    </div>
</div>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        $("#blotterDialog").dialog({
            autoOpen: false,
            modal: true,
            width: 300,
            buttons: {
                Submit: function(){
                    printDocuments();
                },
                Cancel: function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#openDialogButton").on("click", function() {
            $("#blotterDialog").dialog("open");
        });
    });

        function printDocuments() {
            const monthYearFilter = document.getElementById('monthYearFilter');
            const selectedValue = monthYearFilter.value; // Get the selected value
            const pdfUrl = '../nx_pages/nx_reports/blotter_details.php?year=' + encodeURIComponent(selectedValue);
            window.open(pdfUrl, '_blank');
        }

        // Gender Distribution Pie Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [<?= $total_male ?>, <?= $total_female ?>],
                    backgroundColor: ['#4CAF50', '#FFC107'],
                }]
            }
        });

        // Voters vs Non-Voters Doughnut Chart
        const voterCtx = document.getElementById('voterChart').getContext('2d');
        new Chart(voterCtx, {
            type: 'doughnut',
            data: {
                labels: ['Voters', 'Non-Voters'],
                datasets: [{
                    data: [<?= $total_voters ?>, <?= $total_non_voters ?>],
                    backgroundColor: ['#4CAF50', '#F44336'],
                }]
            }
        });

        // Age Groups Bar Chart
        const ageCtx = document.getElementById('ageChart').getContext('2d');
        new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: ['0-3', '4-12', '13-19', '20 and above'],
                datasets: [{
                    label: 'Age Groups',
                    data: [<?= $total_age_0_3 ?>, <?= $total_age_4_12 ?>, <?= $total_age_13_19 ?>, <?= $total_age_20_up ?>],
                    backgroundColor: ['#2196F3', '#FFC107', '#FF5722', '#8BC34A'],
                }]
            }
        });

        // Employment Status Pie Chart
        const employmentCtx = document.getElementById('employmentChart').getContext('2d');
        new Chart(employmentCtx, {
            type: 'pie',
            data: {
                labels: ['Employed', 'Unemployed'],
                datasets: [{
                    data: [<?= $total_employed ?>, <?= $total_unemployed ?>],
                    backgroundColor: ['#4CAF50', '#F44336'],
                }]
            }
        });

        // Education Levels Pie Chart
        const educationCtx = document.getElementById('educationChart').getContext('2d');
        new Chart(educationCtx, {
            type: 'pie',
            data: {
                labels: ['College Undergraduate', 'Bachelors Degree'],
                datasets: [{
                    data: [<?= $total_college_undergraduate ?>, <?= $total_bachelors_degree ?>],
                    backgroundColor: ['#FF5722', '#3F51B5'],
                }]
            }
        });

        // Blotter Records Line Chart
        const blotterCtx = document.getElementById('blotterChart').getContext('2d');
        new Chart(blotterCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode($blotter_years) ?>,
                datasets: [{
                    label: 'Blotter Records',
                    data: <?= json_encode($blotter_data) ?>,
                    borderColor: '#FF5722',
                    fill: false,
                    tension: 0.1
                }]
            }
        });
        function generateReport(value) {
            if (value) {
                const pdfUrl = `../nx_pages/nx_residents/generate_report.php?area=${encodeURIComponent(value)}`;
                window.open(pdfUrl, '_blank');
            } else {
                // Using SweetAlert2 (swal) to show a warning
                Swal.fire({
                    icon: 'warning',
                    title: 'No Area Selected',
                    text: 'Please select an area first to generate the report.',
                    confirmButtonText: 'OK'
                });
            }
        }

    </script>
</body>
</html>
