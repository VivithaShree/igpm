<?php
require_once 'auth.php';
require_once 'config/database.php';
require_once 'config/items.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $sql = "INSERT INTO inward_gatepass (document_no, category, supplied_by, mode_of_transport, invoice_no,
      invoice_date, item_code, nomenclature, unit_of_quantity, quantity, date_received, status)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
    $_POST['status']
  ]);
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Create Inward Gatepass</title>
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
    <h2 class="text-center mb-4">New IGP Entry</h2>
    <div class="form-container">
        <form method="POST">
            <!-- First Row -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Document No</label>
                    <input type="text" name="document_no" class="form-control" required>
                </div>
            </div>

            <!-- Second Row -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Supplied By</label>
                    <input type="text" name="supplied_by" class="form-control" required>
                </div>
            </div>

            <!-- Third Row -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Mode of Transport</label>
                    <select name="mode_of_transport" class="form-control" required>
                        <option value="Road">Road</option>
                        <option value="Air">Air</option>
                        <option value="Rail">Rail</option>
                        <option value="Water">Water</option>
                    </select>
                </div>
            </div>

            <!-- Fourth Row - Invoice Details -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Invoice No</label>
                    <input type="text" name="invoice_no" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Invoice Date</label>
                    <input type="date" name="invoice_date" class="form-control" required>
                </div>
            </div>

            <!-- Fifth Row - All Item Details in One Row -->
            <div class="row mb-3">
    <div class="col-md-2">
        <label>Category</label>
        <select name="category" id="category" class="form-control" required>
            <option value="">Select Category</option>
            <?php foreach ($item_categories as $code => $category): ?>
                <option value="<?php echo $code; ?>"><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-2">
        <label>Item Code</label>
        <select name="item_code" id="item_code" class="form-control" required disabled>
            <option value="">Select Item Code</option>
        </select>
    </div>
    <div class="col-md-3">
        <label>Nomenclature</label>
        <select name="nomenclature" id="nomenclature" class="form-control" required disabled>
            <option value="">Select Nomenclature</option>
        </select>
    </div>
    <div class="col-md-2">
        <label>Unit of Quantity</label>
        <select name="unit_of_quantity" class="form-control" required>
            <option value="kg">KG</option>
            <option value="liters">Ltr</option>
            <option value="ton">Tons</option>
            <option value="numbers">Numbers</option>
        </select>
    </div>
    <div class="col-md-2">
        <label>Quantity</label>
        <input type="number" step="0.01" name="quantity" class="form-control" required>
    </div>
</div>


            <!-- Sixth Row - Status and Date in One Row -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Pending">Pending</option>
                        <option value="Received">Received</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Date Received</label>
                    <input type="date" name="date_received" class="form-control" required>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Save IGP Entry</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script>
const items = <?php echo json_encode($item_categories); ?>;

document.getElementById('category').addEventListener('change', function() {
    const category = this.value;
    const itemCodeSelect = document.getElementById('item_code');
    const nomenclatureSelect = document.getElementById('nomenclature');
    
    // Reset and disable dependent dropdowns
    itemCodeSelect.innerHTML = '<option value="">Select Item Code</option>';
    nomenclatureSelect.innerHTML = '<option value="">Select Nomenclature</option>';
    itemCodeSelect.disabled = !category;
    nomenclatureSelect.disabled = true;
    
    if (category) {
        const categoryItems = items[category].items;
        for (const [code, item] of Object.entries(categoryItems)) {
            const option = new Option(`${code} - ${item.name}`, code);
            itemCodeSelect.add(option);
        }
    }
});

document.getElementById('item_code').addEventListener('change', function() {
    const category = document.getElementById('category').value;
    const itemCode = this.value;
    const nomenclatureSelect = document.getElementById('nomenclature');
    
    // Reset and disable nomenclature dropdown
    nomenclatureSelect.innerHTML = '<option value="">Select Nomenclature</option>';
    nomenclatureSelect.disabled = !itemCode;
    
    if (category && itemCode) {
        const subcategories = items[category].items[itemCode].subcategories;
        subcategories.forEach(subcat => {
            const option = new Option(subcat, subcat);
            nomenclatureSelect.add(option);
        });
    }
});
</script></div><footer class="footer">
    <div class="container">
      <div class="text-center">
        <p class="mb-0">© <?php echo date('Y'); ?> CORDITE FACTORY ARUVANKADU. All rights reserved.</p>
        <p class="mb-0">An ISO 9001:2015 Certified Organization</p>
      </div>
    </div>
  </footer>
</body>
</html>