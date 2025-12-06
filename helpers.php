<?php
/**
 * Fonctions utilitaires pour l'application Club Sportif
 */

/**
 * Valide une adresse email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Valide un numéro de téléphone
 */
function isValidPhone($phone) {
    return preg_match('/^[0-9\s\-\(\)]{10,}$/', $phone);
}

/**
 * Valide une date au format YYYY-MM-DD
 */
function isValidDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Échapper les caractères HTML
 */
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Tronquer une chaîne
 */
function truncate($string, $length = 100, $suffix = '...') {
    if (strlen($string) <= $length) {
        return $string;
    }
    return substr($string, 0, $length - strlen($suffix)) . $suffix;
}

/**
 * Formater une date en français
 */
function formatDateFr($date, $format = 'd/m/Y') {
    try {
        $datetime = new DateTime($date);
        return $datetime->format($format);
    } catch (Exception $e) {
        return $date;
    }
}

/**
 * Formater une heure
 */
function formatTime($time) {
    return substr($time, 0, 5);
}

/**
 * Formater un montant en euros
 */
function formatEuro($amount, $decimals = 2) {
    return number_format($amount, $decimals, ',', ' ') . ' €';
}

/**
 * Obtenir le nom du jour en français
 */
function getDayNameFr($date) {
    $days = ['Monday' => 'Lundi', 'Tuesday' => 'Mardi', 'Wednesday' => 'Mercredi', 
             'Thursday' => 'Jeudi', 'Friday' => 'Vendredi', 'Saturday' => 'Samedi', 'Sunday' => 'Dimanche'];
    
    $datetime = new DateTime($date);
    $dayName = $datetime->format('l');
    
    return isset($days[$dayName]) ? $days[$dayName] : $dayName;
}

/**
 * Obtenir le nom du mois en français
 */
function getMonthNameFr($month) {
    $months = ['January' => 'Janvier', 'February' => 'Février', 'March' => 'Mars', 
               'April' => 'Avril', 'May' => 'Mai', 'June' => 'Juin',
               'July' => 'Juillet', 'August' => 'Août', 'September' => 'Septembre', 
               'October' => 'Octobre', 'November' => 'Novembre', 'December' => 'Décembre'];
    
    $datetime = DateTime::createFromFormat('!m', $month);
    $monthName = $datetime->format('F');
    
    return isset($months[$monthName]) ? $months[$monthName] : $monthName;
}

/**
 * Générer une classe CSS pour un badge de statut
 */
function getStatusBadgeClass($status) {
    $classes = [
        'confirmé' => 'badge-success',
        'en attente' => 'badge-warning',
        'annulé' => 'badge-danger',
        'athlete' => 'badge-info',
        'entraineur' => 'badge-warning',
        'staff' => 'badge-secondary'
    ];
    
    return isset($classes[$status]) ? $classes[$status] : 'badge-secondary';
}

/**
 * Obtenir l'icône FontAwesome pour un type
 */
function getIconForType($type) {
    $icons = [
        'athlete' => 'fas fa-running',
        'entraineur' => 'fas fa-chalkboard-user',
        'staff' => 'fas fa-id-card',
        'paiement' => 'fas fa-money-bill',
        'entrainement' => 'fas fa-dumbbell',
        'equipe' => 'fas fa-users',
        'competition' => 'fas fa-trophy'
    ];
    
    return isset($icons[$type]) ? $icons[$type] : 'fas fa-circle';
}

/**
 * Calculer l'âge à partir d'une date de naissance
 */
function calculateAge($birthDate) {
    try {
        $today = new DateTime('today');
        $birth = new DateTime($birthDate);
        $age = $today->diff($birth)->y;
        return $age;
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Vérifier si une date est dans le passé
 */
function isPastDate($date) {
    return strtotime($date) < time();
}

/**
 * Vérifier si une date est dans le futur
 */
function isFutureDate($date) {
    return strtotime($date) > time();
}

/**
 * Obtenir le numéro de semaine
 */
function getWeekNumber($date) {
    return date('W', strtotime($date));
}

/**
 * Générer un slug à partir d'une chaîne
 */
function generateSlug($string) {
    $slug = strtolower($string);
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return trim($slug, '-');
}

/**
 * Obtenir un paramètre GET de manière sécurisée
 */
function getParam($key, $default = null, $type = 'string') {
    if (!isset($_GET[$key])) {
        return $default;
    }
    
    $value = $_GET[$key];
    
    switch ($type) {
        case 'int':
            return intval($value);
        case 'float':
            return floatval($value);
        case 'bool':
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        case 'string':
        default:
            return escape($value);
    }
}

/**
 * Obtenir un paramètre POST de manière sécurisée
 */
function postParam($key, $default = null, $type = 'string') {
    if (!isset($_POST[$key])) {
        return $default;
    }
    
    $value = $_POST[$key];
    
    switch ($type) {
        case 'int':
            return intval($value);
        case 'float':
            return floatval($value);
        case 'bool':
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        case 'string':
        default:
            return escape($value);
    }
}

/**
 * Définir un message de session
 */
function setSessionMessage($type, $message) {
    $_SESSION[$type] = $message;
}

/**
 * Obtenir et effacer un message de session
 */
function getSessionMessage($type) {
    if (isset($_SESSION[$type])) {
        $message = $_SESSION[$type];
        unset($_SESSION[$type]);
        return $message;
    }
    return null;
}

/**
 * Rediriger avec un message
 */
function redirectWithMessage($url, $type, $message) {
    setSessionMessage($type, $message);
    header('Location: ' . $url);
    exit;
}

/**
 * Générer une URL
 */
function url($path) {
    return APP_URL . '/' . ltrim($path, '/');
}

/**
 * Vérifier si l'utilisateur est connecté
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Vérifier la permission d'accès
 */
function requireLogin() {
    if (!isLoggedIn()) {
        redirectWithMessage('login.php', 'error', 'Vous devez être connecté pour accéder à cette page.');
    }
}

?>
