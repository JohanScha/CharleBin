<?php
/**
 * PrivateBin
 *
 * A zero-knowledge paste bin
 *
 * @copyright 2012 Sébastien SAUVAGE (sebsauvage.net)
 * @license   https://www.opensource.org/licenses/zlib-license.php The zlib/libpng License
 * @version   1.5.1
 * @link      https://github.com/PrivateBin/PrivateBin
 * 
 */

namespace PrivateBin;

use Exception;

/**
 * Filter
 *
 * Provides data filtering functions.
 */
class Filter
{
    /**
     * Format a given time string into a human readable label (localized)
     *
     * Accepts times in the format "[integer][time unit]"
     *
     * @access public
     * @static
     * @param  string $time
     * @throws Exception
     * @return string
     */
    public static function formatHumanReadableTime($time)
    {
        if (preg_match('/^(\d+) *(\w+)$/', $time, $matches) !== 1) {
            throw new Exception("Error parsing time format '$time'", 30);
        }
        switch ($matches[2]) {
        case 'sec':
                $unit = 'second';
                break;
        case 'min':
                $unit = 'minute';
                break;
        default:
                $unit = rtrim($matches[2], 's');
        }
        return I18n::_(array('%d ' . $unit, '%d ' . $unit . 's'), (int) $matches[1]);
    }

    /**
     * Format a given number of bytes in IEC 80000-13:2008 notation (localized)
     *
     * @access public
     * @static
     * @param  int $size
     * @return string
     */
    public static function formatHumanReadableSize($size)
    {
        $iec = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
        $i   = 0;
        while (($size / 1024) >= 1) {
            $size = $size / 1024;
            ++$i;
        }
        return number_format($size, ($i ? 2 : 0), '.', ' ').' '.I18n::_($iec[$i]);
    }
}
