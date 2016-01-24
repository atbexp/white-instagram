<?php include_once 'header.php'; ?>

    <div id="settings" class="container">
        <div class="col-md-4">
            <div class="input-group">
                <div class="input-group-addon">#</div>
                <input type="text" class="form-control" id="tag1" name="tag1" placeholder="тэг 1" value="<?php echo $user->get_tag1(); ?>">
                <span class="input-group-btn hidden">
                    <button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <button class="btn btn-success" type="button"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <div class="input-group-addon">#</div>
                <input type="text" class="form-control" id="tag2" name="tag2" placeholder="тэг 2" value="<?php echo $user->get_tag2(); ?>">
                <span class="input-group-btn hidden">
                    <button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <button class="btn btn-success" type="button"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <button id="reload" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
            <button id="auto" type="submit" class="btn btn-primary">Автообновление</button>
        </div>
    </div>

    <div class="container">
        <div id="column_tag1" class="col-md-4">

            <?php echo insta_tag_column( $instagram, $user->get_tag1() ); ?>

        </div>
        <div id="column_tag2" class="col-md-4">

            <?php echo insta_tag_column( $instagram, $user->get_tag2() ); ?>

        </div>
        <div id="cross_tags" class="col-md-4"></div>
    </div>

<?php include_once 'footer.php'; ?>