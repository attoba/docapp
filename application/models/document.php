<?php
use PHPUnit\Framework\TestCase;
require 'vendor/autoload.php';
use Dotenv\Dotenv;
        
// Load the .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../'); 
$dotenv->load();
        

    
    

class Document extends CI_Model {
    public function __construct() {
        // Load the database library
        $this->load->database();
    }

    public function get_documents($id=null) {
        // If no id is provided, retrieve all posts
        if ($id === FALSE) {
            $query = $this->db->get('documents'); // Assuming you have a 'documents' table
            return $query->result_array(); // Return the result as an array
        }

        // If id is provided, retrieve the specific document
        $query = $this->db->get_where('documents', array('id' => $id));
        return $query->row_array() ?: []; // Return an empty array if no result is found
    }
    public function get_documentsByUser($user_id) {
       // Fetch only documents created by the logged-in user
    //$this->db->where('user_id', $user_id);

        // If id is provided, retrieve the specific document
        $query = $this->db->get_where('documents', array('user_id' => $user_id));
        return $query->result_array(); // Return the result as an array
    }
/*
    public function create($client_id,$user_id) {
        $this->load->library('upload'); // Ensure upload library is loaded

        $config['upload_path'] = 'C:/laragon/www/tutorial2/assets/files/documents';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|txt|doc|docx';
        $config['max_size'] = '2048';

        $this->upload->initialize($config);

        // Check if a file has been uploaded
        if (empty($_FILES['file']['name'])) {
            echo "No file selected for upload.";
            return false;
        }

        if (!$this->upload->do_upload('file')) {
            $error = $this->upload->display_errors();
            log_message('error', $error);
            echo $error;
            return false;
        } else {
            $upload_data = $this->upload->data();
            $original_name = $upload_data['file_name'];
            $unique_name = time() . '_' . $original_name;
            $file = $unique_name;

            // Rename the uploaded file
            $old_path = $config['upload_path'] . '/' . $original_name;
            $new_path = $config['upload_path'] . '/' . $unique_name;
            rename($old_path, $new_path);

            if ($client_id === null) {
                show_error('Client ID is missing.', 400);
            }

            // Send the file to VirusTotal API for scanning
            $api_key = ' ';  
            $scan_result = $this->scanFileWithVirusTotal($new_path, $api_key);

            // Prepare the data array
            $data = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'file' => $file,
                'original_name'=> $original_name,
                'user_id' => $user_id,
                'client_id' => $client_id
            );

            // Insert data into the documents table
            $this->db->insert('documents', $data);

            $document_id = $this->db->insert_id();
            if (!$document_id) {
                log_message('error', 'Document insertion failed.');
                return false;
            }

            // Tracking creation
            $version_data = [
                'version_id' => 1,
                'document_id' => $document_id,
                'updated_by' => $user_id,
            ];
            $this->db->insert('document_versions', $version_data);

            // Logs
            $log_data = [
                'document_id' => $document_id,
                'user_id' => $user_id,
                'action' => 'creé',
                'details' => 'Document creé en ',
            ];
            $this->db->insert('document_logs', $log_data);

            // Check for document existence by unique name
            $this->db->where('file', $unique_name);
            $query = $this->db->get('documents');
            if ($query->num_rows() > 0) {
                return true;  // Document created successfully
            } else {
                log_message('error', 'Document creation failed.');
                return false;
            }
        }
    }

    private function scanFileWithVirusTotal($file_path, $api_key) {
        $url = 'https://www.virustotal.com/vtapi/v2/file/scan';

        // Prepare the cURL request
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Prepare the file for upload
        $file = new CURLFile($file_path);
        $post_data = array('file' => $file, 'apikey' => $api_key);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

        // Execute the request
        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the JSON response
        $result = json_decode($response, true);

        if (isset($result['positives'])) {
            return $result;
        } else {
            return ['positives' => 0];
        }
    }
*/

public function create($client_id, $user_id) {
    $this->load->library('upload'); // Ensure upload library is loaded

    $config['upload_path'] = 'C:/laragon/www/tutorial2/assets/files/documents';
    $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|txt|doc|docx';
    $config['max_size'] = '2048';

    $this->upload->initialize($config);

    // Check if a file has been uploaded
    if (empty($_FILES['file']['name'])) {
        echo "No file selected for upload.";
        return false;
    }

    if (!$this->upload->do_upload('file')) {
        $error = $this->upload->display_errors();
        log_message('error', $error);
        echo $error;
        return false;
    } else {
        $upload_data = $this->upload->data();
        $original_name = $upload_data['file_name'];
        $unique_name = time() . '_' . $original_name;
        $file = $unique_name;

        // Rename the uploaded file
        $old_path = $config['upload_path'] . '/' . $original_name;
        $new_path = $config['upload_path'] . '/' . $unique_name;
        rename($old_path, $new_path);

        if ($client_id === null) {
            show_error('Client ID is missing.', 400);
        }

        // Send the file to VirusTotal API for scanning
        $VIRUSTOTAL_KEY = $_ENV['VIRUSTOTAL_KEY'];
       
        $scan_id = $this->sendFileToVirusTotal($new_path, $VIRUSTOTAL_KEY);

        if (!$scan_id) {
            log_message('error', 'VirusTotal scan initiation failed.');
            echo "VirusTotal scan initiation failed.";

            return false;
        }

        // Retrieve the scan result using scan_id
        $scan_result = $this->getVirusTotalScanResult($scan_id, $VIRUSTOTAL_KEY);

        if (isset($scan_result['positives']) && $scan_result['positives'] > 0) {
            log_message('error', 'File detected with potential malware.');
            echo "File detected with malware, upload aborted.";
            return false;
        }

        // Prepare the data array
        $data = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'file' => $file,
            'original_name' => $original_name,
            'user_id' => $user_id,
            'client_id' => $client_id
        );

        // Insert data into the documents table
        $this->db->insert('documents', $data);

        $document_id = $this->db->insert_id();
        if (!$document_id) {
            log_message('error', 'Document insertion failed.');
            return false;
        }

        // Tracking creation
        $version_data = [
            'version_id' => 1,
            'document_id' => $document_id,
            'updated_by' => $user_id,
        ];
        $this->db->insert('document_versions', $version_data);

        // Logs
        $log_data = [
            'document_id' => $document_id,
            'user_id' => $user_id,
            'action' => 'created',
            'details' => 'Document created successfully.',
        ];
        $this->db->insert('document_logs', $log_data);

        return true;  // Document created successfully
    }
}

private function sendFileToVirusTotal($file_path, $api_key) {
    $url = 'https://www.virustotal.com/vtapi/v2/file/scan';

    // Prepare the cURL request
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Prepare the file for upload
    $file = new CURLFile($file_path);
    $post_data = array('file' => $file, 'apikey' => $api_key);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

    // Execute the request
    $response = curl_exec($curl);
    curl_close($curl);

    // Decode the JSON response
    $result = json_decode($response, true);

    if (isset($result['scan_id'])) {
        return $result['scan_id'];
    } else {
        log_message('error', 'VirusTotal scan initiation error: ' . json_encode($result));
        return false;
    }
}

private function getVirusTotalScanResult($scan_id, $api_key) {
    $url = 'https://www.virustotal.com/vtapi/v2/file/report?apikey=' . $api_key . '&resource=' . $scan_id;

    // Prepare the cURL request
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Execute the request
    $response = curl_exec($curl);
    curl_close($curl);

    // Decode the JSON response
    $result = json_decode($response, true);

    if (isset($result['positives'])) {
        return $result;
    } else {
        log_message('error', 'VirusTotal report retrieval error: ' . json_encode($result));
        return ['positives' => 0];
    }
}

    public function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('documents');
        // Logs
        $log_data = [
            'document_id' => $id,
            'user_id' => $this->session->userdata('user_id'),
            'action' => 'deleted',
            'details' => 'Deleted document version',
        ];
        $this->db->insert('document_logs', $log_data);
        return true;
    }

    public function get_last_version_number($document_id) {
        $this->db->select('version_id');
        $this->db->from('document_versions');
        $this->db->where('document_id', $document_id);
        $this->db->order_by('version_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->version_id;
        } else {
            return 0;
        }
    }

    public function update($id) {
        $this->db->where('id', $id);

        $config['upload_path'] = 'C:/laragon/www/tutorial2/assets/files/documents';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|txt|docx';
        $config['max_size'] = 2048;

        $this->upload->initialize($config);

        // If file upload is successful
        if ($this->upload->do_upload('file')) {
            $data = array('upload_data' => $this->upload->data());
            $file = $_FILES['file']['name'];
        } else {
            // No new file uploaded, retrieve the existing file name from the database
            $document = $this->db->select('file')->where('id', $id)->get('documents')->row();
            if ($document) {
                $file = $document->file;
            } else {
                $file = null;
            }
        }

        // Prepare the data array
        $data = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'user_id' => $this->session->userdata('user_id'),
            'file' => $file
        );

        // Update the document record
        $this->db->where('id', $id);
        $this->db->update('documents', $data);

        // Tracking updates
        $document_id = $id;
        $version_id = $this->get_last_version_number($document_id) + 1;

        $version_data = [
            'document_id' => $document_id,
            'version_id' => $version_id,
            'updated_by' => $this->session->userdata('user_id'),
        ];
        $this->db->insert('document_versions', $version_data);

        // Logs
        $log_data = [
            'document_id' => $document_id,
            'user_id' => $this->session->userdata('user_id'),
            'action' => 'updated',
            'details' => 'Updated document to version '.$version_id,
        ];
        $this->db->insert('document_logs', $log_data);
    }

    public function updateTransferStatus($document_id, $status) {
        $this->db->set('transfer_status', $status);
        $this->db->where('id', $document_id);
        $this->db->update('documents');

        if ($this->db->affected_rows() > 0) {
            $log_data = [
                'document_id' => $document_id,
                'user_id' => $this->session->userdata('user_id'),
                //'action' => 'Transféré',
                'details' => 'Document Transféré',
            ];

            $this->db->insert('document_logs', $log_data);
            return true;
        }
        return false;
    }

    public function getTotalDocuments() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM documents");
        return $query->row()->total;
    }
    
    public function getPending_approval() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM documents WHERE transfer_status = 'await_approval'");
        return $query->row()->total;
    }
    public function sum($a, $b){
        return $a + $b;
    }
}
?>
