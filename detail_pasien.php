<?php
include 'config/database.php';
include 'config/crypto.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM patients WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<h1>Detail Rekam Medis</h1>

<?php if ($row): ?>
    <?php
    // Jika nik_encrypted ada, decrypt. Jika kosong/NULL, pakai nik biasa.
    if (!empty($row['nik_encrypted'])) {
        $nikAsli = decryptNik($row['nik_encrypted']);

        if (empty($nikAsli)) {
            $nikAsli = $row['nik'];
        }
    } else {
        $nikAsli = $row['nik'];
    }
    ?>

    <p>Nama: <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></p>

    <p>
        NIK:
        <input type="password" id="nikField"
               value="<?php echo htmlspecialchars($nikAsli, ENT_QUOTES, 'UTF-8'); ?>"
               readonly>
        <button type="button" onclick="toggleNik()">👁</button>
    </p>

    <p>Diagnosis: <?php echo htmlspecialchars($row['diagnosis'], ENT_QUOTES, 'UTF-8'); ?></p>
<?php else: ?>
    <p>Data pasien tidak ditemukan.</p>
<?php endif; ?>

<a href="dashboard.php">Kembali</a>

<script>
function toggleNik() {
    const field = document.getElementById("nikField");

    if (field.type === "password") {
        field.type = "text";
    } else {
        field.type = "password";
    }
}
</script>