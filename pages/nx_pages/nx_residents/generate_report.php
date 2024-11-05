<?php
// Database connection parameters
$servername = "localhost";  // Localhost if you're running XAMPP locally
$username = "root";         // Default MySQL username in XAMPP
$password = "";             // Default password in XAMPP is empty
$dbname = "north"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Error message if connection fails
}

// Query to fetch all residents ordered by houseNo and head_fam
$sql = "SELECT * FROM tblresident ORDER BY houseNo, head_fam DESC";
$result = mysqli_query($conn, $sql);

// Group residents by their houseNo
$households = [];
while ($row = mysqli_fetch_assoc($result)) {
    $houseNo = $row['houseNo'];
    if (!isset($households[$houseNo])) {
        $households[$houseNo] = [];
    }
    $households[$houseNo][] = $row;  // Add each resident to the appropriate houseNo group
}

// Close connection after retrieving data
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Resident Report</h1>
        
        <!-- Table for displaying the data -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">HOUSEHOLD HEAD</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">RELATION TO HOUSEHOLD HEAD</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">DATE OF BIRTH</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">AGE</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">SEX ON BIRTH</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">CIVIL STATUS</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">OCCUPATION</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">EDUCATIONAL ATTAINMENT</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">REGISTERED VOTERS</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php 
                    // Loop through households and display family data
                    foreach ($households as $houseNo => $members): 
                        // First loop to show household head only once
                        foreach ($members as $index => $member): 
                            if ($member['head_fam'] === 'Yes'):
                    ?>
                        <tr class="border-b">
                            <!-- Household Head: Show full details here -->
                            <td class="px-4 py-2 text-sm font-semibold text-gray-700"><?= $member['fname'] . ' ' . $member['mname'] . ' ' . $member['lname'] . ' ' . $member['suffix'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700">Household Head</td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['bday'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['age'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['gender'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['civil_status'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['occupation'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['education'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['voter'] ?></td>
                        </tr>
                        <?php 
                            endif; // End household head check
                        endforeach; 

                        // Then loop to show family members (exclude household head)
                        foreach ($members as $index => $member): 
                            if ($member['head_fam'] !== 'Yes'):
                    ?>
                        <tr class="border-b">
                            <!-- Family Members: Leave household head column empty -->
                            <td class="px-4 py-2 text-sm text-gray-700"></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['fname'] ?> <?= $member['mname'] ?> <?= $member['lname'] ?> <?= $member['relation'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['bday'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['age'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['gender'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['civil_status'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['occupation'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['education'] ?></td>
                            <td class="px-4 py-2 text-sm text-gray-700"><?= $member['voter'] ?></td>
                        </tr>
                    <?php 
                            endif; // End family member check
                        endforeach;
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
