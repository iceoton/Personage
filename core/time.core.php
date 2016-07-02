<?php
function Cokidoo_DateTime($date)
{
    if(empty($date)) {
        return "No date provided";
    }
    
    $periods         = array(@LA_TM_SECOND, @LA_TM_MINUTE, @LA_TM_HOUR, @LA_TM_DAY, @LA_TM_WEEK, @LA_TM_MONTH, @LA_TM_YEAR, @LA_TM_DECADE);
    $lengths         = array("60","60","24","7","4.35","12","10");
    
    $now             = time();
    $unix_date         = strtotime($date);
    
       // check validity of date
    if(empty($unix_date)) {    
        return "Bad date";
    }

    // is it future date or past date
    if($now > $unix_date) {    
        $difference     = $now - $unix_date;
        $tense         = @LA_TM_AFTER;
        
    } else {
        $difference     = $unix_date - $now;
        $tense         = @LA_TM_FROM;
    }
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
    
    $difference = round($difference);
    
    if($difference != 1) {
        $periods[$j].= "";
    }
    
    return "$difference&nbsp;$periods[$j]&nbsp;{$tense}";
}
?>