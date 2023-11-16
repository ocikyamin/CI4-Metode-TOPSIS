<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Topsis</title>
    <link rel="shortcut icon" type="image/png" href="<?=base_url()?>assets/images/logos/topsis-icon.png" />
    <link rel="stylesheet" href="<?=base_url()?>assets/css/styles.min.css" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="./" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="<?=base_url()?>assets/images/logos/kpnga.png" width="180" alt="">
                                </a>
                                <p class="text-center">
                                    Technique for Order Preference by Similarity to Ideal Solution
                                </p>
                                <form id="form-login">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Username</label>
                                        <input type="text" name="email" class="form-control" id="email"
                                            placeholder="Masukkan Email">
                                        <div class="email invalid-feedback"></div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="Masukkan Password">
                                        <div class="email invalid-feedback"></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2"> Login
                                    </button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">2023 | MPY</p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?=base_url()?>assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#form-login').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "<?=base_url('login/cek')?>",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        if (response.error.email) {
                            $('#email').addClass('is-invalid')
                            $('.email').html(response.error.email)
                        }
                        if (response.error.password) {
                            $('#password').addClass('is-invalid')
                            $('.password').html(response.error.password)
                        }

                    }
                    if (response.sukses) {
                        window.location = response.url
                    }

                }
            });

        });
    });
    </script>
</body>

</html>