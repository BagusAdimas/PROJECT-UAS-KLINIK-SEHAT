<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Klinik Sehat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header text-center">

                    <h3>Login Klinik</h3>

                </div>

                <div class="card-body">

                    <form action="/UAS_KLINIK/controllers/AuthController.php" method="POST">

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

                        <div class="mb-3">

                            <label>Login Sebagai</label>

                            <select
                                name="role"
                                class="form-select"
                                required>

                                <option value="">Pilih Role</option>

                                <option value="admin">
                                    Admin
                                </option>

                                <option value="dokter">
                                    Dokter
                                </option>

                                <option value="pasien">
                                    Pasien
                                </option>

                            </select>

                        </div>

                        <button
                            class="btn btn-primary w-100"
                            type="submit"
                            name="login">

                            Login

                        </button>

                    </form>

                </div>

                <div class="card-footer text-center">

                    Belum punya akun?

                    <a href="views/register.php">Daftar</a>


                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>