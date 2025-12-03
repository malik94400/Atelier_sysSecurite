<?php
// Page pour les recruteurs

// Dossier des uploads de CV
$uploadDirectory = __DIR__ . '/../uploads/';

if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // on n'autorise que les noms de fichier de la forme cv_nom_prenom_uniqid.pdf
    if (!preg_match('/^cv_[a-zA-Z]+_[a-zA-Z]+_[0-9a-f]{16}\.pdf$/', $file)) {
        http_response_code(400);
        echo "Nom de fichier invalide.";
        exit;
    }

    $filePath = $uploadDirectory . $file;

    if (!is_file($filePath)) {
        http_response_code(404);
        echo "Fichier introuvable.";
        exit;
    }

    // Envoi du fichier au navigateur
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $file . '"');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
}

$files = glob($uploadDirectory . 'cv_*.pdf');
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des CV candidats</title>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page">
    <div class="page-header">
        <h1>Liste des CV des candidats</h1>
        <p class="page-subtitle">Espace recruteur – téléchargez les CV reçus.</p>
    </div>

    <?php if (empty($files)): ?>
        <p>Aucun CV n'a encore été uploadé.</p>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Télécharger</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($files as $path): ?>
                <?php
                $basename = basename($path);
                // On découpe le nom : cv_nom_prenom_uniqid.pdf
                $parts = explode('_', $basename);
                $lastname = isset($parts[1]) ? $parts[1] : '';
                $firstname = isset($parts[2]) ? $parts[2] : '';
                ?>
                <tr>
                    <td><?= htmlspecialchars($lastname, ENT_QUOTES); ?></td>
                    <td><?= htmlspecialchars($firstname, ENT_QUOTES); ?></td>
                    <td>
                        <a href="recruteurs.php?file=<?= urlencode($basename); ?>">
                            Télécharger le CV
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p style="margin-top: 16px; font-size: 0.85rem;">
        <a href="index.php">← Retour à l'espace candidat</a>
    </p>
</div>
</body>
</html>