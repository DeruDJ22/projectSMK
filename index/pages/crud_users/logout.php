<?php
include 'alert.php';
session_start();

$akun = session_destroy();
session_unset();
session_reset();
$_SESSION = [];
if ($akun) {
  echo "<script type='text/javascript'>
          Swal.fire({
            icon: 'success',
            title: 'Anda Berhasil Logout',
            confirmedButtonText: 'OK'
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              window.location='../../../'
            }
          })
        </script>";
}
