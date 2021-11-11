<?php

namespace App\Helpers;

class Helper
{
    public static function instance()
    {
        return new Helper();
    }

    public function conditionMinMaxVariable($objectModel, $minValue, $maxValue, $minValueCompare, $maxValueCompare, $colCompare)
    {
        if ($minValue == $minValueCompare && $maxValue == $maxValueCompare) {
            $minValue = 0;
            $objectModel->where($colCompare, '>', (int)$minValue);
        } elseif ($minValue == $minValueCompare) {
            $minValue = 0;
            $objectModel->whereBetween($colCompare, [(int)$minValue, (int)$maxValue]);
        } elseif ($maxValue == $maxValueCompare) {
            $objectModel->where($colCompare, '>=', (int)$minValue);
        } else {
            $objectModel->whereBetween($colCompare, [(int)$minValue, (int)$maxValue]);
        }

        return $objectModel;
    }
}
