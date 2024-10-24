<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com'; // SMTP server
$config['smtp_port'] = 587; // SMTP port
$config['smtp_user'] = 'btissa.alami@gmail.com'; // Your email address
$config['smtp_pass'] = 'ksug moax bqyr bpnk'; // Your email account's password
$config['smtp_crypto'] = 'tls'; // Encryption method (TLS for port 587)
$config['mailtype'] = 'html'; // Email format, can be 'text' or 'html'
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n"; // Newline character for email
