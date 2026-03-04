# 🚀 DÉMARRAGE RAPIDE - PROJET VALORANT PHP

## ⚡ EN 3 ÉTAPES

### ÉTAPE 1️⃣ : Corriger la Base de Données (2 minutes)

1. Ouvrir **phpMyAdmin** : http://localhost/phpmyadmin
2. Sélectionner **projet_valorant**
3. Onglet **SQL**
4. Copier-coller :

```sql
ALTER TABLE games 
CHANGE COLUMN image_url image VARCHAR(255);
```

5. Cliquer sur **Exécuter**

### ÉTAPE 2️⃣ : Démarrer XAMPP

1. Ouvrir le Panneau de Contrôle XAMPP
2. Démarrer **Apache**
3. Démarrer **MySQL**

### ÉTAPE 3️⃣ : Tester le Site

Ouvrir dans le navigateur :
```
http://localhost/php-valo/public/index.php
```

---

## ✅ C'EST FAIT !

Votre site devrait maintenant fonctionner avec :
- ✅ Style Valorant (Noir/Rouge/Gris)
- ✅ Menu de navigation fonctionnel
- ✅ Animations et effets
- ✅ Tous les chemins corrigés

---

## 📚 Documentation

Pour plus de détails, consultez :
- **LISEZ-MOI.txt** - Synthèse 30 secondes
- **GUIDE_TEST.txt** - Guide complet
- **CORRECTIONS_APPLIQUEES.md** - Liste des corrections

---

## 🆘 Problème ?

### Le site ne s'affiche pas ?
→ Vérifier qu'Apache et MySQL sont démarrés

### Erreur "Unknown column 'image'" ?
→ Exécuter le script SQL de l'étape 1

### Le CSS ne se charge pas ?
→ F12 → Onglet Réseau → Vérifier les erreurs 404

---

**C'est tout ! Bon codage ! 🎯**

