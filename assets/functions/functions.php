<?php

// Koneksi ke database
$connDatabase = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query) {
    global $connDatabase; // memanggil variabel di luar function
    $result = mysqli_query($connDatabase, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}



function tambah($data) {
    global $connDatabase;
    // ambil data dari tiap elemen dalam form
    $nama = htmlspecialchars($data["nama"]);
    $nis = htmlspecialchars($data["nis"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $tanggal_lahir = $data["tanggal_lahir"];

    // upload gambar 
    $gambar = upload();
    if ( !$gambar ) {
        return false;
    }
    
    // query insert data dengan menyebutkan nama kolom-kolom yang akan diisi
    $query = "INSERT INTO siswa (nama, nis, alamat, tanggal_lahir, gambar) VALUES ('$nama', '$nis', '$alamat', '$tanggal_lahir', '$gambar')";
    mysqli_query($connDatabase, $query);

    return mysqli_affected_rows($connDatabase);
}



function upload() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gamabr yang diupload
    if ( $error === 4 ) {
        echo "<script>
                alert('Pilih gambar terlebih dahulu!');
              </script>";
        return false;
    }

    // cek apakah yan diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if ( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
        echo "<script>
                alert('Yang anda upload bukan gambar!');
              </script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranFile > 5000000) {
        echo "<script>
                alert('Ukuran Gambar Terlalu Besar');
              </script>";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'assets/foto/' . $namaFileBaru);

    return $namaFileBaru;
}



function hapus($id) {
    global $connDatabase;
    mysqli_query($connDatabase, "DELETE FROM siswa where id = $id");
    return mysqli_affected_rows($connDatabase);
}



function ubah($data) {
    global $connDatabase;

    // ambil data dari tiap elemen dalam form
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $nis = htmlspecialchars($data["nis"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $tanggal_lahir = $data["tanggal_lahir"];
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek apakah user pilih gambar atau tidak
    if ( $_FILES['gambar']['error'] === 4 ) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    // query update data
    $query = "UPDATE siswa SET
                nama = '$nama',
                nis = '$nis',
                alamat = '$alamat',
                tanggal_lahir = '$tanggal_lahir',
                gambar = '$gambar'
            WHERE id = $id    
                ";
    mysqli_query($connDatabase, $query);

    return mysqli_affected_rows($connDatabase);
}



function cari($keyword) {
    global $connDatabase;
    $keyword = mysqli_real_escape_string($connDatabase, $keyword);
    $query = "SELECT * FROM siswa
                WHERE
            nama LIKE '%$keyword%' OR
            nis LIKE '%$keyword%' OR
            alamat LIKE '%$keyword%' OR
            tanggal_lahir LIKE '%$keyword%'
            ";
    return query($query);
}



function registrasi($data) {
    global $connDatabase;

    $username = strtolower(stripslashes($data["username"]));
    $email = strtolower($data["email"]);
    $password = mysqli_real_escape_string($connDatabase, $data["password"]);
    $password2 = mysqli_real_escape_string($connDatabase, $data["password2"]);

    // cek email sudah ada atau belum
    $result = mysqli_query($connDatabase, "SELECT email FROM users WHERE email = '$email'");
    
    if (mysqli_fetch_assoc($result)) {
        echo "
        <script>
            alert('Alamat Email Sudah Terdaftar!');
        </script>"; 
        return false;  
    }

    // cek konfirmasi password
    if ( $password !== $password2 ) {
        echo "
        <script>
            alert('Konfirmasi password tidak sesuai!');
        </script>
        ";
    return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan userbaru ke database
    mysqli_query($connDatabase, "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");

    return mysqli_affected_rows($connDatabase);
}
?>
