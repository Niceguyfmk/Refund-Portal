 <!-- Scripts -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/aos/dist/aos.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="assets/js/app.js"></script>

    <script>
        // Init AOS
        AOS.init({ duration: 800, easing: 'ease-in-out', once: true });

        // Form submit
        document.getElementById("verification-form").addEventListener("submit", async function (e) {
            e.preventDefault();
            const walletId = document.getElementById("search-input").value.trim().toLowerCase();
            const errorBox = document.getElementById("error-message");

            if (!walletId) {
                errorBox.textContent = "⚠️ Please enter a valid Wallet ID";
                errorBox.style.display = "block";
                return;
            }

            const CSV_FILE = "Investor Details.csv";
            try {
                const response = await fetch(CSV_FILE, { cache: 'no-store' });
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const text = await response.text();
                const lines = text.replace(/\r/g, '').split('\n').filter(line => line.trim() !== '');
                const headers = lines[0].split(',').map(h => h.trim());
                let walletIndex = headers.findIndex(h => h.toLowerCase() === 'wallet');
                if (walletIndex === -1) {
                    errorBox.textContent = "⚠️ Wallet column not found in CSV.";
                    errorBox.style.display = "block";
                    return;
                }
                let found = false;
                for (let i = 1; i < lines.length; i++) {
                    const row = lines[i].split(',');
                    if ((row[walletIndex] || '').trim().toLowerCase() === walletId) {
                        found = true; break;
                    }
                }
                if (found) {
                    window.location.href = `table.html?wallet=${encodeURIComponent(walletId)}`;
                } else {
                    errorBox.textContent = "Incorrect Wallet ID, please input a correct one.";
                    errorBox.style.display = "block";
                }
            } catch (error) {
                errorBox.textContent = "Could not check Wallet ID. Please try again later.";
                errorBox.style.display = "block";
                console.error(error);
            }
        });

        // Hide error when typing
        document.getElementById("search-input").addEventListener("input", function () {
            document.getElementById("error-message").style.display = "none";
        });
    </script>
</body>

</html>