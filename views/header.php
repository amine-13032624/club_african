<?php
// Vérification de la session
if (!isset($_SESSION)) {
    session_start();
}
?>
<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-logo">
            <i class="fas fa-trophy"></i>
            <a href="index.php">   Espérance Sportif de Tunis غول افريقيا     </a>
        </div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="index.php" class="nav-link">Accueil</a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=membres" class="nav-link">Membres</a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link">Entraînements</a>
                <div class="dropdown-menu">
                    <a href="index.php?page=entrainements&action=planning">Planning</a>
                    <a href="index.php?page=entrainements&action=ajouter">Ajouter</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="index.php?page=paiements" class="nav-link">Paiements</a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=statistiques" class="nav-link">Statistiques</a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link logout">Déconnexion</a>
            </li>
        </ul>
    </div>
</nav>
