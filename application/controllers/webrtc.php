<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webrtc extends CI_Controller {

    public function index() {
        // Load the WebRTC view (webrtc_view.php)
        $this->load->view('webrtc');
    }
}
