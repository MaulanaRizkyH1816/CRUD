<?php include "tema/head.php" ?>
<?php include "config.php" ?>
<?php session_start();
var_dump($_SERVER['SERVER_NAME']);
//jika tombol disimpan diklik
if (isset($_POST['bsimpan'])) {
    //pengujian apakah data akan diedit atau disimpan baru
    if ($_GET['hal'] == 'edit') {
        //maka data akan diedit

        $edit = mysqli_query($koneksi, "UPDATE tmhs set
                        nim ='$_POST[tnim]',
                        nama ='$_POST[tnama]',
                        alamat ='$_POST[talamat]',
                        prodi ='$_POST[tprodi]',
                        jenis_kelamin ='$_POST[tjenis_kelamin]'
                        WHERE nim = '$_GET[id]'
         ");


        if ($edit) {
            echo "<script> 
            alert('edit data sukses !');
            document.location='index.php';
        </script>";
        } else {
            echo "<script> 
            alert('edit data gagal !');
            document.location='index.php';
        </script>";
        }
    } else {
        //data akan disimpan baru

        $simpan = mysqli_query($koneksi, "INSERT INTO tmhs(nim, nama, alamat, prodi, jenis_kelamin)
        VALUES ('$_POST[tnim]',
                '$_POST[tnama]',
                '$_POST[talamat]',
                '$_POST[tprodi]',
                '$_POST[tjenis_kelamin]')
        ");

        $simpanPassword = mysqli_query($koneksi, "INSERT INTO login VALUES('NULL', '$_POST[tnim]', '$_POST[tpassword]')");

        if ($simpan && $simpanPassword) {
            echo "<script> 
                alert('Simpan data sukses !');
                document.location='index.php';
            </script>";
        } else {
            echo "<script> 
                alert('Simpan data gagal !');
                document.location='index.php';
            </script>";
        }
    }
}
//pengujian jika tombol edit hapus diklik
if (isset($_GET['hal'])) {
    //pengujian jika edit data
    if ($_GET['hal'] == "edit") {
        $tampil = mysqli_query($koneksi, "SELECT* FROM tmhs WHERE nim = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            $vnim = $data['nim'];
            $vnama = $data['nama'];
            $valamat = $data['alamat'];
            $vprodi = $data['prodi'];
            $vjenis_kelamin = $data['jenis_kelamin'];
        }
    } else if ($_GET['hal'] == "hapus") {
        //persiapan hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE nim = '$_GET[id]' ");
        if ($hapus) {
            echo "<script> 
                alert('Hapus data Berhasil !');
                document.location='index.php';
                </script>";
        }
    }
}

?>

<div class="container">
    <h1 class="text-center">CRUD PHP & PHP DASAR</h1>
    <h2 class="text-center">PILIHAN MAHASISWA</h2>

    <!-- Awal Card Form -->
    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            Form Input Data Mahasiswa
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="tnim" value="<?= @$vnim ?>" class="form-control" placeholder="Input nim anda di sini !" required>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="tnama" value="<?= @$vnama ?>" class="form-control" placeholder="Input Nama anda di sini !" required>
                </div>
                <?php if(!(isset($_GET['hal'])=='edit')) :?>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="tpassword" value="<?= @$vpassword ?>" class="form-control" placeholder="Input Password Anda di sini !" required>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="talamat" class="form-control" placeholder="Input Alamat anda disini!"><?= @$valamat ?></textarea>
                </div>
                <div class="form-group">
                    <label>Program Studi</label>
                    <select name="tprodi" class="form-control">
                        <option value="<?= @$vprodi ?>"><?= @$vprodi ?></option>
                        <option value="D3-M!">D3-MI</option>
                        <option value="S1-TI">S1-TI</option>
                        <option value="S1-SI">S1-SI</option>
                        <option value="S1-ARSITEKTUR">S1-ARSITEKTUR</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="tjenis_kelamin" class="form-control">
                        <option value="<?= @$vjenis_kelamin ?>"><?= @$vjenis_kelamin ?></option>
                        <option value="P">P</option>
                        <option value="L">L</option>
                    </select>
                </div>



                <button type="submit" class="btn btn-secondary" name="bsimpan">Simpan</button>
                <button type="reset" class="btn btn-danger" name="briset">Reset</button>
                <?php if (isset($_SESSION['logged'])) : ?>
                    <a class="btn btn-primary"><?= $_SESSION['username']; ?></a>
                    
                    <a class="btn btn-success" href="/login/logout.php">Logout</a>
                <?php else : ?>
                    <a class="btn btn-primary" href="/login/login.php">Login</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <!-- Akhir Card Form -->

    <?php if(isset($_SESSION['logged'])): ?>
    <!-- Awal Card table -->
    <div class="card mt-3">
        <div class="card-header bg-success text-white">
            Daftar Mahasiswa
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th> No.</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Program Studi</th>
                    <th>Jenis Kelamin</th>
                    <th>Aksi</th>
                </tr>
                <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * from tmhs order by nim desc");
                while ($data = mysqli_fetch_array($tampil)) :
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data['nim'] ?></td>
                        <td><?= $data['nama'] ?> </td>
                        <td><?= $data['alamat'] ?></td>
                        <td><?= $data['prodi'] ?></td>
                        <td><?= $data['jenis_kelamin'] ?></td>

                        <td>
                            <a href="index.php?hal=edit&id=<?= $data['nim'] ?>" class="btn btn-warning">Edit</a>
                            <a href="index.php?hal=hapus&id=<?= $data['nim'] ?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; //Penutup perulangan while
                ?>
            </table>
        </div>
    </div>
    <!-- Akhir Card table -->
                <?php endif; ?>

</div>

<?php require "tema/footer.php" ?>