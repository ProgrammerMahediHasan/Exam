<?php

$uploadMessage = '';
$preview = '';

if (isset($_POST['btn_upload'])) {
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['fileToUpload']['tmp_name'];
        $fileName = $_FILES['fileToUpload']['name'];
        $fileType = $_FILES['fileToUpload']['type'];

        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $destPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $uploadMessage = "File uploaded successfully: $fileName";

            // Generate preview
            if (strpos($fileType, 'image') !== false) {
                // Image preview
                $preview = "<img src='uploads/$fileName' style='max-width:500px;'>";
            } elseif ($fileType === 'application/pdf') {
                // PDF preview
                $preview = "<embed src='uploads/$fileName' type='application/pdf' width='600' height='400'>";
            } else {
                // Other files
                $preview = "<a href='uploads/$fileName' target='_blank'>View File</a>";
            }

        } else {
            $uploadMessage = "Error moving the uploaded file.";
        }
    } else {
        $uploadMessage = "No file uploaded or file upload error.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <h2>Upload a File</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" required><br><br>
        <button type="submit" name="btn_upload">Upload</button>
    </form>

    <?php if ($uploadMessage !== ''): ?>
        <p><?= htmlspecialchars($uploadMessage) ?></p>
    <?php endif; ?>

    <?php if ($preview !== ''): ?>
        <div>
            <?= $preview ?>
        </div>
    <?php endif; ?>
</body>
</html>
