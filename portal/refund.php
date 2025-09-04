<!-- Hero Section -->
   <section class="hero-section" >

        <div class="container">
            <div class="hero-content text-center" >
                <h1 class="display-4 fw-bold mb-4">Refund Portal</h1>
                <p class="lead mb-5">Please verify your identity to proceed</p>

                <!-- Wallet Verification -->
                <div class="search-container"  data-aos-delay="300">
                    <form action="/Refund-Portal/portal/table" method="POST" class="d-flex flex-column align-items-center">
                        <label for="search-input" class="input-label" id="input-label">Enter your Wallet ID</label>
                        <input type="text" class="form-control search-input mb-3" id="search-input"
                            placeholder="Wallet ID" required>
                        <button class="search-btn" type="submit"><i class="fas fa-search"></i> Verify</button>
                        <div id="error-message" class="error-message"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>