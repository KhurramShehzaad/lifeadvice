<?php

/** PHPExcel root directory */
if (!defined('PHPEXCEL_ROOT')) {
    /**
     * @ignore
     */
    define('PHPEXCEL_ROOT', dirname(__FILE__) . '/../../');
    require(PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php');
}

/** EULER */
define('EULER', 2.71828182845904523536);

/**
 * PHPExcel_Calculation_Engineering
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @category    PHPExcel
 * @package        PHPExcel_Calculation
 * @copyright    Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license        http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version        ##VERSION##, ##DATE##
 */
class PHPExcel_Calculation_Engineering
{
    /**
     * Details of the Units of measure that can be used in CONVERTUOM()
     *
     * @var mixed[]
     */
    private static $conversionUnits = array(
        'g'     => array('Group' => 'Mass',        'Unit Name' => 'Gram',                     'AllowPrefix' => true),
        'sg'    => array('Group' => 'Mass',        'Unit Name' => 'Slug',                     'AllowPrefix' => false),
        'lbm'   => array('Group' => 'Mass',        'Unit Name' => 'Pound mass (avoirdupois)', 'AllowPrefix' => false),
        'u'     => array('Group' => 'Mass',        'Unit Name' => 'U (atomic mass unit)',     'AllowPrefix' => true),
        'ozm'   => array('Group' => 'Mass',        'Unit Name' => 'Ounce mass (avoirdupois)', 'AllowPrefix' => false),
        'm'     => array('Group' => 'Distance',    'Unit Name' => 'Meter',                    'AllowPrefix' => true),
        'mi'    => array('Group' => 'Distance',    'Unit Name' => 'Statute mile',             'AllowPrefix' => false),
        'Nmi'   => array('Group' => 'Distance',    'Unit Name' => 'Nautical mile',            'AllowPrefix' => false),
        'in'    => array('Group' => 'Distance',    'Unit Name' => 'Inch',                     'AllowPrefix' => false),
        'ft'    => array('Group' => 'Distance',    'Unit Name' => 'Foot',                     'AllowPrefix' => false),
        'yd'    => array('Group' => 'Distance',    'Unit Name' => 'Yard',                     'AllowPrefix' => false),
        'ang'   => array('Group' => 'Distance',    'Unit Name' => 'Angstrom',                 'AllowPrefix' => true),
        'Pica'  => array('Group' => 'Distance',    'Unit Name' => 'Pica (1/72 in)',           'AllowPrefix' => false),
        'yr'    => array('Group' => 'Time',        'Unit Name' => 'Year',                     'AllowPrefix' => false),
        'day'   => array('Group' => 'Time',        'Unit Name' => 'Day',                      'AllowPrefix' => false),
        'hr'    => array('Group' => 'Time',        'Unit Name' => 'Hour',                     'AllowPrefix' => false),
        'mn'    => array('Group' => 'Time',        'Unit Name' => 'Minute',                   'AllowPrefix' => false),
        'sec'   => array('Group' => 'Time',        'Unit Name' => 'Second',                   'AllowPrefix' => true),
        'Pa'    => array('Group' => 'Pressure',    'Unit Name' => 'Pascal',                   'AllowPrefix' => true),
        'p'     => array('Group' => 'Pressure',    'Unit Name' => 'Pascal',                   'AllowPrefix' => true),
        'atm'   => array('Group' => 'Pressure',    'Unit Name' => 'Atmosphere',               'AllowPrefix' => true),
        'at'    => array('Group' => 'Pressure',    'Unit Name' => 'Atmosphere',               'AllowPrefix' => true),
        'mmHg'  => array('Group' => 'Pressure',    'Unit Name' => 'mm of Mercury',            'AllowPrefix' => true),
        'N'     => array('Group' => 'Force',       'Unit Name' => 'Newton',                   'AllowPrefix' => true),
        'dyn'   => array('Group' => 'Force',       'Unit Name' => 'Dyne',                     'AllowPrefix' => true),
        'dy'    => array('Group' => 'Force',       'Unit Name' => 'Dyne',                     'AllowPrefix' => true),
        'lbf'   => array('Group' => 'Force',       'Unit Name' => 'Pound force',              'AllowPrefix' => false),
        'J'     => array('Group' => 'Energy',      'Unit Name' => 'Joule',                    'AllowPrefix' => true),
        'e'     => array('Group' => 'Energy',      'Unit Name' => 'Erg',                      'AllowPrefix' => true),
        'c'     => array('Group' => 'Energy',      'Unit Name' => 'Thermodynamic calorie',    'AllowPrefix' => true),
        'cal'   => array('Group' => 'Energy',      'Unit Name' => 'IT calorie',               'AllowPrefix' => true),
        'eV'    => array('Group' => 'Energy',      'Unit Name' => 'Electron volt',            'AllowPrefix' => true),
        'ev'    => array('Group' => 'Energy',      'Unit Name' => 'Electron volt',            'AllowPrefix' => true),
        'HPh'   => array('Group' => 'Energy',      'Unit Name' => 'Horsepower-hour',          'AllowPrefix' => false),
        'hh'    => array('Group' => 'Energy',      'Unit Name' => 'Horsepower-hour',          'AllowPrefix' => false),
        'Wh'    => array('Group' => 'Energy',      'Unit Name' => 'Watt-hour',                'AllowPrefix' => true),
        'wh'    => array('Group' => 'Energy',      'Unit Name' => 'Watt-hour',                'AllowPrefix' => true),
        'flb'   => array('Group' => 'Energy',      'Unit Name' => 'Foot-pound',               'AllowPrefix' => false),
        'BTU'   => array('Group' => 'Energy',      'Unit Name' => 'BTU',                      'AllowPrefix' => false),
        'btu'   => array('Group' => 'Energy',      'Unit Name' => 'BTU',                      'AllowPrefix' => false),
        'HP'    => array('Group' => 'Power',       'Unit Name' => 'Horsepower',               'AllowPrefix' => false),
        'h'     => array('Group' => 'Power',       'Unit Name' => 'Horsepower',               'AllowPrefix' => false),
        'W'     => array('Group' => 'Power',       'Unit Name' => 'Watt',                     'AllowPrefix' => true),
        'w'     => array('Group' => 'Power',       'Unit Name' => 'Watt',                     'AllowPrefix' => true),
        'T'     => array('Group' => 'Magnetism',   'Unit Name' => 'Tesla',                    'AllowPrefix' => true),
        'ga'    => array('Group' => 'Magnetism',   'Unit Name' => 'Gauss',                    'AllowPrefix' => true),
        'C'     => array('Group' => 'Temperature', 'Unit Name' => 'Celsius',                  'AllowPrefix' => false),
        'cel'   => array('Group' => 'Temperature', 'Unit Name' => 'Celsius',                  'AllowPrefix' => false),
        'F'     => array('Group' 