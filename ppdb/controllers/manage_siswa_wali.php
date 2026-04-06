<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kelola Data Siswa dan Wali Siswa</title>
    <link rel="stylesheet" href="../assets/css/dashboard_admin.css" />
</head>
<body>
    <header class="header">
        <div class="container header-container">
            <h1>Kelola Data Siswa dan Wali Siswa</h1>
            <a href="dashboard_admin.php" class="btn-primary">Kembali ke Dashboard</a>
        </div>
    </header>

    <main class="container">
        <?php if (!empty($error)): ?>
            <div role="alert" style="color: red; margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div role="alert" style="color: green; margin-bottom: 1rem;"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if ($editSiswa): ?>
            <section>
                <h2>Edit Data Siswa</h2>
                <form method="post" action="manage_siswa_wali.php">
                    <input type="hidden" name="id_siswa" value="<?= (int)$editSiswa['id_siswa'] ?>" />
                    <label>
                        Nama Siswa:
                        <input type="text" name="nama_siswa" value="<?= htmlspecialchars($editSiswa['nama_siswa']) ?>" required />
                    </label><br/>
                    <label>
                        NIK Siswa:
                        <input type="text" name="nik_siswa" value="<?= htmlspecialchars($editSiswa['nik_siswa']) ?>" required />
                    </label><br/>
                    <label>
                        Jenis Kelamin:
                        <select name="jenis_kelamin_siswa" required>
                            <option value="L" <?= $editSiswa['jenis_kelamin_siswa'] === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= $editSiswa['jenis_kelamin_siswa'] === 'P' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </label><br/>
                    <label>
                        Umur:
                        <input type="number" name="umur_siswa" value="<?= (int)$editSiswa['umur_siswa'] ?>" required />
                    </label><br/>
                    <label>
                        Alamat:
                        <textarea name="alamat_siswa" required><?= htmlspecialchars($editSiswa['alamat_siswa']) ?></textarea>
                    </label><br/>
                    <button type="submit" name="update_siswa" class="btn-primary">Simpan Perubahan</button>
                    <a href="manage_siswa_wali.php">Batal</a>
                </form>
            </section>
        <?php elseif ($editWali): ?>
            <section>
                <h2>Edit Data Wali Siswa</h2>
                <form method="post" action="manage_siswa_wali.php">
                    <input type="hidden" name="id_wali" value="<?= (int)$editWali['id_wali'] ?>" />
                    <label>
                        Nama Wali:
                        <input type="text" name="nama_wali" value="<?= htmlspecialchars($editWali['nama_wali']) ?>" required />
                    </label><br/>
                    <label>
                        NIK Wali:
                        <input type="text" name="nik_wali" value="<?= htmlspecialchars($editWali['nik_wali']) ?>" required />
                    </label><br/>
                    <label>
                        Hubungan Wali:
                        <input type="text" name="hubungan_wali" value="<?= htmlspecialchars($editWali['hubungan_wali']) ?>" required />
                    </label><br/>
                    <label>
                        Alamat Wali:
                        <textarea name="alamat_wali" required><?= htmlspecialchars($editWali['alamat_wali']) ?></textarea>
                    </label><br/>
                    <button type="submit" name="update_wali" class="btn-primary">Simpan Perubahan</button>
                    <a href="manage_siswa_wali.php">Batal</a>
                </form>
            </section>
        <?php else: ?>
            <section>
                <h2>Daftar Wali Siswa</h2>
                <table border="1" cellpadding="8" style="margin-bottom: 2rem;">
                    <thead>
                        <tr>
                            <th>Nama Wali</th>
                            <th>NIK Wali</th>
                            <th>Hubungan</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($waliList as $wali): ?>
                            <tr>
                                <td><?= htmlspecialchars($wali['nama_wali']) ?></td>
                                <td><?= htmlspecialchars($wali['nik_wali']) ?></td>
                                <td><?= htmlspecialchars($wali['hubungan_wali']) ?></td>
                                <td><?= htmlspecialchars($wali['alamat_wali']) ?></td>
                                <td>
                                    <a href="manage_siswa_wali.php?action=edit_wali&id_wali=<?= (int)$wali['id_wali'] ?>">Edit</a>
                                    |
                                    <a href="manage_siswa_wali.php?action=delete_wali&id_wali=<?= (int)$wali['id_wali'] ?>" onclick="return confirm('Yakin hapus data wali ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <section>
                <h2>Daftar Siswa</h2>
                <table border="1" cellpadding="8">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>NIK Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th>Umur</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($siswaList as $siswa): ?>
                            <tr>
                                <td><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                                <td><?= htmlspecialchars($siswa['nik_siswa']) ?></td>
                                <td><?= htmlspecialchars($siswa['jenis_kelamin_siswa']) ?></td>
                                <td><?= (int)$siswa['umur_siswa'] ?></td>
                                <td><?= htmlspecialchars($siswa['alamat_siswa']) ?></td>
                                <td>
                                    <a href="manage_siswa_wali.php?action=edit&id_siswa=<?= (int)$siswa['id_siswa'] ?>">Edit</a>
                                    |
                                    <a href="manage_siswa_wali.php?action=delete&id_siswa=<?= (int)$siswa['id_siswa'] ?>" onclick="return confirm('Yakin hapus data siswa ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
