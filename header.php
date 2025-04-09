<?php
session_start();
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechTrouble - Technical Support System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php">
                        <i class="fas fa-tools"></i>
                        <span>TechTrouble</span>
                    </a>
                </div>
                
                <nav class="main-nav">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="categories.php">Categories</a></li>
                        <li><a href="solutions.php">Solutions</a></li>
                        <li><a href="community.php">Community</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </nav>
                
                <div class="user-actions">
                    <button class="theme-toggle" title="Toggle Dark Mode">
                        <i class="fas fa-moon"></i>
                    </button>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="user-dropdown">
                            <button class="user-menu-btn">
                                <i class="fas fa-user-circle"></i>
                                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
                                <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                                <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                                <a href="logout.php" class="logout-btn">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline">Login</a>
                        <a href="register.php" class="btn btn-primary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <main class="container">

<style>
    /* Main Header Styles */
    .main-header {
        background-color: var(--bg-secondary);
        padding: 1rem 0;
        box-shadow: var(--shadow);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Logo Styles */
    .logo a {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        color: var(--text-color);
        font-size: 1.5rem;
        font-weight: 600;
    }

    .logo i {
        color: var(--primary-color);
        font-size: 1.8rem;
    }

    /* Navigation Styles */
    .main-nav ul {
        display: flex;
        gap: 2rem;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .main-nav a {
        color: var(--text-color);
        text-decoration: none;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: var(--radius);
        transition: var(--transition);
    }

    .main-nav a:hover {
        color: var(--primary-color);
        background-color: var(--bg-color);
    }

    /* User Actions Styles */
    .user-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .btn {
        padding: 0.5rem 1.5rem;
        border-radius: var(--radius);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
    }

    .btn-outline {
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
    }

    .btn-outline:hover {
        background-color: var(--primary-color);
        color: white;
    }

    /* User Dropdown Styles */
    .user-dropdown {
        position: relative;
    }

    .user-menu-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: none;
        border: none;
        color: var(--text-color);
        cursor: pointer;
        padding: 0.5rem 1rem;
        border-radius: var(--radius);
        transition: var(--transition);
    }

    .user-menu-btn:hover {
        background-color: var(--bg-color);
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background-color: var(--bg-secondary);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 0.5rem;
        min-width: 200px;
        display: none;
        z-index: 1000;
    }

    .user-dropdown:hover .dropdown-menu {
        display: block;
    }

    .dropdown-menu a {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        color: var(--text-color);
        text-decoration: none;
        border-radius: var(--radius);
        transition: var(--transition);
    }

    .dropdown-menu a:hover {
        background-color: var(--bg-color);
    }

    .logout-btn {
        color: #dc3545;
    }

    .logout-btn:hover {
        background-color: #dc3545;
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 1rem;
        }

        .main-nav ul {
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .user-actions {
            flex-direction: column;
            width: 100%;
        }

        .btn {
            width: 100%;
            text-align: center;
        }
    }
</style> 