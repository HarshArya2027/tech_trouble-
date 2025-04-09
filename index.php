<?php
require_once 'includes/header.php';
?>

<div class="hero-section">
    <div class="container">
        <h1>Welcome to TechTrouble</h1>
        <p>Your one-stop solution for technical support and troubleshooting</p>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="cta-buttons">
                <a href="register.php" class="btn btn-primary">Get Started</a>
                <a href="login.php" class="btn btn-outline">Login</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="features-section">
    <div class="container">
        <h2>How It Works</h2>
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-bug"></i>
                <h3>Report Issues</h3>
                <p>Describe your technical problems and get help from experts</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-lightbulb"></i>
                <h3>Find Solutions</h3>
                <p>Access a database of solutions for common technical issues</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-users"></i>
                <h3>Community Support</h3>
                <p>Get help from our community of technical experts</p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 