<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test CSS</title>
    <style>
        body {
            background: #0f1923;
            color: white;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .test {
            background: #1f2731;
            border: 2px solid #ff4655;
            padding: 20px;
            margin: 20px 0;
        }
        h1 { color: #ff4655; }
    </style>
</head>
<body>
    <h1>🔍 Test de Diagnostic CSS</h1>

    <div class="test">
        <h2>Informations sur les chemins</h2>
        <p><strong>URL actuelle :</strong> <?= $_SERVER['REQUEST_URI'] ?></p>
        <p><strong>Script actuel :</strong> <?= $_SERVER['SCRIPT_NAME'] ?></p>
        <p><strong>Dossier du script :</strong> <?= dirname($_SERVER['SCRIPT_NAME']) ?></p>
    </div>

    <div class="test">
        <h2>Test de chargement CSS</h2>
        <p>Si cette page a du style (fond noir, bordure rouge), c'est que le CSS se charge.</p>
        <p><strong>Chemin style.css depuis admin.php :</strong> ../assets/css/style.css</p>
        <p><strong>URL absolue devrait être :</strong> http://localhost/php-valo/assets/css/style.css</p>
    </div>

    <div class="test">
        <h2>Test des liens CSS</h2>
        <link rel="stylesheet" href="../assets/css/style.css">
        <p>Lien CSS chargé : <code>&lt;link rel="stylesheet" href="../assets/css/style.css"&gt;</code></p>
        <p>Ouvrez F12 → Onglet Réseau pour voir si le fichier est en 404</p>
    </div>

    <div class="test">
        <h2>Solution</h2>
        <p>Si vous accédez via <code>http://localhost/admin.php</code> au lieu de <code>http://localhost/php-valo/public/admin.php</code>,</p>
        <p>les chemins relatifs <code>../</code> ne fonctionneront pas car ils cherchent au mauvais endroit.</p>
        <p><strong>✅ URL correcte :</strong> <a href="http://localhost/php-valo/public/admin.php" style="color: #ff4655;">http://localhost/php-valo/public/admin.php</a></p>
    </div>
</body>
</html>

