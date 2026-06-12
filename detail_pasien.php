<?php
include 'config/database.php';

// Tangkap input dan validasi
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0; // cast ke integer

// Prepared statement untuk mencegah SQL Injection
$stmt = $conn->prepare("SELECT * FROM patients WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<h1>Detail Rekam Medis</h1>

<?php if ($row): ?>
    <p>Nama: <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></p>
    <p>Diagnosis: <?php echo htmlspecialchars($row['diagnosis'], ENT_QUOTES, 'UTF-8'); ?></p>
<?php else: ?>
    <p>Data pasien tidak ditemukan.</p>
<?php endif; ?>

<a href="dashboard.php">Kembali</a>