<?php
$treeView = 'headofthefamily'; // Change this value based on the current page

// Change this query to get the head of the family along with the total members in each house
$sqls = "SELECT 
            houseNo, 
            COUNT(*) as total_members,
            MAX(CONCAT(fname, ' ', lname)) as head_of_family
        FROM 
            tblresident
        WHERE 
            head_fam = 'yes'
        GROUP BY 
            houseNo
        ORDER BY 
            houseNo ASC";

$resuktSqks = $conn->query($sqls);

// Initialize an array to hold the data
$data = [];

if ($resuktSqks->num_rows > 0) {
    // Fetch each row and append it to the data array
    while ($row = $resuktSqks->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "No records found.";
}

?>

<div class="p-3 w-full bg-white">
    <p class="text-3xl mb-3">HEAD OF FAMILY LIST</p>
    <hr class="mt-3 mb-3">
    <table id="officials-table" style="width: 100%;" class="cell-border hover">
        <thead>
            <tr>
                <th>House Number</th>
                <th>Total Members</th>
                <th>Head of Family</th>
                <!-- Add more headers as needed -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $resident): ?>
                <tr>
                    <td><?php echo htmlspecialchars($resident['houseNo']); ?></td>
                    <td>
                        <?php echo htmlspecialchars($resident['total_members']); ?>
                        <button class=" hover:text-blue-700 text-blue-500 font-bold rounded" onclick="showModal(<?php echo $resident['houseNo']; ?>)"><i title="View" class="fa-regular fa-eye"></i></button>
                    </td>
                    <td><?php echo htmlspecialchars($resident['head_of_family']); ?></td>
                    <!-- Add more cells as needed -->
                </tr>

                <!-- Modal for displaying members assigned to each head of family -->
                <div id="modal-<?php echo $resident['houseNo']; ?>" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-headline" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">Members assigned to <?php echo htmlspecialchars($resident['head_of_family']); ?></h3>
                                        <div class="mt-2">
                                            <?php
                                            $conn = new mysqli('localhost', 'root', '', 'north');

                                            $sql_members = "SELECT * FROM tblresident WHERE houseNo = '" . $resident['houseNo'] . "'";
                                            $result_members = $conn->query($sql_members);
                                            if ($result_members->num_rows > 0) {
                                                while ($member = $result_members->fetch_assoc()) {
                                                    echo "<p>" . htmlspecialchars($member['fname'] . ' ' . $member['lname']) . "</p>";
                                                }
                                            } else {
                                                echo "No members found.";
                                            }
                                            $conn->close();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="hideModal(<?php echo $resident['houseNo']; ?>)">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
 </tbody>
    </table>
</div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"> -->
<script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
<script>
$(document).ready(function() {
    const table = $('#officials-table').DataTable({
        pageLength: 5,
        lengthMenu: [5, 10, 25, 50],
        scrollX: true
    });
});
    function showModal(houseNo) {
        document.getElementById('modal-' + houseNo).classList.remove('hidden');
    }

    function hideModal(houseNo) {
        document.getElementById('modal-' + houseNo).classList.add('hidden');
    }
</script>