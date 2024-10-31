<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

session_start();
require "../../db_connect.php";

$response = [
    'success' => false,
    'message' => '',
    'data' => null,
];

function logAction($conn, $user, $action) {
    $logdate = date('Y-m-d H:i:s');
    $sql = "INSERT INTO tbllogs (user, logdate, action) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user, $logdate, $action);
    $stmt->execute();
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user']['username'];
    
    // Start output buffering to capture the SQL dump
    ob_start();

    // Write the SQL commands to backup the database
    $tables = mysqli_query($conn, "SHOW TABLES");
    while ($table = mysqli_fetch_array($tables)) {
        $tableName = $table[0];

        // Write CREATE TABLE statement
        $createTable = mysqli_query($conn, "SHOW CREATE TABLE $tableName");
        $createTableRow = mysqli_fetch_array($createTable);
        echo $createTableRow[1] . ";\n\n";

        // Write INSERT statements for each row
        $rows = mysqli_query($conn, "SELECT * FROM $tableName");
        while ($row = mysqli_fetch_assoc($rows)) {
            $values = array_map(function($value) {
                return "'" . mysqli_real_escape_string($GLOBALS['conn'], $value) . "'";
            }, array_values($row));
            echo "INSERT INTO $tableName (" . implode(", ", array_keys($row)) . ") VALUES (" . implode(", ", $values) . ");\n";
        }
        echo "\n\n";
    }

    // Capture the output and clean the buffer
    $backupData = ob_get_clean();

    // Log the action
    logAction($conn, $user, 'Backup');

    // Create a temporary file to store the SQL backup
    $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    file_put_contents($filename, $backupData);

    // Prepare the response with the download link
    $response['success'] = true;
    $response['message'] = 'Backup created successfully.';
    $response['data'] = [
        'download_link' => $filename, // Link to download the file
        'backup_data' => $backupData,  // Include the SQL data in the response
    ];
    
    // Prepare for file download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($backupData));

    // Clear output buffer
    ob_clean();
    flush();

    // Output the backup data directly
    echo $backupData;
    
} else {
    $response['message'] = 'User not logged in.';
}

// Return the response as JSON if not downloading
if (!$response['success']) {
    echo json_encode($response);
}

$conn->close();
?>
