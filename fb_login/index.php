<?php
require './fb-init.php';
?>
<?php if (isset($_SESSION['facebook_access_token'])): ?>
    <a href="logout.php">Logout</a>
<?php else: ?>
    <a href="<?php echo $loginUrl; ?>">Login whit facebook</a>
<?php endif; ?>
