<?php
/**
 * Configuration de l'application Club Sportif
 */

// Informations du site
define('APP_NAME', 'Club Sportif');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/club-sportif');

// Répertoires
define('APP_PATH', __DIR__);
define('VIEWS_PATH', APP_PATH . '/views');
define('MODELS_PATH', APP_PATH . '/models');
define('CONTROLLERS_PATH', APP_PATH . '/controllers');
define('CONFIG_PATH', APP_PATH . '/config');

// Pagination
define('ITEMS_PER_PAGE', 15);

// Statuts possibles
define('PAIEMENT_STATUTS', ['en attente', 'confirmé', 'annulé']);
define('METHODES_PAIEMENT', ['Espèces', 'Chèque', 'Carte bancaire', 'Virement']);
define('TYPES_ENTRAINEMENT', ['Collectif', 'Individuel', 'Groupe']);
define('NIVEAUX_COMPETENCE', ['Débutant', 'Intermédiaire', 'Avancé', 'Expert']);
define('CATEGORIES_MEMBRES', ['Junior', 'Senior', 'Vétéran']);
define('TYPES_MEMBRES', ['athlete', 'entraineur', 'staff']);

// Couleurs et styles
define('PRIMARY_COLOR', '#3498db');
define('SECONDARY_COLOR', '#2c3e50');
define('SUCCESS_COLOR', '#27ae60');
define('DANGER_COLOR', '#e74c3c');
define('WARNING_COLOR', '#f39c12');
define('INFO_COLOR', '#3498db');

// Messages
define('MSG_SUCCESS', 'Opération réussie!');
define('MSG_ERROR', 'Une erreur est survenue.');
define('MSG_REQUIRED', 'Ce champ est obligatoire.');
define('MSG_INVALID_EMAIL', 'Email invalide.');
define('MSG_INVALID_PHONE', 'Numéro de téléphone invalide.');

// Durée de session (en secondes)
define('SESSION_TIMEOUT', 3600); // 1 heure

// Limites
define('MAX_FILE_SIZE', 5242880); // 5MB
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_ATTEMPT_TIMEOUT', 900); // 15 minutes

?>
