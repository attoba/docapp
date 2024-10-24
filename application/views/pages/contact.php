<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-6">
        <h2 class="text-center"><i class="fas fa-envelope"></i> Contacter</h2>
        <form action="<?php echo base_url('contact/contactEmail'); ?>" method="post">
            
            <div class="form-group mb-3">
                <label for="to">A</label>
                <input type="email" class="form-control" name="to" id="to" placeholder="Enter l'email du destinataire" required>
            </div>
            
            <div class="form-group mb-3">
                <label for="subject">Objet</label>
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Entrer le sujet" required>
            </div>
            
            <div class="form-group mb-3">
                <label for="message">Message</label>
                <textarea class="form-control" name="message" id="message" rows="5" placeholder="Entrer Votre Message" required></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Envoyer l'Email</button>
            
        </form>
    </div>
</div>
