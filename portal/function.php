<?php
class WalletService {
    private $apiUrl;

    public function __construct() {
        // Replace with your actual Google Sheets API endpoint
        $this->apiUrl = "https://sheets.googleapis.com/v4/spreadsheets/YOUR_SHEET_ID/values/A1:Z100?key=YOUR_API_KEY";
    }

    /**
     * Get wallet data from Google Sheets
     */
    public function getWalletData(string $walletId): array {
        // 🔒 Sanitize input
        $walletId = preg_replace("/[^a-zA-Z0-9]/", "", $walletId);

        if (!$walletId) {
            return ["error" => "Invalid Wallet ID"];
        }

        // Call Google Sheets API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $err = curl_error($ch);
            curl_close($ch);
            return ["error" => "Curl Error: " . $err];
        }

        curl_close($ch);
        $data = json_decode($response, true);

        if (!isset($data['values'])) {
            return ["error" => "No data found in sheet"];
        }

        // ✅ Filter by wallet ID (assuming column A contains wallet IDs)
        $filtered = [];
        foreach ($data['values'] as $row) {
            if (isset($row[0]) && $row[0] === $walletId) {
                $filtered[] = $row;
            }
        }

        return empty($filtered)
            ? ["error" => "No matching wallet found"]
            : $filtered;
    }
}
