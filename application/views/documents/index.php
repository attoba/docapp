<style>
  html, body {
    height: 100%;
    margin: 0;
}

.container {
    justify-content: center;
    align-items: center;
}
</style> 
<div>
  <table id="example5" class="display" style="width:100%">
      <thead>
        <tr>
            <th>title</th>
            <th>file</th>
            <th>description</th>
            <th>created At</th>
            <th>Etat</th>
            <th>actions</th>
        </tr>
      </thead>
      
  </table>
  </div>
<!-- Import jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Import Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Import DataTables JS -->
<script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script> 

<script>
  $(document).ready(function() {
    var columns = [
      {data: 'title',"className": "text-truncate"},
      {data: 'file', //original_name
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
      {data: 'description'},
      {data: 'created_at'},
      {data: 'transfer_status',
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

    var table = $('#example5').DataTable({
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json',
      },
      ajax: {
        url: "http://localhost/tutorial2/Documents/fetchDocuments",
        dataSrc: function(json) {
          console.log('data shows here:');
          console.log(json);
          return json.data;
        },
      },
      columns: columns,
      //order: [[2, "desc"]], // Order by the first column (ID) in descending order
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
    $('#example5 tbody').on('click', 'tr', function() {
      var data = table.row(this).data();
      if (data) {
        window.location.href = "<?php echo base_url('documents/consult_document/'); ?>" + data.id;
      }
    });
  });
</script>





