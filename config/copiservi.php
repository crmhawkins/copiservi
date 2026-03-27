<?php

return [
    'branding' => [
        'name' => 'COPISERVI',
        'colors' => [
            'purple' => '#2e119c',
            'blue' => '#000099',
            'muted' => '#666699',
            'mutedLight' => '#CCCCFF',
        ],
    ],

    // En el proyecto viejo se leía de panel/bono*.txt. Aquí lo configuramos por ENV.
    // Bonos solicitados: 400, 250, 545 y 1200.
    'bonos' => array_values(array_filter([
        env('COPISERVI_BONO_1', 400),
        env('COPISERVI_BONO_2', 250),
        env('COPISERVI_BONO_3', 545),
        env('COPISERVI_BONO_4', 1200),
    ], fn ($v) => $v !== null && $v !== '')),
];

