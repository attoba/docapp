<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
    <style>
        .card {
          transition: transform 0.2s; /* Smooth transition */
      }

      .card:hover {
          transform: scale(1.05); /* Slightly increase the size on hover */
          cursor: pointer; /* Change cursor to pointer */
      }
      
  .btn-circle {
    width: 60px; /* Adjust size */
    height: 60px; /* Same as width for circle */
    border-radius: 100%; /* Makes the button circular */
    display: flex; /* Center the icon */
    align-items: center; /* Center vertically */
    justify-content: center; /* Center horizontally */
    font-size: 24px; /* Adjust icon size */
    transition: transform 0.2s;
  }
  .btn-circle :hover {
          transform: scale(1.05); /* Slightly increase the size on hover */
          cursor: pointer; /* Change cursor to pointer */
      }

</style>
   

    
  <div class="container-fluid">
    <div class="row">
      <!-- Quick Access Section -->
      <div class="col-md-3">
      <a href="../create" class="btn btn-primary btn-circle mb-4 shadow-sm text-decoration-none">
        <i class="bi bi-plus"></i>
      </a>

        <a href="../mydocuments" class="card mb-4 shadow-sm text-decoration-none">
          <div class="card-body text-center">
            <i class="bi bi-folder fs-1 text-primary"></i>
            <h5 class="mt-3">My Documents</h5>
          </div>
        </a>

        <a href="YOUR_LINK_HERE" class="card mb-4 shadow-sm text-decoration-none">
          <div class="card-body text-center">
              <i class="bi bi-arrow-repeat fs-1 text-primary"></i>
              <h5 class="mt-3">Transferred Documents</h5>
          </div>
        </a>

      </div>

      <!-- Main Dashboard Content -->
      <div class="col-md-9">
        <!-- Statistics Section -->
        <div class="row">
              <div class="col-md-4">
          <div class="card shadow-sm mb-4">
              <div class="card-body text-center">
                  <h5 class="text-muted">
                      <i class="fas fa-file-alt"></i> Total Documents
                  </h5>
                  <h3 class="text-primary"><?php echo $total_documents; ?></h3>
              </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="card shadow-sm mb-4">
              <div class="card-body text-center">
                  <h5 class="text-muted">
                      <i class="fas fa-users"></i> Total Customers
                  </h5>
                  <h3 class="text-success"><?php echo $total_customers; ?></h3>
              </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="card shadow-sm mb-4">
              <div class="card-body text-center">
                  <h5 class="text-muted">
                      <i class="fas fa-clock"></i> Pending Approval
                  </h5>
                  <h3 class="text-warning"><?php echo $pending_approval; ?></h3>
              </div>
          </div>
      </div>

        </div>

        

        <!-- Upcoming Deadlines Section -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header">Upcoming Deadlines</div>
          <div class="card-body">
            <ul class="list-unstyled">
              <?php if (!empty($upcoming_deadlines)): ?>
                <?php foreach ($upcoming_deadlines as $event): ?>
                  <li>
                    <strong><?php echo htmlspecialchars($event['event_name']); ?></strong>
                    <span class="text-muted"> - <?php echo date('M d, Y', strtotime($event['event_start_datetime'])); ?></span>
                  </li>
                <?php endforeach; ?>
              <?php else: ?>
                <li>No upcoming events.</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </div>

  
</body>
</html>
