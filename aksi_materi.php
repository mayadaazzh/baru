<?php
// koneksi database
include 'koneksi.php';

// menangkap data yang di kirim dari form
$title = $_POST['title'];
$id_dosen = $_POST['id_dosen'];

$rand = rand();
$ekstensi =  array('png', 'jpg', 'jpeg', 'gif', 'pdf', 'docx');
$filename = $_FILES['materi']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

if (in_array($ext, $ekstensi)) {
    $xx = $rand . '_' . $filename;
    move_uploaded_file($_FILES['materi']['tmp_name'], 'materi/' . $rand . '_' . $filename);
    mysqli_query($koneksi, "insert into materi values('','$id_dosen','$title','$xx')");

    // Redirect to uploadmateri.php with the id_dosen parameter in the URL and display the alert
    echo '<script>alert("Materi berhasil ditambahkan!"); window.location.href = "uploadmateri.php?id_dosen=' . $id_dosen . '";</script>';
    exit;
} else {
    // Redirect to uploadmateri.php with the id_dosen parameter in the URL and display the alert
    echo '<script>alert("Gagal mengunggah materi!"); window.location.href = "uploadmateri.php?id_dosen=' . $id_dosen . '";</script>';
    exit;
}
