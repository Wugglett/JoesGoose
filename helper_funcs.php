<?php
        function Time_To_String($time): string {
            $hour = (int)($time/60/60);
            $time -= $hour*60*60;
            $minute = (int)($time/60);
            $time -= $minute*60;
            $second = (int)$time;
    
            $hour_string = $hour;
            if ($hour<10) $hour_string = "0".$hour;
            
            $minute_string = $minute;
            if ($minute<10) $minute_string = "0".$minute;
    
            $second_string = $second;
            if ($second<10) $second_string = "0".$second;
    
            $time_string = $hour_string.":".$minute_string.":".$second_string;
    
            return $time_string;
        }
?>