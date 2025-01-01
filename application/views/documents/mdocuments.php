<style>
    .alert {
        position: fixed;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1050; /* Ensure it appears on top */
        width: 20%; /* Adjust width as needed */
        display: none; /* Initially hidden */
        padding: 10px;
        border-radius: 5px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
    }

    /* Make table rows look clickable */
    .clickable-row {
        cursor: pointer;
    }

    .row-card {
        margin-bottom: 20px; /* Space between cards */
    }

    .row-card .card-body {
        padding: 1.25rem; /* Adjust padding for compact view */
    }

    .form-group {
        margin-bottom: 1rem; /* Reduce space between form elements */
    }

    .btn {
        margin-top: 0.5rem; /* Reduce margin-top for buttons */
    }

    .text-truncate {
    overflow: hidden;
    white-space: nowrap;  /* Prevent wrapping */
    text-overflow: ellipsis; /* Add ellipsis (...) for overflow text */
    max-width: 200px; /* Set your desired width */
    }

</style>
<div class="container mt-4">
    <!-- Alerts positioned at the top center -->
    <?php if ($this->session->flashdata('success')): ?>
        <div id="alert-success" class="alert alert-success" role="alert">
            <?= htmlspecialchars($this->session->flashdata('success')) ?>
        </div>
    <?php elseif ($this->session->flashdata('error')): ?>
        <div id="alert-error" class="alert alert-error" role="alert">
            <?= htmlspecialchars($this->session->flashdata('error')) ?>
        </div>
    <?php elseif ($this->session->flashdata('warning')): ?>
        <div id="alert-warning" class="alert alert-warning" role="alert">
            <?= htmlspecialchars($this->session->flashdata('warning')) ?>
        </div>
    <?php endif; ?>

    <!-- Your view content here -->
    <h3 class="mb-1">Mes Documents</h3><br>

    <div class="">
            <div class="card">
                <div class="card-body" style="height: 115px">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="post" enctype="multipart/form-data"
                                  action="<?php echo base_url('DocumentController/importFromExcel'); ?>">
                                <label for="excel_file">Importer depuis Excel:</label>
                                <div class="d-flex align-items-center pr-5">
                                    <input type="file" name="excel_file" class="form-control-file mt-2"
                                           accept=".xls,.xlsx"/>
                                    <button type="submit" class="btn btn-primary ml-2">Importer
                                    </button>
                                </div>
                                </form>
                        </div>
                        <div class="col-md-6">
                            <form method="post"
                                  action="<?php echo base_url('DocumentController/exportToExcel'); ?>">
                                <label class="d-block">Exporter la table vers Excel:</label>
                                <button type="submit" class="btn btn-success mt-2" style="color: white">Exporter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>                  

    <div class="bg-white mt-2 px-5 border">
        <table id="example2" class="table border dt-responsive nowrap mt-3 clickable-row" style="width:100%">
            <thead>
              <tr>
                  <th>Titre</th>
                  <th>Fichier</th>
                  <th>Date de Création</th>
                  <th>Client</th>
                  <th>Etat</th>
                  <th>action</th>

              </tr>
            </thead>
        </table>
    </div>
</div>

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
<script>
  $(document).ready(function() {
    var columns = [
      {data: 'title',"className": "text-truncate"},
      {data: 'original_name',
        render: function(data, type, row) {
            // Determine the file extension
            var fileExtension = data.split('.').pop().toLowerCase();
            var icon = '';

            // Assign icon based on file type
            switch(fileExtension) {
                case 'pdf':
                    icon = '<i class="fas fa-file-pdf text-danger"></i>';
                    break;
                case 'doc':
                case 'docx':
                    icon = '<i class="fas fa-file-word text-primary"></i>';
                    break;
                case 'xls':
                case 'xlsx':
                    icon = '<i class="fas fa-file-excel text-success"></i>';
                    break;
                case 'ppt':
                case 'pptx':
                    icon = '<i class="fas fa-file-powerpoint text-warning"></i>';
                    break;
                case 'jpg':
                case 'jpeg':
                case 'png':
                    icon = '<i class="fas fa-file-image text-info"></i>';
                    break;
                case 'zip':
                case 'rar':
                    icon = '<i class="fas fa-file-archive text-muted"></i>';
                    break;
                default:
                    icon = '<i class="fas fa-file-alt"></i>'; // Generic file icon
            }

            // Return the icon along with the file name
            return icon + ' ' + data;
        }
    },
      {data: 'created_at'},
      {data: 'client_id'},
      {
            data: 'transfer_status',
            render: function (data, type, row) {
                if (data === 'transféré') {
                  return '<span class="badge bg-success" style="font-weight: bold; font-size: 13px;"><strong>' + data + '</strong></span>';
                } else {
                  return '<span class="badge bg-warning" style="font-weight: bold; font-size: 13px;"><strong>' + data + '</strong></span>';
                }
            }
          },
      {data: 'actions', orderable: false, searchable: false},
    ];

    var table = $('#example2').DataTable({
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json',
      },
      ajax: {
        url: "<?php echo base_url('documents/fetchDocumentsByUser'); ?>",
        dataSrc: function(json) {
          console.log('data shows here:');
          console.log(json);
          return json.data;
        },
      },
      columns: columns,
      order: [[2, "desc"]], // Order by the first column (ID) in descending order
      responsive: true,
    });

    // Show success, error, and warning alerts and hide after 3 seconds
      <?php if ($this->session->flashdata('success')): ?>
    $('#alert-success').fadeIn().delay(3000).fadeOut();
      <?php elseif ($this->session->flashdata('error')): ?>
    $('#alert-error').fadeIn().delay(3000).fadeOut();
      <?php elseif ($this->session->flashdata('warning')): ?>
    $('#alert-warning').fadeIn().delay(3000).fadeOut();
      <?php endif; ?>

    // Make table rows clickable
    $('#example2 tbody').on('click', 'tr', function() {
      var data = table.row(this).data();
      if (data) {
        window.location.href = "<?php echo base_url('DocumentController/consult_document/'); ?>" + data.id;
      }
    });
  });
</script>
