<?php

require __DIR__.'/GoogleImageSearch.php';

class Application
{
    private $_files = [];

    function __construct() {
    }

    public function run()
    {
        $this->_processFiles();
        $this->_view();
    }

    private function _processFiles()
    {
        $this->_clean();
        $this->_loadFiles();
        $this->_googleSearch();
    }

    private function _clean()
    {
        $path = __DIR__.'/../img';

        if (file_exists($path)) {
            $files = glob($path.'/*');

            foreach ($files as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }

    private function _loadFiles()
    {
        $path = __DIR__.'/../img';

        if (!file_exists($path)) {
            mkdir($path, 0777);
        }

        if (!empty($_FILES['images'])) {
            $images = $_FILES['images'];

            for ($i = 0; $i < count($images['name']); $i++) {
                $uploadfile = $path.'/'.$images['name'][$i];

                if (move_uploaded_file($images['tmp_name'][$i], $uploadfile)) {
                    $this->_files[] = (object) [
                        'name' => $images['name'][$i],
                        'size' => $images['size'][$i],
                    ];
                }
            }
        }
    }

    private function _googleSearch()
    {
        foreach ($this->_files as $file) {
            $file->result = $this->_googleRequest($file);
        }
    }

    private function _googleRequest($file)
    {
        $imageSearch = new GoogleImageSearch();

        echo "Search by image URL: <br />\n";
        if($results = $imageSearch->search('http://upload.wikimedia.org/wikipedia/commons/2/22/Turkish_Van_Cat.jpg', 2)) {
            if($results['search_results']) {
                echo "Best guess: <strong><a href=\"{$results['best_guess'][1]}\">{$results['best_guess'][0]}</strong><br />\n";
                echo "<ol><br />\n";
                foreach($results['search_results'] as $k => $r) {
                    echo "<li><a href=\"{$r[1]}\">{$r[0]}</a> ; <a href=\"{$r[2]}\">Original image</a></li>\n";
                }
                echo "</ol><br />\n";
            } else {
                echo 'Nothing found';
            }

        }
        echo "Search by uploading local image: <br />\n";

        exit();


        return [];
    }

    private function _view()
    {
        $this->render(__DIR__.'/../views/index.php', [
            'files' => $this->_files,
        ]);
    }

    public function render($file, $params = [])
    {
        extract($params, EXTR_OVERWRITE);
        require $file;
    }
}
