<?php
// koneksi database
include 'koneksi.php';

// menangkap data yang di kirim dari form
$id_dosen = $_POST['id_dosen'];
$query = "SELECT * FROM dosen WHERE id_dosen='$id_dosen'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result); // Inisialisasi $data

$id_pengumpulan = $_POST['id_pengumpulan'];
$nilai = $_POST['nilai'];

// query to update the user's "nilai"
$query = "UPDATE pengumpulan SET nilai='$nilai' WHERE id_pengumpulan = '$id_pengumpulan'";

if (mysqli_query($koneksi, $query)) {
    // jika query dijalankan dan data nilai masuk ke tabel, tampilkan pesan sukses
    echo '<script>alert("nilai Berhasil Ditambahkan!"); window.location.href = "uploadtugas.php?id_dosen=' . $id_dosen . '";</script>';
} else {
    // jika query gagal dijalankan, tampilkan pesan gagal
    echo '<script>alert("gagal masukkan nilai, silahkan coba lagi!"); window.location.href = "datatugas.php?id_dosen=' . $id_dosen . '";</script>';
}
