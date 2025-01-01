
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
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" integrity="sha384-L5rLJDVZhrHrRIaa3eLLU/uLS3+3gVzd1vFs4wVyufS93DmLRAdBySoFzqFDwuQJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css" integrity="sha384-cWgz6YKDgXz/mTomsnOIXd/1s0iivK+FhwVdmzN0ErdazMmt4RieKmZXMWdwScEm" crossorigin="anonymous">
    <!-- Bootstrap CSS for better styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK" crossorigin="anonymous"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js" integrity="sha384-t11ZTRbO9om+k0pVXmc3c8SsIHonT3oUvoi3FxMm1c9DVQwl9VbTNv3+UjbUrI6Z" crossorigin="anonymous"></script>    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js" integrity="sha384-PW44M5zRI8UiBruC2V4DPQEZ5/VhLIonUXY/9XpPS683SN/3zmKITa4uiYKi+Pni" crossorigin="anonymous"></script>
</head>
<body>
<?php require_once APPPATH . 'views/templates/menu.php'; ?>
<?php //echo $current_page  ?>
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
                    url: "http://localhost/tutorial2/documents/fetchDocumentsByUser",
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
                            // Set the badge class based on the transfer status
                            var badgeClass;
                            
                            if (data === 'await_approval') {
                                badgeClass = 'badge-warning';  // For 'await_approval', use 'badge-warning'
                            } else if (data === 'not_transferred') {
                                badgeClass = 'badge-danger';  // For 'not_transferred', use 'badge-danger'
                            } else if (data === 'approved') {
                                badgeClass = 'badge-success'; // For 'approved', use 'badge-success'
                            } else {
                                badgeClass = 'badge-secondary'; // For any other case, use 'badge-secondary'
                            }
                            
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
