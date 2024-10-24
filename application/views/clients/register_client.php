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

    .centered-container {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .card {
        margin-top: 20px;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        max-width: 600px;
        width: 100%;
        border: 1px solid #e0e0e0;
        position: relative;
        margin-bottom: 20px;
    }

    .card h3 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 24px;
        color: #343a40;
    }

    .card hr {
        margin: 20px 0;
        border: none;
        border-top: 1px solid #e0e0e0;
    }

    .form-group label {
        font-weight: bold;
        font-size: 14px;
        color: #495057;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        border-color: #007bff;
    }

    .invalid-feedback {
        display: none;
    }

    .was-validated .form-control:invalid ~ .invalid-feedback {
        display: block;
    }
</style>
<?php include APPPATH . 'views/templates/menuClient.php'; ?>
<div class="centered-container">
    <div class="card">
        <div class="mx-auto text-center">
            <h3 class="my-3"><i class="fas fa-user-plus"></i> <?php echo $title; ?></h3>
        </div>
        <hr class="my-3">

        <!-- Form Starts -->
        <?php echo form_open('ClientController/register', ['class' => 'needs-validation', 'novalidate' => true]); ?>

        <div class="form-group">
            <label for="inputEmail4">E-mail</label>
            <input type="email" class="form-control" name="email" id="inputEmail4"
                   value="<?php echo set_value('email'); ?>" required>
            <div class="invalid-feedback text-left">Veuillez saisir un e-mail valide.</div>
        </div>

        <div class="form-row">
            
            <div class="form-group col-md-6">
                <label for="name">Nom</label>
                <input type="text" id="lastname" name="name" class="form-control"
                       value="<?php echo set_value('name'); ?>" required>
                <div class="invalid-feedback text-left">Veuillez saisir le nom.</div>
            </div>
        </div>

        <div class="form-group">
            <label for="company">Entreprise</label>
            <input type="text" id="company" name="company" class="form-control"
                   value="<?php echo set_value('company'); ?>" required>
            <div class="invalid-feedback text-left">Veuillez saisir le nom de l'entreprise.</div>
        </div>

        <div class="form-group">
            <label for="phone_number">Numéro téléphone</label>
            <div class="input-group">
                <input type="tel" id="phone_number" name="phone_number[]" class="form-control"
                       value="<?php echo set_value('phone_number[0]'); ?>" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary add-phone-btn" type="button"
                            title="Ajouter un autre numéro">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="invalid-feedback text-left">Veuillez saisir le numéro du téléphone.</div>
        </div>
        <div id="additional-phone-numbers"></div>
        <!--        interets-->
        <div class="form-group interest-section">
            <label for="interets">Intérêts</label>

            <div class="row" id="interest-grid">
                <?php
                // Predefined interests
                $predefined_interests = ['Site Web', 'Marketing Digital', 'SEO', 'Logiciel de gestion'];
                ?>

                <!-- Display Predefined Interests -->
                <?php foreach ($predefined_interests as $index => $interest): ?>
                    <div class="col-md-6">
                        <div class="interest-checkbox d-flex align-items-center">
                            <input type="checkbox" name="interets[]" value="<?php echo $interest; ?>"
                                   id="interest<?php echo $index; ?>" class="mr-2">
                            <label for="interest<?php echo $index; ?>"><?php echo $interest; ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Placeholder for Additional Interests -->
            <div class="row" id="additional-interest-fields"></div>

            <!-- Section to Add New Interests -->
            <div class="additional-interests mt-3">
                <label for="new-interest">Ajouter un nouvel intérêt</label>
                <div class="input-group">
                    <input type="text" id="new-interest" class="form-control" name="new_interest[]"
                           placeholder="Nouvel intérêt">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary add-interest-btn" type="button"
                                title="Ajouter un autre intérêt">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!--        interets-->
        <div class="form-group">
            <label for="ville">Ville</label>
            <input type="text" id="ville" name="ville" class="form-control"
                   value="<?php echo set_value('ville'); ?>" required>
            <div class="invalid-feedback text-left">Veuillez saisir la ville.</div>
        </div>

        <div class="form-group">
            <label for="address">Adresse</label>
            <textarea rows="5" class="form-control" name="address" id="address"
                      required><?php echo set_value('address'); ?></textarea>
            <div class="invalid-feedback text-left">Veuillez saisir l'adresse.</div>
        </div>

        <button class="btn btn-lg btn-success btn-block" type="submit">Ajouter</button>
        <?php echo form_close(); ?>
        <!-- Form Ends -->

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

        <?php if (isset($validation_errors) && ! empty($validation_errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show alert-card" role="alert">
                <?php echo $validation_errors; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      var forms = document.getElementsByClassName('needs-validation');
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();

  // Auto-hide alerts after 7 seconds
  setTimeout(function() {
    const alertElements = document.querySelectorAll('.alert-card');
    alertElements.forEach(alertElement => {
      alertElement.style.opacity = '0';
      alertElement.style.transition = 'opacity 0.5s ease-out';
    });
  }, 7000);

  // more phone numbers

  document.addEventListener('DOMContentLoaded', function() {
    let phoneIndex = 1; // Start index for additional phone numbers

    document.querySelector('.add-phone-btn').addEventListener('click', function() {
      const newPhoneInput = document.createElement('div');
      newPhoneInput.classList.add('input-group', 'mt-2');

      newPhoneInput.innerHTML = `
                <input type="tel" id="phone_number_${phoneIndex}" name="phone_number[]" class="form-control" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary remove-phone-btn" type="button" title="Supprimer ce numéro">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <div class="invalid-feedback text-left">Veuillez saisir le numéro du téléphone.</div>
            `;

      document.getElementById('additional-phone-numbers').appendChild(newPhoneInput);
      phoneIndex++;
    });

    document.getElementById('additional-phone-numbers').addEventListener('click', function(e) {
      if (e.target && e.target.closest('.remove-phone-btn')) {
        e.target.closest('.input-group').remove();
      }
    });
  });

  // interets
  document.addEventListener('DOMContentLoaded', function() {
    // Handle adding new interests dynamically
    document.querySelector('.add-interest-btn').addEventListener('click', function() {
      var newInterestInput = document.querySelector('input[name="new_interest[]"]');
      var newInterest = newInterestInput.value.trim();

      if (newInterest) {
        var additionalFields = document.getElementById('additional-interest-fields');
        var timestamp = Date.now();
        var newInterestDiv = document.createElement('div');
        newInterestDiv.className = 'col-md-6';  // Ensure it fits the grid layout

        newInterestDiv.innerHTML = `
                <div class="interest-checkbox d-flex align-items-center">
                    <input type="checkbox" name="interets[]" value="${newInterest}" id="new-interest-${timestamp}" class="mr-2" checked>
                    <label for="new-interest-${timestamp}">${newInterest}</label>
                </div>
            `;

        additionalFields.appendChild(newInterestDiv); // Append new interest to the grid
        newInterestInput.value = '';  // Clear input field after adding
      }
    });
  });


</script>
