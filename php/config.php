<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/php/user.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/php/instagram/Instagram.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/php/instagram/InstagramException.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/php/functions.php';

use MetzWeb\Instagram\Instagram;

$instagram = new Instagram(array(
    'apiKey'      => '34f5cce9bc1e47228eb1b9baecd45909',
    'apiSecret'   => 'd6c280dd3b73489db2574d876f08719f',
    'apiCallback' => 'http://'.$_SERVER['SERVER_NAME']
));

$user = new whiteUser();

if ( $user->get_access_token() ):
    $instagram->setAccessToken( $user->get_access_token() );
endif;

