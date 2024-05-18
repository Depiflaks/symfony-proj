<?php
declare(strict_types=1);

namespace App\View;

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Users List</title>
</head>
<body>
<form action="/delete_user.php" method="post" enctype="multipart/form-data">
    <?php 
        foreach ($data as $user) {
            var_dump($user);
        }
    ?>
</form>
</body>
</html>