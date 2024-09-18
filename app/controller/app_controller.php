<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once(__DIR__ . '/../api/Nida.php');

class NIDAController
{
    private $ninLookup;

    public function __construct()
    {
        $this->ninLookup = new Nida();
    }

    // Get Authorization Token from headers
    private function getAuthorizationToken()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
                return $matches[1]; // Return token
            }
        }
        return null; // Return null if token not found
    }

    // Validate token (This should involve more than just presence check in real scenarios)
    private function validateToken()
    {
        $token = $this->getAuthorizationToken();
        // Token validation logic should go here (e.g., decoding JWT)
        return !empty($token); // For now, return true if token exists
    }

    // Main request handler
    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if (!$this->validateToken()) {
            echo json_encode(["success" => false, "message" => "Invalid operation. Auth token missing!"]);
            return;
        }

        // Switch between different request methods
        switch ($method) {
            case 'POST':
                $this->handlePostRequest();
                break;
            case 'GET':
                $this->handleGetRequest();
                break;
            default:
                echo json_encode(["success" => false, "message" => "Invalid request method"]);
        }
    }

    private function handlePostRequest()
    {
        if (isset($_POST['verify_nida_nin'])) {
            // Trim whitespace and remove spaces from the NIDA number
            $nidaNIN = str_replace(' ', '', trim($_POST['verify_nida_nin']));
    
            // Validate NIDA number (should be exactly 20 characters and numeric)
            if (!empty($nidaNIN) && strlen($nidaNIN) === 20 && is_numeric($nidaNIN)) {
                $userData = $this->ninLookup->loadUser($nidaNIN, true); // Load user data based on NIDA
                echo  $userData ;
            } else {
                echo json_encode(['success' => false, 'message' => 'Please enter a valid NIDA number']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Unknown request']);
        }
    }
    

   private function handleGetRequest()
    {
        if (!$this->validateToken()) {
            echo json_encode(["success" => false, "message" => "Invalid token"]);
            return;
        }
        // Other GET request handling logic can go here
        echo json_encode(['success' => true, 'message' => 'GET request handled']);
    }
}

// Instantiate and handle the request
$nidaController = new NIDAController();
$nidaController->handleRequest();
