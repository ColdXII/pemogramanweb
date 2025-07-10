<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Siswa AJAX</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Tambah Siswa (AJAX)</h2>
    <div id="msg"></div>
    <form id="formTambah">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Jenis Kelamin</label><br>
            <input type="radio" name="jk" value="Laki-laki" required> Laki-laki
            <input type="radio" name="jk" value="Perempuan"> Perempuan
        </div>
        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $('#formTambah').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'register_ajax.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if (res.trim() === 'success') {
                    $('#msg').html('<div class="alert alert-success">Data berhasil ditambahkan!</div>');
                    $('#formTambah')[0].reset();
                } else if (res.trim() === 'incomplete') {
                    $('#msg').html('<div class="alert alert-warning">Form belum lengkap.</div>');
                } else {
                    $('#msg').html('<div class="alert alert-danger">Gagal menambahkan data.</div>');
                }
            }
        });
    });
</script>
</body>
</html>