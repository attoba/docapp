<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document Management Sidebar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.3/font/bootstrap-icons.min.css">

  <style>
    body, html {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }
    .d-flex {
      flex-grow: 1;
    }
    .sidebar {
      display: flex;
      flex-direction: column;
      height: 100vh; /* Full height of the viewport */
      background-color: #343a40;
      padding-top: 20px;
      position: fixed; /* Keep the sidebar fixed */
      top: 0;
      bottom: 0;
      left: 0;
      width: 255px;
      transition: width 0.3s ease; /* Smooth transition for collapse */
    }
    .sidebar a {
      color: white;
      display: flex;
      align-items: center;
      padding: 10px;
      text-decoration: none;
    }
    .sidebar a:hover, .menu-header:hover {
      background-color: #495057;
    }
    .main-content {
      margin-left: 230px; /* Default margin for non-collapsed sidebar */
      padding: 20px;
      flex-grow: 1;
      transition: margin-left 0.3s ease; /* Smooth transition for content adjustment */
    }
    .content-wrapper {
      max-width: 100%; /* Ensure the content expands fully */
      text-align: center;
    }
    .sidebar.collapsed {
      width: 80px; /* Collapsed width */
    }
    .sidebar.collapsed ~ .main-content {
      margin-left: 80px; /* Adjust margin when sidebar is collapsed */
    }
    .sidebar.collapsed .menu-text {
      display: none; /* Hide text when sidebar is collapsed */
    }
    /* Space between icon and text */
    .menu-text {
      margin-left: 10px;
    }
    /* Optional: Center icons when sidebar is collapsed */
    .sidebar.collapsed a {
      justify-content: center;
    }
    /* Sublinks */
    .submenu {
      display: none;
      padding-left: 20px;
    }
   
    .submenu.show {
      display: block;
    }
    .menu-header {
      color: white;
      display: flex;
      align-items: center;
      padding: 10px;
      cursor: pointer;
    }
    .menu-header .bi-chevron-down {
      margin-left: auto;
    }
    /* Style for sublinks */
.submenu a {
  color: white;
  display: flex;
  align-items: center;
  padding: 10px;
  text-decoration: none;
}

/* Space between icon and text */
.submenu .submenu-text {
  margin-left: 10px;
}

/* Hide sublink text when sidebar is collapsed */
.sidebar.collapsed .submenu .submenu-text {
  display: none;
}

/* Optional: center icons when the sidebar is collapsed */
.sidebar.collapsed .submenu a {
  justify-content: center;
}
#toggleBtn {
  background-color: #343a40; /* Dark background */
  color: white; /* White text (icon) */
  border: none; /* Remove default border */
  border-radius: 5px; /* Rounded corners */
  padding: 8px 12px; /* Adjust padding for better size */
  cursor: pointer; /* Show pointer on hover */
  transition: background-color 0.3s ease; /* Smooth transition on hover */
  font-size: 16px; /* Adjust font size for the icon */
  width: 40px;
}

#toggleBtn:hover {
  background-color: #495057; /* Darker background on hover */
}

#toggleBtn:focus {
  outline: none; /* Remove focus outline */
  box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5); /* Add focus shadow for accessibility */
}




/* Sidebar content with scrolling enabled */
.sidebar-content {
  flex-grow: 1;
  overflow-y: auto; /* Makes the content scrollable */
  padding-bottom: 50px; /* Adds padding to avoid content being hidden under the fixed settings */
}

/* Fixed "Settings" section at the bottom */
/* Special styling for Settings section */
.settings-section {
  position: absolute;
  text-align: center; /* Center the settings text */
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 15px; /* Increased padding for a larger clickable area */
  background-color: #495057; /* Slightly lighter than the sidebar */
  cursor: pointer;
  border-top: 1px solid #6c757d; /* Top border for separation */
  transition: background-color 0.3s ease; /* Smooth hover transition */
}

.settings-section:hover {
  background-color: #6c757d; /* Lighter background on hover */
}

/* Special style for Settings submenu */
.SettingsSubmenu {
  position: absolute;
  display: none;
  top: auto;
  left: 250px; /* Place outside the expanded sidebar */
  width: 220px;
  background-color: #495057; /* Match with Settings section */
  z-index: 1000; /* Ensure it's on top */
  border-left: 3px solid #6c757d; /* Border for visual separation */
  border-top: 1px solid #6c757d; /* Border on top as well */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow for depth */
  transition: all 0.3s ease; /* Smooth open/close animation */
  padding: 10px 0; /* Padding for submenu items */
}

/* Display submenu when visible */
.submenu.show {
  display: block;
}

/* Submenu links styling */
.SettingsSubmenu a {
  color: #fff;
  display: block;
  padding: 10px 15px;
  text-decoration: none;
}

.SettingsSubmenu a:hover {
  background-color: #6c757d;
}

/* Adjust for collapsed sidebar */
.sidebar.collapsed ~ .SettingsSubmenu {
  left: 80px; /* Align outside the collapsed sidebar */
}

/* Chevron icon rotation */
.menu-header i.bi-chevron-down {
  transition: transform 0.3s ease;
}

.menu-header .show i.bi-chevron-down {
  transform: rotate(180deg); /* Rotate icon when submenu is open */
}


.submenu.show {
  display: block;
}

/* Customize the scrollbar */
.sidebar-content::-webkit-scrollbar {
  width: 5px; /* Adjust the width of the scrollbar */
}

.sidebar-content::-webkit-scrollbar-track {
  background-color: #343a40; /* Color of the scrollbar track */
}

.sidebar-content::-webkit-scrollbar-thumb {
  background-color: #6c757d; /* Color of the scrollbar thumb */
  border-radius: 10px; /* Rounded scrollbar thumb for a smoother look */
}

.sidebar-content::-webkit-scrollbar-thumb:hover {
  background-color: #495057; /* Darker color on hover */
}

/* Collapsed sidebar styles */
.sidebar.collapsed .sidebar-content {
  overflow-y: hidden; /* Hide scrollbar */
}

.sidebar.collapsed .bi-chevron-down {
  display: none; /* Hide the chevron-down icon */
}


  </style>
</head>
<body>
  <div class="d-flex">
    <div class="sidebar bg-dark p-3" id="sidebar">
    <button class="btn btn-light btn-sm mb-3" id="toggleBtn">☰</button>
    <!-- Sidebar content container -->
    <div class="sidebar-content">
      <a href="<?php echo base_url(); ?>dashboard/adminDashboard">
        <i class="bi bi-file-earmark-plus"></i>
        <span class="menu-text">dashboard</span>
      </a>

      <!-- Menu header (not clickable, just expandable) -->
      <div class="menu-header" id="documentsMenu">
        <i class="bi bi-folder"></i>
        <span class="menu-text">Documents</span>
        <i class="bi bi-chevron-down"></i> <!-- Expand icon -->
      </div>
      <!-- Collapsible sublinks -->
      <div class="submenu show" id="documentsSubmenu">
        <a href="<?php echo base_url(); ?>documents">
          <i class="bi bi-file-earmark"></i>
          <span class="submenu-text">All Documents</span>
        </a>
        <a href="<?php echo base_url(); ?>mydocuments">
          <i class="bi bi-arrow-repeat"></i>
          <span class="submenu-text">Transferred </span>
        </a>
        <a href="<?php echo base_url(); ?>mydocuments">
          <i class="bi bi-person"></i>
          <span class="submenu-text">My Documents</span>
        </a>
      </div>

       <!-- Menu header (not clickable, just expandable) -->
       <div class="menu-header" id="clientsMenu">
        <i class="bi bi-folder"></i>
        <span class="menu-text">Clients</span>
        <i class="bi bi-chevron-down"></i> <!-- Expand icon -->
      </div>
      <!-- Collapsible sublinks -->
      <div class="submenu show" id="clientsSubmenu">
        <a href="<?php echo base_url(); ?>clients">
          <i class="bi bi-file-earmark"></i>
          <span class="submenu-text">Clients</span>
        </a>
        <a href="<?php echo base_url(); ?>NewClient">
          <i class="bi bi-arrow-repeat"></i>
          <span class="submenu-text">New Client </span>
        </a>
        <a href="<?php echo base_url(); ?>mydocuments">
          <i class="bi bi-person"></i>
          <span class="submenu-text">My Documents</span>
        </a>
      </div>
    

      <a href="<?php echo base_url(); ?>create">
        <i class="bi bi-file-earmark-plus"></i>
        <span class="menu-text">Create</span>
      </a>
      
      <a href="<?php echo base_url(); ?>calendar">
        <i class="bi bi-calendar3"></i>
        <span class="menu-text">Calendar</span>
      </a>

      <a href=href="<?php echo base_url(); ?>contact">
        <i class="bi bi-person-lines-fill"></i>
        <span class="menu-text">Contact</span>
      </a>
     
    </div>
      <!-- Settings section at the bottom -->
      <div class="menu-header settings-section" id="SettingsMenu">
        <i class="bi bi-gear"></i>
        <span class="menu-text">Settings</span>
      </div>
      <!-- Collapsible Settings submenu -->
      <div class="submenu settings-section SettingsSubmenu" id="SettingsSubmenu">
        <a href="<?php echo base_url(); ?>changePassword">
          <i class="bi bi-file-earmark"></i>
          <span class="submenu-text">Change Password</span>
        </a>
      </div>

   </div>

    <div class="main-content" id="mainContent">
      <div class="content-wrapper">
        <!-- The view content will be loaded here -->
        <?php $this->load->view($view); ?>
      </div>
    </div>
  </div>

  <script>
    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const documentsMenu = document.getElementById('documentsMenu');
    const documentsSubmenu = document.getElementById('documentsSubmenu');
    const clientsMenu = document.getElementById('clientsMenu');
    const clientsSubmenu = document.getElementById('clientsSubmenu');
    const SettingsMenu = document.getElementById('SettingsMenu');
    const SettingsSubmenu = document.getElementById('SettingsSubmenu');
    
    toggleBtn.addEventListener('click', function() {
      sidebar.classList.toggle('collapsed');
      // Dynamically update the main content margin based on sidebar state
      if (sidebar.classList.contains('collapsed')) {
        mainContent.style.marginLeft = '80px'; // Adjust margin for collapsed sidebar
      } else {
        mainContent.style.marginLeft = '250px'; // Adjust margin for expanded sidebar
      }
    });
    // Toggle submenu visibility
    SettingsMenu.addEventListener('click', function() {
      SettingsSubmenu.classList.toggle('show');
      const chevron = SettingsMenu.querySelector('.bi-chevron-down');
      // Rotate chevron when submenu is visible
      if (SettingsSubmenu.classList.contains('show')) {
        chevron.style.transform = 'rotate(180deg)';
      } else {
        chevron.style.transform = 'rotate(0deg)';
      }
    });

    // Show the submenu by default (you can add the 'show' class directly in the HTML)
clientsSubmenu.classList.add('show');
documentsSubmenu.classList.add('show');

// Toggle submenu visibility for Clients Menu
clientsMenu.addEventListener('click', function() {
  clientsSubmenu.classList.toggle('show');
  const chevron = clientsMenu.querySelector('.bi-chevron-down');
  
  // Rotate chevron based on submenu visibility
  if (!clientsSubmenu.classList.contains('show')) {
    chevron.style.transform = 'rotate(0deg)';
  } else {
    chevron.style.transform = 'rotate(180deg)';
  }
});

// Toggle submenu visibility for Documents Menu
documentsMenu.addEventListener('click', function() {
  documentsSubmenu.classList.toggle('show');
  const chevron = documentsMenu.querySelector('.bi-chevron-down');
  
  // Rotate chevron based on submenu visibility
  if (!documentsSubmenu.classList.contains('show')) {
    chevron.style.transform = 'rotate(0deg)';
  } else {
    chevron.style.transform = 'rotate(180deg)';
  }
});

  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
