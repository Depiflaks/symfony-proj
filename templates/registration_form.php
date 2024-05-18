<?php
namespace App\View;
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Registration</title>
</head>
<body>
<form action="/user/add_user" method="post" enctype="multipart/form-data">
    <div>
        <label for="first_name">first_name:</label>
        <input name="first_name" id="first_name" type="text" value="s">
    </div>
    <div>
        <label for="last_name">last_name:</label>
        <input name="last_name" id="last_name" type="text" value="s">
    </div>
    <div>
        <label for="middle_name">middle_name:</label>
        <input name="middle_name" id="middle_name" type="text" value="y">
    </div>
    <div>
        <label for="gender">gender:</label>
        <input name="gender" id="gender" type="text" value= "male">
    </div>
    <div>
        <label for="birth_date">birth_date:</label>
        <input name="birth_date" id="birth_date" type="date">
    </div>
    <div>
        <label for="email">email:</label>
        <input name="email" id="email" type="text" value="@gmail.com">
    </div>
    <div>
        <label for="phone">phone:</label>
        <input name="phone" id="phone" type="text" value="1234">
    </div>
    <div>
        <label for="avatar_icon">avatar_icon:</label>
        <input name="avatar_icon" id="avatar_icon" type="file" accept="image/png, image/jpg, image/gif">
    </div>
    <button type="submit">Submit</button>
</form>
</body>
</html>