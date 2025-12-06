# Guide de Déploiement - Club Sportif

## 📋 Sommaire

1. [Prérequis](#prérequis)
2. [Checklist de Déploiement](#checklist-de-déploiement)
3. [Déploiement sur Serveur](#déploiement-sur-serveur)
4. [Configuration de Sécurité](#configuration-de-sécurité)
5. [Sauvegarde et Restauration](#sauvegarde-et-restauration)
6. [Maintenance](#maintenance)
7. [Troubleshooting](#troubleshooting)

---

## 🔍 Prérequis

### Serveur Web
- Apache 2.4+ avec mod_rewrite activé
- Ou Nginx 1.10+

### PHP
- PHP 7.4+
- Extensions requises:
  - PDO
  - pdo_mysql
  - json
  - zlib (recommandé)
  - openssl (recommandé)

### Base de Données
- MySQL 5.7+
- Ou MariaDB 10.2+
- Accès en lecture/écriture

### Certificats
- HTTPS obligatoire en production
- Certificat SSL/TLS valide

---

## ✅ Checklist de Déploiement

### Avant le Déploiement

- [ ] Backup complet du système local
- [ ] Test de tous les formulaires
- [ ] Vérification des liens
- [ ] Optimisation des images
- [ ] Minification CSS/JS
- [ ] Vérification de la sécurité
- [ ] Documentation à jour
- [ ] Tests de performance

### Configuration

- [ ] Modifier `config/database.php` avec infos prod
- [ ] Changer le mot de passe admin dans `login.php`
- [ ] Configurer `config/club.php` avec les infos du club
- [ ] Activer HTTPS dans `config/constants.php`
- [ ] Configurer les logs

### Sécurité

- [ ] Désactiver `install.php` ou le supprimer
- [ ] Désactiver `check.php` ou restreindre l'accès
- [ ] Configurer `.htaccess` pour la sécurité
- [ ] Permissions des fichiers (644 pour fichiers, 755 pour dossiers)
- [ ] Supprimer les fichiers de test

### Performance

- [ ] Configurer le cache HTTP
- [ ] Activer la compression Gzip
- [ ] Optimiser les images
- [ ] Vérifier les indexes DB
- [ ] Configurer les logs

### Backup

- [ ] Configurer sauvegarde automatique
- [ ] Tester la restauration
- [ ] Stocker les backups hors serveur
- [ ] Vérifier la fréquence de backup

---

## 🚀 Déploiement sur Serveur

### Étape 1: Préparer l'Environnement

```bash
# Créer le répertoire
mkdir /var/www/club-sportif
cd /var/www/club-sportif

# Définir les permissions
chmod 755 /var/www/club-sportif
chmod 755 /var/www/club-sportif/*
chmod 644 /var/www/club-sportif/*.php
```

### Étape 2: Copier les Fichiers

#### Via FTP/SFTP
```
1. Connecter au serveur
2. Naviguer vers /var/www/html
3. Créer dossier club-sportif
4. Uploader les fichiers
```

#### Via Git
```bash
cd /var/www/club-sportif
git clone <repo-url> .
git checkout v1.0.0
```

#### Via SCP
```bash
scp -r club-sportif/ user@serveur:/var/www/html/
```

### Étape 3: Configurer la Base de Données

```bash
# Se connecter à MySQL
mysql -u root -p

# Créer la base
CREATE DATABASE club_sportif CHARACTER SET utf8mb4;
CREATE USER 'club_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON club_sportif.* TO 'club_user'@'localhost';
FLUSH PRIVILEGES;

# Importer le schéma
USE club_sportif;
SOURCE /path/to/database/club_sportif.sql;
```

### Étape 4: Configuration

```bash
# Éditer config/database.php
nano config/database.php
```

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'club_user');
define('DB_PASS', 'strong_password');
define('DB_NAME', 'club_sportif');
```

### Étape 5: Vérification

1. Accéder à: `https://votre-domaine.com/club-sportif/check.php`
2. Vérifier tous les statuts
3. Corriger les problèmes

### Étape 6: Installation

1. Accéder à: `https://votre-domaine.com/club-sportif/install.php`
2. Suivre les étapes
3. Ou exécuter manuellement si nécessaire

---

## 🔒 Configuration de Sécurité

### 1. HTTPS/SSL

```apache
# .htaccess
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 2. Permissions des Fichiers

```bash
# Fichiers
find /var/www/club-sportif -type f -exec chmod 644 {} \;

# Dossiers
find /var/www/club-sportif -type d -exec chmod 755 {} \;

# Dossier spécial (uploads)
chmod 775 /var/www/club-sportif/uploads
chmod 775 /var/www/club-sportif/cache
```

### 3. Propriété des Fichiers

```bash
# Si utilisant www-data
chown -R www-data:www-data /var/www/club-sportif
```

### 4. Configuration PHP

```php
// php.ini
upload_max_filesize = 5M
post_max_size = 5M
max_execution_time = 300
memory_limit = 128M
display_errors = Off
log_errors = On
error_log = /var/log/php-errors.log
```

### 5. Configuration Apache

```apache
# Désactiver listing répertoires
<Directory /var/www/club-sportif>
    Options -Indexes
    AllowOverride All
    Require all granted
</Directory>
```

### 6. Supprimer les Fichiers de Dev

```bash
rm /var/www/club-sportif/install.php
rm /var/www/club-sportif/check.php
# Ou restreindre l'accès via .htaccess
```

### 7. Sécuriser Database

```sql
-- Créer utilisateur limité
CREATE USER 'club_read'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT ON club_sportif.* TO 'club_read'@'localhost';

-- Supprimer utilisateur test
DROP USER 'test'@'localhost';
```

---

## 💾 Sauvegarde et Restauration

### Sauvegarde Automatique

```bash
#!/bin/bash
# backup.sh
BACKUP_DIR="/home/backups"
DB_NAME="club_sportif"
DB_USER="club_user"
DB_PASS="password"
DATE=$(date +%Y%m%d_%H%M%S)

# Sauvegarder BD
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/backup_$DATE.sql

# Compresser
gzip $BACKUP_DIR/backup_$DATE.sql

# Garder 7 jours
find $BACKUP_DIR -name "backup_*.sql.gz" -mtime +7 -delete

echo "Backup complété: $BACKUP_DIR/backup_$DATE.sql.gz"
```

### Ajouter Cron Job

```bash
# Tous les jours à 2h du matin
0 2 * * * /path/to/backup.sh

# Editer crontab
crontab -e
```

### Restaurer une Sauvegarde

```bash
# Décompresser
gunzip backup_20240101_020000.sql.gz

# Restaurer
mysql -u club_user -p club_sportif < backup_20240101_020000.sql
```

---

## 🔧 Maintenance

### Monitoring

```bash
# Vérifier les logs
tail -f /var/log/apache2/error.log
tail -f /var/log/php-errors.log

# Vérifier l'espace disque
df -h

# Vérifier l'utilisation mémoire
free -h

# Vérifier les processus
top
```

### Mises à Jour

```bash
# Sauvegarder avant mise à jour
mysqldump -u club_user -p club_sportif > backup_before_update.sql

# Télécharger la nouvelle version
wget https://github.com/club-sportif/repo/archive/v1.1.0.zip
unzip v1.1.0.zip

# Copier les fichiers (sauf config)
cp -r club-sportif-1.1.0/* /var/www/club-sportif/
# Ne pas écraser config/database.php

# Mettre à jour la BD si nécessaire
mysql -u club_user -p club_sportif < database/migrations/v1.1.0.sql
```

### Nettoyage

```bash
# Nettoyer les sessions anciennes
find /tmp -name "sess_*" -mtime +7 -delete

# Nettoyer les logs
logrotate -f /etc/logrotate.d/apache2
```

---

## 🆘 Troubleshooting

### Erreur: "Connection refused"

```bash
# Vérifier que MySQL fonctionne
systemctl status mysql

# Redémarrer MySQL
systemctl restart mysql

# Vérifier les identifiants
mysql -u club_user -p club_sportif -e "SELECT 1;"
```

### Erreur: "Permission denied"

```bash
# Vérifier les permissions
ls -la /var/www/club-sportif/

# Corriger
chmod 755 /var/www/club-sportif
chmod 644 /var/www/club-sportif/*.php
```

### Erreur: "404 Not Found"

```bash
# Vérifier que mod_rewrite est activé
apache2ctl -M | grep rewrite

# L'activer si nécessaire
a2enmod rewrite
systemctl restart apache2
```

### Performance Lente

```bash
# Vérifier les indexes
ANALYZE TABLE membre;
ANALYZE TABLE entrainement;
ANALYZE TABLE paiement;

# Voir les requêtes lentes
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;
```

---

## 📊 Monitoring

### Setup Monitoring

```bash
# Installer Monit (optionnel)
apt-get install monit

# Configurer alertes
echo "alert admin@clubsportif.com" >> /etc/monit/monitrc
```

### Logs

```
Access Log: /var/log/apache2/access.log
Error Log: /var/log/apache2/error.log
PHP Log: /var/log/php-errors.log
```

---

## ✨ Optimisations

### Caching

```php
// Ajouter aux contrôleurs
header('Cache-Control: public, max-age=3600');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
```

### Compression

```apache
# .htaccess
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/javascript
</IfModule>
```

---

## 📞 Support en Cas de Problème

1. Vérifier les logs
2. Exécuter `check.php`
3. Consulter la documentation
4. Contacter le support

**Email**: admin@clubsportif.com  
**Téléphone**: 01 23 45 67 89

---

**Dernier mise à jour**: 2024-01-XX  
**Version**: 1.0.0  
**Statut**: Production Ready ✓

© 2024 Club Sportif - Tous droits réservés
