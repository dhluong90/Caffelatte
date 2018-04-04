<?php

namespace App\Http\Helpers;
Class TimeHelper {
     /**
      * Convert day numeric to day string of week
      * @param $day_convert
      * @return $days_of_week
      */
     public static function convert_day_of_week($day_convert) {
          $days_of_week = '';
          switch ($day_convert) {
               case '1': case 1:
                    $days_of_week = 'Monday';
                    break;
               case '2': case 2:
                    $days_of_week = 'Tuesday';
                    break;
               case '3': case 3:
                    $days_of_week = 'Wednesday';
                    break;
               case '4': case 4:
                    $days_of_week = 'Thursday';
                    break;
               case '5': case 5:
                    $days_of_week = 'Friday';
                    break;
               case '6': case 6:
                    $days_of_week = 'Saturday';
                    break;
               case '7': case 7:
                    $days_of_week = 'Sunday';
                    break;
               default:
                    return FALSE;
          }
          $day_current = date('N');
          if ($day_convert < $day_current) {
               $days_of_week = $days_of_week.' - 1 weeks';
          }
          return $days_of_week;
     }
    /**
     * check store open by time
     * @param $start_time
     * @param $end_time
     * @param $start_day
     * @param $end_day
     * @return boolean
     */
     public static function check_time_open($start_time, $end_time, $start_day, $end_day) {
          date_default_timezone_set("Asia/Ho_Chi_Minh");
          $time_current = date('H:i:s');
          $date_current = date('Y-m-d');
          $day_of_week = TimeHelper::convert_day_of_week(date('N'));
          $time_current = $date_current . " " . $time_current;

          $start_day = TimeHelper::convert_day_of_week($start_day);
          $end_day = TimeHelper::convert_day_of_week($end_day);
          $start_time = $date_current . " " . $start_time;
          $end_time = $date_current . " " . $end_time;
          
          if (strtotime($start_time) > strtotime($end_time)) {
               $end_time = date('Y-m-d H:i:s', strtotime($end_time . ' + 1 days'));
          }

          if (strtotime($start_time) <= strtotime($time_current)  && strtotime($time_current) <= strtotime($end_time)) {
               if (strtotime($start_day) <= strtotime($day_of_week) && strtotime($day_of_week) <= strtotime($end_day)) {
                    return TRUE;
               }
               return FALSE;
          } else {
               return FALSE;
          }
     }
}