<?php

$sqls = "SELECT 
    h.houseNo,
    h.fname,
    h.lname,
    h.purok,
    h.brgy,
    h.province,
    h.municipality,
    h.relation,
    CONCAT(h.fname, ' ', h.lname) as head_of_family,
    (SELECT COUNT(*) 
     FROM tblresident m 
     WHERE m.houseNo = h.houseNo) as total_members
FROM tblresident h
WHERE h.head_fam = 'yes'
ORDER BY h.houseNo ASC";

$resultSqls = $conn->query($sqls);

// Initialize data array
$data = [];

if ($resultSqls->num_rows > 0) {
    while ($row = $resultSqls->fetch_assoc()) {
        $data[] = $row;
    }
}

// Function to get family members
function getFamilyMembers($houseNo) {
    global $conn;
    $sql_members = "SELECT 
        fname,
        lname,
        head_fam,
        relation,
        CONCAT(fname, ' ', lname) as full_name
    FROM tblresident 
    WHERE houseNo = ?
    ORDER BY head_fam DESC, fname ASC";
    
    $stmt = $conn->prepare($sql_members);
    $stmt->bind_param("s", $houseNo);
    $stmt->execute();
    return $stmt->get_result();
}
?>


    <div class="p-3 w-full bg-white shadow-lg rounded-lg">
        <p class="text-3xl mb-3 font-bold text-gray-800">HEAD OF FAMILY LIST</p>
        <hr class="mt-3 mb-3">
        <button class='p-3 bg-blue-500 rounded-lg mb-8 text-white' onclick="GenerateReport()">
            Generate Report
        </button>
        <table id="officials-table" class="cell-border hover" style='width: 100%;'>
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">House No.</th>
                    <th class="px-4 py-2">Street</th>
                    <th class="px-4 py-2">Total Members & Family Members</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $resident): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2"><?php echo htmlspecialchars($resident['head_of_family']); ?></td>
                        <td class="px-4 py-2"><?php echo htmlspecialchars($resident['houseNo']); ?></td>
                        <td class="px-4 py-2">
                            <?php 
                            echo htmlspecialchars($resident['purok']) . ', ' .
                                 htmlspecialchars($resident['brgy']) . ', ' .
                                 htmlspecialchars($resident['municipality']) . ', ' .
                                 htmlspecialchars($resident['province']);
                            ?>
                        </td>
                        <td class="px-4 py-2">
                            <?php echo htmlspecialchars($resident['total_members']); ?>
                            <button class="ml-2 hover:text-blue-700 text-blue-500 font-bold rounded" 
                                    onclick="showModal(<?php echo htmlspecialchars($resident['houseNo']); ?>)">
                                <i title="View Members" class="fa-regular fa-eye"></i>
                            </button>
                        </td>


                    </tr>

                    <!-- Modal for family members -->
                    <div id="modal-<?php echo htmlspecialchars($resident['houseNo']); ?>" 
                         class="hidden fixed z-50 inset-0 overflow-y-auto" 
                         aria-labelledby="modal-title" 
                         role="dialog" 
                         aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <!-- Background overlay -->
                            <div class="fixed inset-0  bg-opacity-75 transition-opacity" 
                                 aria-hidden="true"></div>

                            <!-- Modal panel -->
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                Members of House #<?php echo htmlspecialchars($resident['houseNo']); ?>
                                            </h3>
                                            <div class="mt-4 space-y-2">
                                                <?php
                                                $result_members = getFamilyMembers($resident['houseNo']);
                                                if ($result_members->num_rows > 0) {
                                                    while ($member = $result_members->fetch_assoc()) {
                                                        $memberName = htmlspecialchars($member['full_name']);
                                                        $relation = htmlspecialchars($member['relation']);
                                                        $isHead = $member['head_fam'] === 'yes' 
                                                            ? '<span class="text-blue-600 ml-2">(Head of Family)</span>' 
                                                            : '';
                                                        
                                                        // Check if relation is empty
                                                        if (!empty($relation)) {
                                                            $relationText = "($relation)";
                                                        } else {
                                                            $relationText = ''; // Remove the parentheses if no relation
                                                        }

                                                        echo "<p class='py-1 border-b border-gray-200'>" . 
                                                            $memberName . $isHead . $relationText . "</p>";
                                                    }
                                                } else {
                                                    echo "<p class='text-gray-500'>No members found.</p>";
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" 
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
                                            onclick="hideModal(<?php echo htmlspecialchars($resident['houseNo']); ?>)">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#officials-table').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                scrollX: true,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                initComplete: function() {
                    // Add custom styling to DataTables elements
                    $('.dataTables_length select').addClass('border rounded px-2 py-1');
                    $('.dataTables_filter input').addClass('border rounded px-2 py-1');
                }
            });
        });

        function showModal(houseNo) {
            document.getElementById('modal-' + houseNo).classList.remove('hidden');
            // Prevent body scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }

        function hideModal(houseNo) {
            document.getElementById('modal-' + houseNo).classList.add('hidden');
            // Restore body scrolling when modal is closed
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('fixed')) {
                const modalId = event.target.closest('[id^="modal-"]').id;
                const houseNo = modalId.replace('modal-', '');
                hideModal(houseNo);
            }
        }

        // Close modal on escape key press
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const openModal = document.querySelector('[id^="modal-"]:not(.hidden)');
                if (openModal) {
                    const houseNo = openModal.id.replace('modal-', '');
                    hideModal(houseNo);
                }
            }
        });

        function GenerateReport(){
            const pdfUrl = `../nx_pages/nx_residents/generate_report.php`;
            window.open(pdfUrl, '_blank');
        }
    </script>