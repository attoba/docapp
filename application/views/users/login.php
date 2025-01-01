


<!-- Form Open Tag -->
<?php echo form_open('users/login'); ?>

<!-- Container for Centering the Form Vertically and Horizontally -->
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-4">
            <!-- Form Title -->
            <h1 class="text-center"><?= $title; ?></h1>

            <!-- Username Field -->
            <div class="form-group mb-3">
                <label>Username</label>
                <input type="text" class="form-control" name="username" placeholder="Enter your username">
            </div>

            <!-- Password Field with Toggle Visibility -->
            <div class="form-group mb-3">
                <label>Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password">
                    <div class="input-group-append">
                        <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
        <?php
        
            require 'vendor/autoload.php';

            use Dotenv\Dotenv;  
            $dotenvPath = dirname(__DIR__, 3);  // Adjust the path
            $dotenv = Dotenv::createUnsafeImmutable($dotenvPath);
            $dotenv->load();       
    
          ?>

            <!-- Google reCAPTCHA -->          
            <div class="form-group mb-3">
                <div class="g-recaptcha" data-sitekey=<?php echo htmlspecialchars($_ENV['RECAPTCHA_KEY'], ENT_QUOTES, 'UTF-8'); ?>></div>
            </div>


            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </div>
    </div>
</div>

<!-- Form Close Tag -->
<?php echo form_close(); ?>

<!-- Load the reCAPTCHA API script -->
<script src="https://www.google.com/recaptcha/api.js"></script>

<!-- Font Awesome for the eye icon -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
// JavaScript to toggle password visibility
const togglePassword = document.querySelector('#togglePassword');
const passwordField = document.querySelector('#password');
const eyeIcon = document.querySelector('#togglePassword i');

togglePassword.addEventListener('click', function () {
    // Toggle the type attribute
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
    
    // Toggle the eye / eye-slash icon
    eyeIcon.classList.toggle('fa-eye');
    eyeIcon.classList.toggle('fa-eye-slash');
});
</script>

<style>
html, body {
    height: 100%;
    margin: 0;
}

.container {
    justify-content: center;
    align-items: center;
}

.input-group-text {
    cursor: pointer;
}
.g-recaptcha {
        display: block;
        margin-top: 60px;
        align-items: center;
margin-left: 25px;
    }
    h1 {
        margin-bottom: 30px;
        font-size: 2rem;
    }

    .btn-primary {
        padding: 10px 20px;
        font-size: 1.2rem;
    }
    .form-group label {
        font-weight: bold;
    }
</style>
