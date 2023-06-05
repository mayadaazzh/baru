<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}
include 'koneksi.php';

$id_tugas = $_GET['id_tugas'];
$id_dosen = $_GET['id_dosen'];

$query11 = "SELECT * FROM dosen WHERE id_dosen = '$id_dosen'";
$result11 = mysqli_query($koneksi, $query11);
$data00 = mysqli_fetch_assoc($result11); // Ambil data mahasiswa

$query22 = "SELECT * FROM dosen WHERE id_dosen = '$id_dosen'";
$result22 = mysqli_query($koneksi, $query22);

$query = "SELECT * FROM tugas WHERE id_tugas = '$id_tugas'";
$result = mysqli_query($koneksi, $query);
$roww = mysqli_fetch_assoc($result);

$query_sudah = "SELECT m.id_mahasiswa, m.Nama, p.file, n.nilai, p.id_pengumpulan
                FROM mahasiswa m
                LEFT JOIN pengumpulan p ON m.id_mahasiswa = p.id_mahasiswa AND p.id_tugas = '$id_tugas'
                LEFT JOIN nilai n ON p.id_pengumpulan = n.id_pengumpulan
                WHERE p.id_tugas = '$id_tugas'";

$query_nilai = "SELECT nilai FROM pengumpulan WHERE id_tugas = '$id_tugas'";
$result_nilai = mysqli_query($koneksi, $query_nilai);

$result_sudah = mysqli_query($koneksi, $query_sudah);

$query_belum = "SELECT m.id_mahasiswa, m.Nama
                FROM mahasiswa m
                LEFT JOIN pengumpulan p ON m.id_mahasiswa = p.id_mahasiswa AND p.id_tugas = '$id_tugas'
                WHERE p.id_pengumpulan IS NULL
                AND m.id_mahasiswa NOT IN (
                    SELECT id_mahasiswa FROM pengumpulan WHERE id_tugas = '$id_tugas'
                )";

$result_belum = mysqli_query($koneksi, $query_belum);
?>

<?php
include('./include/header.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Pengumpulan Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>

<body>

    <div class="content">
        <a href="uploadtugas.php?id_dosen=<?php echo $data00['id_dosen'] ?>" class="btn btn-dark">Back</a>

        <h4>Mahasiswa yang Sudah Mengumpulkan Tugas</h4>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>File Pengumpulan</th>
                    <th>Nilai</th>
                    <th>Hasil</th> <!-- Tambahan kolom hasil nilai -->
                </tr>
            </thead>
            <tbody>

                <?php

                $no = 1;
                while ($row = mysqli_fetch_assoc($result_sudah)) :
                    $rowss = mysqli_fetch_assoc($result_nilai);
                    $data11 = mysqli_fetch_assoc($result22); // Ambil data mahasiswa
                ?>
                    <tr>
                        <th scope="row"><?php echo $no++; ?></th>
                        <td><?php echo $row['Nama']; ?></td>
                        <td><a href="downloadTugasMahasiswa.php?file=<?php echo $row['file']; ?>"><?php echo $row['file']; ?></a></td>

                        <td>
                            <form method="post" action="editnilaiaksi.php">
                                <input type="hidden" name="id_dosen" value="<?php echo $data11['id_dosen']; ?>">
                                <input type="hidden" name="id_pengumpulan" value="<?php echo $row['id_pengumpulan']; ?>">
                                <input type="hidden" name="id_tugas" value="<?php echo $roww['id_tugas']; ?>">
                                <input type="number" name="nilai" class="form-control" min="0" max="100">
                                <button type="submit" class="btn btn-dark"><i class="fas fa-edit"></i> Simpan</button>
                            </form>
                        </td>

                        <td><?php echo $rowss['nilai']; ?></td> <!-- Menampilkan hasil nilai -->
                    </tr>
                <?php endwhile; ?>

            </tbody>
        </table>

        <h4>Mahasiswa yang Belum Mengumpulkan Tugas</h4>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result_belum)) :
                ?>
                    <tr>
                        <th scope="row"><?php echo $no++; ?></th>
                        <td><?php echo $row['Nama']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php
    include('./include/footer.php');
    ?>