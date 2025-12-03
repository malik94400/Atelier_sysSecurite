<?php
session_start();

// Upload du fichier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../src/Upload.php';
    $upload = new Upload();

    if ($upload->upload()) {
        $message = 'Votre CV a bien été uploadé.';
    } else {
        $message = $_SESSION['message'] ?? 'Une erreur est survenue.';
    }
}

unset($_SESSION['message']);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Upload de CV</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page">
    <div class="page-header">
        <h1>Upload de CV</h1>
        <p class="page-subtitle">Espace candidat – envoyez votre CV en PDF.</p>
    </div>

    <h3>Candidat</h3>
    <p>Merci d'uploader votre CV par ce formulaire.</p>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="lastname">Votre nom</label>
        <input type="text" name="lastname" id="lastname" required>

        <label for="firstname">Votre prénom</label>
        <input type="text" name="firstname" id="firstname" required>

        <label for="cv">Votre CV</label>
        <input type="file" name="cv" id="cv" accept="application/pdf" required>

        <input type="submit" value="Envoyer">
    </form>

    <?php if (!empty($message)): ?>
        <?php
        $isSuccess = str_contains($message, 'bien été uploadé');
        $messageClass = $isSuccess ? 'message message-success' : 'message message-error';
        ?>
        <div class="<?= $messageClass ?>">
            <?= htmlspecialchars($message, ENT_QUOTES); ?>
        </div>
    <?php endif; ?>

    <p style="margin-top: 16px; font-size: 0.85rem;">
        <a href="recruteurs.php">→ Accéder à l'espace recruteur</a>
    </p>
</div>
</body>
</html>