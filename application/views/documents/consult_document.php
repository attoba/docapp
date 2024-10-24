<head>
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.min.js"></script>
</head>

<style>
    /* General Layout */
    .main-container {
        display: grid;
        grid-template-rows: auto 1fr auto;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
        max-width: 1200px;
        margin: 50px auto;
        font-family: 'Arial', sans-serif;
    }


    /* Status Text Colors */
.status-gray {
    color: gray;
    font-weight: bold;
}

.status-green {
    color: green;
    font-weight: bold;
}

.status-yellow {
    color: orange;
    font-weight: bold;
}

/* Button Styling */
.custom-btn {
    padding: 8px 12px;
    border-radius: 5px;
    margin-left: 15px; /* Adds space between buttons */
}

/* Info Button */
.custom1-btn-info {
    color: #007bff;
    text-decoration: none;
    font-size: bold;
   
}
.custom2-btn-info {
    text-decoration: none;
    font-size: bold;
    background-color: #0056b3;
    color:white;
}

.custom2-btn-info:hover {
    background-color: #007bff;

}

/* Success Button */
.custom-btn-success {
    background-color: #28a745;
    color: white;
    text-decoration: none;
}

.custom-btn-success:hover {
    background-color: #218838;
}

/* Danger Button */
.custom-btn-danger {
    background-color: #dc3545;
    color: white;
    text-decoration: none;
}

.custom-btn-danger:hover {
    background-color: #c82333;
}

/* Adjust spacing between buttons */
#document-status a {
    margin-right: 10px;
}

/* Flex container to align status text and buttons properly */
.detail-value {
    display: flex;
    align-items: center;
    gap: 20px;
}

/* Add margin between status and buttons */
#status-text {
    margin-right: 20px;
}



    .action-buttons {
    grid-column: 1 / -1;
    display: flex;
    gap: 9px;
    padding: 10px;
    border-radius: 8px;
}
/* Specific Action Buttons */
.action-buttons .custom-btn {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 10px;
    width: 100px; /* Fixed width for uniform buttons */
    height: 100px; /* Fixed height */
    color: black; /* Black text and icons by default */
    font-size: 14px;
    background-color: transparent; /* Transparent background */
    border: none; /* No borders */
    transition: background-color 0.3s, color 0.3s;
    text-align: center;
}

.custom-btn i {
    font-size: 24px;
    margin-bottom: 5px; /* Space between icon and label */
    color: black; /* Black icons */
}

/* Hover Effects */
.custom-btn-success:hover {
    background-color: #28a745; /* Green background on hover */
    color: white; /* White text and icons on hover */
}

.custom-btn-primary:hover {
    background-color: #007bff; /* Blue background on hover */
    color: white; /* White text and icons on hover */
}

.custom-btn-danger:hover {
    background-color: #dc3545; /* Red background on hover */
    color: white; /* White text and icons on hover */
}

/* Ensure buttons are placed next to each other without gaps */
.action-buttons a {
    text-decoration: none;
}

/* Additional Button Styles */
.custom-btn-outline-secondary {
    background-color: transparent;
    color: #000; /* Default text color */
    border: 1px solid #000; /* Border color */
}

.custom-btn-outline-secondary:hover {
    background-color: #6c757d; /* Grey background on hover */
    color: white; /* Text color on hover */
}

.custom-btn-info {
    background-color: transparent;
    color: #000; /* Default text color */
    border: 1px solid #000; /* Border color */
}

.custom-btn-info:hover {
    background-color: #17a2b8; /* Info button hover color */
    color: white; /* Text color on hover */
}

/* Responsive adjustments for buttons */
@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column; /* Stack buttons on smaller screens */
    }

    .btn {
        width: 100%; /* Full width buttons */
    }
}


    /* General layout for document details */
.document-details {
    display: grid;
    padding: 10px;
   /* background-color: #f7f7f7;*/
    border-radius: 8px;
    width: 800px;
}

/* Each row containing label and value */
.detail-row {
    display: flex;
    justify-content: flex-start;
    gap: 20px;
    align-items: center;
}

/* Styling for the label section */
.detail-label {
    font-weight: bold;
    display: flex;
    align-items: center;
    min-width: 150px; /* Minimum width for labels */
    color: #007bff; /* Label icon color */
}

/* Styling for the value section */
.detail-value {
    flex-grow: 1;
    display: flex;
    align-items: center;
}

/* Adjust icons inside labels */
.detail-label i {
    margin-right: 8px;
}


    .document-details div {
        display: flex;
        align-items: center;
        font-size: 16px;
        margin: 10px;
    }

    .document-details i {
        margin-right: 10px;

    }

    /* Right Panel (PDF Canvas) */
    #pdfCanvas {
        border: 1px solid black;
        width: 100%;
        height: auto;
    }

    /* Bottom (Document Versions) */
    .versions-container {
        grid-column: 1 / -1;
        margin-top: 20px;
    }

    .table {
        width: 100%;
        margin: 0 auto;
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-container {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="main-container">
<!-- Action Buttons at the Top -->
<div class="action-buttons">
        <a href="<?= site_url('documents/download/' . $document['file']) ?>" class="custom-btn custom-btn-success">
            <i class="fas fa-download"></i> Télécharger
        </a>
        <a href="<?= site_url('documents/edit/'.$document['id']) ?>" class="custom-btn custom-btn-primary">
            <i class="fas fa-edit"></i> Modifier
        </a>
        <a href="<?= site_url('documents/delete_document/'.$document['id']) ?>" class="custom-btn custom-btn-danger">
            <i class="fas fa-trash-alt"></i> Supprimer
        </a>
        <a href="<?= site_url('documents/share/' . $document['id']) ?>" class="custom-btn custom-btn-outline-secondary">
        <i class="fas fa-share-alt"></i> Partager
    </a>
    <a href="<?= site_url('documents/preview_document/' . $document['id']) ?>" class="custom-btn custom-btn-info" target="_blank">
        <i class="fas fa-eye"></i> Aperçu
    </a>
    </div>

   <!-- Document Details (Left) -->
<div class="document-details">
     
    <div class="detail-row">
        <div class="detail-label"><i class="fas fa-file-alt"></i><strong>Title:</strong></div>
        <div class="detail-value"><?= $document['title'] ?></div>
    </div>
    
    <div class="detail-row">
        <div class="detail-label"><i class="fas fa-align-left"></i><strong>Description:</strong></div>
        <div class="detail-value"><?= $document['description'] ?></div>
    </div>
    
    <div class="detail-row">
        <div class="detail-label"><i class="fas fa-calendar-alt"></i><strong>Date de Création:</strong></div>
        <div class="detail-value"><?= date('d-m-Y', strtotime($document['created_at'])) ?></div>
    </div>
    
    <div class="detail-row">
        <div class="detail-label"><i class="fas fa-file"></i><strong>Fichier:</strong></div>
        <div class="detail-value">
            <?= $document['original_name'] ?>
            <a href="<?= site_url('documents/preview_document/' . $document['id']) ?>" class="custom1-btn custom1-btn-info"target="_blank">
               <div></div>
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>

    <!-- Status Section -->
    <div class="detail-row">
        <div class="detail-label"><i class="fas fa-tasks"></i><strong>Document Status:</strong></div>
        <div class="detail-value" id="document-status">
            <?php if ($document['transfer_status'] == 'not_transferred'): ?>
                <span id="status-text" class="status-gray"> Not Transferred</span>
                <a href="javascript:void(0);" class="custom-btn custom2-btn-info transfer-btn" data-id="<?= $document['id'] ?>">
                    <i class="fas fa-exchange-alt"></i> Transfer Now
                </a>
            <?php elseif ($document['transfer_status'] == 'await_approval'): ?>
                <span id="status-text" class="status-yellow"> Awaiting Approval</span>
                <a href="javascript:void(0);" class="custom-btn custom-btn-success approve-btn" data-id="<?= $document['id'] ?>">
                    <i class="fas fa-check"></i> Approve Now
                </a>
                <a href="javascript:void(0);" class="custom-btn custom-btn-danger reject-btn" data-id="<?= $document['id'] ?>">
                    <i class="fas fa-times"></i> Reject
                </a>
            <?php elseif ($document['transfer_status'] == 'approved'): ?>
                <span id="status-text" class="status-green"> Approved</span>
            <?php endif; ?>
        </div>
    </div>

</div>

    <!-- PDF Canvas (Right) -->
    <canvas id="pdfCanvas" style="border: 1px solid black; max-width: 100%; height: auto;"></canvas>

    <!-- Document Versions at the Bottom -->
    <div class="versions-container">
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
    </div>
    
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
</div>

<script>
   const url = '<?= base_url('documents/preview_document/'.$document['id']); ?>'; 
   const canvas = document.getElementById('pdfCanvas');
const ctx = canvas.getContext('2d');

// Set the desired width for the minimized canvas
const desiredWidth = 300; // Set this to whatever size you want
let scale;

// Load the PDF document
pdfjsLib.getDocument(url).promise.then(function(pdfDoc) {
    // Fetch the first page
    pdfDoc.getPage(1).then(function(page) {
        const viewport = page.getViewport({ scale: 1 });
        
        // Calculate the scale based on the desired width
        scale = desiredWidth / viewport.width;
        const scaledViewport = page.getViewport({ scale: scale });
        
        // Set canvas dimensions to the new scaled size
        canvas.width = desiredWidth;
        canvas.height = scaledViewport.height;

        // Render the page into the canvas context
        const renderContext = {
            canvasContext: ctx,
            viewport: scaledViewport
        };
        page.render(renderContext);
    });
});


$(document).ready(function() {
    // Handle Transfer Now
    $(document).on('click', '.transfer-btn', function() {
        var documentId = $(this).data('id');
        $.ajax({
            url: '<?= site_url("documents/transfer") ?>/' + documentId,
            method: 'POST',
            cache: false, // Prevents browser caching
            success: function(response) {
                // Update the status and buttons
                $('#document-status').html(`
                    <span id="status-text" class="status-green"> Awaiting Approval</span>
                    <a href="javascript:void(0);" class="custom-btn custom-btn-success approve-btn" data-id="${documentId}">
                        <i class="fas fa-check"></i> Approve Now
                    </a>
                    <a href="javascript:void(0);" class="custom-btn custom-btn-danger reject-btn" data-id="${documentId}">
                        <i class="fas fa-times"></i> Reject
                    </a>
                `);
            },
            error: function(error) {
                alert('Failed to transfer the document.');
            }
        });
    });

    // Handle Approve Now
    $(document).on('click', '.approve-btn', function() {
        var documentId = $(this).data('id');
        $.ajax({
            url: '<?= site_url("documents/approve") ?>/' + documentId,
            method: 'POST',
            cache: false,
            success: function(response) {
                // Update the status to Approved
                $('#document-status').html(`
                    <span id="status-text" class="status-blue"> Approved</span>
                `);
            },
            error: function(error) {
                alert('Failed to approve the document.');
            }
        });
    });

    // Handle Reject
    $(document).on('click', '.reject-btn', function() {
        var documentId = $(this).data('id');
        $.ajax({
            url: '<?= site_url("documents/reject") ?>/' + documentId,
            method: 'POST',
            cache: false,
            success: function(response) {
                // Reset the status to Not Transferred
                $('#document-status').html(`
                    <span id="status-text" class="status-gray"> Not Transferred</span>
                    <a href="javascript:void(0);" class="custom-btn custom-btn-info transfer-btn" data-id="${documentId}">
                        <i class="fas fa-exchange-alt"></i> Transfer Now
                    </a>
                `);
            },
            error: function(error) {
                alert('Failed to reject the document.');
            }
        });
    });
});

</script>
