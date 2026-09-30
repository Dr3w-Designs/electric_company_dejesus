<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<section class="section-padding bg-light-custom">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-5 mx-auto">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-bolt text-warning fa-3x mb-3"></i>
                            <h1 class="h3 text-primary-custom">
                                Dashboard Login
                            </h1>
                            <p class="text-muted">
                                Enter any username and password.
                            </p>
                        </div>

                        <form method="post" action="<?= base_url('login') ?>">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    Username
                                </label>

                                <input
                                    type="text"
                                    class="form-control form-control-lg"
                                    id="username"
                                    name="username"
                                    placeholder="Enter any username"
                                >
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    Password
                                </label>

                                <input
                                    type="password"
                                    class="form-control form-control-lg"
                                    id="password"
                                    name="password"
                                    placeholder="Enter any password"
                                >
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Login
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="<?= base_url() ?>">
                                Return to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
