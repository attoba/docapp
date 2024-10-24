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
</style>
<?php include APPPATH . 'views/templates/menuClient.php'; ?>

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
    <h3 class="mb-1"></h3>

    <div class="row">

        <div class="col-md-6 row-card">
            <div class="card">
                <div class="card-body" style="height: 115px">
                    <form method="post" action="<?php echo base_url('ClientController/selectClients'); ?>"
                          class="row">
                        <!-- Nombre de clients -->
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="number_of_clients">Nombre de clients à contacter:</label>
                                <select id="number_of_clients" name="number_of_clients" class="form-control">
                                    <option value="" selected>Selectionner un nombre</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Statut:</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="" selected>Selectionner un statut</option>
                                    <option value="nouveau">Nouveau</option>
                                    <option value="contacte">Contacté</option>
                                    <option value="en_negociation">En négociation</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-3 mt-4">
                            <button type="submit" class="btn btn-primary btn-block">Sélectionner</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Right card: Import and Export buttons -->
        <div class="col-md-6 row-card">
            <div class="card">
                <div class="card-body" style="height: 115px">
                    <div class="row">
                        <div class="col-md-8">
                            <form method="post" enctype="multipart/form-data"
                                  action="<?php echo base_url('ClientController/importFromExcel'); ?>">
                                <label for="excel_file">Importer depuis Excel:</label>
                                <div class="d-flex align-items-center pr-5">
                                    <input type="file" name="excel_file" class="form-control-file mt-2"
                                           accept=".xls,.xlsx"/>
                                    <button type="submit" class="btn btn-primary ml-2">Importer
                                    </button>
                                </div>

                            </form>
                        </div>
                        <div class="">
                            <form method="post"
                                  action="<?php echo base_url('ClientController/exportToExcel'); ?>">
                                <label class="d-block" for="number_of_clients">Exporter la table vers Excel:</label>
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
        <table id="example1" class="table border dt-responsive nowrap mt-3 clickable-row" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Entreprise</th>
                <th>Téléphone(s)</th>
                <th>Ville</th>
                <th>Statut</th>

                <th>Actions</th>

            </tr>
            </thead>
        </table>
    </div>
</div>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">

    <!-- Bootstrap CSS for better styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- Import jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Import Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Import DataTables JS -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script>
  $(document).ready(function() {
    var columns = [
      {data: 'id'},
      {data: 'name'},
      {data: 'email'},
      {data: 'company'},
      {
        'data': 'phone_numbers',
        'render': function(data, type, row) {
          if (typeof data === 'string') {
            try {
              data = JSON.parse(data);
            } catch (e) {
              console.error('Error parsing phone numbers:', e);
              return 'N/A';
            }
          }
          return data.length ? data.join(', ') : 'N/A';
        },
      },
      {data: 'ville'}, // Add this column to show the city
      {
        data: 'status',
        render: function(data, type, row) {
          var labelClass = '';
          var statusLabel = '';

          switch (data) {
            case 'nouveau':
              labelClass = 'badge badge-danger';
              statusLabel = 'Nouveau';
              break;
            case 'contacte':
              labelClass = 'badge badge-primary';
              statusLabel = 'Contacté';
              break;
            case 'en_negociation':
              labelClass = 'badge badge-warning';
              statusLabel = 'En Négociation';
              break;
            case 'converti':
              labelClass = 'badge badge-success';
              statusLabel = 'Converti';
              break;
            case 'perdu':
              labelClass = 'badge badge-secondary';
              statusLabel = 'Perdu';
              break;
            default:
              labelClass = 'badge badge-light';
              statusLabel = data;
          }

          return '<span class="' + labelClass +
              ' px-3 py-2 text-white mt-2" style="font-size: 12px; font-weight: 800">' + statusLabel +
              '</span>';
        },
      },

      {data: 'actions', orderable: false, searchable: false},
    ];

    var table = $('#example1').DataTable({
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json',
      },
      ajax: {
        url: "<?php echo base_url('ClientController/fetchClients'); ?>",
        dataSrc: function(json) {
          return json.data;
        },
      },
      columns: columns,
      order: [],
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
    $('#example1 tbody').on('click', 'tr', function() {
      var data = table.row(this).data();
      window.location.href = '<?php echo base_url('ClientController/consult_client/'); ?>' + data.id;
    });
  });
</script>
