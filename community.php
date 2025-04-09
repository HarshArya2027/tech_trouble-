<?php
require_once 'includes/header.php';

// Get active discussions
$query = "SELECT d.*, u.username, c.name as category_name,
          (SELECT COUNT(*) FROM comments WHERE discussion_id = d.id) as comment_count
          FROM discussions d
          JOIN users u ON d.user_id = u.id
          JOIN categories c ON d.category_id = c.id
          ORDER BY d.created_at DESC
          LIMIT 10";

$discussions = mysqli_query($conn, $query);

// Get recent comments
$comments_query = "SELECT c.*, u.username, d.title as discussion_title
                   FROM comments c
                   JOIN users u ON c.user_id = u.id
                   JOIN discussions d ON c.discussion_id = d.id
                   ORDER BY c.created_at DESC
                   LIMIT 5";

$recent_comments = mysqli_query($conn, $comments_query);
?>

<div class="page-header">
    <div class="container">
        <h1>Community Forum</h1>
        <p>Join the discussion and help others with their technical issues</p>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="grid-layout">
            <!-- Main Content -->
            <div class="main-content">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2>Active Discussions</h2>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="new-discussion.php" class="btn btn-primary">Start New Discussion</a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($discussions) > 0): ?>
                            <div class="discussions-list">
                                <?php while ($discussion = mysqli_fetch_assoc($discussions)): ?>
                                    <div class="discussion-item card-hover fade-in">
                                        <div class="discussion-header">
                                            <h3>
                                                <a href="discussion.php?id=<?php echo $discussion['id']; ?>">
                                                    <?php echo htmlspecialchars($discussion['title']); ?>
                                                </a>
                                            </h3>
                                            <span class="badge"><?php echo htmlspecialchars($discussion['category_name']); ?></span>
                                        </div>
                                        <div class="discussion-meta">
                                            <span>Posted by <?php echo htmlspecialchars($discussion['username']); ?></span>
                                            <span><?php echo date('M d, Y', strtotime($discussion['created_at'])); ?></span>
                                            <span><?php echo $discussion['comment_count']; ?> comments</span>
                                        </div>
                                        <div class="discussion-excerpt">
                                            <?php echo nl2br(htmlspecialchars(substr($discussion['content'], 0, 200) . '...')); ?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p>No discussions found. Be the first to start one!</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Recent Comments -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Recent Comments</h3>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($recent_comments) > 0): ?>
                            <div class="comments-list">
                                <?php while ($comment = mysqli_fetch_assoc($recent_comments)): ?>
                                    <div class="comment-item fade-in">
                                        <div class="comment-meta">
                                            <span class="username"><?php echo htmlspecialchars($comment['username']); ?></span>
                                            <span class="date"><?php echo date('M d, Y', strtotime($comment['created_at'])); ?></span>
                                        </div>
                                        <div class="comment-content">
                                            <a href="discussion.php?id=<?php echo $comment['discussion_id']; ?>">
                                                <?php echo htmlspecialchars($comment['discussion_title']); ?>
                                            </a>
                                            <p><?php echo nl2br(htmlspecialchars(substr($comment['comment'], 0, 100) . '...')); ?></p>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <p>No recent comments.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Categories -->
                <div class="card">
                    <div class="card-header">
                        <h3>Categories</h3>
                    </div>
                    <div class="card-body">
                        <ul class="category-list">
                            <?php
                            $categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY name");
                            while ($category = mysqli_fetch_assoc($categories)):
                            ?>
                                <li>
                                    <a href="category.php?id=<?php echo $category['id']; ?>">
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 