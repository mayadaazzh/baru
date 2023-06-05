<?php
// koneksi database
include 'koneksi.php';

// menangkap data id yang di kirim dari url

$id = $_GET['id_tugas'];
$id_dosen = $_GET['id_dosen'];

// menghapus data dari database
mysqli_query($koneksi, "DELETE FROM `tugas` WHERE `id_tugas`='$id'");

// mengalihkan halaman kembali ke uploadmateri.php

echo '<script>alert("Tugas Berhasil dihapus!"); window.location.href = "uploadtugas.php?id_dosen=' . $id_dosen . '";</script>';
