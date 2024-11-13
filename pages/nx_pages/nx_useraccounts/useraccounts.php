<?php
$sqls = "SELECT 
            *,
            CONCAT_WS(' ', fname, mname, lname, suffix) AS full_name,
            image 
        FROM 
            tblregistered_account
        ORDER BY 
            isApproved DESC";

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

<div class="p-3 w-full bg-white">
    <h1 class="text-3xl font-bold">User Accounts</h1>
    <hr class="mt-3 mb-5">
    <!-- <button onclick="openModal('createModal')" class="bg-green-500 text-white px-4 py-2 rounded mb-4 mt-2">Add Official</button> -->

    <div class="filter-container mb-6 flex items-center space-x-4">
        <!-- Account Type Filter -->
        <div class="flex items-center">
            <label for="account_type_filter" class="mr-2 text-sm font-medium text-gray-700">Account Type:</label>
            <select id="account_type_filter" class="form-select block w-48 p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                <option value="">All</option>
                <option value="0">Non Resident</option>
                <option value="1">Resident</option>
            </select>
        </div>
    </div>


    <table id="officials-table" style="width: 100%;" class="cell-border hover">
        <thead>
            <tr>
                <th>Image</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Birthday</th>
                <th>Account Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $official): ?> 
            <tr data-id="<?= $official['id'] ?>">
                <td><img src='../../assets/images/pfp/<?= $official["image"] ?>' style='width:50px;height:auto;' /></td>
                <td>
                    <div><?= htmlspecialchars($official['full_name']) ?></div>
                    <div>
                        <span class="badge 
                            <?= $official['isApproved'] == '1' ? 'bg-green-500' : 'bg-red-500' ?> 
                            text-white text-sm px-2 py-1 rounded-full">
                            <?= $official['isApproved'] == '1' ? 'Approved' : 'Disapproved' ?>
                        </span>
                    </div>
                </td>

            </td>
                <td><?= htmlspecialchars($official['email']) ?></td>
                <td><?= htmlspecialchars($official['contact']) ?></td>
                <td><?= htmlspecialchars($official['bday']) ?></td>
                <td><?= htmlspecialchars($official['account_type'] == 0 ? 'Non-resident' : 'Resident') ?>
                <span class="hidden">
                    <?= htmlspecialchars($official['account_type'] == 0 ? '0' : '1') ?>
                </span>
                </td>
                <td class="flex space-x-2">
                    <button class="bg-red-500 text-white px-4 py-2 rounded mb-4 mt-2" title="Delete" onclick="deleteRecord(<?= $official['id'] ?>)">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button 
                        class="toggle-approval-button <?= $official['isApproved'] == '1' ? 'bg-purple-500' : 'bg-yellow-500' ?> text-white px-4 py-2 rounded mb-4 mt-2" 
                        title="<?= $official['isApproved'] == '1' ? 'Disapprove' : 'Approve' ?>" 
                        data-approved="<?= $official['isApproved'] ?>" 
                        onclick="toggleApproval(<?= $official['id'] ?>, <?= $official['isApproved'] == '1' ? 'true' : 'false' ?>, this)">
                        <i class="fa-regular <?= $official['isApproved'] == '1' ? 'fa-thumbs-down' : 'fa-thumbs-up' ?>"></i>
                    </button>


                    <?php if ($_SESSION['user']['isAdmin'] == '2'): ?>
                        <?php if ($official['isAdmin'] == '1'): ?>
                            <button onclick="removeAdmin(<?= $official['id'] ?>)" title='Remove Admin' class="bg-red-300 text-white px-4 py-2 rounded mb-4 mt-2">
                                <i class="fas fa-user-times"></i>
                            </button>
                        <?php else: ?>
                            <button onclick="setAdmin(<?= $official['id'] ?>)" title='Set Admin' class="bg-green-500 text-white px-4 py-2 rounded mb-4 mt-2">
                                <i class="fas fa-user-shield"></i> 
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>
</div>

<!-- MODALS SECTION -->
<!-- Create Official Modal -->
<div id="createModal" class="modal fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <span class="cursor-pointer float-right" onclick="closeModal('createModal')">&times;</span>
        <h2 class="text-lg font-semibold mb-4">Create Official</h2>
        <form id="createForm" enctype="multipart/form-data" onsubmit="event.preventDefault(); addRecord();">
            <input type="text" name="fname" id="addFname" placeholder="First Name" class="block w-full mb-2 p-2 border rounded" required>
            <input type="text" name="mname" id="addMname" placeholder="Middle Name" class="block w-full mb-2 p-2 border rounded">
            <input type="text" name="lname" id="addLname" placeholder="Last Name" class="block w-full mb-2 p-2 border rounded" required>
            <input type="text" name="suffix" id="addSuffix" placeholder="Suffix" class="block w-full mb-2 p-2 border rounded">
            <input type="text" name="position" id="addPosition" placeholder="Position" class="block w-full mb-2 p-2 border rounded" required>
            <input type="text" name="contact" id="addContact" placeholder="Contact" class="block w-full mb-2 p-2 border rounded" required>
            <input type="date" name="bday" id="addBday" class="block w-full mb-2 p-2 border rounded" required>
            <input type="file" name="image" id="addImage" class="block w-full mb-2 p-2 border rounded" required>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Create</button>
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
// function editRecord(id) {
    
//     $.get('nx_query/manage_officials.php?action=get&id=' + id, function(response) {
//         if (response.success) {
//             const official = response.data;
//             document.getElementById('editId').value = official.id;
//             document.getElementById('editFname').value = official.fname;
//             document.getElementById('editMname').value = official.mname;
//             document.getElementById('editLname').value = official.lname;
//             document.getElementById('editSuffix').value = official.suffix;
//             document.getElementById('editPosition').value = official.position;
//             document.getElementById('editContact').value = official.contact;
//             document.getElementById('editBday').value = official.bday;

//             // Set up the image preview
//             const imagePreview = document.getElementById('editImagePreview');
//             imagePreview.src = '../../assets/images/pfp/' + official.image; // Update image preview
//             imagePreview.style.display = 'block'; // Show the image preview

//             openModal('editModal');
//         } else {
//             swal("Error: " + response.message, {
//                 icon: "error",
//             });
//         }
//     }).fail(function() {
//         swal("Error retrieving record.", {
//             icon: "error",
//         });
//     });
// }

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
                url: 'nx_query/manage_residents.php?action=deletes&id=' + id,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        swal("Record deleted successfully!", {
                            icon: "success",
                        }).then(() => {
                            // Optionally refresh the table or remove the row
                            $(`tr[data-id='${id}']`).remove(); // Remove the row from the table
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
function setAdmin(id) {
    swal({
        title: "Are you sure?",
        text: "This user will be set as an admin!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSetAdmin) => {
        if (willSetAdmin) {
            $.ajax({
                url: 'nx_query/manage_residents.php?action=setAdmin&id=' + id,
                type: 'POST',
                success: function(response) {
                    if (response.success) {
                        swal("User set as admin successfully!", {
                            icon: "success",
                        });
                    } else {
                        swal("Error: " + response.message, {
                            icon: "error",
                        });
                    }
                },
                error: function() {
                    swal("Error setting user as admin.", {
                        icon: "error",
                    });
                }
            });
        }
    });
}
function removeAdmin(id) {
    // AJAX call to remove admin status
    $.ajax({
        url: 'nx_query/manage_residents.php?action=removeAdmin&id=' + id,
        type: 'POST',
        success: function(response) {
            if (response.success) {
                swal("User is no longer an admin!", {
                    icon: "success",
                }).then(() => {
                    // Optionally, refresh the page or update the UI
                });
            } else {
                swal("Error: " + response.message, {
                    icon: "error",
                });
            }
        },
        error: function() {
            swal("Error updating admin status.", {
                icon: "error",
            });
        }
    });
}

function toggleApproval(id, currentApprovalState, button) {
  // Now we're passing the button directly
  if (!button) {
    console.error("Button element not found");
    return;
  }

  // The new state should be the opposite of the current state
  const newApprovalState = !currentApprovalState;
  
  // Determine the action text based on new approval state
  const actionText = newApprovalState ? "approve" : "disapprove";
  
  swal({
    title: "Are you sure?",
    text: `You will ${actionText} this user!`,
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((willProceed) => {
    if (willProceed) {
      $.ajax({
        url: "nx_query/manage_residents.php?action=setapprove&resident_id=" + id,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({ isApproved: newApprovalState }),
        success: function(response) {
          try {
            // Parse the response if it's a string
            const result = typeof response === 'string' ? JSON.parse(response) : response;
            
            if (result.success) {
              // Update button classes
              button.classList.remove(currentApprovalState ? 'bg-purple-500' : 'bg-yellow-500');
              button.classList.add(newApprovalState ? 'bg-purple-500' : 'bg-yellow-500');
              
              // Update button title
              button.setAttribute('title', newApprovalState ? 'Disapprove' : 'Approve');
              button.setAttribute('data-approved', newApprovalState ? '1' : '0');
              
              // Update icon
              const icon = button.querySelector('i');
              if (icon) {
                icon.classList.remove('fa-thumbs-up', 'fa-thumbs-down');
                icon.classList.add(newApprovalState ? 'fa-thumbs-down' : 'fa-thumbs-up');
              }
              
              swal("Status updated successfully!", {
                icon: "success",
              });
              
              // Optionally reload the page or update the UI
              setTimeout(() => {
                location.reload();
              }, 1500);
            } else {
              swal("Error: " + (result.message || "Unknown error"), {
                icon: "error",
              });
            }
          } catch (e) {
            console.error("Error parsing response:", e);
            swal("Error processing response", {
              icon: "error",
            });
          }
        },
        error: function(xhr, status, error) {
          console.error("Ajax error:", error);
          swal("Error updating record: " + error, {
            icon: "error",
          });
        }
      });
    }
  });
}
</script>