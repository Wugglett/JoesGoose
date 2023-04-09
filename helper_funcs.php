<?php
        function Time_To_String($time): string {
            $hour = (int)($time/60/60);
            $time -= $hour*60*60;
            $minute = (int)($time/60);
            $time -= $minute*60;
            $second = (int)$time;
    
            $hour_string = $hour;
            if ($hour == 0) $hour_string = "";
            else $hour_string = $hour.":";
            
            $minute_string = $minute;
            if ($minute<10) $minute_string = "0".$minute.":";
            else $minute_string = $minute_string.":";
    
            $second_string = $second;
            if ($second<10) $second_string = "0".$second;
    
            $time_string = $hour_string.$minute_string.$second_string;
    
            return $time_string;
        }

        function TimeSince($time): string {
            $seconds_since = time() - $time;

            $minutes_since = $seconds_since/60;
            if ($minutes_since < 1) return floor($seconds_since)." seconds ago";

            $hours_since = $minutes_since/60;
            if ($hours_since < 1) return floor($minutes_since)." minutes ago";

            $days_since = $hours_since/24;
            if ($days_since < 1) return floor($hours_since)." hours ago";

            $years_since = $days_since/365;
            if ($years_since < 1) return floor($days_since)." days ago";

            return floor($years_since)." years ago";
        }
