<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
require "../../db_connect.php"; // Ensure this file establishes a MySQLi connection

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $query = "";

    switch ($category) {
        case 'male':
            $query = "SELECT fname, lname, age, gender, voter, occupation, education FROM tblresident WHERE gender='Male'";
            break;
        case 'female':
            $query = "SELECT fname, lname, age, gender, voter, occupation, education FROM tblresident WHERE gender='Female'";
            break;
        case 'voters':
            $query = "SELECT fname, lname, age, gender, voter, occupation, education FROM tblresident WHERE voter='Yes'";
            break;
        case 'non-voters':
            $query = "SELECT fname, lname, age, gender, voter, occupation, education FROM tblresident WHERE voter='No'";
            break;
        case 'age-0-3':
            $query = "SELECT fname, lname, age, gender, voter, occupation, education FROM tblresident WHERE age BETWEEN 0 AND 3";
            break;
        case 'age-4-12':
            $query = "SELECT fname, lname, age, gender, voter, occupation, education FROM tblresident WHERE age BETWEEN 4 AND 12";
            break;
        case 'age-13-19':
            $query = "SELECT fname, lname, age, gender, voter, occupation, education FROM tblresident WHERE age BETWEEN 13 AND 19";
            break;
        case 'age-20-up':
            $query = "SELECT fname, lname, age, gender, voter, occupation, education FROM tblresident WHERE age >= 20";
            break;
        case 'employed':
            $query = "SELECT fname, lname, age, gender, voter, occupation, education FROM tblresident WHERE occupation='Employed'";
            break;
        case 'unemployed':
            $query = "SELECT fname, lname, age, gender, voter, occupation, education FROM tblresident WHERE occupation='Unemployed'";
            break;
        case 'college-undergraduate':
            $query = "SELECT fname, lname, age, gender, voter, occupation, education FROM tblresident WHERE education='College, Undergraduate'";
            break;
        case 'bachelors-degree':
            $query = "SELECT fname, lname, age, gender, voter, occupation, education FROM tblresident WHERE education='Bachelors degree'";
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid category']);
            exit();
    }

    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo json_encode(['status' => 'error', 'message' => 'Query failed']);
        exit();
    }

    $details = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row['name'] = $row['fname'] . ' ' . $row['lname'];
        $details[] = $row;
    }

    echo json_encode(['status' => 'success', 'data' => $details]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No category provided']);
}
?>
