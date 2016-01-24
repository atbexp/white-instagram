<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/php/config.php';

abstract class html{
    public static function insta_images( $images_data ){
        $output = '';
        foreach( $images_data as $image ):
            $output .= self::insta_image($image);
        endforeach;
        return $output;
    }
    public static function insta_image( $image_data ){
        $output = '';
        $domen = 'https://www.instagram.com/';
        //<a href="/explore/locations/365542000/" title="Crossroad RC &amp; SB" class="place">Crossroad RC &amp; SB</a>
        $output .= "
        <div class=\"insta-block\" data-id=\"{$image_data->id}\">
                    <div class=\"insta-block-header\">
                        <img src=\"{$image_data->user->profile_picture}\" class=\"autor-ava\">
                        <div class=\"info\">
                            <a href=\"{$domen}{$image_data->user->username}/\" title=\"{$image_data->user->username}\" class=\"autor\" target='_blank'>{$image_data->user->username}</a>
                        </div>

                        <a href=\"{$image_data->link}\" class=\"time\" target='_blank'>".human_time_diff($image_data->created_time)."</a>
                    </div>
                    <div class=\"insta-block-body\">
                        <img src=\"{$image_data->images->standard_resolution->url}\" alt=\"\">
                    </div>
                    <div class=\"insta-block-footer\">
                        <div class=\"likes\">{$image_data->likes->count} ".NumberEnd( $image_data->likes->count ,array('отметка','отметки','отметок') )." «Нравится»</div>
                        <div class=\"title\">
                            {$image_data->caption->text}
                       </div>
                        <div class=\"comments\">
                            {$image_data->comments->count} ".NumberEnd( $image_data->comments->count ,array('комментарий','комментария','комментариев') )."
                        </div>
                    </div>
                </div>
        ";
        return $output;
    }
}

function insta_tag_column( $instagram, $tag ){
    if ( $tag ):
        $gettag = $instagram->getTagMedia($tag,5);
        return html::insta_images( $gettag->data );
    endif;
}

// Окончания в словах
function NumberEnd($number, $titles) {
    $cases = array (2, 0, 1, 1, 1, 2);
    return $titles[ ($number%100>4 && $number%100<20)? 2 : $cases[min($number%10, 5)] ];
}

// Constants for expressing human-readable intervals
// in their respective number of seconds.
define( 'MINUTE_IN_SECONDS', 60 );
define( 'HOUR_IN_SECONDS',   60 * MINUTE_IN_SECONDS );
define( 'DAY_IN_SECONDS',    24 * HOUR_IN_SECONDS   );
define( 'WEEK_IN_SECONDS',    7 * DAY_IN_SECONDS    );
define( 'YEAR_IN_SECONDS',  365 * DAY_IN_SECONDS    );

function human_time_diff( $from, $to = '' ) {
    if ( empty( $to ) ) {
        $to = time();
    }

    $diff = (int) abs( $to - $from );

    if ( $diff < HOUR_IN_SECONDS ) {
        $mins = round( $diff / MINUTE_IN_SECONDS );
        if ( $mins <= 1 )
            $mins = 1;
        /* translators: min=minute */
        //$since = sprintf( _n( '%s min', '%s mins', $mins ), $mins );
        $since = $mins.' '.NumberEnd($mins, array('минута','минуты','минут'));
    } elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
        $hours = round( $diff / HOUR_IN_SECONDS );
        if ( $hours <= 1 )
            $hours = 1;
        //$since = sprintf( _n( '%s hour', '%s hours', $hours ), $hours );
        $since = $hours.' '.NumberEnd($hours, array('час','часа','часов'));
    } elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
        $days = round( $diff / DAY_IN_SECONDS );
        if ( $days <= 1 )
            $days = 1;
        //$since = sprintf( _n( '%s day', '%s days', $days ), $days );
        $since = $days.' '.NumberEnd($days, array('день','дня','дней'));
    } elseif ( $diff < 30 * DAY_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
        $weeks = round( $diff / WEEK_IN_SECONDS );
        if ( $weeks <= 1 )
            $weeks = 1;
        //$since = sprintf( _n( '%s week', '%s weeks', $weeks ), $weeks );
        $since = $weeks.' '.NumberEnd($weeks, array('неделя','недели','недель'));
    } elseif ( $diff < YEAR_IN_SECONDS && $diff >= 30 * DAY_IN_SECONDS ) {
        $months = round( $diff / ( 30 * DAY_IN_SECONDS ) );
        if ( $months <= 1 )
            $months = 1;
        //$since = sprintf( _n( '%s month', '%s months', $months ), $months );
        $since = $months.' '.NumberEnd($months, array('месяц','месяца','месяцев'));
    } elseif ( $diff >= YEAR_IN_SECONDS ) {
        $years = round( $diff / YEAR_IN_SECONDS );
        if ( $years <= 1 )
            $years = 1;
        //$since = sprintf( _n( '%s year', '%s years', $years ), $years );
        $since = $years.' '.NumberEnd($years, array('год','года','лет'));
    }
    return $since;
}