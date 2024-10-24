<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendor/bootstrap-5.2.0-dist/css/bootstrap.css">
    <title>User Login</title>
    <style>
        body {
            background-image: linear-gradient(180deg,
                    hsl(244deg 96% 26%) 3%,
                    hsl(268deg 100% 25%) 39%,
                    hsl(281deg 100% 23%) 49%,
                    hsl(294deg 100% 22%) 56%,
                    hsl(306deg 100% 23%) 62%,
                    hsl(315deg 100% 25%) 67%,
                    hsl(323deg 100% 27%) 72%,
                    hsl(328deg 100% 29%) 76%,
                    hsl(333deg 100% 30%) 80%,
                    hsl(338deg 100% 31%) 84%,
                    hsl(342deg 100% 32%) 87%,
                    hsl(345deg 100% 32%) 91%,
                    hsl(348deg 100% 33%) 94%,
                    hsl(352deg 100% 33%) 97%,
                    hsl(0deg 87% 35%) 100%);
        }
    </style>
</head>

<body>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white bg-opacity-75" style="border-radius: 24px;">
                    <div class="card-body p-5 text-center">
                        <div class="mt-md-4 pb-5">
                            <img src="vendor/foto/logocn.png" alt="logocn" width="200px"> <br><br>
                            <h2 class="text-uppercase fw-bold mb-2">Login</h2>
                            <p class="text-white-50 mb-5">Masukkan Username dan Password</p>
                            <form action="cek.php" method="post">
                                <div class="form-floating form-outline form-light mb-4">
                                    <input type="text" name="username" class="form-control" id="floatingInput" placeholder="user">
                                    <label for="floatingInput" style="color: #000000; text-align: left;">Username</label>
                                </div>
                                <div class="form-floating form-outline form-light mb-4">
                                    <input type="password" name="password" class="form-control" id="floatingInput" placeholder="pass">
                                    <label for="floatingInput" style="color: #000000; text-align: left;">Password</label>
                                </div>
                                <button class="btn btn-outline-light btn-lg px-5" type="submit" name="login">Login</button>
                            </form>
                            <form>
                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <a href="#!" class="text-white" style="margin-right: 20px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
                                        </svg>
                                    </a>
                                    <a href="#!" class="text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                        </svg>
                                    </a>
                                    <a href="#!" class="text-white" style="margin-left: 20px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                            <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                                        </svg>
                                    </a>
                                </div>
                            </form>
                        </div>
                        <!-- <div>
                            <p class="mb-0">Don't have an account? <a href="register.php" class="text-white-50 fw-bold">Sign Up</a>
                            </p>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="index/library/bootstrap-5.2.0-dist/js/bootstrap.js"></script>
</body>

</html>