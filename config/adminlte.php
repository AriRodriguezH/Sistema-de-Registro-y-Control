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

    'title' => 'SRCCA',
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

    'logo' => '<b>SRCCA</b>',
    'logo_img' => '/assests/img/imagen.png',
    'logo_img_class' => 'brand-image  ',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => '',

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
            'path' => 'vendor/adminlte/dist/img/mgsicopi.png',
            'alt' => 'Auth Logo',
            'class' => 'bg-success',
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
            'path' => 'vendor/adminlte/dist/img/mgsicopi.png',
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
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-olive',
    'usermenu_image' => false,
    'usermenu_desc' => true,
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
    'layout_fixed_footer' => null,
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
    'classes_brand' => 'btn bg-info active',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-info elevation-4 ',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
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
    'dashboard_url' => '/mgsi',
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

    
        // Parte superior de la barra Navbar items:

        // Parte lateral Sidebar items:
        
        [
            'type' => 'sidebar-menu-search',
            'text' => 'Buscar',
        ],
        
        ['header' => 'CONFIGURACIONES DE LA CUENTA'],
        [
            'text' => 'Perfil',
            'url'  => '/verPerfil',
            'icon' => 'nav-icon fas fa-fw fa-user',
            'text-size'=>'46px'
        ],
        [
            'text' => 'Cambiar contraseña',
            'url'  => '/cambiarContrasena',
            'icon' => 'nav-icon fas fa-fw fa-lock',
        ],
       //       ACCIONES DEL MENÚ
        ['header' => 'MENÚ'],
        [
            'text' => 'Inicio',
            'url'  => '/mgsi',
            'icon' => 'nav-icon fas fa fa-home',
            
        ],
        [
            'text' => 'Usuarios',
            'url'  => '/usuarios',
            'icon' => 'nav-icon fas fa-users-cog',
            //aqui ponemos que quienes tengan el permiso de ver rol lo pueden ver 
            'can'  => 'ver-usuarios',
        ],
        [
            'text' => 'Roles',
            'url'  => '/roles',
            'icon' => 'nav-icon fas fa-sharp fa-regular fa-users',
            'can'  => 'ver-rol',
        ],
        [
            'text'    => 'Procesos',
            'icon' =>'fas fa-circle nav-icon',
        
            'submenu' => [
                
                [
                    'text' => 'A. Objetivos, requerimientos y estrategias',
                    'url'  => '/procesoA',
                    'icon' => 'nav-icon fas fa-solid fa-object-group',
                    'active' => ['procesoA/*'], // Agregamos esta línea para mantener el submenú activo en las rutas relacionadas con ProcesoA
                ],
                [
                    'text' => 'B. Identificación de los procesos y activos esenciales',
                    'url'  => '/procesoB',
                    'icon' => 'nav-icon fas fa-copy',
                    'active' => ['procesoB/*'], // Agregamos esta línea para mantener el submenú activo en las rutas relacionadas con ProcesoB
                ],
                [
                    'text' => 'C. Análisis de Riesgos',
                    'url'  => '/procesoC',
                    'icon' => 'nav-icon fas fa-solid fa-eye',
                    'active' => ['procesoC/*'], // Agregamos esta línea para mantener el submenú activo en las rutas relacionadas con ProcesoC
                ],
                [
                    'text' => 'D. Implementación de los controles mínimos de Seguridad de la Información',
                    'url'  => '/procesoD',
                    'icon' => 'nav-icon fas fa-solid fa-file-contract',
                    'active' => ['procesoD/*'], // Agregamos esta línea para mantener el submenú activo en las rutas relacionadas con ProcesoD
                ],
                [
                    'text' => 'E. Programa de gestión de vulnerabilidades',
                    'url'  => '/procesoE',
                    'icon' => 'nav-icon fa fa-balance-scale',
                    'active' => ['procesoE/*'], // Agregamos esta línea para mantener el submenú activo en las rutas relacionadas con ProcesoE
                ],
                [
                    'text' => 'F. Protocolo de respuesta ante incidentes de Seguridad de la Información',
                    'url'  => '/procesoF',
                    'icon' => 'nav-icon fas fa-solid fa-user-shield',
                    'active' => ['procesoF/*'], // Agregamos esta línea para mantener el submenú activo en las rutas relacionadas con ProcesoF
                ],
                [
                    'text' => 'G. Plan de Continuidad de Operaciones y Plan de Recuperación ante Desastres',
                    'url'  => '/procesoG',
                    'icon' => 'nav-icon fas fa-solid fa-file-signature',
                    'active' => ['procesoG/*'], // Agregamos esta línea para mantener el submenú activo en las rutas relacionadas con ProcesoG
                ],
                [
                    'text' => 'H. Supervisión y evaluación',
                    'url'  => '/procesoH',
                    'icon' => 'nav-icon fas fa-solid fa-check-double',
                    'active' => ['procesoH/*'], // Agregamos esta línea para mantener el submenú activo en las rutas relacionadas con ProcesoH
                ],
                [
                    'text' => 'I. Programa de Formación, Concientización y Capacitación en materia de Seguridad de la Información',
                    'url'  => '/procesoI',
                    'icon' => 'nav-icon fas fa-solid fa-sitemap',
                    'active' => ['procesoI/*'], // Agregamos esta línea para mantener el submenú activo en las rutas relacionadas con ProcesoI
                ],
                [
                    'text' => 'J. Programa de implementación del SRCCA',
                    'url'  => '/procesoJ',
                    'icon' => 'nav-icon fas fa-solid fa-book',
                    'active' => ['procesoJ/*'], // Agregamos esta línea para mantener el submenú activo en las rutas relacionadas con ProcesoJ
                ],
            ],
        ],
                
        [
            'text'    => 'Gráficas',
            'icon'    => 'nav-icon fas fa-chart-pie',
            'submenu' => [
                [
                    'text' => 'Gráfica General SRCCA',
                    'url'  => '/grafica-cumplimiento',
                    'icon' =>'nav-icon fas fa-solid fa-chart-area'
                ],
                [
                    'text'    => 'Gráfica de los Procesos SRCCA',
                    'icon_color' => 'yellow',
                    'submenu' => [
                        [
                            'text' => 'A. Objetivos, requerimientos y estrategias',
                            'url'  => '/graficasA',
                            'icon' => 'nav-icon fas fa-solid fa-object-group',
                            
                        ],
                        [
                            'text' => 'B. Identificación de los procesos y activos esenciales',
                            'url'  => '/graficasB',
                            'icon' => 'nav-icon fas fa-copy',
                            
                        ],
                        [
                            'text' => 'C. Análisis de Riesgos',
                            'url'  => '/graficasC',
                            'icon' => 'nav-icon fas fa-solid fa-eye',
                            
                        ],
                        [
                            'text' => 'D. Implementación de los controles mínimos de Seguridad de la Información',
                            'url'  => '/graficasD',
                            'icon' => 'nav-icon fas fa-solid fa-file-contract',
                            
                        ],
                        [
                            'text' => 'E. Programa de gestión de vulnerabilidades.',
                            'url'  => '/graficasE',
                            'icon' => 'nav-icon fa fa-balance-scale',
                            
                        ],
                        [
                            'text' => 'F. Protocolo de respuesta ante incidentes de Seguridad de la Información',
                            'url'  => '/graficasF',
                            'icon' => 'nav-icon fas fa-solid fa-user-shield',
                            
                        ],
                        [
                            'text' => 'G. Plan de Continuidad de Operaciones y Plan de Recuperación ante Desastres',
                            'url'  => '/graficasG',
                            'icon' => 'nav-icon fas fa-solid fa-file-signature',
                            
                        ],
                        [
                            'text' => 'H. Supervisión y evaluación',
                            'url'  => '/graficasH',
                            'icon' => 'nav-icon fas fa-solid fa-check-double',
                            
                        ],
                        [
                            'text' => 'I. Programa de Formación, Concientización y Capacitación en materia de Seguridad de la Información',
                            'url'  => '/graficasI',
                            'icon' => 'nav-icon fas fa-solid fa-sitemap',
                            
                        ],
                        [
                            'text' => 'J. Programa de implementación del SRCCA   ',
                            'url'  => '/graficasJ',
                            'icon' => 'nav-icon fas fa-solid fa-book',
                            
                        ],
                    ],
                ],
             
            ],
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
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
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
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
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
