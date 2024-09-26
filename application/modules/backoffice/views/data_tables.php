<script type="text/javascript">
$(document).ready( function () {
    $('#table_id').DataTable({
        paging: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url() ?>backoffice/backoffice/getdatatables",
            type: "POST"}
    });
    
} );
</script>
    

<table id="table_id" class="table table-striped">
    <thead class="">
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
            <th>Column 3</th>
            <th>Column 4</th>
            <th>Column 5</th>
            <th>Column 6</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>