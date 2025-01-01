<?php
// Get the current page's filename
$current_page = $this->uri->segment(1); // Get the first segment of the URL
?>
<nav class="simple-menu">
    <ul class="nav-menu">
        <li class="nav-item <?php if($current_page == 'documents') echo 'active'; ?>">
            <a href="<?php echo base_url(); ?>documents">All Documents</a>
        </li>
        <li class="nav-item <?php if($current_page == 'mydocuments') echo 'active'; ?>">
            <a href="<?php echo base_url(); ?>mydocuments">My Documents</a>
        </li>
        <li class="nav-item <?php if($current_page == 'create') echo 'active'; ?>">
            <a href="<?php echo base_url(); ?>create">Create</a>
        </li>
    </ul>
</nav>

<style>
/* Style the menu container */
.simple-menu {
    margin: 0px;
    box-shadow: 0px 2px 5px -2px rgba(0, 0, 0, 0.1); /* Bottom-only shadow */
    padding: 10px;
    padding-left: 80px; /* Left padding to align the items to the left */
    margin-right: 0;
    width: 100%;
    margin-left: 5px;
}

/* General menu styles */
.nav-menu {
    display: flex;
    justify-content: flex-start; /* Align menu items to the left */
    list-style: none;
    padding: 0;
    margin: 0;
    border-bottom: 2px solid transparent; /* Gray line under the entire menu */

}

/* Style individual menu items */
.nav-item {
    position: relative;
    margin-left: 60px; /* Space between menu items */
    padding-bottom: 10px;
}

/* Style the links */
.nav-item a {
    text-decoration: none;
    color: #333;
    font-size: 18px;  /* Make the text bigger */
    font-weight: bold; /* Bold text */
    padding: 10px 0;
}

/* Blue line under the active/current page */
.nav-item.active::after {
    content: '';
    display: block;
    height: 5px;  /* Thicker line for active item */
    background-color: #007bff;
    width: 100%;
    position: absolute;
    bottom: -10px;  /* Add space between text and the line */
    left: 0;
}

/* Make sure all other items don't have a line */
.nav-item::after {
    content: '';
    display: block;
    height: 2px;
    background-color: transparent; /* No line by default */
    width: 100%;
    position: absolute;
    bottom: -10px; /* Space between the text and the bottom line */
    left: 0;
}

/* Hover state for menu items */
.nav-item a:hover {
    color: #007bff;
}
</style>
