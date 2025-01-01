<!-- application/views/layout.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <?php require_once 'header.php'; ?> <!-- Optional header -->
  <?php require_once 'sidebar.php'; ?> <!-- Include your sidebar -->
  <div class="main-content">
    <?php echo $this->renderSection('content'); ?> <!-- Render content of each page -->
  </div>
</body>
</html>
