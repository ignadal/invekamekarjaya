<?php

return [
    'name_column' => 'name',
    'locale_column' => 'locale',
    'theme_color_column' => 'theme_color',
    'avatar_column' => 'avatar_url',
    'disk' => env('FILESYSTEM_DISK', 'public'),
    'visibility' => 'public', // or replace by filesystem disk visibility with fallback value
    'show_custom_fields' => true,
    'custom_fields' => [
        'no_hp' => [
            'type' => 'text',
            'label' => 'Nomor HP',
            'placeholder' => 'Masukkan Nomor HP',
            'required' => false,
            'rules' => 'nullable|string|max:255',
        ],
    ],
];
