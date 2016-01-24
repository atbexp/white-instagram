<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/php/config.php';



switch ( $_POST['action'] ){
    case 'set_tag':
        switch ($_POST['id']){
            case 'tag1':
                $user->set_tag1($_POST['val']);
                $output['column_tag1'] = insta_tag_column( $instagram, $user->get_tag1() );
                break;
            case 'tag2':
                $user->set_tag2($_POST['val']);
                $output['column_tag2'] = insta_tag_column( $instagram, $user->get_tag2() );
                break;
        }
        $output['status'] = 1;
        break;
    case 'reload':
        $output['column_tag1'] = insta_tag_column( $instagram, $user->get_tag1() );
        $output['column_tag2'] = insta_tag_column( $instagram, $user->get_tag2() );
        $output['status'] = 1;
        break;
    case 'get_param':
        $output['param']['tag1'] = $user->get_tag1();
        $output['param']['tag2'] = $user->get_tag2();
        $output['status'] = 1;
        break;
}

echo json_encode($output);