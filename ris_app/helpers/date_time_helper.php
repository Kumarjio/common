<?php
 
class MyTime {
    
    var $day;
    var $month;
    var $year;
    var $hour;
    var $minute;
    var $second;
    
    function get_time_for_db() {
        return $this->hour . ':' . $this->minute . ':' . $this->second;
    }
    
    function get_date_for_db() {
        return $this->year . '-' . $this->month . '-' . $this->day;
    }
    
    function get_date_time_for_db() {
        return $this->get_date_for_db() . ' ' . $this->get_time_for_db();
    }
    
    function get_date_time() {
        return $this->day . "-" . $this->month . "-" . $this->year . " " . $this->hour . ":" . $this->minute . ":" . $this->second;
    }
}

if (!function_exists('get_current_date_time')) { 
    function get_current_date_time() {
        date_default_timezone_set("Asia/Calcutta"); 
        $timestamp = strtotime(date('Y-m-d H:i:s'));
        
        $mytime = new MyTime();
        $mytime->day = date('d', $timestamp);
        $mytime->month = date('m', $timestamp);
        $mytime->year = date('Y', $timestamp);
        $mytime->hour = date('H', $timestamp);
        $mytime->minute = date('i', $timestamp);
        $mytime->second = date('s', $timestamp);
        return $mytime;
    }
}

if (!function_exists('time_elapsed_string')) { 
    function time_elapsed_string($older_date) {
        $now = get_current_date_time()->get_date_time_for_db();
        
        //current date and time
        $newer_date = $now;
        
        // Setup the strings
        $unknown_text = 'sometime';
        $right_now_text = 'right now';
        $ago_text = '%s ago';
        
        // array of time period chunks
        $chunks = array(YEAR_IN_SECONDS, 30 * DAY_IN_SECONDS, WEEK_IN_SECONDS, DAY_IN_SECONDS, HOUR_IN_SECONDS, MINUTE_IN_SECONDS, 1);
        
        if (!empty($newer_date) && !is_numeric($newer_date)) {
            $time_chunks = explode(':', str_replace(' ', ':', $newer_date));
            $date_chunks = explode('-', str_replace(' ', '-', $newer_date));
            $newer_date = gmmktime((int)$time_chunks[1], (int)$time_chunks[2], (int)$time_chunks[3], (int)$date_chunks[1], (int)$date_chunks[2], (int)$date_chunks[0]);
        }
        
        if (!empty($older_date) && !is_numeric($older_date)) {
            $time_chunks = explode(':', str_replace(' ', ':', $older_date));
            $date_chunks = explode('-', str_replace(' ', '-', $older_date));
            $older_date = gmmktime((int)$time_chunks[1], (int)$time_chunks[2], (int)$time_chunks[3], (int)$date_chunks[1], (int)$date_chunks[2], (int)$date_chunks[0]);
        }
        
        // Difference in seconds
        $since = $newer_date - $older_date;
        
        // Something went wrong with date calculation and we ended up with a negative date.
        if (0 > $since) {
            $output = $unknown_text;
        } else {
            
            // Step one: the first chunk
            for ($i = 0, $j = count($chunks); $i < $j; ++$i) {
                $seconds = $chunks[$i];
                
                // Finding the biggest chunk (if the chunk fits, break)
                $count = floor($since / $seconds);
                if (0 != $count) {
                    break;
                }
            }
            
            // If $i iterates all the way to $j, then the event happened 0 seconds ago
            if (!isset($chunks[$i])) {
                $output = $right_now_text;
            } else {
                
                // Set output var
                switch ($seconds) {
                    case YEAR_IN_SECONDS:
                        $output = sprintf('%s year', $count);
                        break;

                    case 30 * DAY_IN_SECONDS:
                        $output = sprintf('%s month', $count);
                        break;

                    case WEEK_IN_SECONDS:
                        $output = sprintf('%s week', $count);
                        break;

                    case DAY_IN_SECONDS:
                        $output = sprintf('%s day', $count);
                        break;

                    case HOUR_IN_SECONDS:
                        $output = sprintf('%s hour', $count);
                        break;

                    case MINUTE_IN_SECONDS:
                        $output = sprintf('%s minute', $count);
                        break;

                    default:
                        $output = sprintf('%s second', $count);
                }
                
                // Step two: the second chunk
                // A quirk in the implementation means that this
                // condition fails in the case of minutes and seconds.
                // We've left the quirk in place, since fractions of a
                // minute are not a useful piece of information for our
                // purposes
                if ($i + 2 < $j) {
                    $seconds2 = $chunks[$i + 1];
                    $count2 = floor(($since - ($seconds * $count)) / $seconds2);
                    
                    // Add to output var
                    if (0 != $count2) {
                        
                        switch ($seconds2) {
                            case 30 * DAY_IN_SECONDS:
                                $output.= sprintf(' %s month', $count2);
                                break;

                            case WEEK_IN_SECONDS:
                                $output.= sprintf(' %s week', $count2);
                                break;

                            case DAY_IN_SECONDS:
                                $output.= sprintf(' %s day', $count2);
                                break;

                            case HOUR_IN_SECONDS:
                                $output.= sprintf(' %s hour', $count2);
                                break;

                            case MINUTE_IN_SECONDS:
                                $output.= sprintf(' %s minute', $count2);
                                break;

                            default:
                                $output.= sprintf(' %s second', $count2);
                        }
                    }
                }
                
                // No output, so happened right now
                if (!(int)trim($output)) {
                    $output = $right_now_text;
                }
            }
        }
        
        if ($output != $right_now_text) {
            $output = sprintf($ago_text, $output);
        }
        return $output;
    }
}

if (!function_exists('getDateByDay')) { 
    function getDateByDay($day, $start_date, $end_date) {
        $end_date = strtotime($end_date);
        $dates = array();
        for ($i = strtotime($day, strtotime($start_date)); $i <= $end_date; $i = strtotime('+1 week', $i)) {
            $dates[] = date('Y-m-d', $i);
        }
        return $dates;
    }
}

if (!function_exists('generateDates')) { 
    function generateDates($start_date, $end_date) {
        $end_date = strtotime($end_date);
        $dates = array();
        for ($i = strtotime($start_date); $i <= $end_date; $i = strtotime('+1 day', $i)) {
            $dates[] = date('Y-m-d', $i);
        }
        return $dates;
    }
}