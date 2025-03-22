<?php
if (isset($_POST["submit"])) {
    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES["cv"]) && $_FILES["cv"]["error"] == 0) {
        $file = $_FILES["cv"];

        // Vérifier l'extension et la taille du fichier
        $allowedExtensions = ["pdf"];
        $maxSize = 2 * 1024 * 1024; // 2 Mo

        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExt, $allowedExtensions)) {
            echo "Seuls les fichiers PDF sont autorisés.";
            exit;
        }

        if ($fileSize > $maxSize) {
            echo "Le fichier est trop volumineux (max 2 Mo).";
            exit;
        }

        // Définir le dossier de destination
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Nom de fichier unique
        $newFileName = uniqid("cv_", true) . "." . $fileExt;
        $uploadPath = $uploadDir . $newFileName;

        // Déplacer le fichier téléchargé
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            echo "CV téléchargé avec succès.";
            // Ici, vous pouvez enregistrer le chemin du fichier dans une base de données
        } else {
            echo "Erreur lors du téléchargement.";
        }
    } else {
        echo "Aucun fichier téléchargé ou erreur.";
    }
}
?>