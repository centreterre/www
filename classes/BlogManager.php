<?php
class BlogManager {
    private $baseDir;
	private $pages = array ();
	private $pageIndexes = array ();
	public function __construct($baseDir) {
	    $this->baseDir = $baseDir;
	    $pages = array ();
		foreach ( scandir ( $baseDir . '/pages' ) as $file ) {
			if ($file != '.' && $file != '..') {
				array_push ( $pages, $file );
			}
		}
		$this->pages = array_reverse ( $pages );
		$pageIndex = 0;
		$pageIndexes = array ();
		foreach ( $this->pages as $page ) {
			$pageIndexes [$page] = $pageIndex;
			$pageIndex = $pageIndex + 1;
		}
		$this->pageIndexes = $pageIndexes;
	}
	public function getPageIndex($page) {
		if (isset ( $this->pageIndexes [$page] )) {
			return $this->pageIndexes [$page];
		} else {
			die ( 'Page not found.' );
		}
	}
	public function renderPagesPrint() {
		$countPages = count ( $this->pageIndexes );
		foreach ( $this->pageIndexes as $pageIndex ) {
			$index = $countPages - $pageIndex -1;
			$this->renderPagePrint ( $index );
		}
	}
	public function renderPagePrint($pageIndex) {
		$this->checkPageIndex ( $pageIndex );
		$page = $this->pages [$pageIndex];
		if ($stream = fopen ( $this->getPageFile ( $page ), "r" )) {
			$array = array ();
			$start = true;
			$cols = array ();
			$col_sum = 12;
			while ( ! feof ( $stream ) ) {
				$line = trim ( fgets ( $stream ) );
				if (preg_match ( '/{ ([\d]+) (.*)}/i', $line, $line_matches )) {
					$level = $line_matches [1];
					$label = $line_matches [2];
					if ($level == 1) {
						echo '<h1>' . $label . '</h1>';
					} else if ($level == 2) {
						echo '<h3>' . $label . '</h3>';
					} else if ($level == 3) {
						echo '<h4>' . $label . '</h4>';
					}
				} else if (preg_match ( '/{ ([\d]+)/i', $line, $line_matches )) {
					$col = $line_matches [1];
					if ($col_sum == 12) {
						$col_sum = $col;
						echo '<div class="row">';
					} else {
						$col_sum += $col;
					}
					echo '<div class="col-md-' . $col . '">';
				} else if (preg_match ( '/(.*)}/i', $line )) {
					echo '</div>';
					if ($col_sum == 12) {
						echo '</div>';
					}
				} else if ($line != '') {
					$this->renderColPrint ( $page, $line );
				}
			}
			fclose ( $stream );
		}
	}
	private function renderColPrint($page, $line) {
		if (preg_match ( '/(\[)(.*)\/(.*)(\])/i', $line, $matches )) {
			$src = $matches [2];
			$label = $matches [3];
			$caption = false;
			if (preg_match ( '/@(.*)/i', $label, $label_matches )) {
				$label = $label_matches [1];
				$caption = true;
			}
			$img = '<img';
			$img .= '  loading="lazy"';
			$img .= '  decoding="async"';
			$img .= '  class="img-responsive"';
			$img .= '  src="'.$this->baseDir.'/pages/' . $page . '/' . $src . '"';
			$img .= '  >';
				$img .= '<div class="caption">' . $label . '</div>';
			echo $img;
		} else {
			echo '<p>' . $line . '</p>';
		}
	}
	public function renderPage($pageIndex) {
		$this->checkPageIndex ( $pageIndex );
		$page = $this->pages [$pageIndex];
		if ($stream = fopen ( $this->getPageFile ( $page ), "r" )) {
			$array = array ();
			$start = true;
			$cols = array ();
			$col_sum = 12;
			while ( ! feof ( $stream ) ) {
				$line = trim ( fgets ( $stream ) );
				if (preg_match ( '/{ ([\d]+) (.*)}/i', $line, $line_matches )) {
					$level = $line_matches [1];
					$label = $line_matches [2];
					if ($level == 1) {
						echo '<h1>' . $label . '</h1>';
					} else if ($level == 2) {
						echo '<h3><i class="fa fa-clock-o"></i>' . $label . '</h3>';
					} else if ($level == 3) {
						echo '<h4>' . $label . '</h4>';
					}
				} else if (preg_match ( '/{ ([\d]+)/i', $line, $line_matches )) {
					$col = $line_matches [1];
					if ($col_sum == 12) {
						$col_sum = $col;
						echo '<div class="row">';
					} else {
						$col_sum += $col;
					}
					echo '<div class="col-md-' . $col . '">';
				} else if (preg_match ( '/(.*)}/i', $line )) {
					echo '</div>';
					if ($col_sum == 12) {
						echo '</div>';
					}
				} else if ($line != '') {
					$this->renderCol ( $page, $line );
				}
			}
			fclose ( $stream );
		}
	}
	public function renderPageByPath($page) {
	    if ($stream = fopen ( $this->getPageFile ( $page ), "r" )) {
	        $array = array ();
	        $start = true;
	        $cols = array ();
	        $col_sum = 12;
	        while ( ! feof ( $stream ) ) {
	            $line = trim ( fgets ( $stream ) );
	            if (preg_match ( '/{ ([\d]+) (.*)}/i', $line, $line_matches )) {
	                $level = $line_matches [1];
	                $label = $line_matches [2];
	                if ($level == 1) {
	                    echo '<h1>' . $label . '</h1>';
	                } else if ($level == 2) {
	                    echo '<h3><i class="fa fa-clock-o"></i>' . $label . '</h3>';
	                } else if ($level == 3) {
	                    echo '<h4>' . $label . '</h4>';
	                }
	            } else if (preg_match ( '/{ ([\d]+)/i', $line, $line_matches )) {
	                $col = $line_matches [1];
	                if ($col_sum == 12) {
	                    $col_sum = $col;
	                    echo '<div class="row">';
	                } else {
	                    $col_sum += $col;
	                }
	                echo '<div class="col-md-' . $col . '">';
	            } else if (preg_match ( '/(.*)}/i', $line )) {
	                echo '</div>';
	                if ($col_sum == 12) {
	                    echo '</div>';
	                }
	            } else if ($line != '') {
	                $this->renderCol ( $page, $line );
	            }
	        }
	        fclose ( $stream );
	    }
	}
	private function renderCol($page, $line) {
		if (preg_match ( '/(\[)(.*)\/(.*)(\])/i', $line, $matches )) {
			$src = $matches [2];
			$label = $matches [3];
			$caption = false;
			if (preg_match ( '/@(.*)/i', $label, $label_matches )) {
				$label = $label_matches [1];
				$caption = true;
			}
			$img = '<a';
			$img .= ' title="' . $label . '"';
			$img .= ' class="fancybox"';
			$img .= ' rel="group"';
			$img .= ' href="'.$this->baseDir.'/pages/' . $page . '/' . $src . '">';
			$img .= '<img';
			$img .= '  loading="lazy"';
			$img .= '  decoding="async"';
			$img .= '  class="img-responsive"';
			$img .= '  src="'.$this->baseDir.'/pages/' . $page . '/' . $src . '"';
			$img .= '  alt="' . $label . '"></a>';
			if ($caption) {
				$img .= '<div class="caption">' . $label . '</div>';
			}
			echo $img;
		} else {
			echo '<p>' . $line . '</p>';
		}
	}
	public function renderPagination($pageIndex) {
		$this->checkPageIndex ( $pageIndex );
		if (count ( $this->pages ) > 0) {
			echo '<br/><div style="text-align:center;">';
			if ($this->hasPreviousPage ( $pageIndex )) {
				echo '<a href="?pageIndex=' . ($pageIndex - 1) . '" class="btn btn-info" role="button">Publication suivante</a>&nbsp;&nbsp;';
			}
			if ($this->hasNextPage ( $pageIndex )) {
				echo '<a href="?pageIndex=' . ($pageIndex + 1) . '" class="btn btn-info" role="button">Publication précédente</a>';
			}
			echo '</div><br/>';
		}
	}
	public function renderSidebar() {
		$lang = Utils::get_lang ();
		foreach ( $this->pages as $page ) {
			if ($stream = fopen ( $this->getPageFile ( $page ), "r" )) {
				while ( ! feof ( $stream ) ) {
					$line = trim ( fgets ( $stream ) );
					if (preg_match ( '/{ ([\d]+) (.*)}/i', $line, $line_matches )) {
						$level = $line_matches [1];
						$label = $line_matches [2];
						if ($level == 1) {
							echo '<div class="linkitem"><i class="fa fa-clock-o" aria-hidden="true"></i>';
							echo '<a href="/?page=' . $page . '">' . $label . '</a></div>';
						}
					}
				}
				fclose ( $stream );
			}
		}
	}
	public function hasPreviousPage($pageIndex) {
		return $pageIndex > 0;
	}
	public function hasNextPage($pageIndex) {
		return $pageIndex < count ( $this->pages ) - 1;
	}
	private function checkPageIndex($pageIndex) {
		if ($pageIndex > count ( $this->pages ) - 1) {
			die ( 'Page not found.' );
		}
	}
	private function getPageFile($page) {
		$lang = Utils::get_lang ();
		return $this->baseDir.'/pages/' . $page . '/' . $page . '_' . $lang . '.txt';
	}
}
