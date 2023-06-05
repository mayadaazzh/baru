<?php
// koneksi database
include 'koneksi.php';

// menangkap data id yang di kirim dari url
$id = $_GET['id_materi'];
$id_dosen = $_GET['id_dosen'];

// menghapus data dari database
mysqli_query($koneksi, "DELETE FROM `materi` WHERE `id_materi`='$id'");

// mengalihkan halaman kembali ke uploadmateri.php

echo '<script>alert("materi Berhasil dihapus!"); window.location.href = "uploadmateri.php?id_dosen=' . $id_dosen . '";</script>';
