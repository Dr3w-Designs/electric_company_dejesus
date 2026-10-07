<?php
$isEdit = ! empty($account['id']);
$action = $isEdit
    ? base_url('accounts/' . $account['id'])
    : base_url('accounts');

$fieldValue = static function (string $field, string $default = '') use ($account): string {
    return (string) old($field, $account[$field] ?? $default, false);
};

$connectionType = $fieldValue('connection_type', 'residential');
$status = $fieldValue('status', 'active');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> - Puihaha Electric Company</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .main-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 20px auto;
            max-width: 900px;
        }
        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .header-section h1 {
            color: #667eea;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <main class="main-container">
            <div class="header-section">
                <h1><i class="bi bi-lightning-charge-fill text-warning"></i> Puihaha Electric Company</h1>
                <p class="text-muted mb-0"><?= esc($formTitle) ?></p>
            </div>

            <?php if ($error = session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= esc($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= $action ?>">
                <?= csrf_field() ?>
                <?php if ($isEdit): ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php endif; ?>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="account_number" class="form-label fw-semibold">Account Number *</label>
                        <input type="text" id="account_number" name="account_number"
                               class="form-control <?= isset($errors['account_number']) ? 'is-invalid' : '' ?>"
                               maxlength="50" value="<?= esc($fieldValue('account_number')) ?>" required>
                        <?php if (isset($errors['account_number'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['account_number']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <label for="customer_name" class="form-label fw-semibold">Customer Name *</label>
                        <input type="text" id="customer_name" name="customer_name"
                               class="form-control <?= isset($errors['customer_name']) ? 'is-invalid' : '' ?>"
                               maxlength="150" value="<?= esc($fieldValue('customer_name')) ?>" required>
                        <?php if (isset($errors['customer_name'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['customer_name']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label fw-semibold">Address *</label>
                        <textarea id="address" name="address" rows="3"
                                  class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
                                  maxlength="2000" required><?= esc($fieldValue('address')) ?></textarea>
                        <?php if (isset($errors['address'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['address']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold">Phone *</label>
                        <input type="tel" id="phone" name="phone"
                               class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                               maxlength="20" value="<?= esc($fieldValue('phone')) ?>" required>
                        <?php if (isset($errors['phone'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['phone']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Email *</label>
                        <input type="email" id="email" name="email"
                               class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                               maxlength="100" value="<?= esc($fieldValue('email')) ?>" required>
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['email']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4">
                        <label for="meter_number" class="form-label fw-semibold">Meter Number *</label>
                        <input type="text" id="meter_number" name="meter_number"
                               class="form-control <?= isset($errors['meter_number']) ? 'is-invalid' : '' ?>"
                               maxlength="50" value="<?= esc($fieldValue('meter_number')) ?>" required>
                        <?php if (isset($errors['meter_number'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['meter_number']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4">
                        <label for="connection_type" class="form-label fw-semibold">Connection Type *</label>
                        <select id="connection_type" name="connection_type"
                                class="form-select <?= isset($errors['connection_type']) ? 'is-invalid' : '' ?>"
                                required>
                            <option value="residential" <?= $connectionType === 'residential' ? 'selected' : '' ?>>Residential</option>
                            <option value="commercial" <?= $connectionType === 'commercial' ? 'selected' : '' ?>>Commercial</option>
                            <option value="industrial" <?= $connectionType === 'industrial' ? 'selected' : '' ?>>Industrial</option>
                        </select>
                        <?php if (isset($errors['connection_type'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['connection_type']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="form-label fw-semibold">Status *</label>
                        <select id="status" name="status"
                                class="form-select <?= isset($errors['status']) ? 'is-invalid' : '' ?>" required>
                            <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            <option value="suspended" <?= $status === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                        </select>
                        <?php if (isset($errors['status'])): ?>
                            <div class="invalid-feedback"><?= esc($errors['status']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= base_url('accounts') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> <?= esc($submitText) ?>
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
