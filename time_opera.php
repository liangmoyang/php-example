<?php 

namespace app\common;

class Date{

    /**
     * 计算两个时间段之间交集的天数
     * @param $startDate1 开始日期1
     * @param $endDate1 结束日期1
     * @param $startDate2 开始日期2
     * @param $endDate2 结束日期2
     */
    static function share_date_days($startDate1, $endDate1, $startDate2, $endDate2)
    {

        $days = 0;

        $startDate1 = strtotime($startDate1);// 开始日期1
        $endDate1 = strtotime($endDate1);// 结束日期1
        $startDate2 = strtotime($startDate2);// 开始日期2
        $endDate2 = strtotime($endDate2);// 结束日期2
        /** ------------ 临界值换算 ------start------ */

        // 如果日期1的结束日期小于日期二的开始日期，则返回0
        if($endDate1 < $startDate2){
            $days = 0;
        }

        // 如果日期1的开始日期小于日期二的结束日期，则返回0
        if($startDate1 > $endDate2){
            $days = 0;
        }

        // 如果日期1的结束日期等于日期2的开始日期，则返回1
        if($endDate1 == $startDate2){
            $days = 1;
        }

        // 如果日期1的开始日期等于日期2的结束日期，则返回1
        if($startDate2 == $endDate1){
            $days = 1;
        }

        /** ------------ 临界值换算 ------end------ */

        /** ------------ 交集换算 ------start------ */

        // 如果开始日期1小于开始日期2，且开始日期2小于结束小于结束日期1
        if($startDate1 < $startDate2 && $endDate1 > $startDate2){
            // 如果结束日期1小于或者等于结束日期2
            if($endDate1 <= $endDate2){
                $days = self::diffBetweenTwoDays($startDate2, $endDate1) + 1;
            }

            // 如果结束日期1大于结束日期2
            if($endDate1 > $endDate2){
                $days = self::diffBetweenTwoDays($startDate2, $endDate2) + 1;
            }
        }

        // 如果开始日期1大于开始日期2，且开始日期1小于结束日期2
        if($startDate1 > $startDate2 && $startDate1 < $endDate2){
            // 如果结束日期1小于等于结束日期2
            if($endDate1 <= $endDate2){
                $days = self::diffBetweenTwoDays($startDate1, $endDate2) + 1;
            }

            // 如果结束日期1大于结束日期2
            if($endDate1 > $endDate2){
                $days = self::diffBetweenTwoDays($startDate1, $endDate2) + 1;
            }
        }

        // 开始日期1等于开始日期2
        if($startDate1 == $startDate2){
            // 结束日期1小于等于结束日期2
            if($endDate1 <= $endDate2){
                $days = self::diffBetweenTwoDays($startDate1, $endDate1) + 1;
            }

            // 结束日期1大于结束日期2
            if($endDate1 > $endDate2){
                $days = self::diffBetweenTwoDays($startDate1, $endDate2) + 1;
            }
        }

        // 结束日期1等于结束日期2
        if($endDate1 == $endDate2){
            // 开始日期1小于等于开始日期2
            if($startDate1 <= $startDate2){
                $days = self::diffBetweenTwoDays($startDate2, $endDate1) + 1;
            }

            // 开始日期1大于开始日期2
            if($startDate1 > $startDate2){
                $days = self::diffBetweenTwoDays($startDate1, $endDate1) + 1;
            }
        }

        // 时间段1在时间段2内
        if($startDate1 >= $startDate2 && $endDate1 <= $endDate2){
            $days = self::diffBetweenTwoDays($startDate1, $endDate1) + 1;
        }

        // 时间段1包含时间段2
        if($startDate1 < $startDate2 && $endDate1 > $endDate2){
            $days = self::diffBetweenTwoDays($startDate2, $endDate2) + 1;
        }

        /** ------------ 交集换算 ------end------ */
        return $days;
    }


    /**
    * 求两个日期之间相差的天数
    * (针对1970年1月1日之后，求之前可以采用泰勒公式)
    * @param string $day1
    * @param string $day2
    * @return number
    */
    static  function diffBetweenTwoDays($day1, $day2)
    {
        // 可以识别时间格式 Roy 2020年5月9日 11:10:14
        $day1 = $day1 && !is_numeric($day1) ? strtotime($day1) : $day1; 
        $day2 = $day2 && !is_numeric($day2) ? strtotime($day2) : $day2;

        if ($day1 < $day2) {
            $tmp = $day2;
            $day2 = $day1;
            $day1 = $tmp;
        }

        return ($day1 - $day2) / 86400;
    }

}