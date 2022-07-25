<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function btn_achor($uri, $title = NULL, $attr = NULL)
{
    return anchor(site_url($uri), $title, $attr);
}

function btn_view($uri, $title = NULL)
{
    return anchor($uri, '<i class="fa fa-eye"></i>' . $title, array(
        'class'=>'btn btn-info',
    ));
}

function btn_print($uri, $title = NULL)
{
    return anchor($uri, '<i class="fa fa-print"></i>' . $title, array(
        'class'=>'btn btn-print','target'=>'_blank'
    ));
}

function btn_edit($uri, $title = NULL)
{
	return anchor($uri, '<i class="fa fa-edit"></i>' . $title, array(
		'class'=>'btn btn-primary',
	));
}

function btn_delete($uri, $title = '', $small = FALSE, $btn_default = FALSE)
{
    $class = 'btn ';

    if ($small)
    $class .= 'btn-xs ';

    if ($btn_default)
    $class .= 'btn-default ';
    else
    $class .= 'btn-danger ';

    return anchor($uri, '<i class="fa fa-trash-o"></i>' . $title, array(
        'onclick'=>"return confirm('You are about to delete a record. This is cannot be undone. Are you sure?');",
        'class'=> $class
    ));
}

function delete_link($uri, $title = NULL, $small = FALSE)
{
	return anchor($uri, '<i class="glyphicon glyphicon-trash"></i> ' . $title, array(
		'onclick'=>"return confirm('You are about to delete a record. This is cannot be undone. Are you sure?');",
        'class' => 'text-danger lead',
        'title' => 'Delete',
	));
}

function btn_detail($uri, $title = NULL, $attr = NULL)
{
    $html_class = array('class'=>'btn btn-info', 'title' => $title);

    if ( ! empty($attr))
    $html_class = array_merge($html_class, $attr);

    return anchor($uri, '<i class="fa fa-table"></i>' . $title, $html_class);
}

function btn_excel($uri, $title = NULL)
{
    return anchor($uri, '<i class="fa fa-download"></i>' . $title, array(
        'class'=>'btn btn-success', 'title' => $title
    ));
}

function btn_new($uri, $title = NULL, $attr = NULL)
{
    if (is_array($attr))
        $attr = array_merge(array('class' => 'btn btn-primary'), $attr);
    else
        $attr = array('class' => 'btn btn-primary');

    return anchor($uri, '<i class="fa fa-plus"></i> ' . $title, $attr);
}

/**
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
    function dump ($var, $label = 'Dump', $echo = TRUE)
    {
        // Store dump in variable
        ob_start();
        var_dump($var);
        $output = ob_get_clean();

        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';

        // Output
        if ($echo == TRUE) {
            echo $output;
        }
        else {
            return $output;
        }
    }
}


if (!function_exists('dump_exit')) {
    function dump_exit($var, $label = 'Dump', $echo = TRUE) {
        dump ($var, $label, $echo);
        exit;
    }
}

function decimal($str)
{
    return (bool)preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $str);
}

function date_convert_to_mysql($date, $format = "Y-m-d")
{
    // Now convert the date field(s)
    $date = date($format, strtotime($date));
    return $date;
}

function date_convert_to_php($date, $format = "m-d-Y")
{
    // Now convert the date field(s)
    $date = date($format, strtotime($date));
    return $date;
}

function to_decimal($str)
{
    return (float)str_replace(',', '', nf($str, 2));
}

function to_negative($num)
{
    return -1 * abs($num);
}

function to_int($str)
{
    return intval(str_replace(',', '', $str));
}

function t($str)
{
    return strtoupper($str);
}

function l($str)
{
    return strtolower($str);
}

function nf($string, $decimal_places = 0, $default_value = '0')
{
    if (empty($string) || in_array($string, [0, NULL])) 
    return $default_value;
    
    return number_format((float)$string, $decimal_places, '.', ',');
}

function accounting($string, $decimal_places = 2, $default_value = '0.00')
{
    $number = nf($string, $decimal_places, $default_value);
    
    if ($number < 0) 
    {
        $number = abs($number);
        return "( {$number} )";
    }

    return $number;
}

/**
 * Return the value for a key in an array or a property in an object.
 * Typical usage:
 *
 * $object->foo = 'Bar';
 * echo get_key($object, 'foo');
 *
 * $array['baz'] = 'Bat';
 * echo get_key($array, 'baz');
 *
 * @param mixed $haystack
 * @param string $needle
 * @param mixed $default_value The value if key could not be found.
 * @return mixed
 */
function get_key ($haystack, $needle, $default_value = '')
{
    if (is_array($haystack)) {
        // We have an array. Find the key.
        return isset($haystack[$needle]) ? $haystack[$needle] : $default_value;
    }
    else {
        // If it's not an array it must be an object
        return isset($haystack->$needle) ? $haystack->$needle : $default_value;
    }
}


function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}


/**
 * Return value without knowing key in one-pair-associative-aray
 */
function get_array_value_without_key($array)
{
    return end( $array);
}

/**
 * ENUM
 * The submitted string must match one of the values given
 *
 * usage:
 * enum[value_1, value_2, value_n]
 *
 * example (any value beside exactly 'ASC' or 'DESC' are invalid):
 * $rule['order_by'] = "required|enum[ASC,DESC]";
 *
 * example of case-insenstive enum using strtolower as validation rule
 * $rule['favorite_corey'] = "required|strtolower|enum[feldman]";
 *
 * @access    public
 * @param     string $str the input to validate
 * @param     string $val a comma separated lists of values
 * @return    bool
 */
function enum($str, $val='')
{

    if (empty($val))
    {
    return FALSE;
    }

    $arr = explode(',', $val);
    $array = array();
    foreach($arr as $value)
    {
    $array[] = trim($value);
    }

    $this->CI->form_validation->set_message('enum', "%s contains an invalid response");
    return (in_array(trim($str), $array)) ? TRUE : FALSE;
}


// --------------------------------------------------------------------

/**
 * NOT ENUM
 * The submitted string must NOT match one of the values given
 *
 * usage:
 * enum[value_1, value_2, value_n]
 *
 * example (any input beside exactly 'feldman' or 'haim' are valid):
 * $rule['favorite_corey'] = "required|not_enum['feldman','haim']";
 *
 * @access   public
 * @param    string $str the input to validate
 * @param    string $val a comma separated lists of values
 * @return   bool
 */
function not_enum($str, $val='')
{
    return ($this->enum($str,$val) === TRUE)? FALSE : TRUE;
}

function php_date($str='', $format = 'Y-m-d')
{
    return in_array($str, ['', '0000-00-00']) ? '' : date($format, strtotime($str));
}

function payroll_date($str='', $format = 'm/d/Y')
{
    return php_date($str, $format);
}

// function proper_date($str = '', $format = 'M j, Y')
function proper_date($str = '', $format = 'F j, Y')
{
    return php_date($str, $format);
}

// function display_earnings($payroll)
// {
//     if ($payroll->)
//     {

//     }
// }




//The function returns the no. of business days between two dates and it skips the holidays
function getWorkingDays($startDate, $endDate, array $holidays){
    // do strtotime calculations just once
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate);


    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)

        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        }
        else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }

    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
   $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
      $workingDays += $no_remaining_days;
    }

    //We subtract the holidays
    /*foreach($holidays as $holiday){
        $time_stamp=strtotime($holiday);
        //If the holiday doesn't fall in weekend
        if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
            $workingDays--;
    }*/

    return $workingDays;
}

//Example:
// $holidays=array("2008-12-25","2008-12-26","2009-01-01");
// echo getWorkingDays("2008-12-22","2009-01-02",$holidays)
// => will return 7

if ( ! function_exists('pagination') )
{
    function pagination($total_rows, $per_page, $url = null, $uri_segment = 3)
    {
        $ci =& get_instance();

        if (is_null($url)) {
            $segment[] = $ci->router->class;
            $segment[] = $ci->router->method;
            $url = implode("/", $segment);
        }
        // Set up pagination
        $config['base_url']    = site_url($url);
        $config['total_rows']  = $total_rows;
        $config['uri_segment'] = $uri_segment;
        $config['per_page']    = $per_page;

        $ci->load->library('pagination');
        $ci->pagination->initialize($config);
        return $ci->pagination->create_links();
    }
}

/**
 * @param string $expression
 */
function dd($output = '', $label = 'dump')
{
    return die(dump($output, $label));
}

function if_fail_dump($expression, $output)
{
    if (! $expression)
        return dd($output, 'Note');
}

function on_fail($expression, $output)
{
    if (! $expression)
    return $output;
}

function is_greater_than($expression, $value)
{
    if (isset($expression))
    {
        dump($expression);
        if ( (float) $expression > $value)
            return TRUE;
    }
    return FALSE;
}

function get_text_input($isType)
{
    $typeList = ["","text","radio","radio","date"];

    return $typeList[$isType];
}

function is_active_menu($str, $class = 'current-page')
{
    $ci =& get_instance();
    return $ci->uri->uri_string() == $str ? $class : '';
}

/**
 *  parameter 
    $arrayName = array(
                 'name'    => 'button',
                 'class'    => 'btn btn-primary',
                 'id'      => 'button',
                 'value'   => 'true',
                 'type'    => 'reset',
                 'content' => 'Reset'
                ) ;
 */
function btn_default($attr = NULL)
{
    $ci =& get_instance();

    switch ($ci->session->userdata('user_RoleId')) {
        case config_item('cesu_group_id'):
            return form_button($attr);
            break;
        
        default:
            return '';
            break;
    }
}
