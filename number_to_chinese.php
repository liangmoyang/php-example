<?
/**
 * 数字转中文
 */
function number2chinese($num)
{
    if (is_int($num) && $num < 100) {
        $char = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $unit = ['', '十', '百', '千', '万'];
        $return = '';
        if ($num < 10) {
            $return = $char[$num];
        } elseif ($num % 10 == 0) {
            $firstNum = substr($num, 0, 1);
            if ($num != 10) $return .= $char[$firstNum];
            $return .= $unit[strlen($num) - 1];
        } elseif ($num < 20) {
            $return = $unit[substr($num, 0, -1)] . $char[substr($num, -1)];
        } else {
            $numData = str_split($num);
            $numLength = count($numData) - 1;
            foreach ($numData as $k => $v) {
                if ($k == $numLength) continue;
                $return .= $char[$v];
                if ($v != 0) $return .= $unit[$numLength - $k];
            }
            $return .= $char[substr($num, -1)];
        }
        return $return;
    }
}
