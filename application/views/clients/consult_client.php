<style>
    .custom-card-container {
        max-height: 528px; /* Set the maximum height for the container */
        display: flex;
        flex-direction: column;
        overflow: hidden; /* Prevent overflow from expanding the container */
    }

    .historique-interactions {
        flex: 1; /* Take up remaining space */
        overflow-y: auto; /* Enable vertical scrolling if content overflows */
    }

    .h-100 {
        height: 100%;
    }

    .custom-close-btn {
        background-color: transparent;
        border: none;
        font-size: 1.5rem;
        color: #454545;
        cursor: pointer;
        outline: none;
    }

    .custom-close-btn:hover {
        color: #ff1a1a;
    }
</style>


<div class="container">
    <!-- Check if the source is 'contact' to display the status and notes cards -->
    <?php if (isset($_GET['source']) && $_GET['source'] === 'contact'): ?>
        <div style="display: flex; gap: 10px;">

            <button type="button" class="btn btn-outline-danger ms-2 mb-3"
                    onclick="window.location.href='<?= site_url('ClientController/close_call/'.$Client->id) ?>'">
                <i class="fas fa-phone-slash me-1"></i> Clôturer l'appel
            </button>
            <!-- donner rendez-vous start-->


            <button type="button" class="btn btn-primary ms-2 mb-3" data-toggle="modal"
                    data-target="#rendezvousModal">
                Donner rendez-vous
            </button>

        </div>

        <!-- Modal for scheduling a rendez-vous -->
        <div class="modal fade" id="rendezvousModal" tabindex="-1" role="dialog"
             aria-labelledby="rendezvousModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rendezvousModalLabel">Planifier un rendez-vous</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="rendezvousForm">
                            <div class="form-group">
                                <label for="rendezvousDate">Date</label>
                                <input type="date" class="form-control" id="rendezvousDate" name="rendezvousDate"
                                       required>
                                <div class="invalid-feedback">La date est requise.</div>
                            </div>
                            <div class="form-group">
                                <label for="rendezvousStartTime">Heure de début</label>
                                <input type="time" class="form-control" id="rendezvousStartTime"
                                       name="rendezvousStartTime" required>
                                <div class="invalid-feedback">L'heure de début est requise.</div>
                            </div>
                            <div class="form-group">
                                <label for="rendezvousEndTime">Heure de fin</label>
                                <input type="time" class="form-control" id="rendezvousEndTime" name="rendezvousEndTime"
                                       required>
                                <div class="invalid-feedback">L'heure de fin est requise.</div>
                            </div>
                            <input type="hidden" id="clientName" name="clientName"
                                   value=" <?= $client->name ?>">
                            <input type="hidden" name="added_by" id="added_by"
                                   value="<?php echo $this->session->userdata('id'); ?>">
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="submitRendezvous">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- donner rendez-vous end-->

        <!-- Change Status and Notes Cards in the Same Row -->
        <div class="row mb-4">
            <!-- Change Status Card -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0 text-white">Changer le Statut</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('ClientController/change_status/'.$client->id) ?>" method="post">
                            <div class="form-group mb-3">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="nouveau" <?= ($client->status == 'nouveau') ? 'selected' : '' ?>>
                                        Nouveau
                                    </option>
                                    <option value="contacte" <?= ($client->status == 'contacte') ? 'selected' : '' ?>>
                                        Contacté
                                    </option>
                                    <option value="en_negociation" <?= ($client->status == 'en_negociation') ? 'selected' : '' ?>>
                                        En Négociation
                                    </option>
                                    <option value="converti" <?= ($client->status == 'converti') ? 'selected' : '' ?>>
                                        Converti
                                    </option>
                                    <option value="perdu" <?= ($client->status == 'perdu') ? 'selected' : '' ?>>
                                        Perdu
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-sync-alt me-1"></i> Mettre à Jour
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Notes Card -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0 text-white">Prendre des Notes</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('ClientController/add_note/'.$client->id) ?>" method="post">
                            <div class="form-group mb-2">
                                <textarea class="form-control" name="note" rows="4"
                                          placeholder="Écrivez vos notes ici..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-save me-1"></i> Sauvegarder
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Prospect Details and other content -->
    <div class="row">
        <!-- Main Prospect Details Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0 text-white">Détails du Client</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <i class="fas fa-user-circle fa-3x text-success mr-2"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0"> <?= $client['name'] ?></h5>
                            <small class="text-muted"><?= $client['company']  ?></small>
                        </div>
                    </div>
                    <div class="list-group">
                        <?php if ($client['assigned_to']): ?>
                            <div class="list-group-item bg-light">
                                <i class="fas fa-user text-success me-2 mr-2"></i>
                                <strong>Assigné
                                    à:</strong>  <?= $client['assigned_to'] ?>
                            </div>
                        <?php else: ?>
                            <div class="list-group-item bg-light">
                                <i class="fas fa-user text-success me-2 mr-2"></i>
                                <strong>Assigné à: </strong> N/A
                            </div>
                        <?php endif; ?>
                        <div class="list-group-item bg-light">
                            <i class="fas fa-envelope text-success me-2 mr-2"></i>
                            <strong>E-mail:</strong> <?= $client['email']?>
                        </div>
                        <div class="list-group-item bg-light">
                            <i class="fas fa-building text-success me-2 mr-2"></i>
                            <strong>Entreprise:</strong> <?= $client['company'] ?>
                        </div>
                        <div class="list-group-item bg-light">
                            <i class="fas fa-phone text-success me-2 mr-2"></i>
                            <strong>Numéros de téléphone:</strong>
                            <div style="margin-left: 26px;">
                                <?php
                                // Check if phone_numbers is an array or JSON string
                                if (is_array($client['phone_numbers'])) {
                                    // If it's already an array, use it directly
                                    $phoneNumbers = $client['phone_numbers'];
                                } else {
                                    // If it's a JSON string, decode it
                                    $phoneNumbers = json_decode($client['phone_numbers'] );
                                    // Ensure decoding was successful and result is an array
                                    if (json_last_error() !== JSON_ERROR_NONE) {
                                        $phoneNumbers = [];
                                    }
                                }
                                // Display the phone numbers each on a new line
                                if ( ! empty($phoneNumbers)) {
                                    foreach ($phoneNumbers as $number) {
                                        echo htmlspecialchars($number).'<br>';
                                    }
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="list-group-item bg-light">
                            <i class="fas fa-map-marker-alt text-success me-2 mr-2"></i>
                            <strong>Adresse:</strong> <?= $client['address'] ?>
                        </div>
                        <div class="list-group-item bg-light">
                            <i class="fas fa-info-circle text-success me-2 mr-2"></i>
                            <strong>Status:</strong> <?=$client['status'] ?>
                        </div>
                        <div class="list-group-item bg-light">
                            <i class="fas fa-calendar-alt text-success me-2 mr-2"></i>
                            <strong>Date de Création:</strong> <?= date('d-m-Y', strtotime($client['created_at'])) ?>
                        </div>
                        <div class="list-group-item bg-light">
                            <i class="fas fa-calendar-check text-success me-2 mr-2"></i>
                            <strong>Dernière Mise à Jour:</strong> <?= date('d-m-Y',
                                strtotime($client['updated_at'])) ?>
                        </div>
                        <!-- Interests Section -->
                        <div class="list-group-item bg-light">
                            <i class="fas fa-star text-success me-2 mr-2"></i>
                            <strong>Intérêts:</strong>
                            <div style="margin-left: 26px;">
                                <?php
                                // Initialize $interests as an empty array
                                $interests = [];

                                // Get the raw JSON string
                                $interetsJson = $client['interets'];

                                // Remove extra quotes and backslashes if present
                                $cleanedJson = stripslashes(trim($interetsJson, '"'));

                                // Attempt to decode JSON string
                                $decoded = json_decode($cleanedJson, true);

                                // Check if decoding was successful and result is an array
                                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                    $interests = $decoded;
                                }

                                // Display interests or 'N/A' if none
                                if ( ! empty($interests)) {
                                    foreach ($interests as $interest) {
                                        echo htmlspecialchars($interest).'<br>';
                                    }
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </div>
                        </div>


                    </div>
                </div>


                <div class="card-footer text-right">
                    <a href="<?= site_url('ClientController/edit_client/'.$client['id']) ?>"
                       class="btn btn-outline-primary me-2">
                        <i class="fas fa-edit me-1"></i> Modifier
                    </a>
                    <?php if ( ! isset($_GET['source']) || $_GET['source'] !== 'contact'): ?>
                        <a href="<?= base_url('ClientController/selectClient/'.$client['id']) ?>"
                           class="btn btn-outline-success me-2">
                            <i class="fas fa-phone me-1"></i> Contacter Client
                        </a>

                    <?php endif; ?>
                    <a href="<?= site_url('ClientController/delete_client/'.$client['id']) ?>"
                       class="btn btn-outline-danger">
                        <i class="fas fa-trash-alt me-1"></i> Supprimer
                    </a>
                </div>
            </div>
        </div>

        
    </div>
</div>

<script>
  $(document).ready(function() {
    $('#submitRendezvous').click(function() {
      // Simple client-side validation
      var isValid = true;

      // Clear previous error messages
      $('#rendezvousForm .form-control').removeClass('is-invalid');
      $('.invalid-feedback').hide();

      // Validate form fields
      $('#rendezvousForm .form-control').each(function() {
        if ($(this).val() === '') {
          $(this).addClass('is-invalid');
          $(this).siblings('.invalid-feedback').show();
          isValid = false;
        }
      });

      // Check if start time is before end time
      const startTime = $('#rendezvousStartTime').val();
      const endTime = $('#rendezvousEndTime').val();
      if (startTime && endTime) {
        const start = new Date('1970-01-01T' + startTime + 'Z');
        const end = new Date('1970-01-01T' + endTime + 'Z');

        if (start >= end) {
          $('#rendezvousEndTime').addClass('is-invalid');
          $('#rendezvousEndTime').
              siblings('.invalid-feedback').
              text('L\'heure de fin doit être après l\'heure de début.').
              show();
          isValid = false;
        }
      }

      if (isValid) {
        // Collect form data
        const form = document.getElementById('rendezvousForm');
        const formData = new FormData(form);

        // Send AJAX request
        fetch('<?php echo site_url('Calendar/save_rendezvous'); ?>', {
          method: 'POST',
          body: formData,
        }).then(response => response.json()).then(data => {
          if (data.status) {
            alert(data.msg);
            $('#rendezvousModal').modal('hide');
            window.location.reload();
          } else {
            alert(data.msg);
          }
        }).catch(error => console.error('Error:', error));
      }
    });
  });

</script>
