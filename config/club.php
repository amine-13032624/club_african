<?php
/**
 * Informations du Club Sportif
 * À modifier selon vos besoins
 */

return [
    'nom' => 'Club Sportif',
    'description' => 'Un club moderne pour tous les sportifs',
    'email' => 'contact@clubsportif.com',
    'telephone' => '01 23 45 67 89',
    'adresse' => '123 Rue du Sport, 75000 Paris',
    'ville' => 'Paris',
    'codePostal' => '75000',
    'pays' => 'France',
    
    'logo' => 'https://via.placeholder.com/100',
    'couleurPrimaire' => '#3498db',
    'couleurSecondaire' => '#2c3e50',
    
    'heuresOuverture' => [
        'lundi' => '08:00 - 22:00',
        'mardi' => '08:00 - 22:00',
        'mercredi' => '08:00 - 22:00',
        'jeudi' => '08:00 - 22:00',
        'vendredi' => '08:00 - 22:00',
        'samedi' => '09:00 - 18:00',
        'dimanche' => 'Fermé'
    ],
    
    'reseaux' => [
        'facebook' => 'https://facebook.com/clubsportif',
        'twitter' => 'https://twitter.com/clubsportif',
        'instagram' => 'https://instagram.com/clubsportif',
        'youtube' => 'https://youtube.com/clubsportif'
    ],
    
    'sports' => ['Football', 'Basketball', 'Tennis', 'Volleyball', 'Badminton'],
    
    'cotisations' => [
        'enfant' => ['nom' => 'Enfant', 'prix' => 20.00],
        'ado' => ['nom' => 'Adolescent', 'prix' => 40.00],
        'adulte' => ['nom' => 'Adulte', 'prix' => 60.00],
        'senior' => ['nom' => 'Senior', 'prix' => 50.00]
    ]
];
?>
