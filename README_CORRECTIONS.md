# 🎯 PROJET VALORANT PHP - GUIDE DE CORRECTION

## 📁 Structure du Projet

```
php-valo/
├── config/
│   ├── db.php                  ← Connexion PDO (accessible via ../config/db.php)
│   └── fix_database.sql        ← Script SQL de correction
│
├── public/                     ← Point d'entrée du site (URL: /public/)
│   ├── index.php              
│   ├── login.php
│   ├── register.php
│   ├── profil.php
│   ├── admin.php
│   ├── admin_game_add.php
│   ├── admin_game_edit.php
│   ├── admin_game_delete.php
│   ├── edit_user.php
│   └── logout.php
│
├── templates/                  ← Réutilisables (accessible via ../templates/)
│   ├── header.php
│   └── footer.php
│
└── assets/                     ← Ressources statiques (accessible via ../assets/)
    ├── css/
    │   ├── style.css          ← Style principal Valorant
    │   ├── admin.css
    │   └── profil.css
    └── img/
        └── games/             ← Images des jeux

```

---

## ✅ Corrections Appliquées

### 1. **Chemins PHP corrigés** (depuis `/public/`)

Tous les fichiers dans `public/` utilisent maintenant des chemins relatifs avec `../` :

```php
// ✅ CORRECT (depuis public/)
require '../config/db.php';
include '../templates/header.php';
include '../templates/footer.php';

// ❌ INCORRECT (ancien chemin)
require 'config/db.php';
include 'templates/header.php';
```

---

### 2. **Chemins CSS et Images corrigés** (dans `templates/header.php`)

```html
<!-- ✅ CORRECT -->
<link rel="stylesheet" href="../assets/css/style.css">

<!-- Dans le code PHP (index.php) -->
<img src="../assets/img/games/<?= $game['image'] ?>">
```

---

### 3. **Base de données - Correction de la colonne `image`**

**Problème :** Erreur SQL `Unknown column 'image'`

**Solution :** Exécuter le script SQL suivant dans phpMyAdmin :

```sql
USE projet_valorant;

ALTER TABLE games 
CHANGE COLUMN image_url image VARCHAR(255);
```

📌 **Fichier disponible :** `config/fix_database.sql`

---

## 🚀 Comment Exécuter le Projet

### Étape 1 : Corriger la base de données

1. Ouvrir **phpMyAdmin** : http://localhost/phpmyadmin
2. Sélectionner la base `projet_valorant`
3. Aller dans l'onglet **SQL**
4. Copier le contenu de `config/fix_database.sql` et l'exécuter

### Étape 2 : Configurer l'URL

**Important :** L'URL d'accès doit maintenant pointer vers `/public/`

- ✅ **URL correcte :** `http://localhost/php-valo/public/index.php`
- ❌ **Ancienne URL :** `http://localhost/php-valo/index.php`

### Étape 3 : Vérifier XAMPP

- Apache : ✅ Démarré
- MySQL : ✅ Démarré (Port 3307)

---

## 🎨 Style Valorant (Noir/Rouge/Gris)

Le thème utilise les couleurs officielles :

```css
:root {
    --val-red: #ff4655;      /* Rouge Valorant */
    --val-dark: #0f1923;     /* Fond noir profond */
    --val-card: #1f2731;     /* Cartes grises */
    --val-text: #ece8e1;     /* Texte beige clair */
}
```

---

## 📝 Fichiers Modifiés

| Fichier | Correction |
|---------|-----------|
| `public/index.php` | Chemins images : `../assets/img/` |
| `public/index.php` | Inclusion footer : `../templates/footer.php` |
| `templates/header.php` | Chemins CSS : `../assets/css/` |
| `config/db.php` | Nettoyage et commentaires professionnels |
| `config/fix_database.sql` | ✨ **NOUVEAU** - Script de correction SQL |

---

## 🔧 Dépannage

### Problème : Les CSS ne se chargent pas

**Vérification :** Ouvrir la console du navigateur (F12) et vérifier les erreurs 404

**Solution :** Assurer que l'URL pointe vers `/public/` et que les chemins utilisent `../assets/`

### Problème : Erreur "Unknown column 'image'"

**Solution :** Exécuter le script SQL `fix_database.sql`

### Problème : Images ne s'affichent pas

**Vérification :**
1. Les images sont bien dans `assets/img/games/`
2. Le chemin utilise `../assets/img/games/` depuis `public/`
3. Le nom du fichier correspond exactement à celui en base de données

---

## 📌 Notes Importantes

- ✅ PHP 7.0+ requis (pour l'opérateur `??`)
- ✅ PDO avec mode FETCH_ASSOC activé
- ✅ Sessions démarrées sur toutes les pages
- ✅ Protection XSS avec `htmlspecialchars()`
- ✅ Mots de passe hashés avec `password_hash()`

---

## 🎯 Checklist Finale

- [x] Chemins PHP corrigés (../)
- [x] Chemins CSS corrigés (../)
- [x] Chemins images corrigés (../)
- [x] Script SQL créé
- [x] db.php amélioré
- [x] Style Valorant appliqué
- [ ] **À FAIRE : Exécuter fix_database.sql**
- [ ] **À FAIRE : Tester depuis /public/**

---

**Créé le :** 4 mars 2026  
**Projet :** PHP Valorant - Structure Professionnelle

