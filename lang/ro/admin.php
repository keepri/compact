<?php

declare(strict_types=1);

return [
    'navigation' => [
        'admin_users' => 'Utilizatori Admin',
        'roles' => 'Roluri',
        'error_pages' => 'Pagini Eroare',
    ],

    'navigation_groups' => [
        'content' => 'Conținut',
        'system' => 'Sistem',
    ],

    'models' => [
        'admin_user' => 'utilizator admin',
        'admin_users' => 'utilizatori admin',
        'error_page' => 'pagină de eroare',
        'error_pages' => 'pagini de eroare',
    ],

    'fields' => [
        'name' => 'Nume',
        'email' => 'Email',
        'email_verified_at' => 'Email verificat la',
        'password' => 'Parolă',
        'role' => 'Rol',
        'users_count' => 'Utilizatori',
        'slug' => 'Slug',
        'heading' => 'Titlu',
        'heading_en' => 'Titlu (Engleză)',
        'heading_ro' => 'Titlu (Română)',
        'message' => 'Mesaj',
        'message_en' => 'Mesaj (Engleză)',
        'message_ro' => 'Mesaj (Română)',
        'created_at' => 'Creat la',
        'updated_at' => 'Actualizat la',
    ],

    'actions' => [
        'save' => 'Salvează',
    ],

    'validations' => [
        'slug_format' => 'Slug-ul poate conține doar litere mici, cifre, cratime și underscore-uri.',
    ],

    'locales' => [
        'en' => 'English',
        'ro' => 'Română',
    ],
];
