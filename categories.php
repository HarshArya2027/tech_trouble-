<?php
require_once 'includes/header.php';

// Get all categories with issue counts
$query = "SELECT c.*, 
          (SELECT COUNT(*) FROM issues WHERE category_id = c.id) as issue_count,
          (SELECT COUNT(*) FROM solutions s 
           JOIN issues i ON s.issue_id = i.id 
           WHERE i.category_id = c.id) as solution_count
          FROM categories c
          ORDER BY c.name";

$categories = mysqli_query($conn, $query);
?>

<div class="page-header">
    <div class="container">
        <h1>Categories</h1>
        <p>Browse technical issues by category</p>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="grid-layout">
            <!-- Main Content -->
            <div class="main-content">
                <div class="card">
                    <div class="card-header">
                        <h2>All Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($categories) > 0): ?>
                            <div class="categories-grid">
                                <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                                    <div class="category-card card-hover fade-in">
                                        <div class="category-icon">
                                            <i class="fas fa-folder"></i>
                                        </div>
                                        <div class="category-info">
                                            <h3>
                                                <a href="category.php?id=<?php echo $category['id']; ?>">
                                                    <?php echo htmlspecialchars($category['name']); ?>
                                                </a>
                                            </h3>
                                            <p><?php echo htmlspecialchars($category['description']); ?></p>
                                            <div class="category-stats">
                                                <span class="stat">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    <?php echo $category['issue_count']; ?> Issues
                                                </span>
                                                <span class="stat">
                                                    <i class="fas fa-check-circle"></i>
                                                    <?php echo $category['solution_count']; ?> Solutions
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p>No categories found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <div class="card">
                    <div class="card-header">
                        <h3>Quick Stats</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        $total_issues = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM issues"))['count'];
                        $total_solutions = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM solutions"))['count'];
                        $total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
                        ?>
                        <div class="stats-list">
                            <div class="stat-item">
                                <i class="fas fa-exclamation-circle"></i>
                                <div class="stat-info">
                                    <span class="stat-value"><?php echo $total_issues; ?></span>
                                    <span class="stat-label">Total Issues</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-check-circle"></i>
                                <div class="stat-info">
                                    <span class="stat-value"><?php echo $total_solutions; ?></span>
                                    <span class="stat-label">Total Solutions</span>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-users"></i>
                                <div class="stat-info">
                                    <span class="stat-value"><?php echo $total_users; ?></span>
                                    <span class="stat-label">Total Users</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 