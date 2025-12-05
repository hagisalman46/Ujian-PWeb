<?php
require_once 'functions.php';

$message = '';
$messageType = '';

if (isset($_POST['create'])) {
    if (createMahasiswa($_POST['npm'], $_POST['nama'], $_POST['jurusan'], $_POST['email'])) {
        $message = "Data berhasil ditambahkan!";
        $messageType = "success";
    } else {
        $message = "Gagal menambahkan data!";
        $messageType = "error";
    }
}

if (isset($_POST['update'])) {
    if (updateMahasiswa($_POST['id'], $_POST['npm'], $_POST['nama'], $_POST['jurusan'], $_POST['email'])) {
        $message = "Data berhasil diupdate!";
        $messageType = "success";
    } else {
        $message = "Gagal mengupdate data!";
        $messageType = "error";
    }
}

if (isset($_GET['delete'])) {
    if (deleteMahasiswa($_GET['delete'])) {
        $message = "Data berhasil dihapus!";
        $messageType = "success";
    } else {
        $message = "Gagal menghapus data!";
        $messageType = "error";
    }
}

$editData = null;
if (isset($_GET['edit'])) {
    $editData = getMahasiswaById($_GET['edit']);
}

$mahasiswa = getAllMahasiswa();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="header">
        <h1>📚 Manajemen Data Mahasiswa</h1>
    </div>

    <div class="content">
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="form-section">
            <h2 style="margin-bottom: 20px; color: #333;">
                <?php echo $editData ? '✏️ Edit Data' : '➕ Tambah Data Baru'; ?>
            </h2>
            
            <form method="POST" action="">
                <?php if ($editData): ?>
                    <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label>NPM</label>
                    <input type="text" name="npm" required 
                           value="<?php echo $editData ? $editData['npm'] : ''; ?>" 
                           placeholder="Masukkan NPM">
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" required 
                           value="<?php echo $editData ? $editData['nama'] : ''; ?>" 
                           placeholder="Masukkan nama lengkap">
                </div>

                <div class="form-group">
                    <label>Jurusan</label>
                    <select name="jurusan" required>
                        <option value="">Pilih Jurusan</option>
                        <option value="Teknik Informatika" <?php echo ($editData && $editData['jurusan'] == 'Teknik Informatika') ? 'selected' : ''; ?>>Teknik Informatika</option>
                        <option value="Sistem Informasi" <?php echo ($editData && $editData['jurusan'] == 'Sistem Informasi') ? 'selected' : ''; ?>>Sistem Informasi</option>
                        <option value="Teknik Elektro" <?php echo ($editData && $editData['jurusan'] == 'Teknik Elektro') ? 'selected' : ''; ?>>Teknik Elektro</option>
                        <option value="Manajemen" <?php echo ($editData && $editData['jurusan'] == 'Manajemen') ? 'selected' : ''; ?>>Manajemen</option>
                        <option value="Akuntansi" <?php echo ($editData && $editData['jurusan'] == 'Akuntansi') ? 'selected' : ''; ?>>Akuntansi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required 
                           value="<?php echo $editData ? $editData['email'] : ''; ?>" 
                           placeholder="mahasiswa@email.com">
                </div>

                <?php if ($editData): ?>
                    <button type="submit" name="update" class="btn btn-success">💾 Update Data</button>
                    <a href="?" class="btn btn-warning">❌ Batal</a>
                <?php else: ?>
                    <button type="submit" name="create" class="btn btn-primary">➕ Simpan Data</button>
                <?php endif; ?>
            </form>
        </div>

        <h2 style="margin-bottom: 20px; color: #333;">📋 Daftar Mahasiswa</h2>
        
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NPM</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($mahasiswa) > 0): ?>
                        <?php $no = 1; foreach ($mahasiswa as $mhs): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($mhs['npm']); ?></td>
                                <td><?php echo htmlspecialchars($mhs['nama']); ?></td>
                                <td><?php echo htmlspecialchars($mhs['jurusan']); ?></td>
                                <td><?php echo htmlspecialchars($mhs['email']); ?></td>
                                <td>
                                    <a href="?edit=<?php echo $mhs['id']; ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                                    <a href="?delete=<?php echo $mhs['id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Yakin ingin menghapus data ini?')">🗑️ Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px; color: #999;">
                                Belum ada data mahasiswa
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>