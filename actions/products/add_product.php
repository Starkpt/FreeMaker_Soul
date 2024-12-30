<?php

// Check if files were uploaded
if (!empty($_FILES['file']['name'][0])) { // Check if at least one file was uploaded
  $uploadDir = 'uploads/'; // Directory where files will be saved

  // Ensure the directory exists
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
  }

  $uploadedFiles = [];

  // Loop through each file
  foreach ($_FILES['file']['name'] as $key => $fileName) {
    $tmpName = $_FILES['file']['tmp_name'][$key];
    $fileSize = $_FILES['file']['size'][$key];
    $fileType = $_FILES['file']['type'][$key];
    $fileError = $_FILES['file']['error'][$key];

    // Check for upload errors
    if ($fileError !== UPLOAD_ERR_OK) {
      echo json_encode(['error' => "Error uploading file: $fileName"]);
      exit;
    }

    // Move the file to the target directory
    $filePath = $uploadDir . basename($fileName);
    if (move_uploaded_file($tmpName, $filePath)) {
      $uploadedFiles[] = [
        'fileName' => $fileName,
        'filePath' => $filePath,
        'fileSize' => $fileSize,
        'fileType' => $fileType,
      ];
    } else {
      http_response_code(500);
      echo json_encode(['error' => "Failed to upload file: $fileName"]);
      exit;
    }
  }

  // Respond with success
  echo json_encode([
    'message' => 'Files uploaded successfully',
    'files' => $uploadedFiles,
  ]);
} else {
  http_response_code(400);
  echo json_encode(['error' => 'No files uploaded']);
}
