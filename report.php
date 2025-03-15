<?php
require_once 'auth.php';
require_once 'config/database.php';
// Pagination settings
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;
// Get total records count
$total_query = "SELECT COUNT(*) as count FROM inward_gatepass";
$total_stmt = $pdo->query($total_query);
$total_records = $total_stmt->fetch(PDO::FETCH_ASSOC)['count'];
$total_pages = ceil($total_records / $records_per_page);
// Get records for current page
$query = "SELECT * FROM inward_gatepass ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
$statement = $pdo->prepare($query);
$statement->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$records = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Inward Gatepass Reports</title>
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
    <h2>Inward Gatepass Reports</h2>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Document No</th>
          <th>Supplied By</th>
          <th>Mode of Transport</th>
          <th>Invoice No</th>
          <th>Invoice Date</th>
          <th>Item Code</th>
          <th>Nomenclature</th>
          <th>Quantity</th>
          <th>Unit</th>
          <th>Date Received</th>
          <th>Status</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($records as $row): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['document_no']); ?></td>
          <td><?php echo htmlspecialchars($row['supplied_by']); ?></td>
          <td><?php echo htmlspecialchars($row['mode_of_transport']); ?></td>
          <td><?php echo htmlspecialchars($row['invoice_no']); ?></td>
          <td><?php echo htmlspecialchars($row['invoice_date']); ?></td>
          <td><?php echo htmlspecialchars($row['item_code']); ?></td>
          <td><?php echo htmlspecialchars($row['nomenclature']); ?></td>
          <td><?php echo htmlspecialchars($row['quantity']); ?></td>
          <td><?php echo htmlspecialchars($row['unit_of_quantity']); ?></td>
          <td><?php echo htmlspecialchars($row['date_received']); ?></td>
          <td><?php echo htmlspecialchars($row['status']); ?></td>
          <td><?php echo htmlspecialchars($row['created_at']); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <!-- Pagination -->
    <nav aria-label="Page navigation">
      <ul class="pagination">
        <?php if($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?php echo ($page-1); ?>">Previous</a>
          </li>
        <?php endif; ?>
        <?php for($i = 1; $i <= $total_pages; $i++): ?>
          <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>
        <?php if($page < $total_pages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?php echo ($page+1); ?>">Next</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
  </div><footer class="footer">
    <div class="container">
      <div class="text-center">
        <p class="mb-0">© <?php echo date('Y'); ?> CORDITE FACTORY ARUVANKADU. All rights reserved.</p>
        <p class="mb-0">An ISO 9001:2015 Certified Organization</p>
      </div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>