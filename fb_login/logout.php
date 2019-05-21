<?php
include './fb-init.php';
session_destroy();

unset($_SESSION['facebook_access_token']);
header("Location:index.php");
