<?php
declare(strict_types=1);

namespace App\View;

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Edit information</title>
</head>
<body>
<form action="/user/update" method="post" enctype="multipart/form-data">
    <input name="user_id" id="user_id" type="hidden" value="<?=$user->getId()?>">
    <div>
        <label for="first_name">first_name:</label>
        <input name="first_name" id="first_name" type="text" value="<?=$user->getFirstName()?>">
    </div>
    <div>
        <label for="last_name">last_name:</label>
        <input name="last_name" id="last_name" type="text" value="<?=$user->getLastName()?>">
    </div>
    <div>
        <label for="middle_name">middle_name:</label>
        <input name="middle_name" id="middle_name" type="text" value="<?=$user->getMiddleName()?>">
    </div>
    <div>
        <label for="gender">gender:</label>
        <input name="gender" id="gender" type="text" value= "<?=$user->getGender()?>">
    </div>
    <div>
        <label for="birth_date">birth_date:</label>
        <input name="birth_date" id="birth_date" type="date" value="<?=explode(' ', $user->getBirthDate())[0]?>">
    </div>
    <div>
        <label for="email">email:</label>
        <input name="email" id="email" type="text" value="<?=$user->getEmail()?>">
    </div>
    <div>
        <label for="phone">phone:</label>
        <input name="phone" id="phone" type="text" value="<?=$user->getPhone()?>">
    </div>
    <div>
        <label for="avatar_icon">avatar_icon:</label>
        <input name="avatar_icon" id="avatar_icon" type="file" accept="image/png, image/jpg, image/gif">
    </div>
    <input type="submit" name="action" value="update">
</form>
<form action="/user/delete" method="post" enctype="multipart/form-data">
    <input name="user_id" type="hidden" value="<?=$user->getId()?>">
    <input type="submit" value="delete">
</form>
</body>
</html>