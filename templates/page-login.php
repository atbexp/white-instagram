<?php include_once 'header.php'; ?>

    <div id="login" class="container text-center">
        <?php echo "<a href='{$instagram->getLoginUrl(array('basic','public_content'))}' class='btn btn-default'>Войти через Instagram</a>"; ?>
    </div>

<?php include_once 'footer.php'; ?>