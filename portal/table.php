<?php
require_once __DIR__ . '/function.php';

// Read wallet_id from GET
$walletId = $_GET['wid'] ?? '';
if (empty($walletId)) {
    header("Location: /Refund-Portal/portal?error=Missing wallet ID , Please try agin.");
    exit;
}

$walletService = new WalletService();
$result = $walletService->getRefundData($walletId);

if (isset($result['error'])) {
    $error = $result['error'];
    header("Location: /Refund-Portal/portal?error=" . $error);
    exit;
}

$profit = 0.00;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AZA Ventures - Refund Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .hero-section {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin-top: 30px;
            color: #333;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }

        .btn-custom {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            min-width: 200px;
            color: #fff;
        }

        .btn-claim {
            background: #dc3545;
            border: none;
        }

        .btn-claim:hover {
            background: #c82333;
            color: white;
        }

        .btn-accept {
            background: #28a745;
            border: none;
        }

        .btn-accept:hover {
            background: #218838;
            color: white;
        }

        .btn-agreement {
            background: #28a745;
            border: none;
        }
    </style>
</head>

<body>

    <section class="hero-section">
        <div class="container hero-content text-center">
            <h1 class="display-4 fw-bold mb-4">Your Refund Status</h1>

            <!-- Table -->
            <div class="table-container">
                <div class="table-responsive">
                    <table id="refundTable" class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Wallet</th>
                                <th>OTC Name</th>
                                <th>USDT Allocation before Fees</th>
                                <th>USDT Allocation After fees</th>
                                <th>% Distribution of OTC</th>
                                <th>Capital Recouped</th>
                                <th>Deal Level profit after fees</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($result['error'])): ?>
                                <tr>
                                    <td colspan="7"><?= htmlspecialchars($result['error']) ?></td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($result as $row):
                                    $profit += floatval($row['Deal Level profit after fees']);
                                    ?>

                                    <tr>
                                        <td><?= htmlspecialchars($row['Wallet']) ?></td>
                                        <td><?= htmlspecialchars($row['OTC Name']) ?></td>
                                        <td><?= htmlspecialchars($row['USDT Allocation before Fees']) ?></td>
                                        <td><?= htmlspecialchars($row['USDT Allocation After fees']) ?></td>
                                        <td><?= htmlspecialchars($row['% Distribution of OTC']) ?></td>
                                        <td><?= htmlspecialchars($row['Capital Recouped']) ?></td>
                                        <td><?= htmlspecialchars($row['Deal Level profit after fees']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
                <!-- Totals Summary -->
                <div id="totalsSummary" class="mt-4 p-3 bg-light rounded shadow-sm text-dark">
                    <h5 class="fw-bold mb-3">Total Profit After Fees:</h5>
                    <div class="row text-center">
                        <div class="col-md-12">
                            <div class="p-3 border rounded bg-white">
                                <div id="totalAfter"
                                    class="fs-5 <?= ($profit >= 0) ? 'text-success' : 'text-danger' ?>">
                                    <strong><?= $profit; ?></strong>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="profitMessage" class="alert alert-success mt-3 d-none fw-bold text-center"></div>


                <!-- Buttons -->
                <div class="cta-buttons">
                    <button class="btn btn-custom btn-claim" id="objBtn">Claims & Objections</button>
                    <a href="/Refund-Portal/portal/paymentplan?wid=<?= $walletId ?>" class="btn btn-custom btn-accept"
                        id="acceptBtn">Accept Refund</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Issue Modal -->
    <div class="modal fade" id="issueModal" tabindex="-1" aria-labelledby="issueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title fw-bold" id="issueModalLabel">Report an Issue</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="web3form-issue" action="https://api.web3forms.com/submit" method="POST"
                    class="needs-validation" novalidate>
                    <div class="modal-body text-dark">
                        <div class="mb-3">
                            <p> Only claims and objections for <b>missing allocation</b> and
                                <b>secondary OTC deal calculations will be entertained </b>.<br><br>
                                Objections raised on Calculation of PnL will be <b>ignored</b>,
                                as it is final and as per the date of the distribution.
                            </p>
                            <input type="hidden" name="access_key" value="67aabbdd-b077-4c5a-a780-bf79f06dd424">
                            <input type="hidden" name="wallet_id" id="web3formWalletId" value="<?= $walletId ?>">
                            <label for="issueText" class="form-label">Are you facing any issues?</label>
                            <textarea class="form-control" id="issueText" name="issue" rows="4"
                                placeholder="Describe your issue here..." required></textarea>
                            <div class="invalid-feedback">Please describe your issue before submitting.</div>
                        </div>
                        <div id="web3form-success" class="alert alert-success d-none mt-2">Thank you for your feedback!
                            We have received your issue.</div>
                        <div id="web3form-error" class="alert alert-danger d-none mt-2">There was an error submitting
                            your issue. Please try again later.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submitIssueBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const profitValue = <?= $profit; ?>; // PHP value injected into JS
            const profitMessage = document.getElementById("profitMessage");
            const acceptBtn = document.getElementById("acceptBtn");

            if (profitValue > 0) {
                profitMessage.textContent = "Congratulations! You are already in profits!";
                profitMessage.classList.remove("d-none");
                profitMessage.classList.add("alert-success");

                // Disable accept button
                acceptBtn.disabled = true;
                acceptBtn.classList.add("disabled");
            }
        });
        // Show the issue modal when "Claims & Objections" is clicked
        document.getElementById("objBtn").addEventListener("click", function (e) {
            e.preventDefault();
            // Set wallet id in hidden field for web3form
            //document.getElementById('web3formWalletId').value = WALLET_ID;
            const issueModal = new bootstrap.Modal(document.getElementById('issueModal'));
            issueModal.show();
        });

        // Web3Forms integration for issue modal
        document.getElementById('web3form-issue').addEventListener('submit', async function (e) {
            e.preventDefault();
            const form = this;
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }
            // Hide previous messages
            document.getElementById('web3form-success').classList.add('d-none');
            document.getElementById('web3form-error').classList.add('d-none');

            const formData = new FormData(form);
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                if (result.success) {
                    document.getElementById('web3form-success').classList.remove('d-none');
                    form.reset();
                    form.classList.remove('was-validated');
                    setTimeout(() => {
                        bootstrap.Modal.getInstance(document.getElementById('issueModal')).hide();
                        document.getElementById('web3form-success').classList.add('d-none');
                    }, 2000);
                } else {
                    document.getElementById('web3form-error').classList.remove('d-none');
                }
            } catch (err) {
                document.getElementById('web3form-error').classList.remove('d-none');
            }
        });

        //  const acceptBtn = document.getElementById("acceptBtn");
        // if (acceptBtn) {
        //     acceptBtn.addEventListener("click", function () {
        //         // Forward wallet id as query param
        //        var WALLET_ID= document.getElementById('web3formWalletId').value;
        //         window.location.href = `paymentplan?wallet=${encodeURIComponent(WALLET_ID)}`;
        //     });
        // }

    </script>
</body>

</html>