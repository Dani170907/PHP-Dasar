    <?php 

    session_start();

    if ( !isset($_SESSION["login"]) ) { 
        header("Location: login.php");
        exit;
    }

    require 'assets/functions/functions.php';

    $siswa = query("SELECT * FROM siswa");
    // tombol cari ditekan
    if ( isset($_POST["cari"])) {
        $siswa = cari($_POST["keyword"]);
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <title>Halaman Admin</title>
        <style>
            .loader {
                width: 100px;
                position: absolute;
                top: 120px;
                z-index: -1;
                left: 150;
                display: none;
            }

            @media print{
                .logout, .tambah, .formCari, .aksi {
                    display: none;
                }
            }
            </style>
        <script src="assets/js/jquery-3.7.1.min.js"></script>
        <script src="assets/js/script.js"></script>

    </head>
    <body>
        
    <a href="logout.php" class="logout">Logout</a> | <a href="print.php" target="_blank">Print</a>

    <h1>Daftar Siswa</h1>

    <a href="tambah.php">Tambah Data Siswa</a>
    <br><br>

    <form actions="" method="post">
        <input type="text" name="keyword" size="50" autofocus 
            placeholder="masukkan keyword pencarian" autocomplete="off" id="keyword">
        <button type="submit" name="cari" id="tombolCari">Cari!</button>

        <img src="assets/elemen/Loading_icon.gif" class="loader">
    </form>

    <br><br>

    <div id="container">
        <table border="1" cellpadding="10">
            
            <tr>
                <th>No.</th>
                <th>Aksi</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Nis</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Status</th>
            </tr>
            <?php $id=1;?>
            <?php foreach( $siswa as $row) : ?>
            <tr>
                <td><?= $id ?></td>
                <td>
                    <a href="ubah.php?id=<?= $row['id'] ?>">Ubah</a> | 
                    <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('yakin?')">hapus</a>
                </td>
                <td><img src="assets/foto/<?= $row['gambar'] ?>" width="50px"></td>
                <td><?= $row['nis']?></td>
                <td><?= $row['nama']?></td>
                <td><?= $row['tanggal_lahir']?></td>
                <td><?= $row['alamat']?></td>
                <td><?= $row['status']?></td>
            </tr>
            <?php $id++ ?>
            <?php endforeach; ?>
        </table>
    </div>
    </body>
    </html>
