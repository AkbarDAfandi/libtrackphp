<?php
session_start();
session_destroy();
header("Location: /../libtrackphp/index.php");
exit();
