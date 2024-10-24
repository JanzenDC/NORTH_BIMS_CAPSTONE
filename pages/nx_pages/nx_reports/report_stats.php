<?php
require '../db_connect.php';
// Function to execute the query and return the result
function fetchQueryResult($conn, $query) {
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0; // Return 0 if query fails or there's no result
    }
}
$query_male = "SELECT COUNT(*) as total FROM tblresident WHERE gender='Male'";
$query_female = "SELECT COUNT(*) as total FROM tblresident WHERE gender='Female'";
$query_voters = "SELECT COUNT(*) as total FROM tblresident WHERE voter='Yes'";
$query_non_voters = "SELECT COUNT(*) as total FROM tblresident WHERE voter='No'";
$query_age_0_3 = "SELECT COUNT(*) as total FROM tblresident WHERE age BETWEEN 0 AND 3";
$query_age_4_12 = "SELECT COUNT(*) as total FROM tblresident WHERE age BETWEEN 4 AND 12";
$query_age_13_19 = "SELECT COUNT(*) as total FROM tblresident WHERE age BETWEEN 13 AND 19";
$query_age_20_up = "SELECT COUNT(*) as total FROM tblresident WHERE age >= 20";

// Queries for employment status
$query_employed = "SELECT COUNT(*) as total FROM tblresident WHERE occupation='Employed'";
$query_unemployed = "SELECT COUNT(*) as total FROM tblresident WHERE occupation='Unemployed'";

// Queries for education levels
$query_college_undergraduate = "SELECT COUNT(*) as total FROM tblresident WHERE education='College, Undergraduate'";
$query_bachelors_degree = "SELECT COUNT(*) as total FROM tblresident WHERE education='Bachelors degree'";

// Fetch the results
$total_male = fetchQueryResult($conn, $query_male);
$total_female = fetchQueryResult($conn, $query_female);
$total_voters = fetchQueryResult($conn, $query_voters);
$total_non_voters = fetchQueryResult($conn, $query_non_voters);
$total_age_0_3 = fetchQueryResult($conn, $query_age_0_3);
$total_age_4_12 = fetchQueryResult($conn, $query_age_4_12);
$total_age_13_19 = fetchQueryResult($conn, $query_age_13_19);
$total_age_20_up = fetchQueryResult($conn, $query_age_20_up);

$total_employed = fetchQueryResult($conn, $query_employed);
$total_unemployed = fetchQueryResult($conn, $query_unemployed);
$total_college_undergraduate = fetchQueryResult($conn, $query_college_undergraduate);
$total_bachelors_degree = fetchQueryResult($conn, $query_bachelors_degree);

?>

<div class="container mx-auto p-6">

    <h1 class="text-3xl font-semibold text-gray-800 mb-8">Resident Statistics</h1>
    <div class='bg-green-400 text-black p-2 rounded-md mb-4 w-[80px]'>
        <a href='../nx_pages/ReportPage.php' class=''>Go Back</a>
    </div>
    <p>Note: You can download the PDF files by clicking those containers.</p>
    <!-- Gender Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-4 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700" onclick="openDialog('male')">
                <i class="fas fa-male"></i> Male Residents
            </h2>
            <p class="text-3xl font-bold text-blue-500 mt-2"><?php echo $total_male; ?></p>
        </div>
        <div class="bg-white p-4 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700" onclick="openDialog('female')">
                <i class="fas fa-female"></i> Female Residents
            </h2>
            <p class="text-3xl font-bold text-pink-500 mt-2"><?php echo $total_female; ?></p>
        </div>
        <div class="bg-white p-4 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700" onclick="openDialog('voters')">
                <i class="fas fa-vote-yea"></i> Voters
            </h2>
            <p class="text-3xl font-bold text-green-500 mt-2"><?php echo $total_voters; ?></p>
        </div>
    </div>

    <!-- Age Group Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-4 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700" onclick="openDialog('non_voters')">
                <i class="fas fa-user-times"></i> Non-Voters
            </h2>
            <p class="text-3xl font-bold text-red-500 mt-2"><?php echo $total_non_voters; ?></p>
        </div>
        <div class="bg-white p-4 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700" onclick="openDialog('age_0_3')">
                <i class="fas fa-child"></i> Age 0-3
            </h2>
            <p class="text-3xl font-bold text-yellow-500 mt-2"><?php echo $total_age_0_3; ?></p>
        </div>
        <div class="bg-white p-4 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700" onclick="openDialog('age_4_12')">
                <i class="fas fa-child"></i> Age 4-12
            </h2>
            <p class="text-3xl font-bold text-yellow-500 mt-2"><?php echo $total_age_4_12; ?></p>
        </div>
    </div>

    <!-- More Age Groups -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-4 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700" onclick="openDialog('age_13_19')">
                <i class="fas fa-user-graduate"></i> Age 13-19
            </h2>
            <p class="text-3xl font-bold text-yellow-500 mt-2"><?php echo $total_age_13_19; ?></p>
        </div>
        <div class="bg-white p-4 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700" onclick="openDialog('age_20_up')">
                <i class="fas fa-user-graduate"></i> Age 20 and Up
            </h2>
            <p class="text-3xl font-bold text-yellow-500 mt-2"><?php echo $total_age_20_up; ?></p>
        </div>
        <div class="bg-white p-4 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700" onclick="openDialog('employed')">
                <i class="fas fa-briefcase"></i> Employed
            </h2>
            <p class="text-3xl font-bold text-green-500 mt-2"><?php echo $total_employed; ?></p>
        </div>
    </div>

    <!-- Employment & Education -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-4 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700" onclick="openDialog('unemployed')">
                <i class="fas fa-user-slash"></i> Unemployed
            </h2>
            <p class="text-3xl font-bold text-red-500 mt-2"><?php echo $total_unemployed; ?></p>
        </div>
        <div class="bg-white p-4 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700" onclick="openDialog('college_undergraduate')">
                <i class="fas fa-graduation-cap"></i> College Undergraduate
            </h2>
            <p class="text-3xl font-bold text-indigo-500 mt-2"><?php echo $total_college_undergraduate; ?></p>
        </div>
        <div class="bg-white p-4 shadow-md rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700" onclick="openDialog('bachelors_degree')">
                <i class="fas fa-graduation-cap"></i> Bachelors Degree
            </h2>
            <p class="text-3xl font-bold text-indigo-500 mt-2"><?php echo $total_bachelors_degree; ?></p>
        </div>
    </div>
</div>

<div id="dialog" title="Resident Statistics Details" style="display: none;">
    <p id="dialog-content"></p>
</div>


<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(function() {
        $("#dialog").dialog({
            autoOpen: false,
            modal: true,
            width: 600,
            close: function() {
                $("#dialog-content").empty(); // Clear content on close
            }
        });
    });

async function openDialog(category) {
    const response = await fetch(`../nx_pages/nx_reports/fetch_details.php?category=${category}`);
    const data = await response.json();

    if (data.status === 'success') {
        const queryString = encodeURIComponent(JSON.stringify(data.data));
        const pdfUrl = `../nx_pages/nx_reports/resident_stats_print_queries.php?data=${queryString}&category=${category}`;
        
        // Open in new tab
        window.open(pdfUrl, '_blank');
    } else {
        console.error('Error fetching details:', data.message);
    }
}
</script>