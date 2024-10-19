<?php
$treeView = 'barangay_official'; // Change this value based on the current page
$sqls = "SELECT 
            id, 
            CONCAT_WS(' ', fname, mname, lname, suffix) AS full_name, 
            position, 
            contact, 
            bday, 
            image 
        FROM 
            tblofficial";

$resuktSqks = $conn->query($sqls);

// Initialize an array to hold the data
$data = [];

if ($resuktSqks->num_rows > 0) {
    // Fetch each row and append it to the data array
    while ($row = $resuktSqks->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<div class="p-3 w-full bg-white rounded-md shadow-xl mb-[80px]">
    <h1 class="text-3xl font-bold">Barangay Officials</h1>
    <hr>


    <table id="officials-table" class="display w-full">
        <thead>
            <tr>
                <th>Image</th>
                <th class="text-start">Full Name</th>
                <th class="text-center">Position</th>
                <th>Contact</th>
                <th class="text-center">Birthday</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $official): ?>
                <tr data-id="<?= $official['id'] ?>">
                    <td><img src='../../assets/images/pfp/<?= $official["image"] ?>' style='width:50px;height:auto;' /></td>
                    <td class="text-start"><?= htmlspecialchars($official['full_name']) ?></td>
                    <td class="text-start"><?= htmlspecialchars($official['position']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($official['contact']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($official['bday']) ?></td>
                    <td class="text-center">
                        <button class="text-yellow-500" title="Edit" onclick="editRecord(<?= $official['id'] ?>)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-500" title="Delete" onclick="deleteRecord(<?= $official['id'] ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- MODALS SECTION -->
<!-- Create Official Modal -->
<div id="createModal" class="modal fixed inset-0 bg-gray-500  bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3 ">
        <i class="fa-solid  text-sm fa-x float-right cursor-pointer"  onclick="closeModal('createModal')" style="color:red;"></i>
        <!-- <span class="cursor-pointer float-right ">&times;</span> -->
        <h1 class="text-xl font-bold mb-4">Add Barangay Official</h1>
        <form id="createForm" enctype="multipart/form-data" onsubmit="event.preventDefault(); addRecord();">

            <label class="text-field-outlined w-full ">
            <input placeholder="" type="text" name="fname" id="addFname" required>
            <span class="text-bold">Firstname</span>
            </label>
            <label class="text-field-outlined w-full ">
            <input placeholder="" type="text" name="mname" id="addMname"  required>
            <span class="text-bold">Middlename</span>
            </label>
            <label class="text-field-outlined w-full ">
            <input placeholder="" type="text" name="lname" id="addLname" required>
            <span class="text-bold">Lastname</span>
            </label>
            <label class="text-field-outlined w-full ">
            <input placeholder="" type="text" name="suffix" id="addSuffix" required>
            <span class="text-bold">Suffix</span>
            </label>
            <label class="text-field-outlined w-full ">
            <input placeholder="" type="text" name="position" id="addPosition" required>
            <span class="text-bold">Position</span>
            </label>
            <label class="text-field-outlined w-full ">
            <input placeholder="" type="number" pattern="\d{1,11}" maxlength="11" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 11);"  name="contact" id="addContact"  required>
            <span class="text-bold">Contact Number</span>
            </label>
            <label class="text-field-outlined w-full ">
            <input placeholder="" type="date" name="bday" id="addBday"  required>
            <span class="text-bold">Birthdate</span>
            </label>
            <input type="file" name="image" id="addImage" class="block w-full mt-1 mb-2 p-2 border rounded-md border-opacity-70 border-black" required>


            <button type="submit" class="custom-btn btn-3 rounded mt-1"><span>Create</span></button>
           
        </form>
    </div>
</div>

<!-- Edit Official Modal -->
<div id="editModal" class="modal fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <span class="cursor-pointer float-right" onclick="closeModal('editModal')">&times;</span>
        <h2 class="text-lg font-semibold mb-4">Edit Official</h2>
        <form id="editForm" enctype="multipart/form-data">
            <input type="hidden" id="editId" name="id">

            <!-- Name Fields -->
            <div class="flex mb-4">
                <input type="text" id="editFname" name="fname" placeholder="First Name" class="block w-full mr-2 p-2 border rounded" required>
                <input type="text" id="editMname" name="mname" placeholder="Middle Name" class="block w-full mr-2 p-2 border rounded">
                <input type="text" id="editLname" name="lname" placeholder="Last Name" class="block w-full p-2 border rounded" required>
            </div>

            <!-- Other Fields in Two Columns -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <input type="text" id="editSuffix" name="suffix" placeholder="Suffix" class="block w-full p-2 border rounded">
                <input type="text" id="editPosition" name="position" placeholder="Position" class="block w-full p-2 border rounded" required>
                <input type="text" id="editContact" name="contact" placeholder="Contact" class="block w-full p-2 border rounded" required>
                <input type="date" id="editBday" name="bday" class="block w-full p-2 border rounded" required>
            </div>

            <input type="file" id="editImage" name="image" class="block w-full mb-2 p-2 border rounded">
            <img id="editImagePreview" src="" alt="Current Image" class="mb-2" style="display:none; width:100px; height:auto;">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded" onclick="updateRecord()">Update</button>
        </form>
    </div>
</div>




<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


<style>
<?php include 'barangay_official.css' ?>
</style>


<script>
$(document).ready(function() {
    const table = $('#officials-table').DataTable({
        pageLength: 6,
        lengthMenu: [6, 10, 25, 50]
    });
});

function openModal(modalId) {
    document.getElementById(modalId).classList.remove("hidden");
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add("hidden");
}
    function showTab(tabId) {
        const tabs = document.querySelectorAll('.tab-content');
        const buttons = document.querySelectorAll('.tab-button');

        tabs.forEach(tab => {
            tab.classList.add('hidden');
            if (tab.id === tabId) {
                tab.classList.remove('hidden');
            }
        });

        buttons.forEach(button => {
            button.classList.remove('active');
            if (button.textContent === tabId.charAt(0).toUpperCase() + tabId.slice(1).replace('Info', ' Info')) {
                button.classList.add('active');
            }
        });
    }

    // Initialize to show the first tab
    showTab('personalInfo');
// CRUD
function editRecord(id) {
    console.log(id);
    $.get('nx_query/manage_officials.php?action=get&id=' + id, function(response) {
        console.log(response)
        if (response.success) {
            const official = response.data;
            document.getElementById('editId').value = official.id;
            document.getElementById('editFname').value = official.fname;
            document.getElementById('editMname').value = official.mname;
            document.getElementById('editLname').value = official.lname;
            document.getElementById('editSuffix').value = official.suffix;
            document.getElementById('editPosition').value = official.position;
            document.getElementById('editContact').value = official.contact;
            document.getElementById('editBday').value = official.bday;

            // Set up the image preview
            const imagePreview = document.getElementById('editImagePreview');
            imagePreview.src = '../../assets/images/pfp/' + official.image; // Update image preview
            imagePreview.style.display = 'block'; // Show the image preview

            openModal('editModal');
        } else {
            swal("Error: " + response.message, {
                icon: "error",
            });
        }
    }).fail(function() {
        swal("Error retrieving record.", {
            icon: "error",
        });
    });
}

function deleteRecord(id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this record!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: 'nx_query/manage_officials.php?action=delete&id=' + id,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        swal("Record deleted successfully!", {
                            icon: "success",
                        }).then(() => {
                            // Optionally refresh the table or remove the row
                            $(`tr[data-id='${id}']`).remove();
                            location.reload();
                             // Remove the row from the table
                        });
                    } else {
                        swal("Error: " + response.message, {
                            icon: "error",
                        });
                    }
                },
                error: function() {
                    swal("Error deleting record.", {
                        icon: "error",
                    });
                }
            });
        }
    });
}
function updateRecord() {
    const id = document.getElementById('editId').value;
    const fname = document.getElementById('editFname').value;
    const mname = document.getElementById('editMname').value;
    const lname = document.getElementById('editLname').value;
    const suffix = document.getElementById('editSuffix').value;
    const position = document.getElementById('editPosition').value;
    const contact = document.getElementById('editContact').value;
    const bday = document.getElementById('editBday').value;

    // Create FormData object for file uploads if needed
    const formData = new FormData();
    formData.append('id', id);
    formData.append('fname', fname);
    formData.append('mname', mname);
    formData.append('lname', lname);
    formData.append('suffix', suffix);
    formData.append('position', position);
    formData.append('contact', contact);
    formData.append('bday', bday);
    
    // If you have an image to upload
    const imageInput = document.getElementById('editImage'); // Assuming you have an input for the image
    if (imageInput.files.length > 0) {
        formData.append('image', imageInput.files[0]);
    }
    console.log('FormData:', Object.fromEntries(formData));


    $.ajax({
        url: 'nx_query/manage_officials.php?action=update',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                swal("Record updated successfully!", {
                    icon: "success",
                }).then(() => {
                    
                    closeModal('editModal');
                });
                location.reload();
            } else {
                swal("Error: " + response.message, {
                    icon: "error",
                });
                location.reload();
            }
        },
        error: function() {
            swal("Error updating record.", {
                icon: "error",
            });
        }
    });
}
function addRecord() {
    const formData = new FormData(document.getElementById('createForm'));

    $.ajax({
        url: 'nx_query/manage_officials.php?action=create',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log('Full server response:', response);
            try {
                const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
                if (jsonResponse.success) {
                    swal("Official added successfully!", {
                        icon: "success",
                    }).then(() => {
                        location.reload();
                        closeModal('createModal');
                    });
                } else {
                    swal("Error: " + (jsonResponse.message || "Unknown error occurred"), {
                        icon: "error",
                    });
                }
            } catch (e) {
                console.error('Error parsing server response:', e);
                console.log('Raw server response:', response);
                swal("Server Error", "The server encountered an error. Please check the server logs.", {
                    icon: "error",
                });
                
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
            console.log('Response Text:', xhr.responseText);
            swal("Error adding record", "Please check the console for more details.", {
                icon: "error",
            });
        }
    });
}

</script>

</script>

<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

