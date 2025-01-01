<style>
.alert-card {
    position: fixed;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    width: 90%;
    max-width: 500px;
    opacity: 0;
    animation: swingInOut 8s forwards;
    transform-origin: top center;
    border-radius: 20px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.centered-container {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f9fafb;
    padding: 30px;
    min-height: 100vh; /* Assure que la carte est centrée sur l'écran */
}

.card {
    margin-top: 20px;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    width: 100%;
    max-width: 700px;
    border: none;
}

.card h3 {
    font-size: 26px;
    color: #4A4A4A;
    font-weight: bold;
    margin-bottom: 20px;
}

.card hr {
    margin: 20px 0;
    border: none;
    border-top: 1px solid #eee;
}

.form-group label {
    font-size: 14px;
    font-weight: 600;
    color: #4a4a4a;
}

.form-control {
    border-radius: 10px;
    border: 1px solid #ced4da;
    padding: 10px 15px;
}

.form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
}

.btn {
    border-radius: 25px;
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    text-transform: uppercase;
}

.btn-success {
    background-color:rgb(15, 67, 189);
    border-color:rgb(22, 47, 205);
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.input-group .btn {
    padding: 0 15px;
    font-size: 16px;
}

.interest-section .input-group {
    margin-top: 10px;
}

.invalid-feedback {
    font-size: 12px;
    color: #e3342f;
}

</style>
<?php require_once APPPATH . 'views/templates/menuClient.php'; ?>
<div class="centered-container">
    <div class="card">
        <div class="mx-auto text-center">
            <h3 class="my-3"><i class="fas fa-user-plus"></i> <?php echo $title; ?></h3>
        </div>
        <hr class="my-3">

        <!-- Form Starts -->
        <?php echo form_open('ClientController/register', ['class' => 'needs-validation', 'novalidate' => true]); ?>

        <div class="form-row">
            <!-- Email -->
            <div class="form-group col-md-6">
                <label for="inputEmail4">E-mail</label>
                <input type="email" class="form-control" name="email" id="inputEmail4"
                       value="<?php echo set_value('email'); ?>" required>
                <div class="invalid-feedback text-left">Veuillez saisir un e-mail valide.</div>
            </div>
            <!-- Nom -->
            <div class="form-group col-md-6">
                <label for="name">Nom</label>
                <input type="text" id="lastname" name="name" class="form-control"
                       value="<?php echo set_value('name'); ?>" required>
                <div class="invalid-feedback text-left">Veuillez saisir le nom.</div>
            </div>
        </div>

        <div class="form-row">
            <!-- Entreprise -->
            <div class="form-group col-md-6">
                <label for="company">Entreprise</label>
                <input type="text" id="company" name="company" class="form-control"
                       value="<?php echo set_value('company'); ?>" required>
                <div class="invalid-feedback text-left">Veuillez saisir le nom de l'entreprise.</div>
            </div>
            <!-- Numéro de téléphone -->
            <div class="form-group col-md-6">
                <label for="phone_number">Numéro téléphone</label>
                <div class="input-group">
                    <input type="tel" id="phone_number" name="phone_number[]" class="form-control"
                           value="<?php echo set_value('phone_number[0]'); ?>" required>
                    
                </div>
                <div class="invalid-feedback text-left">Veuillez saisir le numéro du téléphone.</div>
            </div>
        </div>

        <div class="form-row">
            <!-- Ville -->
            <div class="form-group col-md-6">
                <label for="ville">Ville</label>
                <input type="text" id="ville" name="ville" class="form-control"
                       value="<?php echo set_value('ville'); ?>" required>
                <div class="invalid-feedback text-left">Veuillez saisir la ville.</div>
            </div>
            <!-- Adresse -->
            <div class="form-group col-md-6">
                <label for="address">Adresse</label>
                <textarea rows="3" class="form-control" name="address" id="address" required><?php echo set_value('address'); ?></textarea>
                <div class="invalid-feedback text-left">Veuillez saisir l'adresse.</div>
            </div>
        </div>

        <div class="form-group interest-section">
            <label for="interets">Prestation</label>
            <div class="row" id="interest-grid">
                <?php
                $predefined_interests = ['Site Web', 'Marketing Digital', 'SEO', 'Logiciel de gestion'];
                ?>
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
        </div>

        <button class="btn btn-primary btn-block" type="submit">Ajouter</button>
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
