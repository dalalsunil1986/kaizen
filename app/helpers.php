<?php

/**
 * @param null $string
 * @return null
 * Helper function to localize the string
 */
function getLocalizedString($string = null)
{
    var_dump($string);
    if ( is_null($string) ) return null;

    if ( App::getLocale() == 'en' ) {
        if ( ! empty($string . '_en') ) {
            return $string . '_en';
        } elseif ( ! empty($string . '_ar') ) {
            return $string . '_ar';
        } else {
            return null;
        }
    } elseif ( App::getLocale() == 'ar' ) {
        if ( ! empty($string . '_ar') ) {
            return $string . '_ar';
        } elseif ( ! empty($string . '_en') ) {
            return $string . '_en';
        } else {
            return null;
        }
    }

}