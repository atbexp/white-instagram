<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/php/config.php';

// если получили токен, то записываем его пользователю и в инстакласс
if ( isset( $_GET['code'] ) && !$user->get_access_token() ):
    $data = $instagram->getOAuthToken( $_GET['code'] );
    $instagram->setAccessToken( $data );
    $user->set_access_token( $instagram->getAccessToken() );
endif;

// если у пользователя уже есть токен, то записываем его в инстакласс
if ( $user->get_access_token() ):
    include_once $_SERVER['DOCUMENT_ROOT'].'/templates/page-index.php';
else:
    include_once $_SERVER['DOCUMENT_ROOT'].'/templates/page-login.php';
endif;

