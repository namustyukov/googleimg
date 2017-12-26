<?php

require __DIR__.'/GoogleImageSearch.php';

class Application
{
    private $_files = [];
    private $_pages = 2;

    function __construct() {
        if (!empty($_POST['numPages'])) {
            $this->_pages = (int) $_POST['numPages'];
        }
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
        $resultLinks = [];
        $url = 'http://'.$_SERVER['SERVER_NAME'].'/img/'.$file->name;

        $imageSearch = new GoogleImageSearch();
        $results = $imageSearch->search($url, $this->_pages);

        if($results && $results['search_results']) {
            foreach($results['search_results'] as $k => $r) {
                $resultLinks[] = '
                    <a target="_blank" href="'.$r[1].'">'.$r[0].'</a>
                    <span>[ <a target="_blank" href="'.$r[2].'">Original image</a> ]</span>
                ';
            }
        }

        return $resultLinks;
    }

    private function _view()
    {
        $this->render(__DIR__.'/../views/index.php', [
            'files' => $this->_files,
            'pages' => $this->_pages,
        ]);
    }

    public function render($file, $params = [])
    {
        extract($params, EXTR_OVERWRITE);
        require $file;
    }
}
