<?php

session_start();

if ( !isset($_SESSION["login"]) ) { 
    header("Location: login.php");
    exit;
}

require 'assets/functions/functions.php';

// ambil data di URL
$id = $_GET["id"];
// query data siswa berdasarkan id
$ssw = query("SELECT * FROM siswa WHERE id = $id")[0];


// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
    // cek apakah data berhasil di ubah atau tidak 
    if ( ubah($_POST) > 0 ) {
        echo "
        <script>
            alert('Data berhasil diubah');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data gagal diubah');
            document.location.href = 'index.php';
        </script>
        ";
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Siswa</title>
</head>
<link rel="stylesheet" href="style.css">
<body>
    <h1>Ubah Data Siswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $ssw["id"]; ?>">
        <input type="hidden" name="gambarLama" value="<?= $ssw["gambar"]; ?>">
        <ul>
            <li>
                <label for="nama">Nama: </label>
                <input type="text" name="nama" id="nama" require
                value="<?= $ssw['nama']; ?>">
            </li>
            <li>
                <label for="nis">NIS: </label>
                <input type="text" name="nis" id="nis"
                value="<?= $ssw['nis']; ?>">
            </li>
            <li>
                <label for="alamat">Alamat: </label>
                <input type="text" name="alamat" id="alamat"
                value="<?= $ssw['alamat']; ?>">
            </li>
            <li>
                <label for="tanggal_lahir">tanggal_lahir: </label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                value="<?= $ssw['tanggal_lahir']; ?>">
            </li>
            <li>
                <label for="gambar">Gambar: </label><br>
                <img src="assets/foto/<?= $ssw['gambar'] ?>" width="70" alt=""><br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">ubah Data!</button>
            </li>
        </ul>


    </form>
</body>
</html>
