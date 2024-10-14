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

<div class="p-3 w-full bg-white">
    <h1 class="text-3xl font-bold">Barangay Officials</h1>
    <hr>

    <div class="mb-4 mt-4 flex justify-between">
        <input type="text" id="search-input" placeholder="Search..." class="p-2 border border-gray-300 rounded">
        <button class="text-white bg-green-600 p-2 rounded" id="open-modal">Add Official</button>
    </div>

    <div id="example-table" style="height: 400px; width: 100%;"></div>
</div>

<!-- Modal for Adding Official -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center h-screen flex">
    <div class="bg-white rounded-lg shadow-lg p-5 w-80 md:w-96">
        <h2 class="text-xl font-bold mb-4">Add Official</h2>
        <form id="add-official-form" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block mb-2">First Name:</label>
                    <input type="text" id="first_name" class="p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div>
                    <label class="block mb-2">Middle Name:</label>
                    <input type="text" id="middle_name" class="p-2 border border-gray-300 rounded w-full">
                </div>
                <div>
                    <label class="block mb-2">Last Name:</label>
                    <input type="text" id="last_name" class="p-2 border border-gray-300 rounded w-full" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-2">Position:</label>
                <input type="text" id="position" class="p-2 border border-gray-300 rounded w-full" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2">Contact:</label>
                <input type="text" id="contact" class="p-2 border border-gray-300 rounded w-full" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2">Birthday:</label>
                <input type="date" id="bday" class="p-2 border border-gray-300 rounded w-full" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2">Image Upload:</label>
                <input type="file" id="image" accept="image/*" class="p-2 border border-gray-300 rounded w-full" required>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Add Official</button>
                <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded ml-2" id="close-modal">Close</button>
            </div>
        </form>
    </div>
</div>


<script>
// Data fetched from PHP
const tableData = <?php echo json_encode($data); ?>;

// Create Tabulator table
const table = new Tabulator("#example-table", {
    data: tableData, // Set data for the table
    layout: "fitColumns", // Fit columns to width of table
    height: "400px", // Set height for the table
    columns: [
        { title: "ID", field: "id", visible: false }, // Hide ID
        { title: "Image", field: "image", formatter: function(cell) {
            return "<img src='../../assets/images/pfp/" + cell.getValue() + "' style='width:50px;height:auto;' />";
        }},
        { title: "Full Name", field: "full_name" },
        { title: "Position", field: "position" },
        { title: "Contact", field: "contact" },
        { title: "Birthday", field: "bday" },
        {
            title: "Actions", 
            field: "actions", 
            formatter: function(cell) {
                const id = cell.getRow().getData().id; // Get the row ID
                return `
                    <div class="flex space-x-2">
                        <button class="text-yellow-500" title="Edit" onclick="editRecord(${id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="text-red-500" title="Delete" onclick="deleteRecord(${id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
            }
        },
    ],
    pagination: "local", // Enable pagination
    paginationSize: 10, // Number of rows per page
    movableColumns: true, // Allow column order to be changed
    resizableRows: true, // Allow row height to be changed
    placeholder: "No Data Available", // Placeholder for empty data
});

// Add search functionality
document.getElementById("search-input").addEventListener("keyup", function() {
    const searchTerm = this.value.toLowerCase(); // Convert search term to lowercase
    table.setFilter(function(data) {
        return Object.values(data).some(value => 
            value && value.toString().toLowerCase().includes(searchTerm)
        );
    });
});

// Open modal event
document.getElementById("open-modal").addEventListener("click", function() {
    document.getElementById("modal").classList.remove("hidden");
});

// Close modal event
document.getElementById("close-modal").addEventListener("click", function() {
    document.getElementById("modal").classList.add("hidden");
});

// Add Official form submission
document.getElementById("add-official-form").addEventListener("submit", function(e) {
    e.preventDefault();
    
    // Gather form data
    const newOfficial = {
        id: table.getData().length + 1, // Simulate ID increment
        full_name: document.getElementById("full_name").value,
        position: document.getElementById("position").value,
        contact: document.getElementById("contact").value,
        bday: document.getElementById("bday").value,
        image: document.getElementById("image").value,
    };

    // Add to table
    table.addData([newOfficial]);

    // Reset form fields
    this.reset();
    document.getElementById("modal").classList.add("hidden");

    // SweetAlert notification
    Swal.fire({
        title: 'Success!',
        text: 'Official added successfully!',
        icon: 'success',
        confirmButtonText: 'Okay'
    });
});

// Delete record function with SweetAlert confirmation
function deleteRecord(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Simulate deletion
            table.deleteRow(id); // Assuming 'id' is the row ID
            Swal.fire(
                'Deleted!',
                'Your record has been deleted.',
                'success'
            );
        }
    });
}
</script>
