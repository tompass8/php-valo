<?php
session_start();
require __DIR__ . '/db.php';

// --- SÉCURITÉ ---
// On vérifie que l'utilisateur est admin
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: index.php');
    exit();
}

// TRAITEMENT DU FORMULAIRE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On prépare la requête d'insertion
    $stmt = $pdo->prepare("INSERT INTO games (name, type, description, image_url) VALUES (?, ?, ?, ?)");
    $stmt->execute([
            $_POST['name'],
            $_POST['type'],
            $_POST['description'],
            $_POST['image_url']
    ]);

    // Redirection vers le dashboard
    header('Location: admin.php');
    exit();
}

include 'templates/header.php';
?>

    <style>
        :root {
            --val-red: #ff4655;
            --val-dark: #0f1923;
            --val-card: #1f2731;
            --val-text: #ece8e1;
        }

        /* Fond général de la page */
        .add-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 85vh;
            background-color: var(--val-dark);
            color: var(--val-text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        /* La carte du formulaire */
        .form-card {
            background: var(--val-card);
            width: 100%;
            max-width: 600px; /* Un peu plus large pour le textarea */
            padding: 40px;
            border-left: 5px solid var(--val-red);
            border-top: 1px solid #333;
            border-right: 1px solid #333;
            border-bottom: 1px solid #333;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        h1 {
            text-transform: uppercase;
            font-size: 2em;
            margin-top: 0;
            margin-bottom: 30px;
            letter-spacing: 1px;
            font-weight: 800;
        }

        .subtitle {
            color: #888;
            font-size: 0.9em;
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
        }

        /* Styles des champs */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.8em;
            margin-bottom: 8px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px;
            background-color: var(--val-dark); /* Fond noir profond */
            border: 1px solid #444;
            color: white;
            font-family: inherit;
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
        }

        /* Effet Focus rouge */
        input:focus, textarea:focus {
            border-color: var(--val-red);
            background-color: #16202a;
        }

        textarea {
            resize: vertical; /* Permet de redimensionner la hauteur */
            min-height: 100px;
        }

        /* Bouton Créer */
        .btn-submit {
            background-color: var(--val-red);
            color: white;
            border: none;
            padding: 15px 30px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            /* Forme géométrique Valorant */
            clip-path: polygon(0 0, 100% 0, 100% 70%, 95% 100%, 0 100%);
            transition: 0.2s;
            display: block;
            width: 100%;
            margin-top: 20px;
            font-size: 1em;
        }

        .btn-submit:hover {
            background-color: white;
            color: var(--val-red);
            transform: translateY(-2px);
        }

        /* Bouton Annuler */
        .btn-cancel {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #888;
            text-decoration: none;
            font-size: 0.8em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-cancel:hover { color: white; text-decoration: underline; }

    </style>

    <div class="add-container">
        <div class="form-card">
            <span class="subtitle">// PROTOCOLE D'AJOUT</span>
            <h1>NOUVELLE MISSION</h1>

            <form method="POST">

                <div class="form-group">
                    <label>NOM DE CODE (Jeu)</label>
                    <input type="text" name="name" required placeholder="Ex: LEAGUE OF LEGENDS">
                </div>

                <div class="form-group">
                    <label>TYPE DE MISSION</label>
                    <input type="text" name="type" required placeholder="Ex: FPS TACTIQUE, MOBA...">
                </div>

                <div class="form-group">
                    <label>VISUEL TACTIQUE (URL Image)</label>
                    <input type="text" name="image_url" placeholder="https://...">
                </div>

                <div class="form-group">
                    <label>BRIEFING (Description)</label>
                    <textarea name="description" placeholder="Détails de la mission..."></textarea>
                </div>

                <button type="submit" class="btn-submit">INITIALISER LA MISSION</button>

                <a href="admin.php" class="btn-cancel">ANNULER ET RETOURNER AU QG</a>
            </form>
        </div>
    </div>

<?php include 'templates/footer.php'; ?>