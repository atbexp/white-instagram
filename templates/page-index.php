<?php include_once 'header.php'; ?>

    <div id="settings" class="container">
        <div class="col-sm-4">
            <div class="input-group">
                <div class="input-group-addon">#</div>
                <input type="text" class="form-control" id="tag1" name="tag1" placeholder="тэг 1" value="<?php echo $user->get_tag1(); ?>">
                <span class="input-group-btn hidden">
                    <button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <button class="btn btn-success" type="button"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                </span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                <div class="input-group-addon">#</div>
                <input type="text" class="form-control" id="tag2" name="tag2" placeholder="тэг 2" value="<?php echo $user->get_tag2(); ?>">
                <span class="input-group-btn hidden">
                    <button class="btn btn-danger" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <button class="btn btn-success" type="button"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
                </span>
            </div>
        </div>
        <div class="col-sm-4">
            <button id="reload" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
            <button id="auto" type="submit" class="btn btn-primary">Автообновление</button>
        </div>
    </div>

    <div class="container hidden-xs">
        <div id="column_tag1" class="col-sm-4">
            <?php echo insta_tag_column( $instagram, $user->get_tag1() ); ?>
        </div>
        <div id="column_tag2" class="col-sm-4">
            <?php echo insta_tag_column( $instagram, $user->get_tag2() ); ?>
        </div>
        <div id="cross_tags" class="col-sm-4"></div>
    </div>

    <div class="container visible-xs">
        <div class="col-sm-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#column_tag1_xs" aria-controls="home" role="tab" data-toggle="tab">#<?php echo $user->get_tag1(); ?></a></li>
            <li role="presentation"><a href="#column_tag2_xs" aria-controls="profile" role="tab" data-toggle="tab">#<?php echo $user->get_tag2(); ?></a></li>
            <li role="presentation"><a href="#cross_tags_xs" aria-controls="messages" role="tab" data-toggle="tab">Совпадения</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="column_tag1_xs">
                <?php echo insta_tag_column( $instagram, $user->get_tag1() ); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="column_tag2_xs">
                <?php echo insta_tag_column( $instagram, $user->get_tag2() ); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="cross_tags_xs"></div>
        </div>
        </div>
    </div>

<?php include_once 'footer.php'; ?>