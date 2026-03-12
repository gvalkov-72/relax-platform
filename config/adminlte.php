<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    */

    'title' => 'Relax Admin',
    'title_prefix' => '',
    'title_postfix' => '',


    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    */

    'logo' => '<b>Relax</b>Admin',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_alt' => 'Admin Logo',


    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    */

    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => false,


    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    */

    'use_route_url' => false,

    'dashboard_url' => 'admin/dashboard',

    'login_url' => 'login',
    'logout_url' => 'logout',
    'register_url' => null,


    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    */

    'sidebar_mini' => 'lg',
    'sidebar_nav_accordion' => true,


    /*
    |--------------------------------------------------------------------------
    | Menu
    |--------------------------------------------------------------------------
    */

    'menu' => [

        [
            'text' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon'  => 'fas fa-home',
        ],

        [
            'text' => 'Users',
            'route' => 'admin.users.index',
            'icon'  => 'fas fa-users',
            'can'   => 'manage users',
            'active' => ['admin/users*'],
        ],

        [
            'text' => 'Roles',
            'route' => 'admin.roles.index',
            'icon'  => 'fas fa-user-shield',
            'can'   => 'manage roles',
            'active' => ['admin/roles*'],
        ],

        [
            'text' => 'Permissions',
            'route' => 'admin.permissions.index',
            'icon'  => 'fas fa-key',
            'can'   => 'manage permissions',
            'active' => ['admin/permissions*'],
        ],

        ['header' => 'CONTENT'],

        [
            'text' => 'Meditations',
            'route' => 'admin.meditations.index',
            'icon'  => 'fas fa-brain',
            'can'   => 'manage meditations',
            'active' => ['admin/meditations*'],
        ],

        [
            'text' => 'Audio Files',
            'route' => 'admin.audio.index',
            'icon'  => 'fas fa-music',
            'can'   => 'manage audio',
            'active' => ['admin/audio*'],
        ],

        [
            'text' => 'Brainwave Presets',
            'route' => 'admin.brainwaves.index',
            'icon'  => 'fas fa-wave-square',
            'can'   => 'manage brainwaves',
            'active' => ['admin/brainwaves*'],
        ],

    ],


    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
    ],


    /*
    |--------------------------------------------------------------------------
    | Plugins
    |--------------------------------------------------------------------------
    */

    'plugins' => [],


    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    */

    'livewire' => false,

];
