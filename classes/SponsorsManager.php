<?php

class SponsorsManager
{
    private $expe;
    private $baseDir;
    private $lang;

    public function __construct($expe)
    {
        $this->expe = $expe;
        $this->baseDir = $expe . '/sponsors';
        $this->lang = Utils::get_lang();
    }

    public function renderPages()
    {
        foreach (scandir($this->baseDir) as $file) {
            if ($file != '.' && $file != '..') {
                $this->renderPage($file);
            }
        }
    }

    private function renderPage($dir)
    {
        $exploded = explode("-", $dir);
        if (sizeof($exploded) > 1) {
            $file = $exploded[1];
        } else {
            $file = $exploded[0];
        }
        $title = '';
        $href = '';
        $text = '';
        if ($stream = fopen($this->baseDir . '/' . $dir . '/' . $this->lang . '.txt', "r")) {
            $title = trim(fgets($stream));
            $href = trim(fgets($stream));
            if ($href == '') {
                $href = 'javascript:void(0);';
            }
            while (!feof($stream)) {
                $text = $text . trim(fgets($stream));
            }
            fclose($stream);
        }



        echo '<div class="row">';
        echo '<div class="col-md-4">';
        echo '<a href="' . $href . '"> <img class="img-responsive img-hover" src="' . $this->expe . '/sponsors/' . $dir . '/' . $file . '.png" alt=""></a>';
        echo '</div>';
        echo '<div class="col-md-8">';
        echo '<h3><a href="' . $href . '">' . $title . '</a></h3>';
        echo '<p>' . $text . '</p>';
        echo '</div>';
        echo '</div>';
        echo '<hr>';
    }

}
