<!DOCTYPE html>
<html lang="en">
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
                <input type="file" name="images[]" class="fileField" multiple="multiple" accept="image/*">
                <input type="text" name="numPages" class="textField" placeholder="Number pages">
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
        <?php
            if ($files) {
                echo '<div class="section">';

                foreach ($files as $file) {
                ?>
                    <div class="result">
                        <div class="result_header"><?= $file->name ?> <span>[<?= $pages ?> pages]</span></div>
                    <?php
                        if ($file->result) {
                            foreach ($file->result as $result) {
                                echo '<div class="result_row">'.$result.'</div>';
                            }
                        } else {
                            echo '<div class="empty">No result</div>';
                        }
                    ?>
                    </div>
                <?php
                }

                echo '</div>';
            }
        ?>
    </div>
</body>
</html>