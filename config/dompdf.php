<?php
use Dompdf\Dompdf;

return [
    'extensions' => [
        'dompdf/lib/php-font-lib',
        'dompdf/lib/php-svg-lib',
        // Otras extensiones si es necesario
    ],

    'font_dir' => base_path('vendor/dompdf/dompdf/lib/fonts'),
    'font_cache' => storage_path('fonts'),
    'temp_dir' => storage_path('temp'),
    'chroot' => base_path(),
    // ...

];

$dompdf = new Dompdf();

// Set options directly on the Dompdf instance
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);
