<?php
require_once 'auth.php';
require_once 'config/database.php';

// Query for pending records
$pending_query = "SELECT * FROM inward_gatepass WHERE status = 'Pending' ORDER BY id DESC";
$pending_stmt = $pdo->prepare($pending_query);
$pending_stmt->execute();
$pending_records = $pending_stmt->fetchAll(PDO::FETCH_ASSOC);

// Add these new queries for status counts
$pending_count = $pdo->query("SELECT COUNT(*) FROM inward_gatepass WHERE status = 'Pending'")->fetchColumn();
$rejected_count = $pdo->query("SELECT COUNT(*) FROM inward_gatepass WHERE status = 'Rejected'")->fetchColumn();
$received_count = $pdo->query("SELECT COUNT(*) FROM inward_gatepass WHERE status = 'Received'")->fetchColumn();


// Add these queries for counts
$daily_count = $pdo->query("SELECT COUNT(*) FROM inward_gatepass WHERE DATE(date_received) = CURDATE()")->fetchColumn();
$weekly_count = $pdo->query("SELECT COUNT(*) FROM inward_gatepass WHERE YEARWEEK(date_received) = YEARWEEK(CURDATE())")->fetchColumn();
$monthly_count = $pdo->query("SELECT COUNT(*) FROM inward_gatepass WHERE YEAR(date_received) = YEAR(CURDATE()) AND MONTH(date_received) = MONTH(CURDATE())")->fetchColumn();
$yearly_count = $pdo->query("SELECT COUNT(*) FROM inward_gatepass WHERE YEAR(date_received) = YEAR(CURDATE())")->fetchColumn();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Inward Gatepass Management</title>
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
        <div class="text-center text-white mb-2 mx-auto">
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
    <h2>Inward Gatepass Records</h2>
    <a href="create.php" class="btn btn-primary mb-3">Generate New Gate Pass</a>
    <hr>
    <div class="container mt-4">
      <h2>Inward Gatepass Records</h2>
      <!-- Add this summary table before the main table -->
      <div class="row mb-4">
        <div class="col-md-12">
          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th>Today's Records</th>
                <th>This Week's Records</th>
                <th>This Month's Records</th>
                <th>This Year's Records</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $daily_count; ?></td>
                <td><?php echo $weekly_count; ?></td>
                <td><?php echo $monthly_count; ?></td>
                <td><?php echo $yearly_count; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <hr>

      <div class="row mb-4">
        <div class="col-md-12">
          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th>Pending Records</th>
                <th>Rejected Records</th>
                <th>Received Records</th>
                <th>Total Records</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo $pending_count; ?></td>
                <td><?php echo $rejected_count; ?></td>
                <td><?php echo $received_count; ?></td>
                <td><?php echo $pending_count + $rejected_count + $received_count; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <hr>
      <!-- Pending Records Table -->
    <h2 class="mt-4">Pending Gate Pass</h2>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Document No</th>
                <th>Supplied By</th>
                <th>Invoice No</th>
                <th>Item Code</th>
                <th>Nomenclature</th>
                <th>Quantity</th>
                <th>Date Received</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pending_records as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['document_no']); ?></td>
                <td><?php echo htmlspecialchars($row['supplied_by']); ?></td>
                <td><?php echo htmlspecialchars($row['invoice_no']); ?></td>
                <td><?php echo htmlspecialchars($row['item_code']); ?></td>
                <td><?php echo htmlspecialchars($row['nomenclature']); ?></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td><?php echo htmlspecialchars($row['date_received']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </table>
    </div><footer class="footer">
    <div class="container">
      <div class="text-center">
        <p class="mb-0">© <?php echo date('Y'); ?> CORDITE FACTORY ARUVANKADU. All rights reserved.</p>
        <p class="mb-0">An ISO 9001:2015 Certified Organization</p>
      </div>
    </div>
  </footer>
</body>
</html>