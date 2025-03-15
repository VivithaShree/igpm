
<?php
require_once 'auth.php';
require_once 'config/database.php';
require_once 'config/items.php';
if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit();
}
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM inward_gatepass WHERE id = ?");
$stmt->execute([$id]);
$record = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$record) {
  header("Location: index.php");
  exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $sql = "UPDATE inward_gatepass SET
      document_no = ?, category = ?, supplied_by = ?, mode_of_transport = ?,
      invoice_no = ?, invoice_date = ?, item_code = ?,
      nomenclature = ?, unit_of_quantity = ?, quantity = ?,
      date_received = ?, status = ?
      WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $_POST['document_no'],
    $_POST['category'],
    $_POST['supplied_by'],
    $_POST['mode_of_transport'],
    $_POST['invoice_no'],
    $_POST['invoice_date'],
    $_POST['item_code'],
    $_POST['nomenclature'],
    $_POST['unit_of_quantity'],
    $_POST['quantity'],
    $_POST['date_received'],
    $_POST['status'],
    $id
  ]);
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Inward Gatepass</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Inward Gatepass</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="report.php">Reports</a>
                    </li>
                </ul>
                <div class="text-center text-white mb-2">
                    <h3 class="mb-1">INDIAN ORDNANCE FACTORIES</h3>
                    <h4>CORDITE FACTORY ARUVANKADU</h4>
                </div>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Edit IGP Entry</h2>
        <div class="form-container">
            <form method="POST">
                <!-- First Row -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Document No</label>
                        <input type="text" name="document_no" class="form-control" value="<?php echo htmlspecialchars($record['document_no']); ?>" required>
                    </div>
                </div>

                <!-- Second Row -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Supplied By</label>
                        <input type="text" name="supplied_by" class="form-control" value="<?php echo htmlspecialchars($record['supplied_by']); ?>" required>
                    </div>
                </div>

                <!-- Third Row -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Mode of Transport</label>
                        <select name="mode_of_transport" class="form-control" required>
                            <option value="Road" <?php echo $record['mode_of_transport'] == 'Road' ? 'selected' : ''; ?>>Road</option>
                            <option value="Air" <?php echo $record['mode_of_transport'] == 'Air' ? 'selected' : ''; ?>>Air</option>
                            <option value="Rail" <?php echo $record['mode_of_transport'] == 'Rail' ? 'selected' : ''; ?>>Rail</option>
                            <option value="Water" <?php echo $record['mode_of_transport'] == 'Water' ? 'selected' : ''; ?>>Water</option>
                        </select>
                    </div>
                </div>

                <!-- Fourth Row -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Invoice No</label>
                        <input type="text" name="invoice_no" class="form-control" value="<?php echo htmlspecialchars($record['invoice_no']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label>Invoice Date</label>
                        <input type="date" name="invoice_date" class="form-control" value="<?php echo htmlspecialchars($record['invoice_date']); ?>" required>
                    </div>
                </div>

                <!-- Fifth Row -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label>Category</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach ($item_categories as $code => $category): ?>
                                <option value="<?php echo $code; ?>" <?php echo $record['category'] == $code ? 'selected' : ''; ?>>
                                    <?php echo $category['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Item Code</label>
                        <select name="item_code" id="item_code" class="form-control" required>
                            <option value="<?php echo htmlspecialchars($record['item_code']); ?>"><?php echo htmlspecialchars($record['item_code']); ?></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Nomenclature</label>
                        <select name="nomenclature" id="nomenclature" class="form-control" required>
                            <option value="<?php echo htmlspecialchars($record['nomenclature']); ?>"><?php echo htmlspecialchars($record['nomenclature']); ?></option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Unit of Quantity</label>
                        <select name="unit_of_quantity" class="form-control" required>
                            <option value="kg" <?php echo $record['unit_of_quantity'] == 'kg' ? 'selected' : ''; ?>>KG</option>
                            <option value="liters" <?php echo $record['unit_of_quantity'] == 'liters' ? 'selected' : ''; ?>>Ltr</option>
                            <option value="ton" <?php echo $record['unit_of_quantity'] == 'ton' ? 'selected' : ''; ?>>Tons</option>
                            <option value="numbers" <?php echo $record['unit_of_quantity'] == 'numbers' ? 'selected' : ''; ?>>Numbers</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Quantity</label>
                        <input type="number" step="0.01" name="quantity" class="form-control" value="<?php echo htmlspecialchars($record['quantity']); ?>" required>
                    </div>
                </div>

                <!-- Sixth Row -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Pending" <?php echo $record['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="Received" <?php echo $record['status'] == 'Received' ? 'selected' : ''; ?>>Received</option>
                            <option value="Rejected" <?php echo $record['status'] == 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Date Received</label>
                        <input type="date" name="date_received" class="form-control" value="<?php echo htmlspecialchars($record['date_received']); ?>" required>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update IGP Entry</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <script>
    const items = <?php echo json_encode($item_categories); ?>;
    const currentItemCode = "<?php echo htmlspecialchars($record['item_code']); ?>";
    const currentNomenclature = "<?php echo htmlspecialchars($record['nomenclature']); ?>";

    document.getElementById('category').addEventListener('change', function() {
        const category = this.value;
        const itemCodeSelect = document.getElementById('item_code');
        const nomenclatureSelect = document.getElementById('nomenclature');
        
        itemCodeSelect.innerHTML = '<option value="">Select Item Code</option>';
        nomenclatureSelect.innerHTML = '<option value="">Select Nomenclature</option>';
        
        if (category) {
            const categoryItems = items[category].items;
            for (const [code, item] of Object.entries(categoryItems)) {
                const option = new Option(`${code} - ${item.name}`, code);
                if (code === currentItemCode) option.selected = true;
                itemCodeSelect.add(option);
            }
        }
    });

    document.getElementById('item_code').addEventListener('change', function() {
        const category = document.getElementById('category').value;
        const itemCode = this.value;
        const nomenclatureSelect = document.getElementById('nomenclature');
        
        nomenclatureSelect.innerHTML = '<option value="">Select Nomenclature</option>';
        
        if (category && itemCode) {
            const subcategories = items[category].items[itemCode].subcategories;
            subcategories.forEach(subcat => {
                const option = new Option(subcat, subcat);
                if (subcat === currentNomenclature) option.selected = true;
                nomenclatureSelect.add(option);
            });
        }
    });

    // Trigger initial load of item code and nomenclature
    document.getElementById('category').dispatchEvent(new Event('change'));
    </script>
<!-- Footer -->
</div><footer class="footer">
    <div class="container">
      <div class="text-center">
        <p class="mb-0">© <?php echo date('Y'); ?> CORDITE FACTORY ARUVANKADU. All rights reserved.</p>
        <p class="mb-0">An ISO 9001:2015 Certified Organization</p>
      </div>
    </div>
  </footer>

  </div>
</body>
</html>