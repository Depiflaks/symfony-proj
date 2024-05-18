<div>
    <label for="<?=$user->getId()?>"><a href='./show_user.php?id=<?= $user->getId() ?>'><?=$user->getFirstName()?> <?=$user->getLastName()?></label>
    <input id="<?=$user->getId()?>" type="submit" name="user_id" value="<?=$user->getId()?>">
</div>