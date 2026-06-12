<?php
include 'config/database.php';
include 'config/crypto.php';

$result = mysqli_query($conn, "SELECT id, nik FROM patients");

while ($row = mysqli_fetch_assoc($result)) {
    $id = (int)$row['id'];
    $nik = $row['nik'];

    $nik_encrypted = encryptNik($nik);

    $stmt = mysqli_prepare($conn, "UPDATE patients SET nik_encrypted = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $nik_encrypted, $id);
    mysqli_stmt_execute($stmt);
}

echo "NIK berhasil dienkripsi ke kolom nik_encrypted.";
?>