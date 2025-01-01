<?php
require 'vendor/autoload.php';
use Dotenv\Dotenv;
        
// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../'); 
$dotenv->load();
defined('BASEPATH') || exit('No direct script access allowed');

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com'; // SMTP server
$config['smtp_port'] = 587; // SMTP port
$config['smtp_user'] = 'btissa.alami@gmail.com'; // Your email address
$config['smtp_pass'] = $_ENV['EMAIL_PASSWORD']; // Your email account's password
$config['smtp_crypto'] = 'tls'; // Encryption method (TLS for port 587)
$config['mailtype'] = 'html'; // Email format, can be 'text' or 'html'
$config['charset'] = 'utf-8';
$config['wordwrap'] = true;
$config['newline'] = "\r\n"; // Newline character for email
