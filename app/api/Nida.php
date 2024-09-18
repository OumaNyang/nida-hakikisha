<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
class Nida {
    private $BASE_URL = "https://ors.brela.go.tz/um/load/load_nida/%s";

    public function getHeaders() {
        return [
            "Content-Type: application/json",
            "Content-Length: 0",
            "Connection: keep-alive",
            "Accept-Encoding: gzip, deflate, br"
        ];
    }

    public function bytesToImg($imageStr) {
        try {
            $decodedImg = base64_decode($imageStr);
            $image = imagecreatefromstring($decodedImg);
            if ($image === false) {
                throw new Exception("Failed to decode image");
            }
            return $image;
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function pythonizeImages($userData) {
        if (isset($userData["PHOTO"])) {
            $userData["PHOTO"] = $this->bytesToImg($userData["PHOTO"]);
        }
        if (isset($userData["SIGNATURE"])) {
            $userData["SIGNATURE"] = $this->bytesToImg($userData["SIGNATURE"]);
        }
        return $userData;
    }

    public function capitalizeKeys($userData) {
        $newUserData = [];
        foreach ($userData as $key => $value) {
            $capitalizedKey = ucfirst($key);
            $newUserData[$capitalizedKey] = $value;
        }
        return $newUserData;
    }

    public function preprocessUserData($userData) {
        if (isset($userData["PHOTO"]) && isset($userData["SIGNATURE"])) {
            $userData = $this->pythonizeImages($userData);
        }
        $userData = $this->capitalizeKeys($userData);
        return (object) $userData;  // Convert to stdClass object
    }

    public function loadUser($nationalId, $json = false) {
        try {
            $userData = $this->loadUserInformation($nationalId);
            if (!$json) {
                $userData = $this->preprocessUserData($userData);
                return  json_encode(["success"=>false,"message"=>" Request not  successfull","data"=>$userData]);
            }else{
                return  json_encode(["success"=>true,"message"=>"Lookup Request Successfull","data"=>$userData]);

            }
        } catch (Exception $e) {

            return json_encode(["success"=>false,"Message"=>"Fetch error Occured. ". $e->getMessage(),"data"=>[]]);

        }
    }

    private function loadUserInformation($nationalId) {
        try {
            $url = sprintf($this->BASE_URL, $nationalId);
            $options = [
                "http" => [
                    "method" => "POST",
                    "header" => implode("\r\n", $this->getHeaders()),
                ]
            ];
            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);

            // Check if the content is encoded in deflate
            foreach ($http_response_header as $header) {
                if (stripos($header, 'Content-Encoding: deflate') !== false) {
                    $response = gzinflate($response); // Decompress the response
                    break;
                }
            }

            // Debugging: Output response headers and raw response content
            // echo "Response Headers:\n";
            // foreach ($http_response_header as $header) {
            //     echo $header . "\n";
            // }
            
            // echo "Raw Response: " . $response . "\n"; // Show raw response
            
            // Decode the JSON response
            $userInformation = json_decode($response, true);
            if (isset($userInformation["obj"]["result"])) {
                return $userInformation["obj"]["result"];
            }
            if (isset($userInformation["obj"]["error"])) {
                return null;
            }
        } catch (Exception $e) {
            throw new Exception("Can't load user information, possibly due to connection issues: " . $e->getMessage());
        }
    }
}
// 19820801 12102 00005 11
// 19620222416010
// 19841121332060000128
// $nida = new Nida();
// $userData = $nida->loadUser("19820801121020000510", true);  // Replace with a valid national ID
// echo ($userData); 
?>

