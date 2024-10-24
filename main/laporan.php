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

<body class="bg-blue-gray-50">
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
                        <a href="index.php" class="flex items-center mb-4 bg-cyan-300 hover:bg-cyan-200 rounded-2xl">
                            <span class="flex items-center justify-center h-14 w-14 rounded-2xl">
                                <img src="../vendor/icon/cash-register-solid.svg" class="h-7 w-7">
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center bg-cyan-300 hover:bg-cyan-200 rounded-2xl">
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
        <div class="w-full flex flex-col bg-blue-gray-50 h-auto min-h-fit bg-white pr-4 pl-2 py-4">
            <div class="bg-white rounded-3xl flex flex-col h-full shadow py-10 px-3">
                <!-- cart icon -->
                <table class="border-collapse border">
                    <thead align="center">
                        <tr>
                            <td class="border">No</td>
                            <td class="border">Order ID</td>
                            <td class="border">Nama Barang</td>
                            <td class="border">Jumlah</td>
                            <td class="border">Tanggal Transaksi</td>
                            <td class="border">Status transaksi</td>
                        </tr>
                    </thead>
                    <?php
                    $tgl = date("Y-m-d");
                    $no = 1;
                    $query = "SELECT tbl_penjualan.*, tbl_penjualan_item.*, tbl_barang.*
                              FROM tbl_penjualan JOIN tbl_penjualan_item ON tbl_penjualan.no_penjualan = tbl_penjualan_item.no_penjualan
                                                 JOIN tbl_barang ON tbl_penjualan_item.id_barang = tbl_barang.id
                                                 WHERE tbl_penjualan.username = '$_SESSION[username]' AND tbl_penjualan.tgl_transaksi = '$tgl'
                                                 ORDER BY tbl_penjualan_item.id_barang DESC;  ";
                    $hasil = mysqli_query($koneksi, $query);
                    while ($data = mysqli_fetch_array($hasil)) {
                    ?>
                        <tbody align="center">
                            <tr>
                                <td class="border"><?= $no; ?></td>
                                <td class="border"><?= $data['no_penjualan']; ?></td>
                                <td class="border"><?= $data['nama_barang']; ?></td>
                                <td class="border"><?= $data['jumlah']; ?></td>
                                <td class="border"><?= $data['tgl_transaksi']; ?></td>
                                <td class="border">
                                    <?php if ($data['status_trx'] == 0) { ?>
                                        <span>Cash</span>
                                    <?php } else { ?>
                                        <span>Payment Succsess</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php
                        $no++;
                    }
                        ?>
                        </tbody>
                </table>
                <!-- end of payment info -->
            </div>
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