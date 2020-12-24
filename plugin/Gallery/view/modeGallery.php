<?php
include $global['systemRootPath'] . 'plugin/Gallery/view/topLogic.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">
    <head>
        <title><?php
            echo $siteTitle;
            ?></title>
        <?php include $global['systemRootPath'] . 'view/include/head.php'; ?>
        <script src="<?php echo $global['webSiteRootURL']; ?>view/js/infinite-scroll.pkgd.min.js" type="text/javascript"></script>
    </head>

    <body class="<?php echo $global['bodyClass']; ?> youtube">

        <!-- tempcode Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T3BRWG7"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php include $global['systemRootPath'] . 'view/include/navbar.php'; ?>
        <div class="container-fluid gallery">
            <div class="row text-center" style="padding: 10px;">
                <?php echo getAdsLeaderBoardTop(); ?>
            </div>
            <div class="col-sm-10 col-sm-offset-1 list-group-item">
                <?php
                    include $global['systemRootPath'] . 'plugin/Gallery/view/mainArea.php';
                ?>
            </div>
        </div>
                <?php
                    include $global['systemRootPath'] . 'plugin/Gallery/view/footer.php';
                ?>
    </body>
</html>
<?php include $global['systemRootPath'] . 'objects/include_end.php'; ?>
