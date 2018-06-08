<?php

namespace vendor\validate;

class Required
{
    /**
     * @param array|string $data
     * @return bool
     */
    public static function validate($data)
    {
        if (!is_array($data)) {
            $data = [$data];
        }
        foreach ($data as $item) {
            if (empty($item)) {
                return false;
            }
        }
        return true;
    }
}