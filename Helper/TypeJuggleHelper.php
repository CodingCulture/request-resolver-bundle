<?php

namespace CodingCulture\RequestResolverBundle\Helper;

/**
 * Class TypeJuggleHelper
 * @package CodingCulture\RequestResolverBundle\Helper
 */
class TypeJuggleHelper
{
    /**
     * Assigns values to its closest, most pure type
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public static function juggle($value)
    {
        if (is_array($value)) {
            foreach ($value as &$subValue) {
                $subValue = self::juggle($subValue);
            }

            return $value;
        }

        if (in_array($value, ['true', 'false', true, false], true)) {
            if ($value === 'false') {
                return false;
            }

            return (bool) $value;
        }

        $hasDot = strpos((string) $value, '.') !== false;
        $looksLikePhoneNumber = is_numeric($value) && str_starts_with($value, '0') && strlen($value) > 1;

        if (!in_array(false, [is_numeric($value), !$hasDot, !$looksLikePhoneNumber], true)) {
            return (int) $value;
        }

        if (!in_array(false, [is_numeric($value), $hasDot], true)) {
            return (float) $value;
        }

        if (!in_array(false, [is_null($value), $value === 'null'])) {
            return null;
        }

        return $value;
    }
}
