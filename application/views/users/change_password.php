<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-4">
            
            <?php if(validation_errors()): ?>
                <div class="alert alert-danger">
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif; ?>
            
            <?php if($this->session->flashdata('password_error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('password_error'); ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('password_changed')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('password_changed'); ?>
                </div>
            <?php endif; ?>

            <?php echo form_open('users/change_password'); ?>
                <div class="form-group">
                    <label>Old Password</label>
                    <input type="password" class="form-control" name="old_password" placeholder="Old Password">
                </div>
                
                <div class="form-group">
                    <label>New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password">
                        <div class="input-group-append">
                            <span class="input-group-text" id="toggleNewPassword">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm New Password">
                </div>

                <button type="submit" class="btn btn-primary btn-block">Change Password</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Font Awesome for the eye icon -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script>
// JavaScript to toggle new password visibility
const toggleNewPassword = document.querySelector('#toggleNewPassword');
const newPasswordField = document.querySelector('#new_password');
const eyeIcon = document.querySelector('#toggleNewPassword i');

toggleNewPassword.addEventListener('click', function () {
    const type = newPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
    newPasswordField.setAttribute('type', type);
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
    font-weight: bold;
}

.input-group-text {
    cursor: pointer;
}
</style>
