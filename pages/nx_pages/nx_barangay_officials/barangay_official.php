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


    <table id="officials-table" class="display w-full">
        <thead>
            <tr>
                <th>Image</th>
                <th>Full Name</th>
                <th>Position</th>
                <th>Contact</th>
                <th>Birthday</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $official): ?>
                <tr data-id="<?= $official['id'] ?>">
                    <td><img src='../../assets/images/pfp/<?= $official["image"] ?>' style='width:50px;height:auto;' /></td>
                    <td><?= htmlspecialchars($official['full_name']) ?></td>
                    <td><?= htmlspecialchars($official['position']) ?></td>
                    <td><?= htmlspecialchars($official['contact']) ?></td>
                    <td><?= htmlspecialchars($official['bday']) ?></td>
                    <td>
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




<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    const table = $('#officials-table').DataTable({
        pageLength: 4,
        lengthMenu: [4, 10, 25, 50]
    });
});
</script>

<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
