<?php
include 'config/database.php';

function maskNik($nik) {
    if (strlen($nik) <= 8) {
        return str_repeat("*", strlen($nik));
    }

    return substr($nik, 0, 4) . "********" . substr($nik, -4);
}

// Tangkap input, lalu escape agar aman
$name = $_GET['q'] ?? '';
$name = "%$name%";

// Gunakan prepared statement untuk mencegah SQL Injection
$stmt = mysqli_prepare($conn, "SELECT * FROM patients WHERE name LIKE ?");
mysqli_stmt_bind_param($stmt, "s", $name);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

echo "<h1>Hasil Pencarian Pasien:</h1>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "Nama: " . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') .
         " | NIK: " . htmlspecialchars(maskNik($row['nik']), ENT_QUOTES, 'UTF-8') .
         "<br>";
}
?>