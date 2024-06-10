<?php if (isAdmin()) : ?>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
        $target_dir = __DIR__ . "/../src/uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            $message = "Datei existiert bereits.";
            $uploadOk = 0;
        }

        // Only images
        $allowed_types = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType, $allowed_types)) {
            $message = "Nur JPG, JPEG und PNG Dateien sind erlaubt.";
            $uploadOk = 0;
        }

        define('BASE_URL', '../index.php?page=fileUpload&status=');

        // idk something with error
        if ($uploadOk == 0) {
            header("Location: " . BASE_URL . "error&message=" . urlencode($message));
        } else {
            // Try upload file
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                include "toThumbnail.php";
        
                $message = "Die Datei " . htmlspecialchars(basename($_FILES["file"]["name"])) . " wurde hochgeladen.";
                header("Location: " . BASE_URL . "success&message=" . urlencode($message));
            } else {
                $message = "Beim Uploaden Ihrer Datei ist ein Fehler aufgetreten.";
                header("Location: " . BASE_URL . "error&message=" . urlencode($message));
            }
        }
    } else {
        $message = "Invalid request.";
        header("Location: ../index.php?page=fileUpload&status=error&message=" . urlencode($message));
    }
?>
<?php endif; ?>