<?php
$wallet = $_POST['wallet'] ?? $_GET['wallet'] ?? '';
$refund = $_POST['refund'] ?? $_GET['refund'] ?? 0;
$toBeRefund = $_POST['toBeRefund'] ?? $_GET['toBeRefund'] ?? 0;
if (empty($wallet)) {
    header("Location: /Refund-Portal/portal/?error=Missing wallet ID , Please try agin."); 
    exit; 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AZA Ventures - Agreement</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body { font-family: 'Montserrat', sans-serif; margin:0; color:#fff; }
    .hero-section{
      background: linear-gradient(135deg,#1a2a6c,#b21f1f,#fdbb2d);
      min-height:100vh; position:relative; overflow:hidden; display:flex; align-items:center;
    }
    .hero-content{ position:relative; z-index:2; width:100%; }
    .form-container{
      background:#fff; color:#333; border-radius:16px; padding:32px;
      box-shadow:0 18px 40px rgba(0,0,0,0.25); max-width:640px; margin:0 auto;
    }
    .display-4{ font-weight:800; }
    .lead{ opacity:.9; }
    .form-label{ font-weight:600; display:flex; align-items:center; gap:.5rem; }
    .info-dot{
      display:inline-flex; align-items:center; justify-content:center;
      width:20px; height:20px; border-radius:50%; background:#6c63ff; color:#fff;
      font-size:.8rem; cursor:pointer;
    }
    .btn-success{
      background:#28a745; border:none; font-weight:700; border-radius:12px; padding:.9rem 1.25rem;
      transition:transform .15s ease, box-shadow .15s ease, background .2s ease;
    }
    .btn-success:hover{ transform:translateY(-1px); box-shadow:0 8px 20px rgba(40,167,69,.35); background:#239c3f; }
    .form-control{
      border:none; background:#f7f8fa; padding:0.9rem 1rem; border-radius:12px;
    }
    .form-control[readonly]{ background:#f0f2f5; }
  </style>
</head>
<body>
  <section class="hero-section">
    <div class="container hero-content text-center py-5">
      <h1 class="display-4 fw-bold mb-2">Email for KYC</h1>
      <p class="lead mb-4">Please confirm your email below</p>

      <div class="form-container text-start">
        <form id="agreementForm" action="agreementsave" method="POST">
            <div class="mb-3">
                <label class="form-label" for="agreementEmail">Email</label>
                <input type="email" class="form-control"  name="agreementEmail" id="agreementEmail" required placeholder="you@example.com"/>
            </div>

            <!-- Hidden Wallet, Refund, Next Tranche -->
            <input type="hidden" name="wallet" value="<?= htmlspecialchars($wallet ?? '') ?>">
            <input type="hidden" name="refund" value="<?= htmlspecialchars($refund ?? 0) ?>">
            <input type="hidden" name="toBeRefund" value="<?= htmlspecialchars($toBeRefund ?? 0) ?>">

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="agreementCheck" required />
                <label class="form-check-label" for="agreementCheck">I agree to the above</label>
            </div>

            <button type="submit" class="btn btn-success w-100">Submit Email</button>
        </form>

      </div>
    </div>
  </section>

</body>
</html>
