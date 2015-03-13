<?php
/*
 *   Array Function Start
*/

    if (!function_exists('MultiArrayToSinlgeArray')) {
        function MultiArrayToSinlgeArray($multi_dimensional_array) {
            $single_dimensional_array = array();
            foreach ($multi_dimensional_array as $val) {
                if (is_array($val)) {
                    foreach ($val as $val2) {
                        $single_dimensional_array[] = $val2;
                    }
                }
            }
            return $single_dimensional_array;
        }
    }

    if (!function_exists('subvalue_sort')) {
        function subvalue_sort($a, $subkey) {
            $c = NULL;
            foreach ($a as $k => $v) {
                $b[$k] = strtolower($v->$subkey);
            }
            if (isset($b) && is_array($b)) {
                asort($b);
                foreach ($b as $key => $val) {
                    $c[] = $a[$key];
                }
            }
            return $c;
        }
    }

    if (!function_exists('getArrayNexyValue')) {
        function getArrayNexyValue(&$array, $curr_val) {
            $next = false;
            reset($array);
            do {
                $tmp_val = current($array);
                $res = next($array);
            } while (($tmp_val != $curr_val) && $res);
            if ($res) {
                $next = current($array);
            }
            return $next;
        }
    }

    if (!function_exists('getArrayPreviousValue')) {
        function getArrayPreviousValue(&$array, $curr_val) {
            end($array);
            $prev = current($array);
            do {
                $tmp_val = current($array);
                $res = prev($array);
            } while (($tmp_val != $curr_val) && $res);
            if ($res) {
                $prev = current($array);
            }
            return $prev;
        }
    }

    if (!function_exists('objectToArray')) {
        function objectToArray($array) {
            if (is_object($array)) {
                $array = get_object_vars($array);
            }
            
            if (is_array($array)) {
                return array_map(__FUNCTION__, $array);
            } else {
                return $array;
            }
        }
    }

    if (!function_exists('array_column')) {
        function array_column($array, $column) {
            $col = array();
            if(is_object($array)){
                $array = objectToArray($array);    
            }
            
            foreach ($array as $k => $v) {
                if(is_object($v)){
                    $v = objectToArray($v);    
                }
                $col[$k] = $v[$column];
            }
            return $col;
        }
    }

/*
 *   Array Function End
*/

function file_get_html($url, $use_include_path = false, $context=null, $offset = -1, $maxLen=-1, $lowercase = true, $forceTagsClosed=true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN=true, $defaultBRText=DEFAULT_BR_TEXT, $defaultSpanText=DEFAULT_SPAN_TEXT)
{
    $ci = get_instance();

    $ci->load->library('simple_html_dom_node');
    // We DO force the tags to be terminated.
    $dom = new simple_html_dom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
    // For sourceforge users: uncomment the next line and comment the retreive_url_contents line 2 lines down if it is not already done.
    $contents = file_get_contents($url, $use_include_path, $context, $offset);
    // Paperg - use our own mechanism for getting the contents as we want to control the timeout.
    //$contents = retrieve_url_contents($url);
    if (empty($contents) || strlen($contents) > MAX_FILE_SIZE)
    {
        return false;
    }
    // The second parameter can force the selectors to all be lowercase.
    $dom->load($contents, $lowercase, $stripRN);
    return $dom;
}

function str_get_html($str, $lowercase=true, $forceTagsClosed=true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN=true, $defaultBRText=DEFAULT_BR_TEXT, $defaultSpanText=DEFAULT_SPAN_TEXT)
{
    $ci = get_instance();

    $ci->load->library('simple_html_dom_node');
    $dom = new simple_html_dom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
    if (empty($str) || strlen($str) > MAX_FILE_SIZE){
        $dom->clear();
        return false;
    }
    $dom->load($str, $lowercase, $stripRN);
    return $dom;
}

// dump html dom tree
function dump_html_tree($node, $show_attr=true, $deep=0)
{
    $node->dump($node);
}

function myCurl($url) {
    $options = Array(
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_FOLLOWLOCATION => TRUE,
        CURLOPT_AUTOREFERER => TRUE,
        CURLOPT_CONNECTTIMEOUT => 120,
        CURLOPT_TIMEOUT => 120,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_USERAGENT => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8",
        CURLOPT_URL => $url,
    );

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>