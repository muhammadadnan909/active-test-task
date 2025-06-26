<style>
    /* Hide last column (Edit/Delete) in all admin tables */
    table.dataTable th:last-child,
    table.dataTable td:last-child {
        display: none !important;
    }
</style>
<script>
    $(document).ready(function () {
        alert("Dafsdfa");
        const table = $('#posts-table').DataTable();

        // Recalculate column sizes
        table.columns.adjust().draw();
    });
</script>
