<?php echo form_open('users/verify_otp'); ?>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-4">
                <h3 class="text-center">Vérifiez votre boîte de réception</h3>
                <br> <br>

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label><input type="text" />Saisissez le code de vérification</label>
                    <input type="text" class="form-control" name="otp" placeholder="Code">
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Continuer</button>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>
