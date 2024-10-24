<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <title>Document Management System</title>
    
    <!-- Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">    
   
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/main.min.css" rel="stylesheet">

    <style>
        .navbar {
           /* background-color: white;  White background */
            box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.1); /* Optional shadow for better visibility */
        }
        .navbar-brand {
            flex-grow: 1;
            text-align: center;
           /* color: black;  Dark text for contrast */
        }
        /*.navbar-nav .nav-link {
           /* color: #343a40;  Dark text for navbar links 
        }*/
        .navbar-nav .nav-link:hover {
            color: #007bff; /* Add a blue hover effect for links */
        }
        .navbar-toggler {
            border-color: #343a40; /* Dark border for the toggle icon */
        }
        .navbar-toggler-icon {
            background-color: #343a40; /* Dark color for the hamburger icon */
        }
        .dark-mode {
        background-color: #333;
        color: #fff;
        }

        .dark-mode .card {
        background-color: #444;
        color: #fff;
        }

        .dark-mode .btn {
        color: #fff;
        margin-right: 10px;
        }
                /* Default (light mode) */
        #dark-mode-icon {
        color: #000; /* Default to black */
        }

        /* In dark mode, make the icon visible */
        .dark-mode #dark-mode-icon {
        color: #fff; /* White in dark mode */
        }

        #dark-mode-toggle:hover #dark-mode-icon {
        color: #f0ad4e; /* For example, a yellow color when hovering */
        border-radius: 50%; /* Make it circular */

        }
        #dark-mode-toggle {
        width: 40px; /* Set the width */
        height: 40px; /* Set the height */
        border-radius: 50%; /* Make it circular */
        display: flex; /* Center the icon */
        align-items: center; /* Center the icon vertically */
        justify-content: center; /* Center the icon horizontally */
        border: 2px solid transparent; /* Add border for hover effect */
        margin-right: 10px;
    }


    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Center the Logo -->
            <a class="navbar-brand mx-auto" href="#">
                <img src="/tutorial2/logo3.png" alt="Logo" style="height: 40px; margin-right: 10px;">
                Doc Fairy
            </a>

           
            <div class="collapse navbar-collapse" id="navbar">
                <!-- Right-aligned Login/Register or Logout/Logged In -->
                <ul class="navbar-nav ml-auto">
                  <?php if(!$this->session->userdata('logged_in')): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($this->uri->segment(1) == 'users' && $this->uri->segment(2) == 'register') ? 'active' : ''; ?>" href="<?php echo base_url(); ?>users/register">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($this->uri->segment(1) == 'users' && $this->uri->segment(2) == 'login') ? 'active' : ''; ?>" href="<?php echo base_url(); ?>users/login">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                  <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>users/profile">
                            <i class="fas fa-user-circle"></i> Welcome, <?php echo $this->session->userdata('username'); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($this->uri->segment(1) == 'users' && $this->uri->segment(2) == 'logout') ? 'active' : ''; ?>" href="<?php echo base_url(); ?>users/logout">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                  <?php endif; ?>
                </ul>
            </div>
        </div>
        <button id="dark-mode-toggle" class="btn btn-outline-secondary">
            <i id="dark-mode-icon" class="bi bi-moon"></i>
        </button>
    </nav>

    <!-- Bootstrap JS (for navbar toggle) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
       const toggleButton = document.getElementById('dark-mode-toggle');
        const icon = document.getElementById('dark-mode-icon');

        toggleButton.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');

        // Change the icon based on the mode
        if (document.body.classList.contains('dark-mode')) {
            icon.classList.remove('bi-moon');
            icon.classList.add('bi-sun');
        } else {
            icon.classList.remove('bi-sun');
            icon.classList.add('bi-moon');
        }
        });


    </script>
</body>
</html>
