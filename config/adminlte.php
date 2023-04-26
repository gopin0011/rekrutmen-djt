<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'HR | PT. Dwida Jaya Tama',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => 'PT. Dwida Jaya Tama',
    'logo_img' => 'logo-djt-white.png',
    'logo_img_class' => 'brand-image',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'logo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => false,
        'img' => [
            'path' => 'logo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => true,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-1',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-dark',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        // [
        //     'type'         => 'navbar-search',
        //     'text'         => 'search',
        //     'topnav_right' => true,
        // ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        // [
        //     'type' => 'sidebar-menu-search',
        //     'text' => 'search',
        // ],
        // ALL ACCESS ['q','w','e','r','t','y','u']
        // DEPT ['w','e','r','t','y']
        // ONLY APPLICANT ['q']
        // ONLY ADMIN ['w','e','r']
        ['header' => 'system','can'  => ['w','e','r','t','y']],
        [
            'text'    => 'sys_set',
            'icon'    => 'fas fa-fw fa-sliders',
            'can'  => ['w','e','r'],
            'submenu' => [
                [
                    'text' => 'corp',
                    'url'  => 'corps',
                    'icon' => 'fas fa-fw fa-building',
                    'shift' => 'ml-4',
                ],
                [
                    'text' => 'dept',
                    'url'  => 'depts',
                    'icon' => 'fas fa-fw fa-timeline',
                    'shift' => 'ml-4',
                ],
                [
                    'text' => 'dir',
                    'url'  => 'director',
                    'icon' => 'fas fa-fw fa-street-view',
                    'shift' => 'ml-4',
                ],
            ]
        ],
        [
            'text' => 'uac',
            'url'  => 'users',
            'icon' => 'fas fa-fw fa-users-gear',
            'can'  => ['w','e','r'],
        ],
        [
            'text' => 'doc',
            'url'  => 'forms',
            'icon' => 'fas fa-fw fa-folder-tree',
            'can'  => ['w','e','r','t','y'],
        ],

        ['header' => 'employees', 'can'  => ['w','e','r']],
        [
            'text'    => 'staff',
            'icon'    => 'fas fa-fw fa-building-user',
            'can'     => ['w','e','r'],
            'submenu' => [
                [
                    'text' => 'active',
                    'url'  => 'staff/active/all',
                    'icon' => 'fas fa-fw fa-user-check',
                    'shift' => 'ml-4',
                ],
                [
                    'text' => 'resign',
                    'url'  => 'staff/resign/all',
                    'icon' => 'fas fa-fw fa-user-xmark',
                    'shift' => 'ml-4',
                ],
            ]
        ],
        [
            'text'    => 'tlh',
            'icon'    => 'fas fa-fw fa-people-carry-box',
            'can'     => ['w','e','r'],
            'submenu' => [
                [
                    'text' => 'active',
                    'url'  => 'tlh/active/all',
                    'icon' => 'fas fa-fw fa-user-check',
                    'shift' => 'ml-4',
                ],
                [
                    'text' => 'resign',
                    'url'  => 'tlh/resign/all',
                    'icon' => 'fas fa-fw fa-user-xmark',
                    'shift' => 'ml-4',
                ],
            ]
        ],

        ['header' => 'recruit', 'can'  => ['w','e','r','u']],
        [
            'text'    => 'interview',
            'icon'    => 'fas fa-fw fa-comments',
            'can'  => ['w','e','r','u'],
            'submenu' => [
                [
                    'text' => 'invite',
                    'url'  => 'invitations',
                    'icon' => 'fas fa-fw fa-envelope',
                    'shift'=> 'ml-4',
                    'can'  => ['w','e','r'],
                ],
                [
                    'text' => 'today',
                    'url'  => 'applications/today',
                    'icon' => 'fas fa-fw fa-calendar-day',
                    'shift'=> 'ml-4',
                    'can'  => ['w','e','r','u'],
                ],
                [
                    'text' => 'interview_list',
                    'url'  => 'applications/all',
                    'icon' => 'fas fa-fw fa-list-check',
                    'shift'=> 'ml-4',
                    'can'  => ['w','e','r'],
                ],
            ]
        ],
        [
            'text'    => 'datadoc',
            'icon'    => 'fas fa-fw fa-folder',
            'can'     => ['w','e','r'],
            'submenu' => [
                [
                    'text' => 'loker',
                    'url'  => 'vacancies',
                    'icon' => 'fas fa-fw fa-layer-group',
                    'shift' => 'ml-4',
                ],
                [
                    'text' => 'applicant',
                    'url'  => 'candidates',
                    'icon' => 'fas fa-fw fa-file-pen',
                    'shift' => 'ml-4',
                ],
                // [
                //     'text' => 'editor',
                //     'url'  => 'edit',
                //     'icon' => 'fas fa-fw fa-pen-to-square',
                //     'shift' => 'ml-4',
                // ],
            ]
        ],
        [
            'text' => 'reschedule',
            'url'  => 'reschedule',
            'icon' => 'fas fa-fw fa-folder',
            'can'     => ['w','e','r'],
            'label' => '0',
        ],
        

        // lembur
        ['header' => 'lembur', 'can'  => ['w','e','r','t','y']],
        [
            'text'    => 'spl',
            'icon'    => 'fas fa-fw fa-list',
            'can'  => ['w','e','r','t','y'],
            'submenu' => [
                [
                    'text' => 'buat_spl',
                    'url'  => 'overtimes/create',
                    'icon' => 'fas fa-fw fa-list',
                    'shift'=> 'ml-4',
                    'can'  => ['w','e','r','t','y'],
                ],
                [
                    'text' => 'daftar_spl',
                    'url'  => 'overtimes',
                    'icon' => 'fas fa-fw fa-list',
                    'shift'=> 'ml-4',
                    'can'  => ['w','e','r','t','y'],
                ],
                [
                    'text' => 'hariini_spl',
                    'url'  => 'overtimes/today',
                    'icon' => 'fas fa-fw fa-list',
                    'shift'=> 'ml-4',
                    'can'  => ['w','e','r','t','y'],
                ],
                [
                    'text' => 'mana_spl',
                    'url'  => 'overtimes/manager-app',
                    'icon' => 'fas fa-fw fa-list',
                    'shift'=> 'ml-4',
                    'can'  => ['w','e','r','t','y'],
                ],
                [
                    'text' => 'hr_spl',
                    'url'  => 'overtimes/hr-app',
                    'icon' => 'fas fa-fw fa-list',
                    'shift'=> 'ml-4',
                    'can'  => ['w','e','r','t','y'],
                ],
            ]
        ],
        // [
        //     'text' => 'applicant',
        //     'url'  => 'applicants',
        //     'icon' => 'fas fa-fw fa-file-pen',
        // ],
        ['header' => 'APLIKASI LAMARAN','can' => ['q']],
        [
            'text' => 'Pilih Pekerjaan',
            'url'  => 'applications',
            'icon' => 'fas fa-fw fa-magnifying-glass',
            'can'  => ['q'],
        ],

        ['header' => 'KELENGKAPAN DATA','can' => ['q']],
        [
            'text' => 'Profil',
            'url'  => 'applicant_profiles',
            'icon' => 'fas fa-fw fa-user',
            'can'  => ['q'],
        ],
        [
            'text' => 'Data Keluarga',
            'url'  => 'applicant_families',
            'icon' => 'fas fa-fw fa-users',
            'can'  => ['q'],
        ],
        [
            'text' => 'Riwayat Pendidikan',
            'url'  => 'applicant_studies',
            'icon' => 'fas fa-fw fa-graduation-cap',
            'can'  => ['q'],
        ],
        [
            'text' => 'Riwayat Pekerjaan',
            'url'  => 'applicant_careers',
            'icon' => 'fas fa-fw fa-briefcase',
            'can'  => ['q'],
        ],
        [
            'text' => 'Kemampuan Bahasa',
            'url'  => 'applicant_languages',
            'icon' => 'fas fa-fw fa-earth-asia',
            'can'  => ['q'],
        ],
        [
            'text' => 'Pelatihan',
            'url'  => 'applicant_trainings',
            'icon' => 'fas fa-fw fa-certificate',
            'can'  => ['q'],
        ],
        [
            'text' => 'Kegiatan Sosial',
            'url'  => 'applicant_activities',
            'icon' => 'fas fa-fw fa-people-roof',
            'can'  => ['q'],
        ],
        [
            'text' => 'Referensi',
            'url'  => 'applicant_references',
            'icon' => 'fas fa-fw fa-signature',
            'can'  => ['q'],
        ],
        [
            'text' => 'Daftar Pertanyaan',
            'url'  => 'applicant_answers',
            'icon' => 'fas fa-fw fa-comments',
            'can'  => ['q'],
        ],
        [
            'text' => 'Unggah CV',
            'url'  => 'applicant_documents',
            'icon' => 'fas fa-fw fa-upload',
            'can'  => ['q'],
        ],

        ['header' => 'account_settings'],
        [
            'text' => 'profile',
            'url'  => 'users/ubah-data',
            'icon' => 'fas fa-fw fa-user',
        ],
        [
            'text' => 'change_password',
            'url'  => 'users/ubah-password',
            'icon' => 'fas fa-fw fa-lock',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
