<?php
require_once 'includes/header.php';

// Get search query if exists
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Build query
$query = "SELECT s.*, i.title as issue_title, c.name as category_name, u.username 
          FROM solutions s 
          JOIN issues i ON s.issue_id = i.id 
          JOIN categories c ON i.category_id = c.id 
          JOIN users u ON s.user_id = u.id 
          WHERE 1=1";

if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $query .= " AND (i.title LIKE '%$search%' OR s.solution LIKE '%$search%')";
}

if ($category > 0) {
    $query .= " AND i.category_id = $category";
}

$query .= " ORDER BY s.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<div class="page-header">
    <div class="container">
        <h1>Solutions Database</h1>
        <p>Find solutions to common technical issues</p>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <!-- Search Form -->
        <div class="card mb-4">
            <form action="solutions.php" method="GET" class="search-form">
                <div class="form-group">
                    <input type="text" name="search" placeholder="Search solutions..." 
                           value="<?php echo htmlspecialchars($search); ?>" class="form-control">
                </div>
                <div class="form-group">
                    <select name="category" class="form-control">
                        <option value="0">All Categories</option>
                        <?php
                        $categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name");
                        while ($cat = mysqli_fetch_assoc($categories)) {
                            $selected = $category == $cat['id'] ? 'selected' : '';
                            echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <!-- Solutions Grid -->
        <div class="grid-layout">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($solution = mysqli_fetch_assoc($result)): ?>
                    <div class="card card-hover fade-in">
                        <div class="card-header">
                            <h3><?php echo htmlspecialchars($solution['issue_title']); ?></h3>
                            <span class="badge"><?php echo htmlspecialchars($solution['category_name']); ?></span>
                        </div>
                        <div class="card-body">
                            <p><?php echo nl2br(htmlspecialchars($solution['solution'])); ?></p>
                        </div>
                        <div class="card-footer">
                            <small>
                                Posted by <?php echo htmlspecialchars($solution['username']); ?> 
                                on <?php echo date('M d, Y', strtotime($solution['created_at'])); ?>
                            </small>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="card">
                    <div class="card-body text-center">
                        <p>No solutions found. Try a different search term or category.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 