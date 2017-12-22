<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Google image</title>
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="section">
            <form method="post" class="form" enctype="multipart/form-data">
                <input type="file" name="images[]" class="field" multiple="multiple" accept="image/*">
                <button type="submit" class="btn">Search</button>
            </form>
        </div>
        <div class="section">
        <?php 
            if ($files) {
                foreach ($files as $file) {
                ?>
                    <div class="image">
                        <img src="/img/<?= $file->name ?>">
                        <div class="image_name"><?= $file->name ?></div>
                    </div>
                <?php
                }
            } else {
                echo '<div class="empty">Select images</div>';
            }
        ?>
        </div>
        <div class="section">
            sddsfdddd ddddddddddd ddddddddddddd dddddddddddddddddd cccccccccccccc  vvvvvvvvvvvvvv vvvvvvvvvvvvv vvvvvvvvvvvvvvvvv vvvvvvvvvvv vvvvvvvvvv bbbbbbbbbb bbbbbbbbbbbbbbb
        </div>
    </div>
</body>
</html>