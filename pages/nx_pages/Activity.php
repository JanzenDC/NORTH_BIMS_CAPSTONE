<?php
session_start();
$currentPage = 'activity'; // Change this value based on the current page
require '../db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); 
    exit();
}
$user = $_SESSION['user'];

$sqlAct = "SELECT * FROM tblactivity";
$resultAct = $conn->query($sqlAct);

$activityData = [];
if ($resultAct->num_rows > 0) {
    while ($row = $resultAct->fetch_assoc()) {
        $activityData[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity</title>
    <?php 
        include_once "../headers.php"
    ?>
</head>
<body class="bg-gray-100 overflow-hidden">
    <?php
        include_once("../navbar.php")
    ?>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php
            include_once("../nx_sidebar/sidebar.php");
        ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 mb-8 overflow-y-auto">
            <div class='h-screen bg-white p-3'>
                <button id='openActivity' class='bg-red-500 text-white p-3 rounded-md w-32'>
                    <i class="fa-solid fa-plus"></i> Add Activity
                </button>

                <div class='mt-5'>
                    <table id="activityTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Specific Day</th>
                                <th>Date of Acitivity</th>
                                <th>Description</th>
                                <th>Activty</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                            <tbody>
                                <?php foreach ($activityData as $row): ?>
                                <tr>
                                    <td><img src="../../assets/images/activity/<?= $row['image'] ?>" alt="" class='w-10'></td>
                                    <td><?php echo htmlspecialchars($row['recurring_days']); ?></td>
                                    <td><?php echo htmlspecialchars($row['dateofactivity']); ?></td>
                                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                                    <td><?php echo htmlspecialchars($row['activity']); ?></td>
                                    <td class="flex space-x-2">
                                        <button class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded hover:bg-yellow-600 transition duration-200" 
                                                onclick="editApproved(<?php echo htmlspecialchars($row['id']); ?>)">
                                            Edit
                                        </button>
                                        <button class="bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-red-600 transition duration-200" 
                                                onclick="deleteActivity(<?php echo htmlspecialchars($row['id']); ?>)">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div id="activityDialog" title="Add Activity" class="p-4 bg-white rounded shadow-lg" style="display:none;">
         <div class="mt-4">
            <label for="recurring_days" class="block text-sm font-medium text-gray-700">Activity Type:</label>
            <select id="recurring_days" name="recurring_days" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="Specific Date">Specific Day</option>
                <option value="Every Monday">Every Monday</option>
                <option value="Every Tuesday">Every Tuesday</option>
                <option value="Every Wednesday">Every Wednesday</option>
                <option value="Every Thursday">Every Thursday</option>
                <option value="Every Friday">Every Friday</option>
                <option value="Every Saturday">Every Saturday</option>
                <option value="Every Sunday">Every Sunday</option>
            </select>
        </div>
        
        <div class="mt-4" id="specificDateField">
            <label for="activityDate" class="block text-sm font-medium text-gray-700 mt-2">Date:</label>
            <input type="date" id="activityDate" name="activityDate" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
        </div>


        <label for="activityName" class="block text-sm font-medium text-gray-700 mt-2">Activity Name:</label>
        <input type="text" id="activityName" name="activityName" placeholder="Enter Activity Name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">

        <label for="activityDescription" class="block text-sm font-medium text-gray-700 mt-2">Description:</label>
        <textarea id="activityDescription" name="activityDescription" placeholder="Enter Description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 h-24"></textarea>

        <label for="activityImage" class="block text-sm font-medium text-gray-700 mt-2">Image:</label>
        <input type="file" id="activityImage" name="activityImage" accept="image/*" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">

    </div>

    <div id="editActivityDialog" title="Edit Activity" class="p-4 bg-white rounded shadow-lg" style="display:none;">
        <input type="hidden" id="editActivityId">
        <!-- Weekly Recurrence Field -->
        <div class="mt-4 hidden" id="editWeeklyField">
            <label for="editActivityDay" class="block text-sm font-medium text-gray-700">Select Day:</label>
            <select id="editActivityDay" name="editActivityDay" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                <option value="Monday">Every Monday</option>
                <option value="Tuesday">Every Tuesday</option>
                <option value="Wednesday">Every Wednesday</option>
                <option value="Thursday">Every Thursday</option>
                <option value="Friday">Every Friday</option>
                <option value="Saturday">Every Saturday</option>
                <option value="Sunday">Every Sunday</option>
            </select>
        </div>
        
        <label for="editActivityDate" class="block text-sm font-medium text-gray-700 mt-2">Date:</label>
        <input type="date" id="editActivityDate" name="editActivityDate" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">

        <label for="editActivityName" class="block text-sm font-medium text-gray-700 mt-2">Activity Name:</label>
        <input type="text" id="editActivityName" name="editActivityName" placeholder="Enter Activity Name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">

        <label for="editActivityDescription" class="block text-sm font-medium text-gray-700 mt-2">Description:</label>
        <textarea id="editActivityDescription" name="editActivityDescription" placeholder="Enter Description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 h-24"></textarea>

        <label for="editActivityImage" class="block text-sm font-medium text-gray-700 mt-2">New Image (optional):</label>
        <input type="file" id="editActivityImage" name="editActivityImage" accept="image/*" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">

        <div class="mt-4">
            <img id="currentActivityImage" src="" alt="Current Activity Image" class="w-32 h-32 object-cover hidden">
        </div>
    </div>

<script>
$(document).ready(function() {
    $('#activityTable').DataTable({
        "scrollX": true
    });

    $("#activityDialog").dialog({
        autoOpen: false,
        modal: true,
        width: 400,
        buttons: {
            Submit: function() {
                submitActivity();
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });

    $("#openActivity").on("click", function() {
        $("#activityDialog").dialog("open");
    });
});

function submitActivity() {
    // Validate form
    const recurring_days = document.getElementById('recurring_days').value;
    const activityDate = document.getElementById('activityDate').value;
    const activityName = document.getElementById('activityName').value;
    const activityDescription = document.getElementById('activityDescription').value;
    const activityImage = document.getElementById('activityImage').files[0];

    if (!activityDate || !activityName || !activityDescription || !activityImage) {
        swal("Error!", "All fields are required", "error");
        return;
    }

    swal({
        title: "Are you sure?",
        text: "Do you want to add this activity?",
        icon: "warning",
        buttons: ["Cancel", "Yes, add it!"],
        dangerMode: true,
    })
    .then((willAdd) => {
        if (willAdd) {
            const formData = new FormData();
            formData.append('recurring_days', recurring_days);
            formData.append('activityDate', activityDate);
            formData.append('activityName', activityName);
            formData.append('activityDescription', activityDescription);
            formData.append('activityImage', activityImage);

            $.ajax({
                url: 'nx_query/activity_query.php?action=create',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    try {
                        // Handle the case where response is already an object
                        const result = typeof response === 'string' ? JSON.parse(response) : response;
                        
                        if (result.success) {
                            swal("Success!", result.message, "success")
                            .then(() => {
                                location.reload(); // Reload the page to show new data
                            });
                            $("#activityDialog").dialog("close");
                        } else {
                            swal("Error!", result.message, "error");
                        }
                    } catch (e) {
                        console.error("JSON parsing error:", e);
                        swal("Error!", "Invalid server response", "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", error);
                    swal("Error!", "Failed to submit activity", "error");
                }
            });
        }
    });
}

function editApproved(id) {
    // Fetch activity data
    $.ajax({
        url: 'nx_query/activity_query.php?action=get&id=' + id,
        type: 'GET',
        success: function(response) {
            try {
                const result = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (result.success) {
                    // Populate the edit dialog
                    $('#editActivityId').val(result.data.id);
                    $('#editActivityDate').val(result.data.dateofactivity);
                    $('#editActivityName').val(result.data.activity);
                    $('#editActivityDescription').val(result.data.description);
                    $('#editActivityDay').val(result.data.recurring_days)
                    // Show current image
                    const imagePath = '../../assets/images/activity/' + result.data.image;
                    $('#currentActivityImage').attr('src', imagePath).removeClass('hidden');
                    
                    // Open the edit dialog
                    $("#editActivityDialog").dialog("open");
                } else {
                    swal("Error!", result.message, "error");
                }
            } catch (e) {
                console.error("JSON parsing error:", e);
                swal("Error!", "Invalid server response", "error");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
            swal("Error!", "Failed to fetch activity data", "error");
        }
    });
}

$(document).ready(function() {
    // Add this to your existing document.ready function
    $("#editActivityDialog").dialog({
        autoOpen: false,
        modal: true,
        width: 400,
        buttons: {
            "Update": function() {
                updateActivity();
            },
            "Cancel": function() {
                $(this).dialog("close");
            }
        }
    });
});

// Add the updateActivity function
function updateActivity() {
    const id = $('#editActivityId').val();
    const activityDate = $('#editActivityDate').val();
    const activityName = $('#editActivityName').val();
    const activityDescription = $('#editActivityDescription').val();
    const activityImage = $('#editActivityImage')[0].files[0];
    const activityDay = $('#editActivityDay').val();
    if (!activityDate || !activityName || !activityDescription) {
        swal("Error!", "Date, name, and description are required", "error");
        return;
    }

    swal({
        title: "Are you sure?",
        text: "Do you want to update this activity?",
        icon: "warning",
        buttons: ["Cancel", "Yes, update it!"],
        dangerMode: true,
    })
    .then((willUpdate) => {
        if (willUpdate) {
            const formData = new FormData();
            formData.append('id', id);
            formData.append('activityDate', activityDate);
            formData.append('activityName', activityName);
            formData.append('activityDay', activityDay);
            formData.append('activityDescription', activityDescription);
            if (activityImage) {
                formData.append('activityImage', activityImage);
            }

            $.ajax({
                url: 'nx_query/activity_query.php?action=update',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    try {
                        const result = typeof response === 'string' ? JSON.parse(response) : response;
                        
                        if (result.success) {
                            swal("Success!", result.message, "success")
                            .then(() => {
                                location.reload();
                            });
                            $("#editActivityDialog").dialog("close");
                        } else {
                            swal("Error!", result.message, "error");
                        }
                    } catch (e) {
                        console.error("JSON parsing error:", e);
                        swal("Error!", "Invalid server response", "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", error);
                    swal("Error!", "Failed to update activity", "error");
                }
            });
        }
    });
}

function deleteActivity(id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this activity!",
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancel",
                value: null,
                visible: true,
                className: "",
                closeModal: true,
            },
            confirm: {
                text: "Yes, delete it!",
                value: true,
                visible: true,
                className: "bg-red-500",
                closeModal: true
            }
        },
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: 'nx_query/activity_query.php?action=delete',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    try {
                        const result = typeof response === 'string' ? JSON.parse(response) : response;
                        
                        if (result.success) {
                            swal("Success!", result.message, "success")
                            .then(() => {
                                location.reload(); // Reload to update the table
                            });
                        } else {
                            swal("Error!", result.message, "error");
                        }
                    } catch (e) {
                        console.error("JSON parsing error:", e);
                        swal("Error!", "Invalid server response", "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", error);
                    swal("Error!", "Failed to delete activity", "error");
                }
            });
        }
    });
}

</script>
    <!-- If meron na javascript dito nalang mag add wag na sa header.php -->
</body>
</html>