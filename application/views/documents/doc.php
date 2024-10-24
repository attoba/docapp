
<?php if($this->session->flashdata('user_logedin')): ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('user_logedin'); ?>
    </div>
<?php endif; ?>
<?php if(validation_errors()): ?>
    <div class="alert alert-danger">
        <?php echo validation_errors(); ?>
    </div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test AJAX with DataTables</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">

    <!-- Bootstrap CSS for better styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
</head>
<body>
<?php include APPPATH . 'views/templates/menu.php'; ?>
    <div class="container mt-5">
        <h1 class="mb-4 text-center"></h1>

        <!-- Display any success/error messages here -->
        <div id="alert-success" class="alert alert-success" role="alert" style="display:none;">Success message</div>
        <div id="alert-error" class="alert alert-danger" role="alert" style="display:none;">Error message</div>
        <div id="alert-warning" class="alert alert-warning" role="alert" style="display:none;">Warning message</div>

        <!-- DataTable -->
        <table id="example5" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>File</th>
                    <th>Created At</th>
                    <th>Etat</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#example5').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json', // French translation
                },
                ajax: {
                    url: "http://localhost/tutorial2/Documents/fetchDocuments",
                    dataSrc: 'data' // Make sure this matches the structure of your data
                },
                columns: [
                    {data: 'title'},
                    {
                        data: 'original_name',
                        render: function(data, type, row) {
                            var fileExtension = data.split('.').pop().toLowerCase();
                            var icon = '';
                            switch(fileExtension) {
                                case 'pdf': icon = '<i class="fas fa-file-pdf text-danger"></i>'; break;
                                case 'doc': case 'docx': icon = '<i class="fas fa-file-word text-primary"></i>'; break;
                                case 'xls': case 'xlsx': icon = '<i class="fas fa-file-excel text-success"></i>'; break;
                                case 'jpg': case 'jpeg': case 'png': icon = '<i class="fas fa-file-image text-info"></i>'; break;
                                default: icon = '<i class="fas fa-file-alt"></i>';
                            }
                            return icon + ' ' + data;
                        }
                    },
                    {data: 'created_at'},
                    {
                        data: 'transfer_status',
                        render: function(data, type, row) {
                            var badgeClass = data === 'approved' ? 'badge-success' : 'badge-warning';
                            return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                        }
                    },
                    {data: 'actions', orderable: false, searchable: false}
                ],
                order: [[3, "desc"]],
                responsive: true
            });

            // Show flash alerts and hide after 3 seconds
            <?php if ($this->session->flashdata('success')): ?>
                $('#alert-success').fadeIn().delay(3000).fadeOut();
            <?php elseif ($this->session->flashdata('user_logedin')): ?>
                $('#alert-user_logedin').fadeIn().delay(3000).fadeOut();
            <?php elseif ($this->session->flashdata('error')): ?>
                $('#alert-error').fadeIn().delay(3000).fadeOut();
            <?php elseif ($this->session->flashdata('warning')): ?>
                $('#alert-warning').fadeIn().delay(3000).fadeOut();
            <?php endif; ?>

            // Make table rows clickable
            $('#example5 tbody').on('click', 'tr', function() {
                var data = table.row(this).data();
                if (data) {
                    window.location.href = "<?php echo base_url('documents/consult_document/'); ?>" + data.id;
                }
            });
        });
    </script>

</body>
</html>
