<?php
include 'alert.php';
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['password'])) {
    echo "<script type='text/javascript'>
                Swal.fire({
                icon: 'error',
                title: 'Login Terlebih Dahulu!!',
                confirmButtonText: 'OK'
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    window.location='../'
                }
                })
          </script>";
    exit;
} elseif ($_SESSION['level'] == 'admin') {
    echo "<script type='text/javascript'>
                Swal.fire({
                icon: 'error',
                title: 'Anda Tidak Memenuhi Persyaratan!!',
                confirmButtonText: 'OK'
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    history.go(-1)
                }
                })
          </script>";
}
include '../index/library/koneksi.php';
include '../index/library/tanggal.php';

if ($_POST) {
    #jika memilih tombol pilih
    if (isset($_POST['btnPilih'])) {
        $id = $_POST['id'];
        $jumlah = $_POST['jumlah'];
        $cek = "SELECT stok FROM tbl_barang WHERE id = '$id'";
        $ada = mysqli_query($koneksi, $cek);
        $stok = mysqli_fetch_assoc($ada)['stok'];
        if ($jumlah > $stok) {
            echo "<script type='text/javascript'>
                        Swal.fire({
                        icon: 'error',
                        title: 'Stok Tidak Tersedia'
                        })
                      </script>";
        } else {
            $brgQuery = "SELECT * FROM tbl_barang WHERE id = '$id'";
            $brgHasil = mysqli_query($koneksi, $brgQuery);
            $brgData = mysqli_fetch_array($brgHasil);
            $brgQty = mysqli_num_rows($brgHasil);

            if ($brgQty >= 1) {
                $besarDiskon = intval($brgData['harga_jual']) * (intval($brgData['diskon']) / 100);
                $hargaDiskon = intval($brgData['harga_jual']) - $besarDiskon;

                $krgQuery = "INSERT INTO tbl_keranjang SET id_barang = '$id', harga_jual = '$hargaDiskon', qty = '$jumlah', username = '$_SESSION[username]'"; //nanti gunakan session login username
                $result = mysqli_query($koneksi, $krgQuery);
                if ($result) {
                    echo "<script type='text/javascript'>
                        Swal.fire({
                        icon: 'success',
                        title: 'Data Masuk Ke Keranjang'
                        })
                      </script>";
                }
            } else {
                echo "<script type='text/javascript'>
                    Swal.fire({
                    icon: 'error',
                    title: 'Masukkan Nama Barang Yang Tersedia'
                    })
                  </script>";
            }
        }
    }
    #jika klik tombol payment
    if (isset($_POST['btnPayment'])) {
        $no_penjualan = rand(1, 99999); //no acak
        $cekKrg = "SELECT COUNT(*) AS qty FROM tbl_keranjang WHERE username = '$_SESSION[username]'";
        $result = mysqli_query($koneksi, $cekKrg);
        $krgRow = mysqli_fetch_array($result);
        if ($krgRow['qty'] <= 0) {
            echo "<script type='text/javascript'>
                    Swal.fire({
                    icon: 'error',
                    title: 'Belum Ada Barang Minimal 1!!',
                    confirmedButtonText: 'OK'
                    }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        history.go(-1)
                    }
                    })
                  </script>";
        } else {
            $queryPenjualan = "INSERT INTO tbl_penjualan SET no_penjualan = '$no_penjualan', tgl_transaksi = now(), username = '$_SESSION[username]', status_trx='1'";
            $queryPenjualan1 = mysqli_query($koneksi, $queryPenjualan);
            if ($queryPenjualan1) {
                //Ambil data dari keranjang belanja
                $cekKrg = "SELECT * FROM tbl_keranjang WHERE username = '$_SESSION[username]'";
                $result = mysqli_query($koneksi, $cekKrg);
                while ($krgRow = mysqli_fetch_array($result)) {
                    //Insert data ke tbl_penjualan_item
                    $queryItem = "INSERT INTO tbl_penjualan_item SET no_penjualan = '$no_penjualan', id_barang = '$krgRow[id_barang]', harga_jual = '$krgRow[harga_jual]', jumlah = '$krgRow[qty]'";
                    mysqli_query($koneksi, $queryItem);
                    //Update Stok Di tbl_barang
                    $queryBarang = "UPDATE tbl_barang SET stok = stok - $krgRow[qty] WHERE id = '$krgRow[id_barang]'";
                    mysqli_query($koneksi, $queryBarang);
                }
                //kosongkan di tbl_keranjang jika data sudah dipindahan
                mysqli_query($koneksi, "DELETE FROM tbl_keranjang WHERE username = '$_SESSION[username]'");
            }
            echo "<meta http-equiv='refresh' content='0;url=../vendor/midtrans/midtrans-php/examples/snap/checkout-process-simple-version.php?no_penjualan=$no_penjualan'>";
        }
    }
    #jika klik tombol bayar
    if (isset($_POST['btnCash'])) {
        $no_penjualan = rand(1, 99999);
        $total = $_POST['total'];
        $bayar = $_POST['bayar'];
        $cekKrg = "SELECT COUNT(*) AS qty FROM tbl_keranjang WHERE username = '$_SESSION[username]'";
        $result = mysqli_query($koneksi, $cekKrg);
        $krgRow = mysqli_fetch_array($result);
        if ($krgRow['qty'] <= 0) {
            echo "<script type='text/javascript'>
                    Swal.fire({
                    icon: 'error',
                    title: 'Belum Ada Barang Minimal 1!!',
                    confirmedButtonText: 'OK'
                    }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        history.go(-1)
                    }
                    })
                  </script>";
        } else {
            if ($bayar < $total) {
                echo "<script type='text/javascript'>
                    Swal.fire({
                    icon: 'error',
                    title: 'Uang Pembayaran Tidak Mencukupi!!'
                    })
                  </script>";
            } else {
                $queryPenjualan = "INSERT INTO tbl_penjualan SET no_penjualan = '$no_penjualan', tgl_transaksi = now(), username = '$_SESSION[username]', status_trx = '0'";
                $queryPenjualan1 = mysqli_query($koneksi, $queryPenjualan);
                if ($queryPenjualan1) {
                    //Ambil data dari keranjang belanja
                    $cekKrg = "SELECT * FROM tbl_keranjang WHERE username = '$_SESSION[username]'";
                    $result = mysqli_query($koneksi, $cekKrg);
                    while ($krgRow = mysqli_fetch_array($result)) {
                        //Insert data ke tbl_penjualan_item
                        $queryItem = "INSERT INTO tbl_penjualan_item SET no_penjualan = '$no_penjualan', id_barang = '$krgRow[id_barang]', harga_jual = '$krgRow[harga_jual]', jumlah = '$krgRow[qty]'";
                        $sukses = mysqli_query($koneksi, $queryItem);
                        //Update Stok Di tbl_barang
                        $queryBarang = "UPDATE tbl_barang SET stok = stok - $krgRow[qty] WHERE id = '$krgRow[id_barang]'";
                        mysqli_query($koneksi, $queryBarang);
                        if ($sukses) {
                            echo "<script type='text/javascript'>
                            Swal.fire({
                                icon: 'success',
                                title: 'Selamat Data berhasil Terjual!!'
                            })
                            </script>";
                        }
                    }
                    //kosongkan di tbl_keranjang jika data sudah dipindahan
                    mysqli_query($koneksi, "DELETE FROM tbl_keranjang WHERE username = '$_SESSION[username]'");
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Kasir</title>
    <link href="../vendor/tailwindcss/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/tailwind-pos-main/css/style.css">
    <!-- <script src="https://unpkg.com/idb/build/iife/index-min.js"></script> -->
    <script src="../vendor/alpine/alpine.min.js"></script>
    <script src="../vendor/tailwind-pos-main/js/script.js"></script>
</head>

<body class="bg-blue-gray-50" x-data="initApp()" x-init="initDatabase()">
    <!-- noprint-area -->
    <div class="hide-print flex flex-row h-screen antialiased text-blue-gray-800">
        <!-- left sidebar -->
        <div class="flex flex-row w-auto flex-shrink-0 pl-4 pr-2 py-4">
            <div class="flex flex-col items-center py-4 flex-shrink-0 w-20 bg-cyan-500 rounded-3xl">
                <a href="#" class="flex items-center justify-center h-14 w-14 bg-cyan-50 text-cyan-700 rounded-2xl pointer-events-none">
                    <p class="text-center" style="font-size: 13px;">POS SYSTEM</p>
                </a>
                <ul class="flex flex-col space-y-2 mt-12">
                    <li>
                        <a href="#" class="flex items-center mb-4 focus:outline-none bg-cyan-300 hover:bg-cyan-200 rounded-2xl">
                            <span class="flex items-center justify-center h-14 w-14 rounded-2xl">
                                <img src="../vendor/icon/cash-register-solid.svg" class="h-7 w-7">
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="laporan.php" class="flex items-center focus:outline-none bg-cyan-300 hover:bg-cyan-200 rounded-2xl">
                            <span class="flex items-center justify-center h-14 w-14 rounded-2xl">
                                <img src="../vendor/icon/file-solid.svg" class="h-7 w-7">
                            </span>
                        </a>
                    </li>
                </ul>
                <a href="logout.php" target="" class="mt-auto flex items-center justify-center h-14 w-14 rounded-2xl focus:outline-none bg-cyan-400 hover:bg-cyan-200">
                    <img src="../vendor/icon/right-from-bracket-solid.svg" alt="Logout" width="20" height="20">
                </a>
            </div>
        </div>

        <!-- page content -->
        <div class="w-full">
            <!-- store menu -->
            <div class="flex flex-col bg-blue-gray-50 h-80 py-4">
                <div class="h-full overflow-hidden">
                    <div class="h-full overflow-y-auto px-2">
                        <div class="bg-blue-gray-100 rounded-3xl flex flex-wrap content-center justify-center h-full">
                            <form action="" method="post" class="w-96 h-60 bg-opacity-80">
                                <h1 class="text-uppercase fw-bold mb-2 font-black text-black text-center">POS SYSTEM</h1> <br>
                                <select name="id" class="form-select w-full h-10 rounded-md mb-4 pl-2">
                                    <option value="0">-- Pilih Barang --</option>
                                    <?php
                                    include '../index/library/koneksi.php';
                                    $query1 = "SELECT * FROM tbl_barang";
                                    $hasil = mysqli_query($koneksi, $query1);
                                    while ($data = mysqli_fetch_array($hasil)) {
                                    ?>
                                        <option value="<?= $data['id']; ?>"><?= $data['nama_barang']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="floatingInput" style="color: #000000; text-align: left;">QTY </label> <br>
                                <input type="text" name="jumlah" class="form-select w-full h-10 rounded-md mb-4 pl-3">
                                <button type="submit" name="btnPilih" class="bg-black text-white rounded-md h-10 w-16 hover:bg-gray-600" style="margin-right: 430px;">Pilih</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of store menu -->

            <!-- right sidebar -->
            <div class="w-full flex flex-col bg-blue-gray-50 h-auto min-h-fit bg-white pr-4 pl-2 py-4">
                <div class="bg-white rounded-3xl flex flex-col h-full shadow py-10 px-3">
                    <!-- cart icon -->
                    <table border="1" class="">
                        <thead align="center">
                            <tr>
                                <td>No</td>
                                <td>Id Barang</td>
                                <td>Nama Barang</td>
                                <td>Harga</td>
                                <td>Diskon</td>
                                <td>Harga Diskon</td>
                                <td>Jumlah</td>
                                <td>Subtotal</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <?php
                        include '../index/library/koneksi.php';
                        $krgQuery = "SELECT tbl_barang.*, tbl_keranjang.id, tbl_keranjang.harga_jual AS harga_jDiskon, tbl_keranjang.qty
                        FROM tbl_barang, tbl_keranjang
                        WHERE tbl_barang.id = tbl_keranjang.id_barang
                        ORDER BY tbl_barang.id DESC";

                        $krgHasil = mysqli_query($koneksi, $krgQuery);

                        $total = 0;
                        $qtyBrg = 0;
                        $no = 0;
                        $allTotal = [];
                        while ($krgData = mysqli_fetch_array($krgHasil)) :
                            $id = $krgData['id'];
                            $subTot = $krgData['qty'] * $krgData['harga_jDiskon'];
                            $total = $total + ($krgData['qty'] * $krgData['diskon']);
                            $qtyBrg = $qtyBrg + $krgData['qty'];
                            $no++;
                            array_push($allTotal, $subTot);
                        ?>
                            <tbody align="center">
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= $krgData['id']; ?></td>
                                    <td><?= $krgData['nama_barang']; ?></td>
                                    <td><?= "RP. " . number_format($krgData['harga_jual'], 2, ',', '.'); ?></td>
                                    <td><?= $krgData['diskon']; ?></td>
                                    <td><?= "Rp. " . number_format($krgData['harga_jDiskon'], 2, ',', '.'); ?></td>
                                    <td><?= $krgData['qty']; ?></td>
                                    <td><?= "Rp. " . number_format($subTot, 2, ',', '.'); ?></td>
                                    <td>
                                        <a href="hapus_keranjang.php?id=<?= $krgData['id']; ?>">
                                            <img src="../vendor/icon/trash-solid.svg" width="15" height="15">
                                        </a>
                                    </td>
                                </tr>
                            <?php
                        endwhile;
                            ?>
                            <form id="formD" method="post" name="formD">
                                <tr>
                                    <td colspan="6" align="right" class="pt-2">
                                        GRAND TOTAL
                                    </td>
                                    <td rowspan="3" class="pt-2"><?= $qtyBrg; ?></td>
                                    <td colspan="2">
                                        <input type="numeric" value="Rp. <?= number_format(array_sum($allTotal), 2, ',', '.'); ?>" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" readonly>
                                        <input type="hidden" name="total" value="<?= array_sum($allTotal) ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" align="right" class="pt-2">
                                        BAYAR
                                    </td>
                                    <td colspan="2">
                                        <input type="numeric" name="bayar" onkeyup="OnChange(this.value)" onkeypress="return isNumberKey(event)" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" align="right" class="pt-2">
                                        KEMBALI
                                    </td>
                                    <td colspan="2">
                                        <input type="numeric" name="txtDisplay" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-cyan-500" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" align="right" class="pt-2">Metode pembayaran</td>
                                    <td colspan="4" align="center" class="pt-2 pl-10">
                                        <button type="submit" name="btnCash" class="bg-black hover:bg-gray-600 rounded-md text-white mr-4 p-2">Cash</button>
                                        <button type="submit" name="btnPayment" class="bg-black hover:bg-gray-600 rounded-md text-white p-2">Payment</button>
                                    </td>
                                </tr>
                            </form>
                            </tbody>
                    </table>
                    <!-- end of payment info -->
                </div>
            </div>
            <!-- end of right sidebar -->
        </div>
    </div>
    <!-- end of noprint-area -->
    <script>
        totalx = document.formD.total.value;
        document.formD.txtDisplay.value = totalx;
        bayarx = document.formD.bayar.value;
        document.formD.txtDisplay.value = bayarx;

        function OnChange(value) {
            totalx = document.formD.total.value;
            bayarx = document.formD.bayar.value;
            kembali = bayarx - totalx;
            document.formD.txtDisplay.value = kembali;
        }
    </script>

</html>