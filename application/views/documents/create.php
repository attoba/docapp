<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<?php require_once APPPATH . 'views/templates/menu.php'; ?>
<h2 class="text-center"><?= $title; ?></h2>

<?php if(validation_errors()): ?>
    <div class="alert alert-danger">
        <?php echo validation_errors(); ?>
    </div>
<?php endif; ?>


<?php echo form_open_multipart('documents/createDocument', ['class' => 'dropzone', 'id' => 'fileUploadForm', 'onsubmit' => 'return validateForm()']); ?>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Title <input type="text" class="form-control" name="title" placeholder="Add Title" /></label>     
                </div>
                <div class="form-group">
                    <label>Description <textarea id="editor1" class="form-control" name="description" placeholder="Add Body"></textarea></label>
                </div>
                <!-- Add dropdown for client selection -->
                <div class="form-group">
                    <label for="client_id">Select Client</label>
                    <select class="form-control" name="client_id" id="client_id">
                        <option value="">Select Client</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?= $client->id; ?>"><?= $client->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Dropzone area for uploading files -->
                <div class="form-group mb-4">
                  <label for="file-upload">Upload Document</label>
                  <div class="dropzone dz-custom" id="fileUploadForm">
                    <div class="dz-message">
                      <p><i class="fas fa-cloud-upload-alt"></i> Drag and drop files here, or click to select files</p>
                    </div>
                  </div>
                  <small class="form-text text-muted">Accepted formats: PDF, TXT, PNG, JPEG, JPG etc.</small>
                </div>
             
                
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>
<!-- Dropzone JS and CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
  html, body {
    height: 100%;
    margin: 0;
}

.container {
    justify-content: center;
    align-items: center;
}

  form {
  border: none !important;
  box-shadow: none;
  border-radius: 8px;
}
.text-right {
  text-align: right;
}
input:invalid {
  border-color: red;
}

input:valid {
  border-color: green;
}

  /* Styling for the Dropzone with a subtle border */
  .dz-custom {
    border: 1px dashed #ced4da;
    border-radius: 8px;
    background-color: #f8f9fa;
    padding: 30px;
    text-align: center;
    transition: background-color 0.3s ease;
  }

  .dz-custom:hover {
    background-color: #e9ecef;
  }

  .dz-message {
    font-size: 1.1rem;
    color: #6c757d;
    margin: 0;
  }

  .dz-message i {
    font-size: 2rem;
    color: #007bff;
    margin-bottom: 10px;
  }

  .form-group label {
    font-weight: bold;
    color: #495057;
  }

  .form-group input,
  .form-group textarea {
    border: 1px solid #ced4da;
    border-radius: 5px;
    padding: 10px;
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    border-radius: 5px;
    padding: 10px 20px;
  }

  .btn-primary:hover {
    background-color: #0056b3;
  }

  .dz-preview .dz-details {
    display: flex;
    align-items: center;
  }

  .dz-preview i {
    margin-right: 10px;
  }

  /* Improve form appearance on small screens */
  @media (max-width: 768px) {
    .dz-message {
      font-size: 1rem;
    }

    .dz-message i {
      font-size: 1.8rem;
    }
  }
</style>

<script>

  function validateForm() {
      // Get the Dropzone instance
      var dropzone = Dropzone.forElement("#fileUploadForm");
      
      // Check if there are files added to the Dropzone
      if (dropzone.files.length === 0) {
        alert("Veuillez selectionner un fichier."); // Alert the user
        return false; // Prevent the form from submitting
      }
      return true; // Allow the form to submit
    }

  // Initialize Dropzone
  Dropzone.options.fileUploadForm = {
    paramName: "file", // Name for the file parameter
    maxFilesize: 20,    // Max file size in MB
    acceptedFiles: ".pdf,.txt,.doc,.docx,.png,.jpeg,.jpg", // Accepted file types
    addRemoveLinks: true, // Option to remove files before submitting
   
    // Listen to file added event
    init: function() {
      this.on("addedfile", function(file) {
        let icon = '';
        
        // Determine the file type and assign the corresponding Font Awesome icon
        const ext = file.name.split('.').pop().toLowerCase();
        if (ext === 'pdf') {
          icon = '<i class="fas fa-file-pdf"></i>';
        } else if (ext === 'doc' || ext === 'docx') {
          icon = '<i class="fas fa-file-word"></i>';
        } else if (ext === 'txt') {
          icon = '<i class="fas fa-file-alt"></i>';
        } else if (['jpeg', 'jpg', 'png'].includes(ext)) {
          icon = '<i class="fas fa-file-image"></i>';
        } else {
          icon = '<i class="fas fa-file"></i>'; // Default file icon
        }

        // Inject the icon next to the file name
        file.previewElement.querySelector("[data-dz-name]").innerHTML = icon + " " + file.name;
      });
    }
  };

</script>

  
</body>
</html>
