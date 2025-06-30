<?php session_start(); ?>
<?php include 'common/html.php';?>
<?php include 'common/head.php';?>
<body>
    <?php include 'common/analytics.php';?>
    <?php include 'common/navbar.php';?>
    <?php include 'common/banner.php';?>
    <?php include 'up2019/subnavbar.php';?>
    <div class="content container">
        <div class="row">
            <div class="col-md-8">
                <div style="float: right;"><a href="up2019-print.php?lang=<?=Utils::get_lang()?>" target="_blank">Version imprimable</a></div>
                <?php include 'up2019/news/news.php';?>
            </div>
            <div class="col-md-4">
                <?php include 'sidebar/sidebar-latest.php';?>
                <?php include 'sidebar/sidebar-expe.php';?>
            </div>
        </div>
    </div>
    <?php include 'common/footer.php';?>
    <?php include 'common/js-core.php';?>
    <?php include 'common/lightbox.php';?>
</body>
</html>



