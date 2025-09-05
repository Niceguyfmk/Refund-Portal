<?php
require_once __DIR__ . '/function.php';

// Read wallet_id from GET
$walletId = $_GET['wid'] ?? '';
if (empty($walletId)) {
    header("Location: /Refund-Portal/portal?error=missing");
    exit;
}


$walletService = new WalletService();
$result = $walletService->getPaymentData($walletId);

$amountToRefund = 0;
$amountRefunded = 0;

if (!isset($result['error']) && !empty($result)) {
    foreach ($result as $row) {
        // Replace with actual column names from your sheet
        $amountToRefund += (float)str_replace(',', '', $row['Balance to be Paid'] ?? 0);
        $amountRefunded += (float)str_replace(',', '', $row['Refund Already Done'] ?? 0);
    }
}

// ✅ Next tranche is 10% of amountToRefund
$nextTranche = $amountToRefund * 0.1;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Plan - Refund Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }

        body, html {
            height: 100%;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: center;  
            align-items: center;    
            min-height: 100vh;     
        }

        .refund-card {
            background: #3d065f;
            color: #eac2ff;
            border-radius: 1rem;
            padding: 2.5rem 6rem;
            max-width: 600px;
            margin: auto;
        }

        .refund-card h2 {
            font-weight: 700;
            font-size: 2rem;
            line-height: 1.3;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .form-control {
            border-radius: 0.75rem;
            border: none;
            font-size: 1.1rem;
            padding: 0.9rem 1rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
        }

        .btn-custom {
            background: #fff;
            color: #1A0565;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            padding: 0.8rem 2rem;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background: #f3dbff;
            color: #1A0565;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .refund-card {
                padding: 2rem;
                margin: 1rem;
            }

            .form-label {
                font-size: 1.2rem;
            }

            .form-control {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="refund-card shadow-lg">
            <h2 class="text-center">💰 Refund Payment Plan</h2>

            <!-- Refund Summary -->
            <form action="/Refund-Portal/portal/agreement" method="POST">
                <input type="hidden" name="wallet" value="<?= htmlspecialchars($walletId) ?>">
                <input type="hidden" name="refund" value="<?= htmlspecialchars($amountToRefund) ?>">
                <input type="hidden" name="toBeRefund" value="<?= htmlspecialchars($nextTranche) ?>">

                <div class="mb-4">
                    <label for="amountToRefund" class="form-label">Balance to be Paid ($)</label>
                    <input type="number"  id="amountToRefund" class="form-control" value="<?= abs($amountToRefund) ?>" readonly>
                </div>

                <div class="mb-4">
                    <label for="amountRefunded" class="form-label">Refund Already Done ($)</label>
                    <input type="number" id="amountRefunded" class="form-control" value="<?= abs($amountRefunded) ?>" readonly>
                </div>

                <div class="mb-4">
                    <label for="nextTranche" class="form-label">Next Tranche to be Paid</label>
                    <div class="form-control bg-light"><?= number_format($nextTranche, 2) ?> (10% of balance)</div>
                </div>

                <!-- Save Plan -->
                <div class="mt-4 text-center">
                    <button type="submit"  id="agreementLink"
                    class="btn btn-custom" >
                        Go to Verification
                    </button>
                   <!--  <a id="agreementLink"
                    class="btn btn-custom"
                    href="/Refund-Portal/portal/agreement?wallet=<?= urlencode($walletId) ?>&refund=<?= urlencode($amountToRefund) ?>&toBeRefund=<?= urlencode($nextTranche) ?>">
                        Go to Verification
                    </a> -->
                </div>  
            </form>
        </div>
    </div>

</body>

</html>
