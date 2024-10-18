<?php

?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#walkinTable').DataTable({
        "scrollX": true // Enable horizontal scrolling
    });
    $('#newTable').DataTable({
        "scrollX": true // Enable horizontal scrolling
    });
    $('#approvedTable').DataTable({
        "scrollX": true // Enable horizontal scrolling
    });
    $('#disapprovedTable').DataTable({
        "scrollX": true // Enable horizontal scrolling
    });
    $('#doneTable').DataTable({
        "scrollX": true // Enable horizontal scrolling
    });
    $('#residentTable').DataTable({
        "searching": true, // Enable the search feature
        "scrollX": true // Enable horizontal scrolling
    });
    // Initialize jQuery UI Tabs
    $("#tabs").tabs();
});

</script>

<div class="p-3 w-full bg-white">
    <h1 class="text-3xl font-bold">Sample Name</h1>
    <hr class="mb-3 mt-3">
</div>