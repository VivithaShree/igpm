<?php
$item_categories = [
    'RAW' => [
        'name' => 'Raw Materials',
        'items' => [
            'RAW001' => [
                'name' => 'Nitrocellulose',
                'subcategories' => ['Grade A', 'Grade B', 'Grade C']
            ],
            'RAW002' => [
                'name' => 'Nitroglycerine',
                'subcategories' => ['Industrial Grade', 'Technical Grade']
            ],
            'RAW003' => [
                'name' => 'Stabilizers',
                'subcategories' => ['Diphenylamine', 'Ethyl Centralite', 'Methyl Centralite']
            ]
        ]
    ],
    'CHM' => [
        'name' => 'Chemicals',
        'items' => [
            'CHM001' => [
                'name' => 'Acids',
                'subcategories' => ['Sulfuric Acid', 'Nitric Acid', 'Mixed Acid']
            ],
            'CHM002' => [
                'name' => 'Solvents',
                'subcategories' => ['Ether', 'Acetone', 'Ethanol']
            ]
        ]
    ],
    'MAC' => [
        'name' => 'Machinery',
        'items' => [
            'MAC001' => [
                'name' => 'Processing Equipment',
                'subcategories' => ['Mixer', 'Dryer', 'Extruder']
            ],
            'MAC002' => [
                'name' => 'Testing Equipment',
                'subcategories' => ['Stability Tester', 'Viscometer', 'pH Meter']
            ]
        ]
    ]
];
?>