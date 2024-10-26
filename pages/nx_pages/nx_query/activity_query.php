<?php
// activity_query.php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

require "../../db_connect.php";

$response = [
    'success' => false,
    'message' => '',
    'data' => null,
];

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        try {
            // Validate required fields
            if (empty($_POST['activityDate']) || empty($_POST['activityName']) || empty($_POST['activityDescription'])) {
                throw new Exception("All fields are required");
            }

            $activityDate = mysqli_real_escape_string($conn, $_POST['activityDate']);
            $activityName = mysqli_real_escape_string($conn, $_POST['activityName']);
            $activityDescription = mysqli_real_escape_string($conn, $_POST['activityDescription']);
            
            // Handle file upload
            if (!isset($_FILES['activityImage']) || $_FILES['activityImage']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("Image upload is required");
            }

            $imageTmpPath = $_FILES['activityImage']['tmp_name'];
            $imageName = $_FILES['activityImage']['name'];
            $uploadDir = "../../../assets/images/activity/";
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generate unique filename
            $fileInfo = pathinfo($imageName);
            $newImageName = uniqid() . '_' . time() . '.' . $fileInfo['extension'];
            $imagePath = $uploadDir . $newImageName;

            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = mime_content_type($imageTmpPath);
            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception("Invalid file type. Only JPG, PNG, and GIF are allowed.");
            }

            // Move uploaded file
            if (!move_uploaded_file($imageTmpPath, $imagePath)) {
                throw new Exception("Failed to upload image");
            }

            // Database insert
            $sql = "INSERT INTO tblactivity (dateofactivity, activity, description, image) 
                   VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $activityDate, $activityName, $activityDescription, $newImageName);

            if (!$stmt->execute()) {
                throw new Exception("Database error: " . $stmt->error);
            }

            $response['success'] = true;
            $response['message'] = "Activity added successfully";
            $response['data'] = [
                'id' => $stmt->insert_id,
                'date' => $activityDate,
                'name' => $activityName,
                'description' => $activityDescription,
                'image' => $newImageName
            ];

        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }
        break;
    case 'delete':
        try {
            if (!isset($_POST['id'])) {
                throw new Exception("Activity ID is required");
            }

            $id = mysqli_real_escape_string($conn, $_POST['id']);

            // Get image filename before deleting record
            $sql = "SELECT image FROM tblactivity WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to fetch activity image");
            }
            
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            if ($row) {
                // Delete the image file
                $imagePath = "../../../assets/images/activity/" . $row['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Delete the record
            $sql = "DELETE FROM tblactivity WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to delete activity");
            }

            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
                $response['message'] = "Activity deleted successfully";
            } else {
                throw new Exception("Activity not found");
            }
            
        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }
        break;
    case 'get':
        try {
            if (!isset($_GET['id'])) {
                throw new Exception("Activity ID is required");
            }
            
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $sql = "SELECT * FROM tblactivity WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to fetch activity");
            }
            
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $response['success'] = true;
                $response['data'] = $row;
            } else {
                throw new Exception("Activity not found");
            }
            
        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }
        break;
    case 'update':
        try {
            if (!isset($_POST['id'])) {
                throw new Exception("Activity ID is required");
            }

            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $activityDate = mysqli_real_escape_string($conn, $_POST['activityDate']);
            $activityName = mysqli_real_escape_string($conn, $_POST['activityName']);
            $activityDescription = mysqli_real_escape_string($conn, $_POST['activityDescription']);
            
            // Start with base query
            $sql = "UPDATE tblactivity SET dateofactivity = ?, activity = ?, description = ?";
            $params = [$activityDate, $activityName, $activityDescription];
            $types = "sss";
            
            // Handle image upload if new image is provided
            if (isset($_FILES['activityImage']) && $_FILES['activityImage']['error'] === UPLOAD_ERR_OK) {
                $imageTmpPath = $_FILES['activityImage']['tmp_name'];
                $imageName = $_FILES['activityImage']['name'];
                $uploadDir = "../../../assets/images/activity/";
                
                // Generate unique filename
                $fileInfo = pathinfo($imageName);
                $newImageName = uniqid() . '_' . time() . '.' . $fileInfo['extension'];
                $imagePath = $uploadDir . $newImageName;

                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = mime_content_type($imageTmpPath);
                if (!in_array($fileType, $allowedTypes)) {
                    throw new Exception("Invalid file type. Only JPG, PNG, and GIF are allowed.");
                }

                if (!move_uploaded_file($imageTmpPath, $imagePath)) {
                    throw new Exception("Failed to upload new image");
                }

                // Add image to update query
                $sql .= ", image = ?";
                $params[] = $newImageName;
                $types .= "s";
                
                // Delete old image
                $oldImageQuery = "SELECT image FROM tblactivity WHERE id = ?";
                $stmtOld = $conn->prepare($oldImageQuery);
                $stmtOld->bind_param("i", $id);
                $stmtOld->execute();
                $oldImageResult = $stmtOld->get_result();
                if ($oldImage = $oldImageResult->fetch_assoc()) {
                    $oldImagePath = $uploadDir . $oldImage['image'];
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }

            // Complete the query
            $sql .= " WHERE id = ?";
            $params[] = $id;
            $types .= "i";

            // Prepare and execute the statement
            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);

            if (!$stmt->execute()) {
                throw new Exception("Failed to update activity");
            }

            $response['success'] = true;
            $response['message'] = "Activity updated successfully";
            
        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }
    break;
    default:
        $response['message'] = "Invalid action";
}

echo json_encode($response);
$conn->close();
?>