<?php
if(isset($row)){
    $queryString = 'edit-news&id='.$row['id'];
}else{
    $queryString = 'add-news';
}
?>

<div class="content-wrapper">
    <div class="content">
        <h1><?= isset($row) ? 'Edit item' : 'New item' ?></h1>
        <div class="notify"><p>Message</p></div>
        <form action="#" method='post' id="new-item-form">
            <div class="form-item item-title">
                <label for="title">News item title: </label>
                <input maxlength="255" type='text' value="<?= isset($row) ? $row['title']: '' ?>" name='title' id='title' placeholder="Article title"/>
            </div>
            <div class="form-item item-date">
                <label for="date">News item date (should be in format <b>"dd.mm.yyyy"</b>): </label>
                <input value="<?= isset($row) ? date('d.m.Y', $row['date']) : '' ?>" type='text' name='date' id='date' placeholder="Article date"/>
            </div>
            <div class="form-item item-text">
                <label for="text">News item text:</label>
                <textarea name='text' id='text' placeholder="Article text"><?= isset($row) ? $row['text']: '' ?></textarea>
            </div>
            <input type="hidden" name="id" id="id" value="<?= isset($row) ? $row['id']: '' ?>">
            <div class="submit-form" id="json-test">
                <a href="#" onclick="<?= isset($row) ? "updateItem()" : 'createItem()' ?>">
                    <div class="button"><?= isset($row) ? 'Save changes' : 'Create item' ?></div>
                </a>
            </div>
            <div class="submit-form" id="back-2-list">
                <a href="/">
                    <div class="button">Back to list</div>
                </a>
            </div>
        </form>
    </div>
</div>
<div class="page-buffer"></div>