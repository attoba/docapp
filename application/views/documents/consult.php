<head>
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.min.js"></script>
</head>

<style>
    .custom-card-container {
        max-width: 600px;
        margin: 50px auto;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        text-align: center;
    }

    .card-body {
        padding: 30px;
        font-family: 'Arial', sans-serif;
        background-color: #f7f7f7;
    }

    .document-details {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 12px 20px;
        align-items: center;
        text-align: left;
    }

    .document-details strong {
        color: #333;
        font-weight: 600;
    }

    .document-details div {
        padding: 8px 0;
    }

    .document-details i {
        margin-right: 10px;
        color: #007bff;
    }

    .card-footer {
        background-color: #f1f1f1;
        padding: 20px;
        text-align: center;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 4px;
        font-size: 14px;
        margin: 10px;
        transition: background-color 0.3s;
    }

    .btn-outline-success:hover,
    .btn-outline-primary:hover,
    .btn-outline-danger:hover {
        color: white;
    }

    .btn-outline-success:hover {
        background-color: #28a745;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
    }

    /* Responsive design for mobile */
    @media (max-width: 768px) {
        .document-details {
            grid-template-columns: 1fr;
        }

        .btn {
            width: 100%;
        }
    }

    /* Centering tables */
    .table {
        width: 80%;
        margin: 0 auto; /* Centers the table horizontally */
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
</style>

<div class="container mt-4">
    <div class="custom-card-container">
        <div class="card-body">
            <div class="document-details">
                <div><i class="fas fa-file-alt"></i><strong>Title:</strong></div>
                <div><?= $document['title'] ?></div>

                <div><i class="fas fa-align-left"></i><strong>Description:</strong></div>
                <div><?= $document['description'] ?></div>

                <div><i class="fas fa-calendar-alt"></i><strong>Date de Création:</strong></div>
                <div><?= date('d-m-Y', strtotime($document['created_at'])) ?></div>

                <div><i class="fas fa-file"></i><strong>Fichier:</strong></div>
                <div>
                    <?= $document['original_name'] ?>
                    <a href="<?= site_url('documents/preview_document/' . $document['id']) ?>" class="btn btn-info" style="padding: 0; border: none; background-color: transparent; color: white; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;" target="_blank">
                         <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
        </div>
        <canvas id="pdfCanvas" style="border: 1px solid black;"></canvas>

        <div class="card-footer">
            <a href="<?= site_url('documents/download/' . $document['file']) ?>" class="btn btn-outline-success">
                <i class="fas fa-download"></i> Télécharger
            </a>
            <a href="<?= site_url('documents/edit/'.$document['id']) ?>" class="btn btn-outline-primary">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="<?= site_url('documents/delete_document/'.$document['id']) ?>" class="btn btn-outline-danger">
                <i class="fas fa-trash-alt"></i> Supprimer
            </a>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div id="emailModal">
    <div class="modal-content">
        <form id="emailForm" method="post" action="<?php echo site_url('DocumentController/share_file_via_email/'.$document['id']); ?>">
            <input type="hidden" name="document_id" id="document_id" value="">
            <label for="recipient_email">Email du Destinataire:</label>
            <input type="email" name="recipient_email" required placeholder="Entrez l'email">
            <button type="submit" class="btn btn-send">Envoyer</button>
            <button type="button" class="btn btn-cancel" onclick="closeEmailModal()">Annuler</button>
        </form>
    </div>
</div>

<script>
    function openEmailModal(docId) {
        document.getElementById('document_id').value = docId;
        document.getElementById('emailModal').style.display = 'flex';
    }

    function closeEmailModal() {
        document.getElementById('emailModal').style.display = 'none';
    }
</script>

<h3 class="mt-5">Historique des Modifications</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Version</th>
            <th>Mis à Jour Par</th>
            <th>Date de Mise à Jour</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($versions)): ?>
            <?php foreach ($versions as $version): ?>
                <tr>
                    <td>Version <?= $version['version_id']; ?></td>
                    <td><?= $this->user_model->get_user_name($version['updated_by']); ?></td>
                    <td><?= date('d-m-Y H:i:s', strtotime($version['updated_at'])); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Pas d'historique de version disponible.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Document Logs Section -->
<div class="row document-log-container">
    <div class="col-md-12">
        <h3 class="mt-5">Historique Du Document</h3>

        <?php if (!empty($logs)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Details</th>
                        <th>Date de l'Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?php echo $log['action']; ?></td>
                            <td><?php echo $log['details']; ?></td>
                            <td><?php echo date('d-m-Y H:i:s', strtotime($log['logged_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune modification enregistrée pour ce document.</p>
        <?php endif; ?>
    </div>
</div>
<script>
   const url = '<?= base_url('documents/preview_document/'.$document['id']); ?>'; 
  // const url = 'C:/laragon/www/tutorial2/assets/files/documents/'.$document['original_name']; // URL or path to the PDF document
const canvas = document.getElementById('pdfCanvas');
const ctx = canvas.getContext('2d');

// Load the PDF document
pdfjsLib.getDocument(url).promise.then(function(pdfDoc) {
  // Fetch the first page
  pdfDoc.getPage(1).then(function(page) {
    // Define the scale (zoom level)
    const scale = 1.5; // You can adjust this value to control the size
    const viewport = page.getViewport({ scale: scale });

    // Set canvas dimensions to match the PDF page
    canvas.height = viewport.height;
    canvas.width = viewport.width;

    // Render the first page into the canvas context
    const renderContext = {
      canvasContext: ctx,
      viewport: viewport
    };
    page.render(renderContext);
  });
});

</script>