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
    private function getAuthorizationToken()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $matches = [];
            preg_match('/Bearer (.+)/', $headers['Authorization'], $matches);

            if (isset($matches[1])) {
                $token = $matches[1];
                return $token;
            }
            return null;
        }
    }

    private function validateToken()
    {
        $token = $this->getAuthorizationToken();
        if (!empty($token)) {
            return true;
        } else {
            return false;
        }
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $token = $this->getAuthorizationToken();

        if ($token) {
            $userId = $this->validateToken();
        } else {
            echo json_encode(["success" => false, "message" => "Invalid operation .Auth token Missing!"]);
            return;
        }
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
        // Validate token
        $userId = $this->validateToken();
        if ($userId === null) {
            echo json_encode(["success" => false, "message" => "Invalid token"]);
            return;
        }


        if (isset($_POST['verify_nida'])) {
            $userData = $this->ninLookup->loadUser("19620222416010", true);
            echo json_encode(['success' => true, 'message' => 'Request Successfull', 'data' => $userData]);
        }else{
            echo json_encode(['success' => false, 'message' => 'Unkown Request']);

        }
    }

    private function handleGETRequest()
    {
        $userId = $this->validateToken();
        if ($userId === null) {
            echo json_encode(["success" => false, "message" => "Invalid token"]);
            return;
        }
        // ... other GET requests
    }
}


$nidaController = new NIDAController();
$nidaController->handleRequest();
