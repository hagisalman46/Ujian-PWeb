<?php
require_once 'config.php';

function createMahasiswa($npm, $nama, $jurusan, $email) {
    global $pdo;
    $sql = "INSERT INTO mahasiswa (npm, nama, jurusan, email) VALUES (:npm, :nama, :jurusan, :email)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['npm' => $npm, 'nama' => $nama, 'jurusan' => $jurusan, 'email' => $email]);
}

function getAllMahasiswa() {
    global $pdo;
    $sql = "SELECT * FROM mahasiswa ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMahasiswaById($id) {
    global $pdo;
    $sql = "SELECT * FROM mahasiswa WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateMahasiswa($id, $npm, $nama, $jurusan, $email) {
    global $pdo;
    $sql = "UPDATE mahasiswa SET npm=:npm, nama=:nama, jurusan=:jurusan, email=:email WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id, 'npm' => $npm, 'nama' => $nama, 'jurusan' => $jurusan, 'email' => $email]);
}

function deleteMahasiswa($id) {
    global $pdo;
    $sql = "DELETE FROM mahasiswa WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute(['id' => $id]);
}
?>