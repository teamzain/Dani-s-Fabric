<?php
// Include the database connection
@include 'db/config.php';
// Include the notifications function
@include 'notification.php';

// Get the notifications
$notifications = getLowStockNotifications($conn);
$notificationCount = count($notifications);
?>

<div class="top-bar">
    <button class="mobile-menu-toggle">
        <i class="fas fa-bars"></i>
    </button>
    <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search...">
    </div>
    <div class="user-menu">
        <div class="notification-icon">
            <i class="fas fa-bell"></i>
            <?php if ($notificationCount > 0): ?>
                <span class="notification-count"><?php echo $notificationCount; ?></span>
            <?php endif; ?>
            <div class="notification-dropdown">
                <?php if ($notificationCount > 0): ?>
                    <ul>
                        <?php foreach ($notifications as $notification): ?>
                            <li><?php echo htmlspecialchars($notification); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No new notifications</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="avatar-wrapper">
            <img src="img/logo.jpg" alt="User Avatar" class="user-avatar">
            
            <!-- Dropdown Menu -->
            <ul class="dropdown-menu">
                <li><a href="#">Update Username</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</div>

<style>
.notification-icon {
    position: relative;
    cursor: pointer;
}

.notification-count {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 2px 5px;
    font-size: 12px;
}

.notification-dropdown {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background-color: white;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 10px;
    min-width: 200px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.notification-icon:hover .notification-dropdown {
    display: block;
}

.notification-dropdown ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.notification-dropdown li {
    padding: 5px 0;
    border-bottom: 1px solid #eee;
}

.notification-dropdown li:last-child {
    border-bottom: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationIcon = document.querySelector('.notification-icon');
    const notificationDropdown = document.querySelector('.notification-dropdown');

    notificationIcon.addEventListener('click', function(e) {
        e.stopPropagation();
        notificationDropdown.style.display = notificationDropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function() {
        notificationDropdown.style.display = 'none';
    });

    notificationDropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});
</script>


