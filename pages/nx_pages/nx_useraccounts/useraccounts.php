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
                    
                    <button class="bg-black text-white px-4 py-2 rounded mb-4 mt-2" title="View" onclick="viewRecord(<?= $official['id'] ?>)">
                        <i class="fa-solid fa-eye"></i>
                    </button>
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

<div id="viewModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
  <div class="flex items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-4xl">
      <div class="flex justify-between items-start mb-6 p-4">
        <h2 class="text-2xl font-bold text-gray-800">View Registered Account</h2>
        <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="closeModal('viewModal')">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Tabs -->
      <div class="mb-6">
        <nav class="flex space-x-4">
          <button class="text-gray-500 hover:text-gray-700 font-medium py-2 px-4 rounded-t-lg active:text-gray-800 active:border-b-2 active:border-gray-800" onclick="showTab('personal-info')">Personal Info</button>
          <button class="text-gray-500 hover:text-gray-700 font-medium py-2 px-4 rounded-t-lg active:text-gray-800 active:border-b-2 active:border-gray-800" onclick="showTab('contact-info')">Contact Info</button>
          <button class="text-gray-500 hover:text-gray-700 font-medium py-2 px-4 rounded-t-lg active:text-gray-800 active:border-b-2 active:border-gray-800" onclick="showTab('account-info')">Account Info</button>
          <button class="text-gray-500 hover:text-gray-700 font-medium py-2 px-4 rounded-t-lg active:text-gray-800 active:border-b-2 active:border-gray-800" onclick="showTab('other-info')">Other Info</button>
        </nav>
      </div>

      <!-- Tab Content -->
      <div id="personal-info-tab" class="block p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="bg-gray-100 p-6 rounded-lg shadow-md">
            <h3 class="font-medium text-gray-700 mb-2">Full Name</h3>
            <p id="viewFname" class="text-gray-600">-</p>
            <p id="viewMname" class="text-gray-600">-</p>
            <p id="viewLname" class="text-gray-600">-</p>
            <p id="viewSuffix" class="text-gray-600">-</p>
          </div>

          <div class="bg-gray-100 p-6 rounded-lg shadow-md">
            <h3 class="font-medium text-gray-700 mb-2">Birth Details</h3>
            <p><strong>Birthday:</strong> <span id="viewBday" class="text-gray-600">-</span></p>
            <p><strong>Age:</strong> <span id="viewAge" class="text-gray-600">-</span></p>
          </div>
        </div>
      </div>

      <div id="contact-info-tab" class="hidden p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="bg-gray-100 p-6 rounded-lg shadow-md">
            <h3 class="font-medium text-gray-700 mb-2">Contact & Address</h3>
            <p><strong>Contact:</strong> <span id="viewContact" class="text-gray-600">-</span></p>
            <p><strong>House No:</strong> <span id="viewHouseNo" class="text-gray-600">-</span></p>
            <p><strong>Street:</strong> <span id="viewStreet" class="text-gray-600">-</span></p>
            <p><strong>Barangay:</strong> <span id="viewBrgy" class="text-gray-600">-</span></p>
            <p><strong>Municipality:</strong> <span id="viewMunicipality" class="text-gray-600">-</span></p>
            <p><strong>Province:</strong> <span id="viewProvince" class="text-gray-600">-</span></p>
          </div>
        </div>
      </div>

      <div id="account-info-tab" class="hidden p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="bg-gray-100 p-6 rounded-lg shadow-md">
            <h3 class="font-medium text-gray-700 mb-2">Account Information</h3>
            <p><strong>Email:</strong> <span id="viewEmail" class="text-gray-600">-</span></p>
            <p><strong>Username:</strong> <span id="viewUsername" class="text-gray-600">-</span></p>
            <p><strong>ID Type:</strong> <span id="viewIdType" class="text-gray-600">-</span></p>
            <p><strong>Account Type:</strong> <span id="viewAccountType" class="text-gray-600">-</span></p>
          </div>
        </div>
      </div>

      <div id="other-info-tab" class="hidden p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="bg-gray-100 p-6 rounded-lg shadow-md">
            <h3 class="font-medium text-gray-700 mb-2">Gender & Status</h3>
            <p><strong>Gender:</strong> <span id="viewGender" class="text-gray-600">-</span></p>
            <p><strong>Admin Status:</strong> <span id="viewIsAdmin" class="text-gray-600">-</span></p>
            <p><strong>Approval Status:</strong> <span id="viewIsApproved" class="text-gray-600">-</span></p>
          </div>

          <div class="bg-gray-100 p-6 rounded-lg shadow-md">
            <h3 class="font-medium text-gray-700 mb-2">Profile Image</h3>
            <img id="viewImagePreview" src="" alt="Profile Image" class="mb-2" style="display:none; max-width: 150px; height: auto;">
          </div>

          <div class="bg-gray-100 p-6 rounded-lg shadow-md">
            <h3 class="font-medium text-gray-700 mb-2">Identification File</h3>
            <p id="viewIdFilePreview" class="text-gray-600">-</p>
          </div>
        </div>
      </div>


    </div>
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
    showTab('personal-info')
    // Initialize to show the first tab
    showTab('personalInfo');
// CRUD
function viewRecord(id) {
    $.get('nx_query/manage_residents.php?action=gets&id=' + id, function(response) {
        if (response.success) {
            const official = response.data;

            // Display data in the modal
            document.getElementById('viewFname').textContent = official.fname;
            document.getElementById('viewMname').textContent = official.mname;
            document.getElementById('viewLname').textContent = official.lname;
            document.getElementById('viewSuffix').textContent = official.suffix;
            document.getElementById('viewBday').textContent = official.bday;
            document.getElementById('viewAge').textContent = official.age;
            document.getElementById('viewContact').textContent = official.contact;
            document.getElementById('viewHouseNo').textContent = official.houseNo;
            document.getElementById('viewStreet').textContent = official.street;
            document.getElementById('viewBrgy').textContent = official.brgy;
            document.getElementById('viewMunicipality').textContent = official.municipality;
            document.getElementById('viewProvince').textContent = official.province;
            document.getElementById('viewEmail').textContent = official.email;
            document.getElementById('viewUsername').textContent = official.username;
            document.getElementById('viewIdType').textContent = official.id_type;
            document.getElementById('viewAccountType').textContent = official.account_type === 1 ? 'Resident' : 'Non-Resident';
            document.getElementById('viewGender').textContent = official.gender === 1 ? 'Male' : 'Female';
            document.getElementById('viewIsAdmin').textContent = official.isAdmin ? 'Yes' : 'No';
            document.getElementById('viewIsApproved').textContent = official.isApproved ? 'Approved' : 'Not Approved';

            // Display profile image if available
            const imagePreview = document.getElementById('viewImagePreview');
            imagePreview.src = '../../assets/images/pfp/' + official.image;
            imagePreview.style.display = 'block'; // Show the image preview

            // Display ID file if exists
            const idFilePreview = document.getElementById('viewIdFilePreview');
            if (official.id_file) {
                const img = document.createElement('img');
                img.src = official.id_file;  // Set the source to the file path
                img.alt = 'ID File Preview';

                // Set fixed dimensions using JavaScript
                img.style.width = '150px';  // Adjust width as needed
                img.style.height = 'auto';  // Maintains aspect ratio
                img.style.maxHeight = '200px';  // Optional: set a maximum height

                // Clear any previous content and append the image
                idFilePreview.innerHTML = '';
                idFilePreview.appendChild(img);
            } else {
                idFilePreview.textContent = 'No ID file uploaded';
            }

            openModal('viewModal');
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

  function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('[id$="-tab"]').forEach(tab => tab.classList.add('hidden'));

    // Show the selected tab
    document.getElementById(`${tabName}-tab`).classList.remove('hidden');

    // Add active class to the selected tab button
    document.querySelectorAll('.nav-tab').forEach(tab => tab.classList.remove('active:text-gray-800', 'active:border-b-2', 'active:border-gray-800'));
    document.querySelector(`.nav-tab[onclick="showTab('${tabName}')"]`).classList.add('active:text-gray-800', 'active:border-b-2', 'active:border-gray-800');
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