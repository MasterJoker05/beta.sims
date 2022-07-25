<?php

/**
 * Usage: $results = searcharray('searchvalue', searchkey, $array);
 **/

function searcharray($value, $key, $array)
{
   foreach ($array as $k => $val) {
       if ($val[$key] == $value) {
           return $k;
       }
   }
   return NULL;
}

/**
 * Remove_key helper. Functions to remove_key variables while maintaining array data.
 * @author Brando Talaguit
 * @version 1.0
 * $removeKeys
 * $array(0 => array(), ...);
 * $search_key_name
 */
if (!function_exists('remove_key')) {
  function remove_key($removeKeys, $array, $search_key_name = 'FeeId')
  {
    // loop through $array
    foreach ($array as $key => $row)
    {
      // test if the search key name exists in row array
      if (in_array($search_key_name, array_keys($row)))
      {
        if (is_array($removeKeys))
        {
          // we compare FeeId value in array $removeKeys
          if (in_array($row[$search_key_name], $removeKeys))
          {
            // then remove key
            unset($array[$key]);
          }
        }
        else
        {
          if ($row[$search_key_name] == $removeKeys)
          {
            unset($array[$key]);
          }
        }
      }
    }

    return $array;
  }
}


/**
 * Extract_key helper. Functions to extract_key variables to the variable.
 * @author Brando Talaguit
 * @version 1.0
 * $removeKeys
 * $array(0 => array(), ...);
 * $search_key_name
 */
if (!function_exists('extract_key')) {
  function extract_key($extractKeys, $array, $search_key_name = 'FeeId', $single = TRUE)
  {
    $data = [];
    // loop through $array
    foreach ($array as $key => $row)
    {
      // test if the search key name exists in row array
      if (in_array($search_key_name, array_keys($row)))
      {
        if (is_array($extractKeys))
        {
          // we compare FeeId value in array $extractKeys
          if (in_array($row[$search_key_name], $extractKeys))
          {
            if ($single == TRUE)
            {
              return $row;
            }

            // then add to data array
            $data[] = $row;
          }
        }
        else
        {
          if ($row[$search_key_name] == $extractKeys)
          {
            if ($single == TRUE)
            {
              return $row;
            }

            $data[] = $row;
          }
        }
      }
    }

    return $data;
  }
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


function mysql_date($date = '', $format = 'Y-m-d')
{
    return php_date($format, $date);
}


// function l($str)
// {
//     return strtolower($str);
// }

function computeFee($Fee)
{
  $Sum = 0;
  foreach ($Fee as $key => $FeeData)
  {
    $Sum += get_num($FeeData, 'Amount');
  }
  // dump($Sum);
  return $Sum;
}

function array_column_manual($array, $column)
{
    $newarr = array();
    foreach ($array as $row) $newarr[] = $row[$column];
    return $newarr;
}

function getMiscFee($MiscPayment,$MiscFee)
{
  // dump($MiscFee);
  if (!empty($MiscPayment))
  {
    foreach ($MiscPayment as $key => $row)
    {
      $amount = to_decimal(get_num($row, 'Amount'));

      if ($amount > 0)
      {

        $index = searchForId($row['FeeId'], $MiscFee, 'FeeId');

        if ($index >= 0)
        {
          unset($MiscFee[$index]);
        }

      }
    }

   return computeFee($MiscFee);

  }
  else
    return computeFee($MiscFee);
}

function getPartialFee($TokenFee,$Misc,$NSTP,$ID)
{
  $Partial = 500;

  if (get_key($TokenFee, 'FeeId') == 21)
    $Partial = 1000;

  if (get_key($TokenFee, 'FeeId') == 47)
    $Partial = 750;

  if (get_num($TokenFee, 'Amount') == 0)
    $Partial = 0;

  if ($Partial > get_num($TokenFee, 'Amount') )
    $Partial = get_num($TokenFee, 'Amount');

  // dump($TokenFee['Amount']);
  // dump($Partial);


  $Partial +=  $Misc;
  $Partial +=  $NSTP;
  $Partial +=  $ID;

  return $Partial;
}

function get_year_level($curriculum_id, $college_id, $LengthOfStayBySem)
{
        //if ($college_id == 6 && !in_array($curriculum_id, array('53')))
    if (in_array($college_id, array('6','11')) && !in_array($curriculum_id, array('53')))
        {
            $data['semester'] = array(  1  => 'First Year' ,
                                        2  => 'First Year',
                                        3  => 'First Year',
                                        4  => 'Second Year',
                                        5  => 'Second Year',
                                        6  => 'Second Year',
                                        7  => 'Third Year',
                                        8  => 'Third Year',
                                        9  => 'Third Year',
                                        10 => 'Fourth Year',
                                        11 => 'Fourth Year');

        }
        else
        {
            switch ($curriculum_id)
            {
                case '55':  # BACHELOR OF SCIENCE IN CIVIL ENGINEERING
                    $data['semester'] = array(  1  => 'First Year' ,
                                                2  => 'First Year',
                                                3  => 'Second Year',
                                                4  => 'Second Year',
                                                5  => 'Third Year',
                                                6  => 'Third Year',
                                                7  => 'Fourth Year',
                                                8  => 'Fourth Year',
                                                9  => 'Fourth Year',
                                                10 => 'Fifth Year',
                                                11 => 'Fifth Year');
                    break;

                    case '53':  # BACHELOR OF SCIENCE IN RADIOLOGIC TECHNOLOGY
                    $data['semester'] = array(  1  =>'First Year' ,
                                                2  =>'First Year',
                                                3  =>'First Year',
                                                4  =>'Second Year',
                                                5  =>'Second Year',
                                                6  =>'Second Year',
                                                7  =>'Third Year',
                                                8  =>'Third Year',
                                                9  =>'Fourth Year',
                                                10 =>'Fourth Year');
                    break;

                    case '25': # BACHELOR OF SCIENCE IN ACCOUNTANCY FIFTH YEAR PROGRAM
                    $data['semester'] = array(  1  =>'Fifth Year' ,
                                                2  =>'Fifth Year',
                                                10  =>'Fifth Year',
                                                11  =>'Fifth Year');
                    break;

                    case '66':  # DIPLOMA IN CIVIL TECHNOLOGY (DCET)
                    $data['semester'] = array(  1  =>'First Year' ,
                                                2  =>'First Year',
                                                3  =>'Second Year',
                                                4  =>'Second Year',
                                                5  =>'Second Year',
                                                6  =>'Third Year',
                                                7  =>'Third Year');
                    break;
                     case '189':  # BACHELOR IN PHYSICAL WELLNESS MAJOR IN SPORTS MANAGEMENT
                     case '210':  # BACHELOR IN PHYSICAL WELLNESS MAJOR IN SPORTS MANAGEMENT
                        $data['semester'] = array(      1  => 'First Year',
                                                        2  => 'First Year',
                                                        3  => 'Second Year',
                                                        4  => 'Second Year',
                                                        5  => 'Second Year',
                                                        6  => 'Third Year',
                                                        7  => 'Third Year',
                                                        8  => 'Third Year',
                                                        9  => 'Fourth Yearr',
                                                        10  => 'Fourth Year');
                        break;

                default:    # REGULAR PROGRAM
                    $data['semester'] = array(  0  => '',
                                    1  => 'First Year' ,
                                                2  => 'First Year',
                                                3  => 'Second Year',
                                                4  => 'Second Year',
                                                5  => 'Third Year',
                                                6  => 'Third Year',
                                                7  => 'Fourth Year',
                                                8  => 'Fourth Year',
                                                9  => 'Fifth Year',
                                                10 => 'Fifth Year');
                    break;

            } # end case


        } # end if

        return $data['semester'][$LengthOfStayBySem];
}

function searchForId($id, $array, $fieldname = 'Id') {
   foreach ($array as $key => $val) {
       if (intval($val[$fieldname]) === intval($id)) {
           return $key;
       }
   }
   return NULL;
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
function get_num ($haystack, $needle)
{
    return get_key($haystack, $needle, 0);
}

function totime($date)
{
    return empty($date) ? '' : strtotime($date);
}

function OrdinalNumberSuffix($num)
{
    if (!in_array(($num % 100),array(11,12,13)))
    {
      switch ($num % 10)
      {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'st';
        case 2:  return $num.'nd';
        case 3:  return $num.'rd';
      }
    }
    return $num.'th';
}

function permanentRecord($data)
{
    $newData = [];

    foreach ($data as $key => $dataVal) 
    {
        $newData[$dataVal->SyDesc][$dataVal->SemDesc][] = array(
            "CourseCode" => $dataVal->CourseCode,
            "CourseDesc" => $dataVal->CourseDesc,
            "StrGrade"   => $dataVal->StrGrade,
            "StrLab"     => $dataVal->StrLab,
            "RVal"       => $dataVal->RVal,
            "RValLab"    => $dataVal->RValLab,
            "Remarks"    => $dataVal->Remarks,
            "Cfn"        => $dataVal->nametable,
            "units"      => $dataVal->units,

        ); 
    }

    return $newData;
}

function permanentRecordPrint($data)
{
    $newData = [];

    foreach ($data as $key => $dataVal) 
    {
        $newData[$dataVal->SyDesc][$dataVal->SemCode][] = array(
            "CourseCode" => $dataVal->CourseCode,
            "CourseDesc" => $dataVal->CourseDesc,
            "StrGrade"   => $dataVal->StrGrade,
            "StrLab"     => $dataVal->StrLab,
            "RVal"       => $dataVal->RVal,
            "RValLab"    => $dataVal->RValLab,
            "Remarks"    => $dataVal->Remarks,
            "Cfn"        => $dataVal->nametable,
            "units"      => $dataVal->units,

        ); 
    }

    return $newData;
}


function semDescConvert($id)
{
    $data['sem'] = array (
                            1 =>array(
                                'Code' => '1st Sem.',
                                'Desc' =>  'First Semester',
                            ),
                            2 =>array(
                                'Code' => '2nd Sem.',
                                'Desc' =>  'Second Semester',
                            ),
                            3 =>array(
                                'Code' => 'Summer',
                                'Desc' =>  'Summer',
                            ),
                        );
    return $data['sem'][$id];
}
