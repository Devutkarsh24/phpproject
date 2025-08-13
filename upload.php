<?php
header('Content-Type: application/json');

require 'vendor/autoload.php';

use ImageKit\ImageKit;

// ImageKit credentials
$publicKey = "public_m8/sKYc03YRGbxqCGnHobvCzngU=";
$privateKey = "private_w8zLQbqynBFc5iEpIiam9xARk2c=";
$urlEndpoint = "https://ik.imagekit.io/xdx98xrdc";

$imageKit = new ImageKit($publicKey, $privateKey, $urlEndpoint);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);

        // Upload to ImageKit
        $uploadFile = $imageKit->upload([
            "file" => fopen($fileTmpPath, "r"),
            "fileName" => $fileName
        ]);

        if (isset($uploadFile->result->url)) {
            echo json_encode([
                "status" => "success",
                "message" => "Image uploaded successfully!",
                "url" => $uploadFile->result->url
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "ImageKit upload failed: " . $uploadFile->error->message
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No file selected or file error."
        ]);
    }
    exit;
}
