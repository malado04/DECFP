<?php

return [

    'title' => 'MEFPT',
    'title_prefix' => 'MEFPT',
    'title_postfix' => 'MEFPT',

    'use_ico_only' => false,
    'use_full_favicon' => false,

    'google_fonts' => ['allowed' => true],

    'logo' => '<b>MEFPT</b>',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'MEFPT Logo',

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo1.png',
            'alt' => 'Ministère Enseignement Professionnel et Technique',
            'effect' => 'animation__shake',
            'width' => 180,
            'height' => 180,
        ],
    ],

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-success',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    'classes_auth_card' => 'card-outline card-success',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-success',

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-success elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    'use_route_url' => false,
    // 'dashboard_url' => 'dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

'menu' => [

    // TOP NAVBAR
    ['type' => 'navbar-search', 'text' => 'search', 'topnav_right' => true],
    ['type' => 'fullscreen-widget', 'topnav_right' => true],

    // SIDEBAR SEARCH
    ['type' => 'sidebar-menu-search', 'text' => 'search'],

    // =======================
    // MON COMPTE
    // =======================
    ['header' => 'MON COMPTE'],
    [
        'text' => 'Mon profil',
        'url' => 'profile',
        'icon' => 'fas fa-fw fa-user',
        'role' => ['super-admin','ministere','regional-admin','centre-admin','jury','etudiant'],
    ],

    // =======================
    // TABLEAU DE BORD
    // =======================
    ['header' => 'TABLEAU DE BORD'],
    [
        'text' => 'Dashboard Admin',
        'url' => 'admin/dashboard/admin',
        'icon' => 'fas fa-fw fa-tachometer-alt',
        'role' => ['super-admin'],
    ],
    [
        'text' => 'Dashboard Jury',
        'url' => 'admin/dashboard/jury',
        'icon' => 'fas fa-fw fa-clipboard-check',
        'role' => ['jury','super-admin'],
    ],
    [
        'text' => 'Dashboard Ministère',
        'url' => 'admin/dashboard/ministere',
        'icon' => 'fas fa-fw fa-landmark',
        'role' => ['ministere','super-admin'],
    ],
    [
        'text' => 'Dashboard Centre',
        'url' => 'admin/dashboard/centre',
        'icon' => 'fas fa-fw fa-school',
        'role' => ['centre-admin'],
    ],

    // =======================
    // GESTION DES CENTRES
    // =======================
    ['header' => 'GESTION DES CENTRES',
        'role' => ['ministere','regional-admin']
    ],
    [
        'text' => 'Centres d’examen',
        'icon' => 'fas fa-fw fa-school',
        'role' => ['super-admin','ministere','regional-admin'],
        'submenu' => [
            [
                'text' => 'Liste des centres',
                'url'  => 'admin/centres',
                'icon' => 'fas fa-fw fa-list',
            ],
            [
                'text' => 'Ajouter un centre',
                'url'  => 'admin/centres/create',
                'icon' => 'fas fa-fw fa-plus-circle',
                'role' => ['super-admin','ministere'],
            ],
        ],
    ],

    // =======================
    // GESTION EXAMENS
    // =======================
    ['header' => 'GESTION DES EXAMENS',
        'role' => ['super-admin','ministere','centre-admin']
    ],
    [
        'text' => 'Examens',
        'icon' => 'fas fa-fw fa-book',
        'submenu' => [
            [
                'text' => 'Liste des examens',
                'url'  => 'admin/exams',
                'icon' => 'fas fa-fw fa-book-open',
                'role' => ['super-admin','ministere','centre-admin'],
            ],
            [
                'text' => 'Créer un examen',
                'url'  => 'admin/exams/create',
                'icon' => 'fas fa-fw fa-plus-circle',
                'role' => ['super-admin','ministere','centre-admin'],
            ],
            [
                'text' => 'Sessions d’examen',
                'url'  => 'admin/exam_sessions',
                'icon' => 'fas fa-fw fa-calendar-alt',
            ],
            [
                'text' => 'Créer une session',
                'url'  => 'admin/exam_sessions/create',
                'icon' => 'fas fa-fw fa-plus',
                'role' => ['super-admin','ministere','centre-admin'],
            ],
            [
                'text' => 'Compétences',
                'url'  => 'admin/competencies',
                'icon' => 'fas fa-fw fa-layer-group',
            ],
            [
                'text' => 'Ajouter compétence',
                'url'  => 'admin/competencies/create',
                'icon' => 'fas fa-fw fa-plus-circle',
                'role' => ['super-admin','ministere','centre-admin'],
            ],
            [
                'text' => 'Groupes',
                'url'  => 'admin/groups',
                'icon' => 'fas fa-fw fa-layer-group',
            ],
            [
                'text' => 'Ajouter groupes',
                'url'  => 'admin/groups/create',
                'icon' => 'fas fa-fw fa-plus-circle',
                'role' => ['super-admin','ministere','centre-admin'],
            ],
            [
                'text' => 'Pondérations CCP',
                'url'  => 'admin/ccp_weights',
                'icon' => 'fas fa-fw fa-balance-scale',
            ],
        ],
        'role' => ['super-admin','ministere','centre-admin'],
    ],

    // =======================
    // CANDIDATS
    // =======================
    ['header' => 'CANDIDATS'],
    [
        'text' => 'Candidats',
        'icon' => 'fas fa-fw fa-users',
        'submenu' => [
            [
                'text' => 'Liste des candidats',
                'url'  => 'admin/candidates',
                'icon' => 'fas fa-fw fa-list',
            ],
            [
                'text' => 'Ajouter candidat',
                'url'  => 'admin/candidates/create',
                'icon' => 'fas fa-fw fa-user-plus',
            ],
            [
                'text' => 'Documents',
                'url'  => 'admin/candidate_documents',
                'icon' => 'fas fa-fw fa-folder-open',
            ],
        ],
        'role' => ['super-admin','centre-admin','ministere'],
    ],

    // =======================
    // JURY & RÉSULTATS
    // =======================
    ['header' => 'JURY & RÉSULTATS',
    'role' => ['jury','super-admin']
    ],
    [
        'text' => 'Jury',
        'icon' => 'fas fa-fw fa-pen',
        'submenu' => [
            [
                'text' => 'Feuilles de notes',
                'url'  => 'admin/scores',
                'icon' => 'fas fa-fw fa-pen',
                'role' => ['jury','super-admin'],
            ],
            [
                'text' => 'Résultats',
                'url'  => 'admin/results',
                'icon' => 'fas fa-fw fa-chart-line',
            ],
            [
                'text' => 'Procès-verbaux',
                'url'  => 'admin/pv',
                'icon' => 'fas fa-fw fa-file-alt',
            ],
        ],
        'role' => ['jury','ministere','regional-admin','super-admin'],
    ],

    // =======================
    // ESPACE ÉTUDIANT
    // =======================
    ['header' => 'ESPACE ÉTUDIANT',
        'role' => ['etudiant','super-admin']
    ],
    [
        'text' => 'Espace étudiant',
        'icon' => 'fas fa-fw fa-graduation-cap',
        'role' => ['etudiant','super-admin'],
        'submenu' => [
            [
                'text' => 'Mes résultats',
                'url'  => 'etudiant/resultats',
                'icon' => 'fas fa-fw fa-chart-bar',
            ],
            [
                'text' => 'Mes documents',
                'url'  => 'etudiant/documents',
                'icon' => 'fas fa-fw fa-file',
            ],
        ],
    ],

    // =======================
    // ADMINISTRATION SYSTÈME
    // =======================
    ['header' => 'ADMINISTRATION & SÉCURITÉ',
        'role' => ['super-admin']
    ],
    [
        'text' => 'Utilisateurs',
        'url'  => 'admin/users',
        'icon' => 'fas fa-fw fa-users-cog',
        'role' => ['super-admin'],
    ],
    [
        'text' => 'Rôles',
        'url'  => 'admin/roles',
        'icon' => 'fas fa-fw fa-user-tag',
        'role' => ['super-admin'],
    ],
    [
        'text' => 'Journal d’audit',
        'url'  => 'admin/audit',
        'icon' => 'fas fa-fw fa-history',
        'role' => ['super-admin','ministere'],
    ],
    [
        'text' => 'Notifications',
        'url'  => 'admin/notifications',
        'icon' => 'fas fa-fw fa-bell',
        'role' => ['super-admin','ministere'],
    ],
],



    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
        App\AdminLTE\Filters\RoleFilter::class,
    ],

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'],
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js'],
                ['type' => 'css', 'asset' => false, 'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css'],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js'],
                ['type' => 'css', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css'],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js'],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8'],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                ['type' => 'css', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css'],
                ['type' => 'js', 'asset' => false, 'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js'],
            ],
        ],
    ],

    'iframe' => [
        'default_tab' => ['url' => null, 'title' => null],
        'buttons' => [
            'close' => true, 'close_all' => true, 'close_all_other' => true,
            'scroll_left' => true, 'scroll_right' => true, 'fullscreen' => true,
        ],
        'options' => ['loading_screen' => 1000, 'auto_show_new_tab' => true, 'use_navbar_items' => true],
    ],

    'livewire' => false,
];
