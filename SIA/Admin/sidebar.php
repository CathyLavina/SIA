<link rel="stylesheet" href="sidebar.css">


<?php
// Get the current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar" id="sidebar">
    <button class="toggle-btn" id="toggleBtn">&times;</button>

    <div class="account-section">
        <img src="/img/profile.jpg" alt="Profile" class="account-img">
        <span class="account-name">@ACCOUNT</span>
    </div>

    <hr class="divider">

    <ul class="menu">
        <li class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
            <a href="dashboard.php"><i class="fas fa-home"></i><span class="menu-text">DASHBOARD</span></a>
        </li>
        <li class="<?php echo ($current_page == 'borrowbooks.php') ? 'active' : ''; ?>">
            <a href="borrowbooks.php"><i class="fas fa-book"></i><span class="menu-text">BORROW BOOKS</span></a>
        </li>
        <li class="<?php echo ($current_page == 'returnbooks.php') ? 'active' : ''; ?>">
            <a href="returnbooks.php"><i class="fas fa-undo"></i><span class="menu-text">RETURN BOOKS</span></a>
        </li>
        <li class="<?php echo ($current_page == 'students.php') ? 'active' : ''; ?>">
            <a href="students.php"><i class="fas fa-users"></i><span class="menu-text">STUDENTS</span></a>
        </li>
        <li class="<?php echo ($current_page == 'bookinventory.php') ? 'active' : ''; ?>">
            <a href="bookinventory.php"><i class="fas fa-book-open"></i><span class="menu-text">BOOK INVENTORY</span></a>
        </li>
        <li class="<?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>">
            <a href="settings.php"><i class="fas fa-cog"></i><span class="menu-text">SETTINGS</span></a>
        </li>
        <li class="<?php echo ($current_page == 'activitylogs.php') ? 'active' : ''; ?>">
            <a href="activitylogs.php"><i class="fas fa-history"></i><span class="menu-text">ACTIVITY LOGS</span></a>
        </li>
        <li>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span class="menu-text">LOGOUT</span></a>
        </li>
    </ul>
</div>

<script>
// Sidebar toggle
const sidebar = document.getElementById("sidebar");
const toggleBtn = document.getElementById("toggleBtn");

toggleBtn.addEventListener("click", () => {
    sidebar.classList.toggle("collapsed");
    toggleBtn.innerHTML = sidebar.classList.contains("collapsed") ? "&gt;" : "&times;";
});
</script>