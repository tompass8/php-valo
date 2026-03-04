@echo off
chcp 65001 >nul
echo.
echo ═══════════════════════════════════════════════════════════════
echo   🎯 VÉRIFICATION AUTOMATIQUE - PROJET VALORANT PHP
echo ═══════════════════════════════════════════════════════════════
echo.

set "ERRORS=0"

echo [1/6] Vérification de la structure du projet...
if exist "config\db.php" (
    echo   ✓ config\db.php trouvé
) else (
    echo   ✗ config\db.php MANQUANT
    set /a ERRORS+=1
)

if exist "public\index.php" (
    echo   ✓ public\index.php trouvé
) else (
    echo   ✗ public\index.php MANQUANT
    set /a ERRORS+=1
)

if exist "templates\header.php" (
    echo   ✓ templates\header.php trouvé
) else (
    echo   ✗ templates\header.php MANQUANT
    set /a ERRORS+=1
)

if exist "assets\css\style.css" (
    echo   ✓ assets\css\style.css trouvé
) else (
    echo   ✗ assets\css\style.css MANQUANT
    set /a ERRORS+=1
)

echo.
echo [2/6] Vérification des fichiers de correction...

if exist "config\fix_database.sql" (
    echo   ✓ Script SQL créé : config\fix_database.sql
) else (
    echo   ✗ Script SQL MANQUANT
    set /a ERRORS+=1
)

if exist ".htaccess" (
    echo   ✓ Fichier .htaccess créé
) else (
    echo   ⚠ .htaccess manquant (optionnel)
)

echo.
echo [3/6] Vérification des documentations...

if exist "README_CORRECTIONS.md" (
    echo   ✓ README_CORRECTIONS.md
) else (
    echo   ⚠ Documentation manquante
)

if exist "GUIDE_TEST.txt" (
    echo   ✓ GUIDE_TEST.txt
) else (
    echo   ⚠ Guide de test manquant
)

echo.
echo [4/6] Vérification des chemins dans index.php...

findstr /C:"require '../config/db.php'" public\index.php >nul 2>&1
if %errorlevel% equ 0 (
    echo   ✓ Chemin db.php corrigé
) else (
    echo   ✗ Chemin db.php INCORRECT
    set /a ERRORS+=1
)

findstr /C:"include '../templates/header.php'" public\index.php >nul 2>&1
if %errorlevel% equ 0 (
    echo   ✓ Chemin header.php corrigé
) else (
    echo   ✗ Chemin header.php INCORRECT
    set /a ERRORS+=1
)

findstr /C:"include '../templates/footer.php'" public\index.php >nul 2>&1
if %errorlevel% equ 0 (
    echo   ✓ Chemin footer.php corrigé
) else (
    echo   ✗ Chemin footer.php INCORRECT
    set /a ERRORS+=1
)

findstr /C:"../assets/img/games/" public\index.php >nul 2>&1
if %errorlevel% equ 0 (
    echo   ✓ Chemin images corrigé
) else (
    echo   ✗ Chemin images INCORRECT
    set /a ERRORS+=1
)

echo.
echo [5/6] Vérification des chemins dans header.php...

findstr /C:"../assets/css/style.css" templates\header.php >nul 2>&1
if %errorlevel% equ 0 (
    echo   ✓ Chemin CSS corrigé
) else (
    echo   ✗ Chemin CSS INCORRECT
    set /a ERRORS+=1
)

echo.
echo [6/6] Vérification du dossier images...

if exist "assets\img\games" (
    echo   ✓ Dossier assets\img\games existe
) else (
    echo   ⚠ Dossier images absent (créer si nécessaire)
)

echo.
echo ═══════════════════════════════════════════════════════════════

if %ERRORS% equ 0 (
    echo.
    echo   ✅ SUCCÈS : Toutes les corrections sont appliquées !
    echo.
    echo   📋 PROCHAINES ÉTAPES :
    echo.
    echo   1. Exécuter le script SQL dans phpMyAdmin
    echo      Fichier : config\fix_database.sql
    echo.
    echo   2. Démarrer Apache et MySQL dans XAMPP
    echo.
    echo   3. Accéder au site :
    echo      http://localhost/php-valo/public/index.php
    echo.
) else (
    echo.
    echo   ❌ ERREUR : %ERRORS% problème(s) détecté(s)
    echo.
    echo   Vérifier les fichiers marqués avec ✗
    echo.
)

echo ═══════════════════════════════════════════════════════════════
echo.
pause

