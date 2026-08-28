<?php

declare(strict_types=1);

return [
    'navigation' => [
        'admin_users' => 'Admin Users',
        'roles' => 'Roles',
        'error_pages' => 'Error Pages',
    ],

    'navigation_groups' => [
        'content' => 'Content',
        'system' => 'System',
    ],

    'models' => [
        'admin_user' => 'admin user',
        'admin_users' => 'admin users',
        'error_page' => 'error page',
        'error_pages' => 'error pages',
    ],

    'fields' => [
        'name' => 'Name',
        'email' => 'Email',
        'email_verified_at' => 'Email verified at',
        'password' => 'Password',
        'role' => 'Role',
        'users_count' => 'Users',
        'slug' => 'Slug',
        'heading' => 'Heading',
        'heading_en' => 'Heading (English)',
        'heading_ro' => 'Heading (Romanian)',
        'message' => 'Message',
        'message_en' => 'Message (English)',
        'message_ro' => 'Message (Romanian)',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],

    'actions' => [
        'save' => 'Save',
    ],

    'validations' => [
        'slug_format' => 'The slug may only contain lowercase letters, numbers, dashes and underscores.',
    ],

    'locales' => [
        'en' => 'English',
        'ro' => 'Română',
    ],
];
