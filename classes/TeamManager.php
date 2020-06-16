<?php

class TeamManager
{
    private $baseDir;
    private $lang;

    public function __construct($expe)
    {
        $this->baseDir = $expe . '/equipe';
        $this->lang = Utils::get_lang();
    }

    public function renderPages()
    {
        $this->renderPage();
    }

    private function renderPage()
    {
        if ($stream = fopen($this->baseDir . '/equipe.txt', "r")) {
            $colIndex = 0;
            while (!feof($stream)) {
                $img = trim(fgets($stream));
                $name = trim(fgets($stream));
                $fr = trim(fgets($stream));
                $es = trim(fgets($stream));
                $detail = $this->lang == 'fr' ? $fr : $es;
                trim(fgets($stream));
                if (($colIndex % 4) == 0) {
                    echo '<div class="row">';
                }
                if (($colIndex % 4) == 0) {
                    echo '    <div class="col-sm-6 team-row-col-left">';
                }
                if (($colIndex % 4) == 2) {
                    echo '    <div class="col-sm-6 team-row-col-right">';
                }
                echo '        <div class="col-sm-6">';
                echo '            <div class="team-member">';
                echo '                <img';
                echo '                    alt=""';
                echo '                    src="' . $this->baseDir . '/' . $img . '"';
                echo '                    class="img-responsive">';
                echo '                <h4>' . $name . '</h4>';
                echo '                <p class="text-muted tal">' . $detail . '</p>';
                echo '            </div>';
                echo '        </div>';
                $colIndex = $colIndex + 1;
                if (($colIndex % 4) == 0 || ($colIndex % 4) == 2) {
                    echo '    </div>';
                }
                if (($colIndex % 4) == 0) {
                    echo '</div>';
                }
            }
            if (($colIndex % 4) != 0 && ($colIndex % 4) != 2) {
                echo '    </div>';
            }
            if (($colIndex % 4) != 0) {
                echo '</div>';
            }

            fclose($stream);
        }
    }

}
