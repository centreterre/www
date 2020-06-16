<?php
class BlogManager {
	private $pages = array ();
	private $pageIndexes = array ();
	public function __construct() {
		$pages = array ();
		foreach ( scandir ( 'news/pages' ) as $file ) {
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
	public function renderPage($pageIndex) {
		$lang = Utils::get_lang ();
		$this->checkPageIndex ( $pageIndex );
		$page = $this->pages [$pageIndex];
		$xmlDoc = new DOMDocument ();
		$xmlDoc->load ( 'news/pages/' . $page . '/' . $page . '.php' );
		$rootElt = $xmlDoc->documentElement;
		foreach ( $rootElt->childNodes as $child1 ) {
			if ($child1->nodeName == 'h1') {
				if ($child1->getAttribute ( 'lang' ) == $lang) {
					echo '<h1>' . $child1->nodeValue . '</h1>';
				}
			}
			if ($child1->nodeName == 'h3') {
				if ($child1->getAttribute ( 'lang' ) == $lang) {
					echo '<h3><i class="fa fa-clock-o"></i>' . $child1->nodeValue . '</h3>';
				}
			}
			if ($child1->nodeName == 'h4') {
				if ($child1->getAttribute ( 'lang' ) == $lang) {
					echo '<h4>' . $child1->nodeValue . '</h4>';
				}
			}
			if ($child1->nodeName == 'ul') {
				echo '<div class="row">';
				$array = array ();
				foreach ( $child1->childNodes as $child2 ) {
					if ($child2->nodeName == 'li') {
						$paragraphs = '';
						foreach ( $child2->childNodes as $child3 ) {
							if ($child3->nodeName == 'img') {
								$src = $child3->getAttribute ( 'src' );
								$label = $child3->getAttribute ( $lang );
								$img = '<a';
								$img .= ' title="' . $label . '"';
								$img .= ' class="fancybox"';
								$img .= ' rel="group"';
								$img .= ' href="news/pages/' . $page . '/' . $src . '.jpg">';
								$img .= '<img';
								$img .= '  class="img-responsive"';
								$img .= '  src="news/pages/' . $page . '/' . $src . '.jpg"';
								$img .= '  alt="' . $label . '"></a>';
								if ($child3->getAttribute ( 'caption' ) == 'true') {
									$img .= '<div class="caption">' . $label . '</div>';
								}
								array_push ( $array, $img );
							}
							if ($child3->nodeName == 'p') {
								if ($child3->getAttribute ( 'href' ) != '') {
									$paragraphs .= '<a href="' . $child3->getAttribute ( 'href' ) . '">' . $child3->getAttribute ( $lang ) . '</a>';
								}
								if ($child3->getAttribute ( 'lang' ) == $lang) {
									$paragraphs .= '<p>' . $child3->nodeValue . '</p>';
								}
							}
							if ($child3->nodeName == 'video') {
								$uid = uniqid ();
								$src = $child3->getAttribute ( 'src' );
								$_SESSION [$uid] = $src . '.mp4';
								$label = $child3->getAttribute ( $lang );
								array_push ( $array, '<div id="5879bc7147722" class="img-responsive projekktor" uid="' . $uid . '" poster="news/pages/' . $page . '/' . $src . '.jpg" title="' . $label . '"></div>' );
							}
						}
						if ($paragraphs != '') {
							array_push ( $array, $paragraphs );
						}
					}
				}
				$nb_li = count ( $array );
				foreach ( $array as $elt ) {
					echo '<div class="col-md-' . (12 / $nb_li) . '">';
					echo $elt;
					echo '</div>';
				}
				echo '</div>';
			}
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
			$xmlDoc = new DOMDocument ();
			$xmlDoc->load ( 'news/pages/' . $page . '/' . $page . '.php' );
			$rootElt = $xmlDoc->documentElement;
			foreach ( $rootElt->childNodes as $child1 ) {
				if ($child1->nodeName == 'h1') {
					if ($child1->getAttribute ( 'lang' ) == $lang) {
						if ($child1->getAttribute ( 'lang' ) == $lang) {
							echo '<div class="linkitem"><i class="fa fa-clock-o" aria-hidden="true"></i>';
							echo '<a href="/?page=' . $page . '">' . $child1->nodeValue . '</a></div>';
						}
					}
				}
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
}
