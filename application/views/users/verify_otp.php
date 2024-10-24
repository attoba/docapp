<?php echo form_open('users/verify_otp'); ?>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-4">
                <h1 class="text-center">Verify OTP</h1>

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label>Enter OTP</label>
                    <input type="text" class="form-control" name="otp" placeholder="Enter OTP">
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Verify OTP</button>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>
