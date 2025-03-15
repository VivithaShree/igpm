<?php
require_once 'config/database.php';

$suppliers = ['Supplier A', 'Supplier B', 'Supplier C', 'Supplier D', 'Supplier E', 'Supplier F', 'Supplier G', 'Supplier H', 'Supplier I', 'Supplier J'];
$transport_modes = ['Road', 'Air', 'Rail', 'Water'];
$items = ['Computer Parts', 'Electronics', 'Raw Materials', 'Chemicals', 'Machine Parts', 'Tools', 'Steel Plates', 'Plastic Parts', 'Oil', 'Spare Parts'];
$units = ['numbers', 'kg', 'liters', 'ton'];
$statuses = ['Pending', 'Received', 'Rejected'];

for ($i = 1; $i <= 100; $i++) {
    $date = date('Y-m-d', strtotime("-" . rand(0, 365) . " days"));
    $invoice_date = date('Y-m-d', strtotime($date . " -1 day"));
    
    $sql = "INSERT INTO inward_gatepass (
        document_no,
        supplied_by,
        mode_of_transport,
        invoice_no,
        invoice_date,
        item_code,
        nomenclature,
        unit_of_quantity,
        quantity,
        date_received,
        status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'DOC-2023-' . str_pad($i, 3, '0', STR_PAD_LEFT),
        $suppliers[array_rand($suppliers)],
        $transport_modes[array_rand($transport_modes)],
        'INV-' . str_pad($i, 3, '0', STR_PAD_LEFT),
        $invoice_date,
        'ITEM' . str_pad($i, 3, '0', STR_PAD_LEFT),
        $items[array_rand($items)],
        $units[array_rand($units)],
        rand(10, 1000) + (rand(0, 100) / 100),
        $date,
        $statuses[array_rand($statuses)]
    ]);
}

echo "100 dummy records have been inserted successfully!";
?>