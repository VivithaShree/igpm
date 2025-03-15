<?php
require_once 'config/database.php';
if (isset($_GET['id'])) {
  $stmt = $pdo->prepare("DELETE FROM inward_gatepass WHERE id = ?");
  $stmt->execute([$_GET['id']]);
}
header("Location: index.php");
exit();
?>
