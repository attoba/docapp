<style>
    .footer-icons a {
    margin-right: 15px; /* Adjust the value as needed */
}

</style>
</div> <!-- End of container -->

<!-- Footer -->
<footer class="footer mt-auto py-3 bg-dark text-white">
    <div class="container">
        <div class="row">
            <!-- Footer Left -->
            <div class="col-md-4">
                <h5>About Us</h5>
                <p>We are committed to providing the best content and resources to help you grow your skills and knowledge.</p>
            </div>
            
            <!-- Footer Middle -->
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="<?php echo base_url(); ?>" class="text-white">Home</a></li>
                    <li><a href="<?php echo base_url('about'); ?>" class="text-white">About</a></li>
                    <li><a href="<?php echo base_url('posts'); ?>" class="text-white">Blog</a></li>
                    <li><a href="#" class="text-white">Contact</a></li>
                </ul>
            </div>

                <!-- Footer Right -->
                <div class="col-md-4">
            <h5>Follow Us</h5>
            <a href="#" class="text-white footer-icons"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white footer-icons"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white footer-icons"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white footer-icons"><i class="fab fa-linkedin-in"></i></a>
        </div>


        </div>
        <hr class="bg-white">
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0">© 2024 My Blog. All Rights Reserved.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-white">Privacy Policy</a>
                <span class="text-white mx-2">|</span>
                <a href="#" class="text-white">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<a href="#" id="back-to-top" class="btn btn-primary btn-lg back-to-top" role="button" title="Click to return to the top" data-toggle="tooltip" data-placement="left">
    <i class="fas fa-chevron-up"></i>
</a>



<!-- Bootstrap JS from CDN -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<!-- JavaScript includes 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
-->
<script>
    // Back to Top Button
    $(document).ready(function(){
        $('#back-to-top').hide();

        $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });

        $('#back-to-top').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });
    });
</script>
</body>
</html>
