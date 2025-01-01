<style>
    /* Alertes */
    .alert {
        position: fixed;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1050;
        width: 25%;
        display: none;
        padding: 12px;
        border-radius: 8px;
        font-weight: bold;
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

    
</style>

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
</head>
<body>
    <?php require_once APPPATH . 'views/templates/menuClient.php'; ?>

    <div class="container mt-4">
        <!-- Alerts -->
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

        <div class="d-flex col-md-12">
          <!-- Formulaire d'import -->
          <div class="col-md-6 mb-3">
              <label for="excel_file">Importer depuis Excel :</label>
              <div class="d-flex">
                  <input type="file" name="excel_file" class="form-control-file" accept=".xls,.xlsx"/>
                  <button type="submit" class="btn btn-primary ml-2" onclick="window.location.href='register';">Importer</button>
              </div>
          </div>

          <!-- Formulaire d'export -->
          <div class="col-md-6 mb-3">
              <label for="number_of_clients">Exporter vers Excel :</label>
              <button type="submit" class="btn btn-success mt-2">Exporter</button>
          </div>
      </div>
      <br> <br>

        <!-- Clients Table -->
            <table id="example1" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Entreprise</th>
                        <th>Téléphone(s)</th>
                        <th>Ville</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
    </div>

    <script>
        $(document).ready(function() {
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
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'company'},
                    {
                        'data': 'phone_numbers',
                        'render': function(data, type, row) {
                            try {
                                data = JSON.parse(data);
                            } catch (e) {
                                console.error('Error parsing phone numbers:', e);
                                return 'N/A';
                            }
                            return data.length ? data.join(', ') : 'N/A';
                        }
                    },
                    {data: 'ville'},
                    {data: 'actions', orderable: false, searchable: false}
                ],
                order: [],
                responsive: true
            });

            // Show alerts and hide after 3 seconds
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
</body>
</html>
