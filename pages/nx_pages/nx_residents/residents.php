<?php
$treeView = 'residents'; // Change this value based on the current page
$sqls = "SELECT 
            *,
            CONCAT_WS(' ', fname, mname, lname, suffix) AS full_name
        FROM 
            tblresident
        ORDER BY 
            fname DESC";

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
<style>
    .tab-button {
        padding: 0.5rem 1rem;
        border: 1px solid #e2e8f0;
        border-bottom: none;
        background-color: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .tab-button:hover {
        background-color: #edf2f7;
    }
    .tab-button.active {
        background-color: #ffffff;
        border-bottom: 2px solid #4299e1;
        font-weight: bold;
        color: #2b6cb0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .tab-content {
        border: 1px solid #e2e8f0;
        padding: 1rem;
        background-color: #ffffff;
    }
</style>
<div class="p-3 w-full bg-white">
    <h1 class="text-3xl font-bold">Residents</h1>
    <hr class="mt-3 mb-5">
    <button onclick="openModal('createModal')" class="bg-green-500 text-white px-4 py-2 rounded mb-4 mt-2">Add Residents</button>

    <table id="officials-table" style="width: 100%;" class="cell-border hover">
        <thead>
            <tr>
                <th>Image</th>
                <th>Full Name</th>
                <th>Voter</th>
                <th>Occupation</th>
                <th>Gender</th>
                <th>Year Stayed</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $official): ?> 
            <tr data-id="<?= $official['id'] ?>">
                <td><img src='../../assets/images/pfp/<?= $official["image"] ?>' style='width:50px;height:auto;' /></td>
                <td><?= htmlspecialchars($official['full_name']) ?>
            </td>
                <td><?= htmlspecialchars($official['voter']) ?></td>
                <td><?= htmlspecialchars($official['occupation']) ?></td>
                <td><?= htmlspecialchars($official['gender']) ?></td>
                <td><?= htmlspecialchars($official['year_stayed']) ?>
                </td> <!-- Ensure this is visible -->
                <td>
                    <button class="text-yellow-500" title="Edit" onclick="editRecord(<?= $official['resident_id'] ?>)">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-red-500" title="Delete" onclick="deleteRecord(<?= $official['resident_id'] ?>)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>
</div>

<!-- Create Official Modal -->
<div id="createModal" class="modal fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-4">
        <span class="cursor-pointer float-right" onclick="closeModal('createModal')">&times;</span>
        <h2 class="text-lg font-semibold mb-4">Create Resident</h2>
        
        <div class="flex mb-4">
            <button onclick="showTab('createPersonalInfo')" class="tab-button active">Personal Info</button>
            <button onclick="showTab('createAddressInfo')" class="tab-button">Address Info</button>
            <button onclick="showTab('createOtherInfo')" class="tab-button">Other Info</button>
        </div>
        
        <form id="createForm" enctype="multipart/form-data" onsubmit="event.preventDefault(); addRecord();">
            <div id="createPersonalInfo" class="tab-content">
                <input type="text" name="fname" id="addFname" placeholder="First Name" class="block w-full mb-2 p-2 border rounded">
                <input type="text" name="mname" id="addMname" placeholder="Middle Name" class="block w-full mb-2 p-2 border rounded">
                <input type="text" name="lname" id="addLname" placeholder="Last Name" class="block w-full mb-2 p-2 border rounded">
                <input type="text" name="suffix" id="addSuffix" placeholder="Suffix" class="block w-full mb-2 p-2 border rounded">
                <input type="date" name="bday" id="addBday" class="block w-full mb-2 p-2 border rounded">
                <input type="number" name="age" id="addAge" placeholder="Age" class="block w-full mb-2 p-2 border rounded" readonly>
                <select name="gender" id="addGender" class="block w-full mb-2 p-2 border rounded">
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text" name="birthplace" id="addBirthplace" placeholder="Birthplace" class="block w-full mb-2 p-2 border rounded">
            </div>

            <div id="createAddressInfo" class="tab-content hidden">
                <input type="number" name="houseNo" id="addHouseNo" placeholder="House Number" class="block w-full mb-2 p-2 border rounded">
                <input type="text" name="purok" id="addPurok" placeholder="Purok" class="block w-full mb-2 p-2 border rounded">
                <input type="text" name="brgy" id="addBrgy" placeholder="Barangay" class="block w-full mb-2 p-2 border rounded">
                <input type="text" name="municipality" id="addMunicipality" placeholder="Municipality" class="block w-full mb-2 p-2 border rounded">
                <input type="text" name="province" id="addProvince" placeholder="Province" class="block w-full mb-2 p-2 border rounded">
            </div>

            <div id="createOtherInfo" class="tab-content hidden">
                <select name="civil_status" id="addCivilStatus" class="block w-full mb-2 p-2 border rounded">
                    <option value="" disabled>Civil Status</option>
                    <option value="Single" selected>Single</option>
                    <option value="Married">Married</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Divorced">Divorced</option>
                </select>
                <input type="text" name="year_stayed" id="addYearStayed" placeholder="Years Stayed" class="block w-full mb-2 p-2 border rounded">
                <input type="text" name="education" id="addEducation" placeholder="Education" class="block w-full mb-2 p-2 border rounded">
                <select name="head_fam" id="addHeadFam" class="block w-full mb-2 p-2 border rounded">
                    <option value="" disabled selected>Head of Family?</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                <input type="text" name="occupation" id="addOccupation" placeholder="Occupation" class="block w-full mb-2 p-2 border rounded">
                <select name="voter" id="addVoter" class="block w-full mb-2 p-2 border rounded">
                    <option value="" disabled selected>Voter?</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                <input type="file" name="image" id="addImage" class="block w-full mb-2 p-2 border rounded">
            </div>

            <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Create</button>
        </form>
    </div>
</div>

<!-- Edit Official Modal -->
<div id="editModal" class="modal fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-4">
        <span class="cursor-pointer float-right" onclick="closeModal('editModal')">&times;</span>
        <h2 class="text-lg font-semibold mb-4">Edit Resident</h2>

        <div class="flex mb-4">
            <button onclick="showTab('editPersonalInfo')" class="tab-button active">Personal Info</button>
            <button onclick="showTab('editAddressInfo')" class="tab-button">Address Info</button>
            <button onclick="showTab('editOtherInfo')" class="tab-button">Other Info</button>
        </div>

        <form id="editForm" enctype="multipart/form-data">
            <input type="hidden" id="editId" name="resident_id">

            <div id="editPersonalInfo" class="tab-content">
                <input type="text" id="editFname" name="fname" placeholder="First Name" class="block w-full mb-2 p-2 border rounded">
                <input type="text" id="editMname" name="mname" placeholder="Middle Name" class="block w-full mb-2 p-2 border rounded">
                <input type="text" id="editLname" name="lname" placeholder="Last Name" class="block w-full mb-2 p-2 border rounded">
                <input type="text" id="editSuffix" name="suffix" placeholder="Suffix" class="block w-full mb-2 p-2 border rounded">
                <input type="date" id="editBday" name="bday" class="block w-full mb-2 p-2 border rounded">
                <input type="number" id="editAge" name="age" placeholder="Age" class="block w-full mb-2 p-2 border rounded">
                <select id="editGender" name="gender" class="block w-full mb-2 p-2 border rounded">
                    <option value="" disabled selected>Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text" id="editBirthplace" name="birthplace" placeholder="Birthplace" class="block w-full mb-2 p-2 border rounded">
            </div>

            <div id="editAddressInfo" class="tab-content hidden">
                <input type="number" id="editHouseNo" name="houseNo" placeholder="House No." class="block w-full mb-2 p-2 border rounded">
                <input type="text" id="editPurok" name="purok" placeholder="Purok" class="block w-full mb-2 p-2 border rounded">
                <input type="text" id="editBrgy" name="brgy" placeholder="Barangay" class="block w-full mb-2 p-2 border rounded">
                <input type="text" id="editMunicipality" name="municipality" placeholder="Municipality" class="block w-full mb-2 p-2 border rounded">
                <input type="text" id="editProvince" name="province" placeholder="Province" class="block w-full mb-2 p-2 border rounded">
            </div>

            <div id="editOtherInfo" class="tab-content hidden">
                <select id="editCivilStatus" name="civil_status" class="block w-full mb-2 p-2 border rounded">
                    <option value="" disabled selected>Civil Status</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Divorced">Divorced</option>
                </select>
                <input type="text" id="editYearStayed" name="year_stayed" placeholder="Years Stayed" class="block w-full mb-2 p-2 border rounded">
                <input type="text" id="editEducation" name="education" placeholder="Education" class="block w-full mb-2 p-2 border rounded">
                <select id="editHeadFam" name="head_fam" class="block w-full mb-2 p-2 border rounded">
                    <option value="" disabled selected>Head of Family?</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                <input type="text" id="editOccupation" name="occupation" placeholder="Occupation" class="block w-full mb-2 p-2 border rounded">
                <select id="editVoter" name="voter" class="block w-full mb-2 p-2 border rounded">
                    <option value="" disabled selected>Voter?</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                <input type="file" id="editImage" name="image" class="block w-full mb-2 p-2 border rounded">
                <img id="editImagePreview" src="" alt="Current Image" class="mb-2" style="display:none; width:100%; max-width:100px; height:auto;">
            </div>

            <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">Update</button>
        </form>
    </div>
</div>


<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    const table = $('#officials-table').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        scrollX: true
    });

    $('#account_type_filter').on('change', function() {
        const accountType = this.value;
        table.column(5).search(accountType).draw(); // Assuming 'account_type' is in the 6th column (index 5)
    });
    showTab('createPersonalInfo');
    showTab('editPersonalInfo');
});


function openModal(modalId) {
    console.log(modalId)
    if(modalId === 'createModal'){
        showTab('createPersonalInfo');
    }
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
        if (button.textContent === tabId.replace(/([A-Z])/g, ' $1').trim().replace(/^(create|edit)/, '')) {
            button.classList.add('active');
        }
    });
}
document.getElementById('addBday').addEventListener('change', function() {
    const birthday = new Date(this.value);
    const today = new Date();

    let age = today.getFullYear() - birthday.getFullYear();
    const monthDifference = today.getMonth() - birthday.getMonth();

    // Adjust age if the birthday hasn't occurred yet this year
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthday.getDate())) {
        age--;
    }

    document.getElementById('addAge').value = age;
});

// CRUD
function editRecord(id) {
    $.get('nx_query/manage_residents.php?action=get&id=' + id, function(response) {
        if (response.success) {
            const official = response.data;
            console.log(official);
            // Set form fields with values from the official object
            document.getElementById('editId').value = official.resident_id;
            document.getElementById('editFname').value = official.fname || '';
            document.getElementById('editMname').value = official.mname || '';
            document.getElementById('editLname').value = official.lname || '';
            document.getElementById('editSuffix').value = official.suffix || '';
            document.getElementById('editBday').value = official.bday || '';
            document.getElementById('editGender').value = official.gender || ''; // Handle user-defined values
            document.getElementById('editAge').value = official.age || ''; 
            document.getElementById('editHouseNo').value = official.houseNo || '';
            document.getElementById('editPurok').value = official.purok || '';
            document.getElementById('editBrgy').value = official.brgy || '';
            document.getElementById('editMunicipality').value = official.municipality || '';
            document.getElementById('editProvince').value = official.province || '';
            document.getElementById('editCivilStatus').value = official.civil_status || '';
            document.getElementById('editEducation').value = official.education || '';
            document.getElementById('editOccupation').value = official.occupation || '';
            document.getElementById('editBirthplace').value = official.birthplace || '';

            // Set Voter status dropdown
            const voterSelect = document.getElementById('editVoter');
            voterSelect.value = official.voter || '';

            // Set Head of Family dropdown
            const headFamSelect = document.getElementById('editHeadFam');
            headFamSelect.value = official.head_fam || '';

            // Set up the image preview
            const imagePreview = document.getElementById('editImagePreview');
            imagePreview.src = '../../assets/images/pfp/' + (official.image || 'default.png'); // Use a default image if none exists
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
                url: 'nx_query/manage_residents.php?action=delete&id=' + id,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        swal("Record deleted successfully!", {
                            icon: "success",
                        }).then(() => {
                            // Optionally refresh the table or remove the row
                            $(`tr[data-id='${id}']`).remove(); // Remove the row from the table
                            location.reload();
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


function addRecord() {
    const formData = new FormData(document.getElementById('createForm'));

    $.ajax({
        url: 'nx_query/manage_residents.php?action=create',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                swal("Resident added successfully!", {
                    icon: "success",
                }).then(() => {
                    location.reload(); // Reload the page or refresh the table
                });
            } else {
                swal("Error: " + response.message, {
                    icon: "error",
                });
            }
        },
        error: function() {
            swal("Error adding resident.", {
                icon: "error",
            });
        }
    });
}
function updateRecord(event) {
    event.preventDefault();

    const formData = new FormData(document.getElementById('editForm'));

    // Ensure resident_id is included in the formData
    const residentId = document.getElementById('editId').value;
    formData.append('resident_id', residentId);

    // Append additional fields directly without if statements
    document.getElementById('editFname').value && formData.append('fname', document.getElementById('editFname').value);
    document.getElementById('editMname').value && formData.append('mname', document.getElementById('editMname').value);
    document.getElementById('editLname').value && formData.append('lname', document.getElementById('editLname').value);
    document.getElementById('editSuffix').value && formData.append('suffix', document.getElementById('editSuffix').value);
    document.getElementById('editBday').value && formData.append('bday', document.getElementById('editBday').value);
    document.getElementById('editAge').value && formData.append('age', document.getElementById('editAge').value);
    document.getElementById('editGender').value && formData.append('gender', document.getElementById('editGender').value);
    document.getElementById('editBirthplace').value && formData.append('birthplace', document.getElementById('editBirthplace').value);
    document.getElementById('editHouseNo').value && formData.append('houseNo', document.getElementById('editHouseNo').value);
    document.getElementById('editPurok').value && formData.append('purok', document.getElementById('editPurok').value);
    document.getElementById('editBrgy').value && formData.append('brgy', document.getElementById('editBrgy').value);
    document.getElementById('editMunicipality').value && formData.append('municipality', document.getElementById('editMunicipality').value);
    document.getElementById('editProvince').value && formData.append('province', document.getElementById('editProvince').value);
    document.getElementById('editCivilStatus').value && formData.append('civil_status', document.getElementById('editCivilStatus').value);
    document.getElementById('editYearStayed').value && formData.append('year_stayed', document.getElementById('editYearStayed').value);
    document.getElementById('editEducation').value && formData.append('education', document.getElementById('editEducation').value);
    document.getElementById('editHeadFam').value && formData.append('head_fam', document.getElementById('editHeadFam').value);
    document.getElementById('editOccupation').value && formData.append('occupation', document.getElementById('editOccupation').value);
    document.getElementById('editVoter').value && formData.append('voter', document.getElementById('editVoter').value);

    // Handle the image file
    const imageFile = document.getElementById('editImage').files[0];
    imageFile && formData.append('image', imageFile);

    // Log FormData contents
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    $.ajax({
        url: 'nx_query/manage_residents.php?action=update',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);
            if (response.success) {
                swal("Resident updated successfully!", {
                    icon: "success",
                }).then(() => {
                    location.reload(); // Reload the page or refresh the table
                });
            } else {
                swal("Error: " + response.message, {
                    icon: "error",
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            swal("Error updating resident.", {
                icon: "error",
            });
        }
    });
}


// Ensure this event listener is properly set
document.getElementById('editForm').addEventListener('submit', updateRecord);

</script>


