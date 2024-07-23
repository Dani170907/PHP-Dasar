<?php
usleep(500000);
require_once '../assets/functions/functions.php';
$keyword = $_GET["keyword"];
$query = "SELECT * FROM siswa
            WHERE
        nama LIKE '%$keyword%' OR
        nis LIKE '%$keyword%' OR
        alamat LIKE '%$keyword%' OR
        tanggal_lahir LIKE '%$keyword%'
";
$siswa = query($query);
?>
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