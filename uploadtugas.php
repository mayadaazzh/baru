<?php

session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

include 'koneksi.php';

$no = 1;
$id_dosen = $_GET['id_dosen'];
$query = "SELECT * FROM tugas WHERE id_dosen='$id_dosen'";
$result = mysqli_query($koneksi, $query);
?>

<?php

include 'koneksi.php';

$query2 = "SELECT * FROM dosen WHERE id_dosen='$id_dosen'";
$result2 = mysqli_query($koneksi, $query2);
$data0 = mysqli_fetch_assoc($result2);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Dosen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dashboard {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
        }

        .dashboard .nav-link {
            color: #fff;
        }

        .content {
            padding: 20px;
            background-color: #f8f9fa;
        }

        @media (min-width: 992px) {
            .dashboard {
                position: fixed;
                top: 56px;
                bottom: 0;
                left: 0;
                width: 250px;
                overflow-y: auto;
            }

            .content {
                margin-left: 250px;
                height: calc(100vh - 56px);
                overflow-y: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-user-shield me-2"></i> Politeknik Elektronika Negeri Surabaya
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="d-flex ms-auto">
                    <input class="form-control me-2" type="search" placeholder="Cari" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Close Navbar -->

    <div class="dashboard">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active text-white" href="haldosen.php?id_dosen=<?php echo $data0['id_dosen'] ?>"><i class="fas fa-user"></i> Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-white" href="uploadmateri.php?id_dosen=<?php echo $data0['id_dosen'] ?>"><i class="fas fa-book"></i> Materi Kuliah</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-white" href="jadwalmahasiswa.php"><i class="fas fa-calendar-alt"></i> Jadwal Kuliah</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-white" href="uploadtugas.php?id_dosen=<?php echo $data0['id_dosen'] ?>"><i class="fas fa-clipboard"></i> Tugas Kuliah</a>
            </li>

        </ul>
    </div>
    <!-- content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-3 sidebar">
                <!-- Konten sidebar -->
            </div>
            <div class="col-lg-9 col-12">
                <h3 class="text-center" style="margin-top: 20px;">TUGAS MAHASISWA</h3>
                <div class="row my-2">
                    <div class="col-md">
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#tambah">
                            <i class="fa-solid fa-file-arrow-up"></i>&nbsp;Upload
                        </button>
                    </div>
                </div>
                <div class="modal" tabindex="-1" id="tambah">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Tugas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="post" enctype="multipart/form-data" action="aksi_tugas.php">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label">Judul Tugas</label>
                                        <?php
                                        include 'koneksi.php';
                                        $query2 = "SELECT * FROM dosen WHERE id_dosen='$id_dosen'";
                                        $result2 = mysqli_query($koneksi, $query2);
                                        $data2 = mysqli_fetch_assoc($result2);
                                        ?>
                                        <input type="hidden" name="id_dosen" value="<?php echo $data2['id_dosen'] ?>" class="form-control">
                                        <input type="text" name="judul" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Deskripsi</label>
                                        <input type="text" class="form-control" name="deskripsi" id="fileUpload">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Deadline</label>
                                        <input type="datetime-local" name="deadline" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">File</label>
                                        <input type="file" class="form-control" name="file" id="fileUpload">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr class="table-dark text-center">
                            <th>No</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Deadline</th>
                            <th>Action</th>
                        </tr>

                        <?php while ($data = mysqli_fetch_assoc($result)) { ?>

                            <tr>
                                <td><?php echo $no++; ?></td>

                                <td><a href="datatugas.php?id_tugas=<?php echo $data['id_tugas']; ?>&id_dosen=<?php echo $data['id_dosen']; ?>"><?php echo $data['judul']; ?></a></td>
                                <td><?php echo $data['deskripsi']; ?></td>
                                <td><?php echo $data['deadline']; ?></td>
                                <td class="d-flex justify-content-center">
                                    <a href="aksi_hapustugas.php?id_tugas=<?php echo $data['id_tugas']; ?>" class="btn btn-danger mt-2" style="font-weight: 400;" onclick="return confirm('Apakah anda yakin ingin menghapus?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>

                        <?php } ?>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('./include/footer.php');
    ?>