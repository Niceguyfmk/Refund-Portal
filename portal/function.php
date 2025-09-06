<?php
class WalletService {
    private array $sheets = [
        "refund"  => "https://docs.google.com/spreadsheets/d/e/2PACX-1vSk1yfhIHqwm-fm_jyw3JDfw3TO5aW-7jMsI4YLj8lNdJciZiH0ed_5IHPyWM2Rqs73K9UnFSFB_OjM/pub?gid=0&single=true&output=csv",
        "payment" => "https://docs.google.com/spreadsheets/d/e/2PACX-1vSk1yfhIHqwm-fm_jyw3JDfw3TO5aW-7jMsI4YLj8lNdJciZiH0ed_5IHPyWM2Rqs73K9UnFSFB_OjM/pub?gid=890704245&single=true&output=csv",
    ];

    /**
     * Fetch and filter data from a given sheet
     */
    private function fetchData(string $url, string $walletId): array {
        // Sanitize walletId
        $walletId = preg_replace("/[^a-zA-Z0-9]/", "", $walletId);
        if (!$walletId) {
            return ["error" => "Invalid Wallet ID"];
        }

        // Fetch CSV
        $csv = @file_get_contents($url);
        if (!$csv) {
            return ["error" => "Unable to fetch sheet data"];
        }

        // Parse CSV
        $rows = array_map("str_getcsv", explode("\n", trim($csv)));
        if (count($rows) < 2) {
            return ["error" => "No data found in sheet"];
        }

        // Extract header row
        $header = array_shift($rows);

        // Find matching rows
        $matches = [];
        foreach ($rows as $row) {
            if (!empty($row[0]) && trim($row[0]) === $walletId) {
                $matches[] = @array_combine($header, $row);
            }
        }

        return empty($matches) ? ["error" => "No matching wallet found"] : $matches;
    }

    /**
     * Public functions for each sheet
     */
    public function getRefundData(string $walletId): array {
        return $this->fetchData($this->sheets["refund"], $walletId);
    }

    public function getPaymentData(string $walletId): array {
        return $this->fetchData($this->sheets["payment"], $walletId);
    }

    // public function getSummaryData(string $walletId): array {
    //     return isset($this->sheets["summary"])
    //         ? $this->fetchData($this->sheets["summary"], $walletId)
    //         : ["error" => "Summary sheet not configured"];
    // }
}

# -------------------------------------------------
# AGREEMENT SAVE HANDLER (inside same file)
# -------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agreementEmail'])) {
    $email  = filter_var($_POST['agreementEmail'] ?? '', FILTER_SANITIZE_EMAIL);
    $wallet = $_POST['wallet'] ?? '';
    $refund = $_POST['refund'] ?? 0;
    $toBeRefund = $_POST['toBeRefund'] ?? 0;
    $ip     = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    $date   = date("c");

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address");

    }
    if (empty($wallet)) {

        die("Wallet address missing");
    }

    // --- Save to Google Sheets WebApp ---
    $payload = json_encode([
        "email" => $email,
        "wallet" => $wallet,
        "refund" => $refund,
        "toBeRefund" => $toBeRefund,
        "ip" => $ip,
        "dateAgreed" => $date
    ]);
   
    $url = "https://script.google.com/macros/s/AKfycbyhrXUrPcQw1DGEIYv4gKMCRM8NVGm2qBJIGCmxOpNxzWL-Xa6Q3OPKE4c-z_5EfhKzhA/exec";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
   
    header("Location: success?email=" . urlencode($email));
    exit;
}
