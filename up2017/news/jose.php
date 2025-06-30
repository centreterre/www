<div class="row">
    <div class="col-md-12">
        <?php if (Utils::is_lang('fr')) {?>
            <p>José est parti...Son dynamisme, sa gaité, son empathie et son implication sans limite resteront gravés dans nos coeurs.</p>
            <p>Regardons-le encore vivre dans cette Patagonie qu'il a tant aimée, et où il a donné la pleine mesure de ses qualités humaines, au service du collectif qui selon lui rendait l'Homme meilleur</p>
        <?php }?>
        <?php if (Utils::is_lang('es')) {?>
            <p>José se ha ido…. Su dinamismo, alegría, empatía e implicación sin límites quedarán grabados en nuestros corazones.</p>
            <p>Veámosle aún en vida en esta Patagonia que tanto amó, allí donde puso de manifiesto sus cualidades humanas por el bien común que, según él, hacía al Hombre mejor.</p>                
        <?php }?>
        <style>.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; height: auto; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }</style><div class='embed-container'><iframe src='https://player.vimeo.com/video/251078619' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div><br/>
        <?php
            include 'classes/BlogManager.php';
            $bm = new BlogManager ('up2017/news');
            $bm->renderPageByPath('036');
        ?>
    </div>
</div>
