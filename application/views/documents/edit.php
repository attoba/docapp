<?php if(validation_errors()): ?>
    <div class="alert alert-danger">
        <?php echo validation_errors(); ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php echo validation_errors(); ?>
                
                <?php if (isset($document['id'])): ?>
                    <?php echo form_open_multipart('documents/update/'.$document['id']); ?>
                    <input type="hidden" name="id" value="<?php echo $document['id']; ?>">
                <?php endif; ?>

                <div class="form-group" id="editModal">
                    <label><input type="text" /> Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Add Title" value="<?php echo $document['title']; ?>">
                </div>
                <div class="form-group">
                    <label><input type="text" /> Description</label>
                    <textarea id="editor1" class="form-control" name="description"><?php echo set_value('description', $document['description']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Upload File</label>
                    <p><?php echo $document['file']; ?></p> <!-- Show current file -->
                    <input type="file" name="file" size="20">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
