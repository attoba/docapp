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
<style>
    .alert-card {
        position: fixed;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        width: 500px;
        opacity: 0;
        animation: swingInOut 8s forwards;
        transform-origin: top center;
        margin-left: 129px;
        border-radius: 20px;
    }

    @keyframes swingInOut {
        0% {
            opacity: 0;
            transform: translateX(-50%) rotateX(-90deg);
        }
        10% {
            opacity: 1;
            transform: translateX(-50%) rotateX(0deg);
        }
        90% {
            opacity: 1;
            transform: translateX(-50%) rotateX(0deg);
        }
        100% {
            opacity: 0;
            transform: translateX(-50%) rotateX(-90deg);
        }
    }

    /* Ensure proper styling for alert close button */
    .alert-card .close {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 0;
        font-size: 1.25rem;
        background: transparent;
        border: none;
        cursor: pointer;
    }
</style>
<div class="container">
    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('error')): ?>
        <div id="errorAlert" class="alert alert-danger alert-dismissible fade show alert-card" role="alert">
            <?php echo $this->session->flashdata('error'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
        <div id="successAlert" class="alert alert-success alert-dismissible fade show alert-card" role="alert">
            <?php echo $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->userdata('role') == 'admin') : ?>
    <div class="col-md-6 mb-3">
        <button 
            type="button" 
            class="fas fa-user-plus btn btn-success mt-2" 
            onclick="window.location.href='register';">
            Ajouter
        </button>
    </div>
    <?php endif; ?>


    <!-- Table -->
    <h3>Liste des commerciaux</h3><br>

    <div class="bg-white mt-2 px-5 border">
        <table id="example1" class="table border dt-responsive nowrap" style="width:100%">
            <thead>
            <tr>
                <th class="text-dark">Identifiant</th>
                <th class="text-dark">Nom</th>
                <th class="text-dark">E-mail</th>
                <th class="text-dark">Rôle</th>
                <th class="text-dark">Actions</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</body>

<script>
  $(document).ready(function() {
    $('#example1').DataTable({
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/French.json',
      },
      ajax: {
        url: "<?php echo base_url('users/fetchUsers'); ?>",
        dataSrc: function(json) {
          console.log('data shows here:');
          console.log(json);

          json.data.forEach(function(row) {
            if (row.role === 'user') {
              row.role = 'Commercial';
            } else if (row.role === 'admin') {
              row.role = 'Administrateur';
            }
          });

          return json.data;
        },
      },
      columns: [
        {data: 'id'},
        {data: 'name'},
        {data: 'email'},
        {data: 'role'},
        {data: 'actions', orderable: false, searchable: false, width: '120px'},
      ],
      order: [],
      responsive: true,
    });

    // Auto-dismissal of alerts after 7 seconds
    setTimeout(function() {
      const alertElements = document.querySelectorAll('.alert-card');
      alertElements.forEach(alertElement => {
        alertElement.style.opacity = '0';
        alertElement.style.transition = 'opacity 0.5s ease-out';
      });
    }, 7000); // 7000 milliseconds = 7 seconds
  });
</script>
</html>