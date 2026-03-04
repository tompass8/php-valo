-- ========================================
-- SCRIPT DE CORRECTION DE LA BASE DE DONNÉES
-- Projet Valorant PHP
-- ========================================

-- Utiliser la bonne base de données
USE projet_valorant;

-- Vérifier la structure actuelle de la table games
-- (Pour information uniquement, à exécuter manuellement si besoin)
-- DESCRIBE games;

-- Renommer la colonne image_url en image
-- Cette commande corrige l'erreur "Unknown column 'image'"
ALTER TABLE games
CHANGE COLUMN image_url image VARCHAR(255);

-- Vérification finale
SELECT 'Correction terminée : la colonne image_url a été renommée en image' AS status;

