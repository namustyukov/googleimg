<?php

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
