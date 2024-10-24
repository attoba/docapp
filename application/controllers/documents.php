<?php
class Documents extends CI_controller{
    public function __construct() {
        parent::__construct(); // Call the parent constructor
        $this->load->model('document'); // Load the Post_model Document
        $this->load->model('ClientModel'); // Load the  ClientModel
        $this->load->database();
    }
   
    public function testDocuments() {
        $data = $this->document->get_documents(FALSE); // Fetch all documents
    
        // Debugging: Output data to check if it's being retrieved
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
    

    public function index(){
        $data = [
            "title"         => "Liste des documents.",
            'view'          => 'documents/doc',
            'current_page'  => 'documents',
        ];
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);  


     }
     public function mydocuments(){
        $data = [
            "title"         => "Liste des documents.",
            'view'          => 'documents/mydocuments',
            'current_page'  => 'mydocuments',

        ];
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);

     }

     public function addDocument() {
        // Check if form is submitted
        if ($this->input->post()) {
            // Redirect to createDocument if the form is submitted
            return $this->createDocument();
        }
        $source = $this->input->post('source');
        $data['clients'] = $this->ClientModel->get_all_clients(); // Assuming you have a Client model

        // Prepare data to display the form
        $data = [
            'title' => '',
            'view' => 'documents/create',
            'clients'=> $this->ClientModel->get_all_clients(),
            'user_id'=> $this->session->userdata('logged_in'),
            'current_page'  => 'create',

        ];      
        // Load the view to display the form
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);

        }

     
        public function createDocument() { 
            $client_id = $this->input->post('client_id');
            $user_id=$this->session->userdata('user_id');
           
                // Call the create method from Document_model
                if ($this->document->create($client_id,$user_id)) {
                    $this->session->set_flashdata('success', "Le document a été créé avec succès!");
                    redirect('documents');
                } else {
                    redirect('documents');
                }        
        }

public function delete($id){ 
    if(!$this->session->userdata('logged_in')){
        redirect('users/login');
    }
    // Call model to delete document
    $this->document->delete($id);
    redirect('documents');
}

public function edit($id){
    if(!$this->session->userdata('logged_in')){
        redirect('users/login');
    }

    if(empty($data['document'])){
        show_404();
    }
    
    $data = [
        'title' => 'edit des Documents',
        'document' => $this->document->get_documents($id),
        'view' => 'documents/edit',
    ];      
    $this->load->view('templates/sidebar',$data);
}

public function update($id){
    if(!$this->session->userdata('logged_in')){
        redirect('users/login');
    }
    
    // Call model to update document
    $this->document->update($id);
    redirect('documents');
}
    
public function consult_document($id) {
    if (empty($id)) {
        show_404();
    }
    
    $document = $this->document->get_documents($id);
    if (empty($document)) {
        show_404();
    }

    $user = $this->session->userdata('user');

    $logs = $this->db->where('document_id', $id)
                 ->order_by('logged_at', 'DESC')
                 ->get('document_logs')
                 ->result_array();

    $versions = $this->db->where('document_id', $id)
                    ->order_by('updated_at', 'DESC')
                    ->get('document_versions')
                    ->result_array();

    $data = [
        'title' => 'Consulter le document',
        'document' => $document,
        'logs' => $logs,
        'versions' => $versions,
        'view' => 'documents/consult_document',
    ];      
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);    
}


public function fetchDocuments() {
    // Call the model to get documents
    $data = $this->document->get_documents(FALSE); // Pass FALSE to fetch all documents

    // Debugging: Check if data is retrieved
    if (empty($data)) {
        echo json_encode(['data' => [], 'message' => 'No documents found.']);
        return;
    }

    // Format the data
    $formattedData = array_map(function ($row) {
        $actions = '
        <div class="d-flex justify-content-center align-items-center">
            <a class="btn btn-primary btn-sm mr-1" href="'.base_url('documents/edit/'.$row['id']).'" title="Modifier">
                <i class="fas fa-edit"></i>
            </a>
            <a class="btn btn-danger btn-sm" href="'.base_url('documents/delete/'.$row['id']).'" title="Supprimer">
                <i class="fas fa-trash"></i>
            </a>
        </div>';
        $row['actions'] = $actions; // Add actions to the row
        return $row;
    }, $data);

    // Return the formatted data as JSON
    echo json_encode(['data' => $formattedData]);
}

public function fetchDocumentsByUser() {
    
    // Get the logged-in user's ID from the session
    $user_id= $this->session->userdata('user_id');

    //echo $user_id;
    // Fetch only documents created by the logged-in user
    //$this->db->where('user_id', $user_id); 
   // $query = $this->Document_model->get_documents(); 
   // $data  = $query->result_array();
    $data = $this->document->get_documentsByUser($user_id); 

    $formattedData = array_map(function ($row) {
        $actions = '
        <div class="d-flex justify-content-center align-items-center">
            <a href="'.base_url('DocumentController/download/'.$row['file']).'" class="btn btn-success btn-sm ml-2 mr-1">
              <i class="fas fa-download"></i> 
            </a>
            <a class="btn btn-primary btn-sm ml-2 mr-1" href="'.base_url('DocumentController/edit_document/'.$row['id']).'" title="Modifier">
                <i class="fas fa-edit"></i>
            </a>';
             
            $actions .= '
            <a class="btn btn-danger btn-sm ml-2" href="'.base_url('DocumentController/delete_document/'.$row['id']).'" title="Supprimer">
                <i class="fas fa-trash"></i>
            </a>';
        
        $actions .= '</div>';
    
        $row['actions'] = $actions;
    
        return $row;
    }, $data);
    
   // echo json_encode(['data' => $formattedData]);
    echo json_encode(['data' => $formattedData], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

}


public function transfer($document_id) {
    // Fetch the document and ensure it hasn't been transferred yet
    $document = $this->document->get_documents($document_id);

    if ($document['transfer_status'] === 'await_approval') {
        echo "Document already transferred.";
        return;
    }   
    // Update the transfer status to 'transferred'
if ($this->document->updateTransferStatus($document_id, 'await_approval')) {
    echo json_encode(['transfer_status' => true]); // Transfer successful
} else {
    echo json_encode(['transfer_status' => false]); // Transfer failed
}
return;
}

 // Approve Action
 public function approve($document_id) {
    // Update the document status to "approved"
    $this->document->updateTransferStatus($document_id, 'approved');
    // Return success response
    echo json_encode(['status' => 'success']);
}

// Reject Action
public function reject($document_id) {
    // Update the document status back to "not_transferred"
    $this->document->updateTransferStatus($document_id, 'not_transferred');
    // Return success response
    echo json_encode(['status' => 'success']);
}


public function share_file_via_email($id) {

    // Configure email
$config = array(
    'protocol'  => 'smtp',
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'smtp_user' => 'btissa.alami@gmail.com',  
    'smtp_pass' => 'dmjx qpwu djsd vwaq',  // App-specific password cause 2FA is enabled
    'mailtype'  => 'html',
    'charset'   => 'utf-8',
    'wordwrap'  => TRUE,
    'newline'   => "\r\n",  // Ensure newline characters
    'smtp_crypto' => 'tls',  // Use TLS encryption
);

$this->email->initialize($config);

    // Get the file information from the database
    $document = $this->document->get_documents($id);

    // Get the email address of the user to share the file with
    $recipient_email = $this->input->post('recipient_email');

     // Determine the file path
     $filePath = '/assets/files/documents'. '/' . $document['file']; // Assuming your files are stored in 'uploads' folder
 
    // Prepare email
    $this->email->from('btissa.alami@gmail.com', 'FES MARKETING SERVICE');
    $this->email->to($recipient_email);
    $this->email->subject('Fichier partagée avec vous');
    $this->email->message('Bonjour,<br><br>' . $this->session->userdata('first_name') . " ". $this->session->userdata('last_name').'a partage avec vous le document: <br><strong>' . $document['original_name']. '</strong>.<br>vous pouvez le telecharger depuis le lien ci-dessous:<br><a href="' . base_url($filePath) . '">Download File</a><br><br>Cordialement,<br>FMS Team');

    // Send email
    if ($this->email->send()) {
        $this->session->set_flashdata('success', 'Fichier partagée via email avec succès!');
        redirect('documents');

    } else {
        $this->session->set_flashdata('error', $this->email->print_debugger());
        //$error=$this->email->print_debugger();
        //echo $error;
        redirect('documents');
    }     
}

public function preview_document($id)
{
    // Load the document model to retrieve document info
    $document = $this->document->get_documents($id);

    // Check if the document exists
    if (!$document) {
        show_404(); // Show 404 page if the document is not found
    }

    // Determine the file path
    $filePath = 'C:/laragon/www/tutorial2/assets/files/documents'. '/' . $document['file']; // Assuming your files are stored in 'uploads' folder

    // Get the file extension
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);

    // Serve the file for preview
    if (file_exists($filePath)) {
        switch (strtolower($extension)) {
            case 'pdf':
                header('Content-Type: application/pdf');
                break;
            case 'txt':
                header('Content-Type: text/plain');
                break;                   
            case 'jpg':
            case 'jpeg':
                header('Content-Type: image/jpeg');
                break;
            case 'png':
                header('Content-Type: image/png');
                break;
                /*
            case 'doc':
            case 'docx':
                    // Use Google Docs Viewer for Word files
                    $documentUrl = base_url('assets/files/documents/' . $document['file']);
                    $googleDocsViewerUrl = "https://docs.google.com/viewer?url=" . urlencode($documentUrl) . "&embedded=true";
                    
                    // Embed Google Docs Viewer in an iframe
                   // echo "<iframe src='{$googleDocsViewerUrl}' width='100%' height='600px' frameborder='0'></iframe>";
                    break;
                    */
            case 'doc':
                case 'docx':
                    // Force download or open in Microsoft Word
                    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                    header('Content-Disposition: inline; filename="' . $document['file'] . '"');
                    readfile($filePath);
                    break;
            case 'txt':
                header('Content-Type: text/plain');
                exit();                
            default:
                show_error('Preview not supported for this file type');
                return;
        }

        // Output the file inline for the browser to display it
        readfile($filePath);
    } else {
        show_error('File does not exist');
    }
}

public function download($file)
{
$this->load->helper('download');

// Define the file path
$file_path = 'C:/laragon/www/tutorial2/assets/files/documents/' . $file;

// Check if the file exists
if (file_exists($file_path)) {
    // Load the download helper
    $this->load->helper('download');
    
    // Force the file to be downloaded
    force_download($file_path, NULL);
} else {
    // If the file is not found, show a 404 error
    //show_404();
    echo "document not found";
}
}


}
