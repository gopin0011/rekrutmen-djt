<?php return array (
  'adminlte' => 
  array (
    'title' => 'HR | PT. Dwida Jaya Tama',
    'title_prefix' => '',
    'title_postfix' => '',
    'use_ico_only' => false,
    'use_full_favicon' => false,
    'google_fonts' => 
    array (
      'allowed' => true,
    ),
    'logo' => 'PT. Dwida Jaya Tama',
    'logo_img' => 'logo-djt-white.png',
    'logo_img_class' => 'brand-image',
    'logo_img_xl' => NULL,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',
    'auth_logo' => 
    array (
      'enabled' => false,
      'img' => 
      array (
        'path' => 'logo.png',
        'alt' => 'Auth Logo',
        'class' => '',
        'width' => 50,
        'height' => 50,
      ),
    ),
    'preloader' => 
    array (
      'enabled' => false,
      'img' => 
      array (
        'path' => 'logo.png',
        'alt' => 'AdminLTE Preloader Image',
        'effect' => 'animation__shake',
        'width' => 60,
        'height' => 60,
      ),
    ),
    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,
    'layout_topnav' => NULL,
    'layout_boxed' => NULL,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => true,
    'layout_dark_mode' => NULL,
    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',
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
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',
    'menu' => 
    array (
      0 => 
      array (
        'type' => 'fullscreen-widget',
        'topnav_right' => true,
      ),
      1 => 
      array (
        'header' => 'system',
        'can' => 
        array (
          0 => 'w',
          1 => 'e',
          2 => 'r',
          3 => 't',
          4 => 'y',
        ),
      ),
      2 => 
      array (
        'text' => 'sys_set',
        'icon' => 'fas fa-fw fa-sliders',
        'can' => 
        array (
          0 => 'w',
          1 => 'e',
          2 => 'r',
        ),
        'submenu' => 
        array (
          0 => 
          array (
            'text' => 'corp',
            'url' => 'corps',
            'icon' => 'fas fa-fw fa-building',
            'shift' => 'ml-4',
          ),
          1 => 
          array (
            'text' => 'dept',
            'url' => 'depts',
            'icon' => 'fas fa-fw fa-timeline',
            'shift' => 'ml-4',
          ),
          2 => 
          array (
            'text' => 'dir',
            'url' => 'director',
            'icon' => 'fas fa-fw fa-street-view',
            'shift' => 'ml-4',
          ),
        ),
      ),
      3 => 
      array (
        'text' => 'uac',
        'url' => 'users',
        'icon' => 'fas fa-fw fa-users-gear',
        'can' => 
        array (
          0 => 'w',
          1 => 'e',
          2 => 'r',
        ),
      ),
      4 => 
      array (
        'text' => 'doc',
        'url' => 'forms',
        'icon' => 'fas fa-fw fa-folder-tree',
        'can' => 
        array (
          0 => 'w',
          1 => 'e',
          2 => 'r',
          3 => 't',
          4 => 'y',
        ),
      ),
      5 => 
      array (
        'header' => 'employees',
        'can' => 
        array (
          0 => 'w',
          1 => 'e',
          2 => 'r',
        ),
      ),
      6 => 
      array (
        'text' => 'staff',
        'icon' => 'fas fa-fw fa-building-user',
        'can' => 
        array (
          0 => 'w',
          1 => 'e',
          2 => 'r',
        ),
        'submenu' => 
        array (
          0 => 
          array (
            'text' => 'active',
            'url' => 'staff/active/all',
            'icon' => 'fas fa-fw fa-user-check',
            'shift' => 'ml-4',
          ),
          1 => 
          array (
            'text' => 'resign',
            'url' => 'staff/resign/all',
            'icon' => 'fas fa-fw fa-user-xmark',
            'shift' => 'ml-4',
          ),
        ),
      ),
      7 => 
      array (
        'text' => 'tlh',
        'icon' => 'fas fa-fw fa-people-carry-box',
        'can' => 
        array (
          0 => 'w',
          1 => 'e',
          2 => 'r',
        ),
        'submenu' => 
        array (
          0 => 
          array (
            'text' => 'active',
            'url' => 'tlh/active/all',
            'icon' => 'fas fa-fw fa-user-check',
            'shift' => 'ml-4',
          ),
          1 => 
          array (
            'text' => 'resign',
            'url' => 'tlh/resign/all',
            'icon' => 'fas fa-fw fa-user-xmark',
            'shift' => 'ml-4',
          ),
        ),
      ),
      8 => 
      array (
        'header' => 'recruit',
        'can' => 
        array (
          0 => 'w',
          1 => 'e',
          2 => 'r',
          3 => 'u',
        ),
      ),
      9 => 
      array (
        'text' => 'interview',
        'icon' => 'fas fa-fw fa-comments',
        'can' => 
        array (
          0 => 'w',
          1 => 'e',
          2 => 'r',
          3 => 'u',
        ),
        'submenu' => 
        array (
          0 => 
          array (
            'text' => 'invite',
            'url' => 'invitations',
            'icon' => 'fas fa-fw fa-envelope',
            'shift' => 'ml-4',
            'can' => 
            array (
              0 => 'w',
              1 => 'e',
              2 => 'r',
            ),
          ),
          1 => 
          array (
            'text' => 'today',
            'url' => 'applications/today',
            'icon' => 'fas fa-fw fa-calendar-day',
            'shift' => 'ml-4',
            'can' => 
            array (
              0 => 'w',
              1 => 'e',
              2 => 'r',
              3 => 'u',
            ),
          ),
          2 => 
          array (
            'text' => 'interview_list',
            'url' => 'applications/all',
            'icon' => 'fas fa-fw fa-list-check',
            'shift' => 'ml-4',
            'can' => 
            array (
              0 => 'w',
              1 => 'e',
              2 => 'r',
            ),
          ),
        ),
      ),
      10 => 
      array (
        'text' => 'datadoc',
        'icon' => 'fas fa-fw fa-folder',
        'can' => 
        array (
          0 => 'w',
          1 => 'e',
          2 => 'r',
        ),
        'submenu' => 
        array (
          0 => 
          array (
            'text' => 'loker',
            'url' => 'vacancies',
            'icon' => 'fas fa-fw fa-layer-group',
            'shift' => 'ml-4',
          ),
          1 => 
          array (
            'text' => 'applicant',
            'url' => 'candidates',
            'icon' => 'fas fa-fw fa-file-pen',
            'shift' => 'ml-4',
          ),
        ),
      ),
      11 => 
      array (
        'text' => 'reschedule',
        'url' => 'reschedule',
        'icon' => 'fas fa-fw fa-folder',
        'can' => 
        array (
          0 => 'w',
          1 => 'e',
          2 => 'r',
        ),
        'label' => '0',
      ),
      12 => 
      array (
        'header' => 'lembur',
        'can' => 
        array (
          0 => 'w',
          1 => 'e',
          2 => 'r',
          3 => 't',
          4 => 'y',
        ),
      ),
      13 => 
      array (
        'text' => 'spl',
        'icon' => 'fas fa-fw fa-list',
        'can' => 
        array (
          0 => 'w',
          1 => 'e',
          2 => 'r',
          3 => 't',
          4 => 'y',
        ),
        'submenu' => 
        array (
          0 => 
          array (
            'text' => 'buat_spl',
            'url' => 'overtimes/create',
            'icon' => 'fas fa-fw fa-list',
            'shift' => 'ml-4',
            'can' => 
            array (
              0 => 'w',
              1 => 'e',
              2 => 'r',
              3 => 't',
              4 => 'y',
            ),
          ),
          1 => 
          array (
            'text' => 'daftar_spl',
            'url' => 'overtimes',
            'icon' => 'fas fa-fw fa-list',
            'shift' => 'ml-4',
            'can' => 
            array (
              0 => 'w',
              1 => 'e',
              2 => 'r',
              3 => 't',
              4 => 'y',
            ),
          ),
          2 => 
          array (
            'text' => 'hariini_spl',
            'url' => 'overtimes/today',
            'icon' => 'fas fa-fw fa-list',
            'shift' => 'ml-4',
            'can' => 
            array (
              0 => 'w',
              1 => 'e',
              2 => 'r',
              3 => 't',
              4 => 'y',
            ),
          ),
          3 => 
          array (
            'text' => 'mana_spl',
            'url' => 'overtimes/manager-app',
            'icon' => 'fas fa-fw fa-list',
            'shift' => 'ml-4',
            'can' => 
            array (
              0 => 'w',
              1 => 'e',
              2 => 'r',
              3 => 't',
              4 => 'y',
            ),
          ),
          4 => 
          array (
            'text' => 'hr_spl',
            'url' => 'overtimes/hr-app',
            'icon' => 'fas fa-fw fa-list',
            'shift' => 'ml-4',
            'can' => 
            array (
              0 => 'w',
              1 => 'e',
              2 => 'r',
              3 => 't',
              4 => 'y',
            ),
          ),
          5 => 
          array (
            'text' => 'spl_form',
            'url' => 'overtimes/spl-form',
            'icon' => 'fas fa-fw fa-list',
            'shift' => 'ml-4',
            'can' => 
            array (
              0 => 'w',
              1 => 'e',
              2 => 'r',
            ),
          ),
        ),
      ),
      14 => 
      array (
        'header' => 'APLIKASI LAMARAN',
        'can' => 
        array (
          0 => 'q',
        ),
      ),
      15 => 
      array (
        'text' => 'Pilih Pekerjaan',
        'url' => 'applications',
        'icon' => 'fas fa-fw fa-magnifying-glass',
        'can' => 
        array (
          0 => 'q',
        ),
      ),
      16 => 
      array (
        'header' => 'KELENGKAPAN DATA',
        'can' => 
        array (
          0 => 'q',
        ),
      ),
      17 => 
      array (
        'text' => 'Profil',
        'url' => 'applicant_profiles',
        'icon' => 'fas fa-fw fa-user',
        'can' => 
        array (
          0 => 'q',
        ),
      ),
      18 => 
      array (
        'text' => 'Data Keluarga',
        'url' => 'applicant_families',
        'icon' => 'fas fa-fw fa-users',
        'can' => 
        array (
          0 => 'q',
        ),
      ),
      19 => 
      array (
        'text' => 'Riwayat Pendidikan',
        'url' => 'applicant_studies',
        'icon' => 'fas fa-fw fa-graduation-cap',
        'can' => 
        array (
          0 => 'q',
        ),
      ),
      20 => 
      array (
        'text' => 'Riwayat Pekerjaan',
        'url' => 'applicant_careers',
        'icon' => 'fas fa-fw fa-briefcase',
        'can' => 
        array (
          0 => 'q',
        ),
      ),
      21 => 
      array (
        'text' => 'Kemampuan Bahasa',
        'url' => 'applicant_languages',
        'icon' => 'fas fa-fw fa-earth-asia',
        'can' => 
        array (
          0 => 'q',
        ),
      ),
      22 => 
      array (
        'text' => 'Pelatihan',
        'url' => 'applicant_trainings',
        'icon' => 'fas fa-fw fa-certificate',
        'can' => 
        array (
          0 => 'q',
        ),
      ),
      23 => 
      array (
        'text' => 'Kegiatan Sosial',
        'url' => 'applicant_activities',
        'icon' => 'fas fa-fw fa-people-roof',
        'can' => 
        array (
          0 => 'q',
        ),
      ),
      24 => 
      array (
        'text' => 'Referensi',
        'url' => 'applicant_references',
        'icon' => 'fas fa-fw fa-signature',
        'can' => 
        array (
          0 => 'q',
        ),
      ),
      25 => 
      array (
        'text' => 'Daftar Pertanyaan',
        'url' => 'applicant_answers',
        'icon' => 'fas fa-fw fa-comments',
        'can' => 
        array (
          0 => 'q',
        ),
      ),
      26 => 
      array (
        'text' => 'Unggah CV',
        'url' => 'applicant_documents',
        'icon' => 'fas fa-fw fa-upload',
        'can' => 
        array (
          0 => 'q',
        ),
      ),
      27 => 
      array (
        'header' => 'account_settings',
      ),
      28 => 
      array (
        'text' => 'profile',
        'url' => 'users/ubah-data',
        'icon' => 'fas fa-fw fa-user',
      ),
      29 => 
      array (
        'text' => 'change_password',
        'url' => 'users/ubah-password',
        'icon' => 'fas fa-fw fa-lock',
      ),
    ),
    'filters' => 
    array (
      0 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\GateFilter',
      1 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\HrefFilter',
      2 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\SearchFilter',
      3 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\ActiveFilter',
      4 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\ClassesFilter',
      5 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\LangFilter',
      6 => 'JeroenNoten\\LaravelAdminLte\\Menu\\Filters\\DataFilter',
    ),
    'plugins' => 
    array (
      'Datatables' => 
      array (
        'active' => false,
        'files' => 
        array (
          0 => 
          array (
            'type' => 'js',
            'asset' => false,
            'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
          ),
          1 => 
          array (
            'type' => 'js',
            'asset' => false,
            'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
          ),
          2 => 
          array (
            'type' => 'css',
            'asset' => false,
            'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
          ),
        ),
      ),
      'Select2' => 
      array (
        'active' => false,
        'files' => 
        array (
          0 => 
          array (
            'type' => 'js',
            'asset' => false,
            'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
          ),
          1 => 
          array (
            'type' => 'css',
            'asset' => false,
            'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
          ),
        ),
      ),
      'Chartjs' => 
      array (
        'active' => false,
        'files' => 
        array (
          0 => 
          array (
            'type' => 'js',
            'asset' => false,
            'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
          ),
        ),
      ),
      'Sweetalert2' => 
      array (
        'active' => false,
        'files' => 
        array (
          0 => 
          array (
            'type' => 'js',
            'asset' => false,
            'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
          ),
        ),
      ),
      'Pace' => 
      array (
        'active' => false,
        'files' => 
        array (
          0 => 
          array (
            'type' => 'css',
            'asset' => false,
            'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
          ),
          1 => 
          array (
            'type' => 'js',
            'asset' => false,
            'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
          ),
        ),
      ),
    ),
    'iframe' => 
    array (
      'default_tab' => 
      array (
        'url' => NULL,
        'title' => NULL,
      ),
      'buttons' => 
      array (
        'close' => true,
        'close_all' => true,
        'close_all_other' => true,
        'scroll_left' => true,
        'scroll_right' => true,
        'fullscreen' => true,
      ),
      'options' => 
      array (
        'loading_screen' => 1000,
        'auto_show_new_tab' => true,
        'use_navbar_items' => true,
      ),
    ),
    'livewire' => false,
  ),
  'app' => 
  array (
    'name' => 'DJT - Human Resources',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost/rekrutmen',
    'asset_url' => 'http://localhost/rekrutmen/public',
    'timezone' => 'Asia/Jakarta',
    'locale' => 'id',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => 'base64:fnXp8xx4iN+zYXp8tnPsWhHHaXxUx9Mx7uDOc7z5DKs=',
    'cipher' => 'AES-256-CBC',
    'maintenance' => 
    array (
      'driver' => 'file',
    ),
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'Yajra\\DataTables\\DataTablesServiceProvider',
      23 => 'Barryvdh\\DomPDF\\ServiceProvider',
      24 => 'App\\Providers\\AppServiceProvider',
      25 => 'App\\Providers\\AuthServiceProvider',
      26 => 'App\\Providers\\EventServiceProvider',
      27 => 'App\\Providers\\RouteServiceProvider',
      28 => 'GrofGraf\\LaravelPDFMerger\\Providers\\PDFMergerServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Js' => 'Illuminate\\Support\\Js',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Process' => 'Illuminate\\Support\\Facades\\Process',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'RateLimiter' => 'Illuminate\\Support\\Facades\\RateLimiter',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Vite' => 'Illuminate\\Support\\Facades\\Vite',
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
      'JWTHelper' => 'App\\JWT\\JWT',
      'PDFMerger' => 'GrofGraf\\LaravelPDFMerger\\Facades\\PDFMergerFacade',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'sanctum' => 
      array (
        'driver' => 'sanctum',
        'provider' => NULL,
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
        array (
          'host' => 'api-mt1.pusher.com',
          'port' => '443',
          'scheme' => 'https',
          'encrypted' => true,
          'useTLS' => true,
        ),
        'client_options' => 
        array (
        ),
      ),
      'ably' => 
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
        'lock_connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => '/home/user/www/rekrutmen/storage/framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' => 
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' => 
      array (
        'driver' => 'octane',
      ),
    ),
    'prefix' => 'djt_human_resources_cache_',
  ),
  'cors' => 
  array (
    'paths' => 
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' => 
    array (
      0 => '*',
    ),
    'allowed_origins' => 
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' => 
    array (
    ),
    'allowed_headers' => 
    array (
      0 => '*',
    ),
    'exposed_headers' => 
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'local_hrisdb',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'local_hrisdb',
        'username' => 'root',
        'password' => '123rootPassword!',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' => 
        array (
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'local_hrisdb',
        'username' => 'root',
        'password' => '123rootPassword!',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'search_path' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => 'localhost',
        'port' => '3306',
        'database' => 'local_hrisdb',
        'username' => 'root',
        'password' => '123rootPassword!',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'phpredis',
      'options' => 
      array (
        'cluster' => 'redis',
        'prefix' => 'djt_human_resources_database_',
      ),
      'default' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
      ),
      'cache' => 
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'username' => NULL,
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
      ),
    ),
  ),
  'datatables' => 
  array (
    'search' => 
    array (
      'smart' => true,
      'multi_term' => true,
      'case_insensitive' => true,
      'use_wildcards' => false,
      'starts_with' => false,
    ),
    'index_column' => 'DT_RowIndex',
    'engines' => 
    array (
      'eloquent' => 'Yajra\\DataTables\\EloquentDataTable',
      'query' => 'Yajra\\DataTables\\QueryDataTable',
      'collection' => 'Yajra\\DataTables\\CollectionDataTable',
      'resource' => 'Yajra\\DataTables\\ApiResourceDataTable',
    ),
    'builders' => 
    array (
    ),
    'nulls_last_sql' => ':column :direction NULLS LAST',
    'error' => NULL,
    'columns' => 
    array (
      'excess' => 
      array (
        0 => 'rn',
        1 => 'row_num',
      ),
      'escape' => '*',
      'raw' => 
      array (
        0 => 'action',
      ),
      'blacklist' => 
      array (
        0 => 'password',
        1 => 'remember_token',
      ),
      'whitelist' => '*',
    ),
    'json' => 
    array (
      'header' => 
      array (
      ),
      'options' => 0,
    ),
    'callback' => 
    array (
      0 => '$',
      1 => '$.',
      2 => 'function',
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'public',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => '/home/user/www/rekrutmen/storage/app',
        'throw' => false,
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => '/home/user/www/rekrutmen/storage/app/public',
        'url' => 'http://localhost/rekrutmen/storage',
        'visibility' => 'public',
        'throw' => false,
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
        'throw' => false,
      ),
    ),
    'links' => 
    array (
      '/home/user/www/rekrutmen/public/storage' => '/home/user/www/rekrutmen/storage/app/public',
    ),
  ),
  'hashing' => 
  array (
    'driver' => 'bcrypt',
    'bcrypt' => 
    array (
      'rounds' => 10,
    ),
    'argon' => 
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
    ),
  ),
  'logging' => 
  array (
    'default' => 'stack',
    'deprecations' => 
    array (
      'channel' => NULL,
      'trace' => false,
    ),
    'channels' => 
    array (
      'stack' => 
      array (
        'driver' => 'stack',
        'channels' => 
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' => 
      array (
        'driver' => 'single',
        'path' => '/home/user/www/rekrutmen/storage/logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' => 
      array (
        'driver' => 'daily',
        'path' => '/home/user/www/rekrutmen/storage/logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' => 
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
      ),
      'papertrail' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' => 
        array (
          'host' => NULL,
          'port' => NULL,
          'connectionString' => 'tls://:',
        ),
      ),
      'stderr' => 
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' => 
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' => 
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' => 
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
      'null' => 
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' => 
      array (
        'path' => '/home/user/www/rekrutmen/storage/logs/laravel.log',
      ),
    ),
  ),
  'mail' => 
  array (
    'default' => 'smtp',
    'mailers' => 
    array (
      'smtp' => 
      array (
        'transport' => 'smtp',
        'host' => 'mail.dwidajayatama.com',
        'port' => '465',
        'encryption' => 'ssl',
        'username' => 'noreply@dwidajayatama.com',
        'password' => '123dwida*#',
        'timeout' => NULL,
        'local_domain' => NULL,
      ),
      'ses' => 
      array (
        'transport' => 'ses',
      ),
      'mailgun' => 
      array (
        'transport' => 'mailgun',
      ),
      'postmark' => 
      array (
        'transport' => 'postmark',
      ),
      'sendmail' => 
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -bs -i',
      ),
      'log' => 
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' => 
      array (
        'transport' => 'array',
      ),
      'failover' => 
      array (
        'transport' => 'failover',
        'mailers' => 
        array (
          0 => 'smtp',
          1 => 'log',
        ),
      ),
    ),
    'from' => 
    array (
      'address' => 'noreply@dwidajayatama.com',
      'name' => 'PT. Dwida Jaya Tama',
    ),
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => '/home/user/www/rekrutmen/resources/views/vendor/mail',
      ),
    ),
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
    ),
    'failed' => 
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'sanctum' => 
  array (
    'stateful' => 
    array (
      0 => 'localhost',
      1 => 'localhost:3000',
      2 => '127.0.0.1',
      3 => '127.0.0.1:8000',
      4 => '::1',
      5 => 'localhost',
    ),
    'guard' => 
    array (
      0 => 'web',
    ),
    'expiration' => NULL,
    'middleware' => 
    array (
      'verify_csrf_token' => 'App\\Http\\Middleware\\VerifyCsrfToken',
      'encrypt_cookies' => 'App\\Http\\Middleware\\EncryptCookies',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
      'endpoint' => 'api.mailgun.net',
      'scheme' => 'https',
    ),
    'postmark' => 
    array (
      'token' => NULL,
    ),
    'ses' => 
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => '/home/user/www/rekrutmen/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'djt_human_resources_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => '/home/user/www/rekrutmen/resources/views',
    ),
    'compiled' => '/home/user/www/rekrutmen/storage/framework/views',
  ),
  'dompdf' => 
  array (
    'show_warnings' => false,
    'public_path' => NULL,
    'convert_entities' => true,
    'options' => 
    array (
      'font_dir' => '/home/user/www/rekrutmen/storage/fonts',
      'font_cache' => '/home/user/www/rekrutmen/storage/fonts',
      'temp_dir' => '/tmp',
      'chroot' => '/home/user/www/rekrutmen',
      'allowed_protocols' => 
      array (
        'file://' => 
        array (
          'rules' => 
          array (
          ),
        ),
        'http://' => 
        array (
          'rules' => 
          array (
          ),
        ),
        'https://' => 
        array (
          'rules' => 
          array (
          ),
        ),
      ),
      'log_output_file' => NULL,
      'enable_font_subsetting' => false,
      'pdf_backend' => 'CPDF',
      'default_media_type' => 'screen',
      'default_paper_size' => 'a4',
      'default_paper_orientation' => 'portrait',
      'default_font' => 'serif',
      'dpi' => 96,
      'enable_php' => false,
      'enable_javascript' => true,
      'enable_remote' => true,
      'font_height_ratio' => 1.1,
      'enable_html5_parser' => true,
    ),
  ),
  'flare' => 
  array (
    'key' => NULL,
    'flare_middleware' => 
    array (
      0 => 'Spatie\\FlareClient\\FlareMiddleware\\RemoveRequestIp',
      1 => 'Spatie\\FlareClient\\FlareMiddleware\\AddGitInformation',
      2 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddNotifierName',
      3 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddEnvironmentInformation',
      4 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddExceptionInformation',
      5 => 'Spatie\\LaravelIgnition\\FlareMiddleware\\AddDumps',
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddLogs' => 
      array (
        'maximum_number_of_collected_logs' => 200,
      ),
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddQueries' => 
      array (
        'maximum_number_of_collected_queries' => 200,
        'report_query_bindings' => true,
      ),
      'Spatie\\LaravelIgnition\\FlareMiddleware\\AddJobs' => 
      array (
        'max_chained_job_reporting_depth' => 5,
      ),
      'Spatie\\FlareClient\\FlareMiddleware\\CensorRequestBodyFields' => 
      array (
        'censor_fields' => 
        array (
          0 => 'password',
          1 => 'password_confirmation',
        ),
      ),
      'Spatie\\FlareClient\\FlareMiddleware\\CensorRequestHeaders' => 
      array (
        'headers' => 
        array (
          0 => 'API-KEY',
        ),
      ),
    ),
    'send_logs_as_events' => true,
  ),
  'ignition' => 
  array (
    'editor' => 'phpstorm',
    'theme' => 'auto',
    'enable_share_button' => true,
    'register_commands' => false,
    'solution_providers' => 
    array (
      0 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\BadMethodCallSolutionProvider',
      1 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\MergeConflictSolutionProvider',
      2 => 'Spatie\\Ignition\\Solutions\\SolutionProviders\\UndefinedPropertySolutionProvider',
      3 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\IncorrectValetDbCredentialsSolutionProvider',
      4 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingAppKeySolutionProvider',
      5 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\DefaultDbNameSolutionProvider',
      6 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\TableNotFoundSolutionProvider',
      7 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingImportSolutionProvider',
      8 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\InvalidRouteActionSolutionProvider',
      9 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\ViewNotFoundSolutionProvider',
      10 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\RunningLaravelDuskInProductionProvider',
      11 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingColumnSolutionProvider',
      12 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UnknownValidationSolutionProvider',
      13 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingMixManifestSolutionProvider',
      14 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingViteManifestSolutionProvider',
      15 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\MissingLivewireComponentSolutionProvider',
      16 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\UndefinedViewVariableSolutionProvider',
      17 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\GenericLaravelExceptionSolutionProvider',
      18 => 'Spatie\\LaravelIgnition\\Solutions\\SolutionProviders\\OpenAiSolutionProvider',
    ),
    'ignored_solution_providers' => 
    array (
    ),
    'enable_runnable_solutions' => NULL,
    'remote_sites_path' => '/home/user/www/rekrutmen',
    'local_sites_path' => '',
    'housekeeping_endpoint_prefix' => '_ignition',
    'settings_file_path' => '',
    'recorders' => 
    array (
      0 => 'Spatie\\LaravelIgnition\\Recorders\\DumpRecorder\\DumpRecorder',
      1 => 'Spatie\\LaravelIgnition\\Recorders\\JobRecorder\\JobRecorder',
      2 => 'Spatie\\LaravelIgnition\\Recorders\\LogRecorder\\LogRecorder',
      3 => 'Spatie\\LaravelIgnition\\Recorders\\QueryRecorder\\QueryRecorder',
    ),
    'open_ai_key' => NULL,
  ),
  'datatables-buttons' => 
  array (
    'namespace' => 
    array (
      'base' => 'DataTables',
      'model' => '',
    ),
    'pdf_generator' => 'snappy',
    'snappy' => 
    array (
      'options' => 
      array (
        'no-outline' => true,
        'margin-left' => '0',
        'margin-right' => '0',
        'margin-top' => '10mm',
        'margin-bottom' => '10mm',
      ),
      'orientation' => 'landscape',
    ),
    'parameters' => 
    array (
      'dom' => 'Bfrtip',
      'order' => 
      array (
        0 => 
        array (
          0 => 0,
          1 => 'desc',
        ),
      ),
      'buttons' => 
      array (
        0 => 'excel',
        1 => 'csv',
        2 => 'pdf',
        3 => 'print',
        4 => 'reset',
        5 => 'reload',
      ),
    ),
    'generator' => 
    array (
      'columns' => 'id,add your columns,created_at,updated_at',
      'buttons' => 'excel,csv,pdf,print,reset,reload',
      'dom' => 'Bfrtip',
    ),
  ),
  'datatables-html' => 
  array (
    'namespace' => 'LaravelDataTables',
    'table' => 
    array (
      'class' => 'table',
      'id' => 'dataTableBuilder',
    ),
    'script' => 'datatables::script',
    'editor' => 'datatables::editor',
  ),
  'datatables-fractal' => 
  array (
    'includes' => 'include',
    'serializer' => 'League\\Fractal\\Serializer\\DataArraySerializer',
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);
