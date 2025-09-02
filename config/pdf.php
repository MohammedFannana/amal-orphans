<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'pdf_a'                 => false,
	'pdf_a_auto'            => false,
	'icc_profile_path'      => '',
    'font_path'          => resource_path('fonts/'),
    'font_data' => [
        'arialarabic' => [
            'R' => 'arial.ttf',     // Regular
            'B' => 'arialbd.ttf',   // Bold
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
    ],
];
