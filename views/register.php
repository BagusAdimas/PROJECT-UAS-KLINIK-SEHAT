<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Pasien</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header text-center">

                    <h3>Registrasi Pasien</h3>

                </div>

                <div class="card-body">

                    <form action="../controllers/AuthController.php" method="POST">

                        <div class="mb-3">

                            <label>Nama Lengkap</label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Password</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>

                        </div>

                        <button
                            class="btn btn-success w-100"
                            type="submit"
                            name="register">

                            Daftar

                        </button>

                    </form>

                </div>

                <div class="card-footer text-center">

                    Sudah punya akun?

                    <a href="../index.php">

                        Login

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>