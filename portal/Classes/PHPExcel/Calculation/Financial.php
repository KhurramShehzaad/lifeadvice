<?php

/** PHPExcel root directory */
if (!defined('PHPEXCEL_ROOT')) {
    /**
     * @ignore
     */
    define('PHPEXCEL_ROOT', dirname(__FILE__) . '/../../');
    require(PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php');
}

/** FINANCIAL_MAX_ITERATIONS */
define('FINANCIAL_MAX_ITERATIONS', 128);

/** FINANCIAL_PRECISION */
define('FINANCIAL_PRECISION', 1.0e-08);

/**
 * PHPExcel_Calculation_Financial
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
class PHPExcel_Calculation_Financial
{
    /**
     * isLastDayOfMonth
     *
     * Returns a boolean TRUE/FALSE indicating if this date is the last date of the month
     *
     * @param    DateTime    $testDate    The date for testing
     * @return    boolean
     */
    private static function isLastDayOfMonth($testDate)
    {
        return ($testDate->format('d') == $testDate->format('t'));
    }


    /**
     * isFirstDayOfMonth
     *
     * Returns a boolean TRUE/FALSE indicating if this date is the first date of the month
     *
     * @param    DateTime    $testDate    The date for testing
     * @return    boolean
     */
    private static function isFirstDayOfMonth($testDate)
    {
        return ($testDate->format('d') == 1);
    }


    private static function couponFirstPeriodDate($settlement, $maturity, $frequency, $next)
    {
        $months = 12 / $frequency;

        $result = PHPExcel_Shared_Date::ExcelToPHPObject($maturity);
        $eom = self::isLastDayOfMonth($result);

        while ($settlement < PHPExcel_Shared_Date::PHPToExcel($result)) {
            $result->modify('-'.$months.' months');
        }
        if ($next) {
            $result->modify('+'.$months.' months');
        }

        if ($eom) {
            $result->modify('-1 day');
        }

        return PHPExcel_Shared_Date::PHPToExcel($result);
    }


    private static function isValidFrequency($frequency)
    {
        if (($frequency == 1) || ($frequency == 2) || ($frequency == 4)) {
            return true;
        }
        if ((PHPExcel_Calculation_Functions::getCompatibilityMode() == PHPExcel_Calculation_Functions::COMPATIBILITY_GNUMERIC) &&
            (($frequency == 6) || ($frequency == 12))) {
            return true;
        }
        return false;
    }


    /**
     * daysPerYear
     *
     * Returns the number of days in a specified year, as defined by the "basis" value
     *
     * @param    integer        $year    The year against which we're testing
     * @param   integer        $basis    The type of day count:
     *                                    0 or omitted US (NASD)    360
     *                                    1                        Actual (365 or 366 in a leap year)
     *                                    2                        360
     *                                    3                        365
     *                                    4                        European 360
     * @return    integer
     */
    private static function daysPerYear($year, $basis = 0)
    {
        switch ($basis) {
            case 0:
            case 2:
            case 4:
                $daysPerYear = 360;
                break;
            case 3:
                $daysPerYear = 365;
                break;
            case 1:
                $daysPerYear = (PHPExcel_Calculation_DateTime::isLeapYear($year)) ? 366 : 365;
                break;
            default:
                return PHPExcel_Calculation_Functions::NaN();
        }
        return $daysPerYear;
    }


    private static function interestAndPrincipal($rate = 0, $per = 0, $nper = 0, $pv = 0, $fv = 0, $type = 0)
    {
        $pmt = self::PMT($rate, $nper, $pv, $fv, $type);
        $capital = $pv;
        for ($i = 1; $i<= $per; ++$i) {
            $interest = ($type && $i == 1) ? 0 : -$capital * $rate;
            $principal = $pmt - $interest;
            $capital += $principal;
        }
        return array($interest, $principal);
    }


    /**
     * ACCRINT
     *
     * Returns the accrued interest for a security that pays periodic interest.
     *
     * Excel Function:
     *        ACCRINT(issue,firstinterest,settlement,rate,par,frequency[,basis])
     *
     * @access    public
     * @category Financial Functions
     * @param    mixed    $issue            The security's issue date.
     * @param    mixed    $firstinterest    The security's first interest date.
     * @param    mixed    $settlement        The security's settlement date.
     *                                    The security settlement date is the date after the issue date
     *                                    when the security is traded to the buyer.
     * @param    float    $rate            The security's annual coupon rate.
     * @param    float    $par            The security's par value.
     *                                    If you omit par, ACCRINT uses $1,000.
     * @param    integer    $frequency        the number of coupon payments per year.
     *                                    Valid frequency values are:
     *                                        1    Annual
     *                                        2    Semi-Annual
     *                                        4    Quarterly
     *                                    If working in Gnumeric Mode, the following frequency options are
     *                                    also available
     *                                        6    Bimonthly
     *                                        12    Monthly
     * @param    integer    $basis            The type of day count to use.
     *                                        0 or omitted    US (NASD) 30/360
     *                                        1                Actual/actual
     *                                        2                Actual/360
     *                                        3                Actual/365
     *                                        4                European 30/360
     * @return    float
     */
    public static function ACCRINT($issue, $firstinterest, $settlement, $rate, $par = 1000, $frequency = 1, $basis = 0)
    {
        $issue        = PHPExcel_Calculation_Functions::flattenSingleValue($issue);
        $firstinterest    = PHPExcel_Calculation_Functions::flattenSingleValue($firstinterest);
        $settlement    = PHPExcel_Calculation_Functions::flattenSingleValue($settlement);
        $rate        = PHPExcel_Calculation_Functions::flattenSingleValue($rate);
        $par        = (is_null($par))        ? 1000 :    PHPExcel_Calculation_Functions::flattenSingleValue($par);
        $frequency    = (is_null($frequency))    ? 1    :         PHPExcel_Calculation_Functions::flattenSingleValue($frequency);
        $basis        = (is_null($basis))        ? 0    :        PHPExcel_Calculation_Functions::flattenSingleValue($basis);

        //    Validate
        if ((is_numeric($rate)) && (is_numeric($par))) {
            $rate    = (float) $rate;
            $par    = (float) $par;
            if (($rate <= 0) || ($par <= 0)) {
                return PHPExcel_Calculation_Functions::NaN();
            }
            $daysBetweenIssueAndSettlement = PHPExcel_Calculation_DateTime::YEARFRAC($issue, $settlement, $basis);
            if (!is_numeric($daysBetweenIssueAndSettlement)) {
                //    return date error
                return $daysBetweenIssueAndSettlement;
            }

            return $par * $rate * $daysBetweenIssueAndSettlement;
        }
        return PHPExcel_Calculation_Functions::VALUE();
    }


    /**
     * ACCRINTM
     *
     * Returns the accrued interest for a security that pays interest at maturity.
     *
     * Excel Function:
     *        ACCRINTM(issue,settlement,rate[,par[,basis]])
     *
     * @access    public
     * @category Financial Functions
     * @param    mixed    issue        The security's issue date.
     * @param    mixed    settlement    The security's settlement (or maturity) date.
     * @param    float    rate        The security's annual coupon rate.
     * @param    float    par            The security's par value.
     *                                    If you omit par, ACCRINT uses $1,000.
     * @param    integer    basis        The type of day count to use.
     *                                        0 or omitted    US (NASD) 30/360
     *                                        1                Actual/actual
     *                                        2                Actual/360
     *                                        3                Actual/365
     *                                        4                European 30/360
     * @return    float
     */
    public static function ACCRINTM($issue, $settlement, $rate, $par = 1000, $basis = 0)
    {
        $issue        = PHPExcel_Calculation_Functions::flattenSingleValue($issue);
        $settlement    = PHPExcel_Calculation_Functions::flattenSingleValue($settlement);
        $rate        = PHPExcel_Calculation_Functions::flattenSingleValue($rate);
        $par        = (is_null($par))    ? 1000 :    PHPExcel_Calculation_Functions::flattenSingleValue($par);
        $basis        = (is_null($basis))    ? 0 :        PHPExcel_Calculation_Functions::flattenSingleValue($basis);

        //    Validate
        if ((is_numeric($rate)) && (is_numeric($par))) {
            $rate    = (float) $rate;
            $par    = (float) $par;
            if (($rate <= 0) || ($par <= 0)) {
                return PHPExcel_Calculation_Functions::NaN();
            }
            $daysBetweenIssueAndSettlement = PHPExcel_Calculation_DateTime::YEARFRAC($issue, $settlement, $basis);
            if (!is_numeric($daysBetweenIssueAndSettlement)) {
                //    return date error
                return $daysBetweenIssueAndSettlement;
            }
            return $par * $rate * $daysBetweenIssueAndSettlement;
        }
        return PHPExcel_Calculation_Functions::VALUE();
    }


    /**
     * AMORDEGRC
     *
     * Returns the depreciation for each accounting period.
     * This function is provided for the French accounting system. If an asset is purchased in
     * the middle of the accounting period, the prorated depreciation is taken into account.
     * The function is similar to AMORLINC, except that a depreciation coefficient is applied in
     * the calculation depending on the life of the assets.
     * This function will return the depreciation until the last period of the life of the assets
     * or until the cumulated value of depreciation is greater than the cost of the assets minus
     * the salvage value.
     *
     * Excel Function:
     *        AMORDEGRC(cost,purchased,firstPeriod,salvage,period,rate[,basis])
     *
     * @access    public
     * @category Financial Functions
     * @param    float    cost        The cost of the asset.
     * @param    mixed    purchased    Date of the purchase of the asset.
     * @param    mixed    firstPeriod    Date of the end of the first period.
     * @param    mixed    salvage        The salvage value at the end of the life of the asset.
     * @param    float    period        The period.
     * @param    float    rate        Rate of depreciation.
     * @param    integer    basis        The type of day count to use.
     *                                        0 or omitted    US (NASD) 30/360
     *                                        1                Actual/actual
     *                                        2                Actual/360
     *                                        3                Actual/365
     *                                        4                European 30/360
     * @return    float
     */
    public static function AMORDEGRC($cost, $purchased, $firstPeriod, $salvage, $period, $rate, $basis = 0)
    {
        $cost            = PHPExcel_Calculation_Functions::flattenSingleValue($cost);
        $purchased        = PHPExcel_Calculation_Functions::flattenSingleValue($purchased);
        $firstPeriod    = PHPExcel_Calculation_Functions::flattenSingleValue($firstPeriod);
        $salvage        = PHPExcel_Calculation_Functions::flattenSingleValue($salvage);
        $period            = floor(PHPExcel_Calculation_Functions::flattenSingleValue($period));
        $rate            = PHPExcel_Calculation_Functions::flattenSingleValue($rate);
        $basis            = (is_null($basis))    ? 0 :    (int) PHPExcel_Calculation_Functions::flattenSingleValue($basis);

        //    The depreciation coefficients are:
        //    Life of assets (1/rate)        Depreciation coefficient
        //    Less than 3 years            1
        //    Between 3 and 4 years        1.5
        //    Between 5 and 6 years        2
        //    More than 6 years            2.5
        $fUsePer = 1.0 / $rate;
        if ($fUsePer < 3.0) {
            $amortiseCoeff = 1.0;
        } elseif ($fUsePer < 5.0) {
            $amortiseCoeff = 1.5;
        } elseif ($fUsePer <= 6.0) {
            $amortiseCoeff = 2.0;
        } else {
            $amortiseCoeff = 2.5;
        }

        $rate *= $amortiseCoeff;
        $fNRate = round(PHPExcel_Calculation_DateTime::YEARFRAC($purchased, $firstPeriod, $basis) * $rate * $cost, 0);
        $cost -= $fNRate;
        $fRest = $cost - $salvage;

        for ($n = 0; $n < $period; ++$n) {
            $fNRate = round($rate * $cost, 0);
            $fRest -= $fNRate;

            if ($fRest < 0.0) {
                switch ($period - $n) {
                    case 0:
                    case 1:
                        return round($cost * 0.5, 0);
                    default:
                        return 0.0;
                }
            }
            $cost -= $fNRate;
        }
        return $fNRate;
    }


    /**
     * AMORLINC
     *
     * Returns the depreciation for each accounting period.
     * This function is provided for the French accounting system. If an asset is purchased in
     * the middle of the accounting period, the prorated depreciation is taken into account.
     *
     * Excel Function:
     *        AMORLINC(cost,purchased,firstPeriod,salvage,period,rate[,basis])
     *
     * @access    public
     * @category Financial Functions
     * @param    float    cost        The cost of the asset.
     * @param    mixed    purchased    Date of the purchase of the asset.
     * @param    mixed    firstPeriod    Date of the end of the first period.
     * @param    mixed    salvage        The salvage value at the end of the life of the asset.
     * @param    float    period        The period.
     * @param    float    rate        Rate of depreciation.
     * @param    integer    basis        The type of day count to use.
     *                                        0 or omitted    US (NASD) 30/360
     *                                        1                Actual/actual
     *                                        2                Actual/360
     *                                        3                Actual/365
     *                                        4                European 30/360
     * @return    float
     */
    public static function AMORLINC($cost, $purchased, $firstPeriod, $salvage, $period, $rate, $basis = 0)
    {
        $cost        = PHPExcel_Calculation_Functions::flattenSingleValue($cost);
        $purchased   = PHPExcel_Calculation_Functions::flattenSingleValue($purchased);
        $firstPeriod = PHPExcel_Calculation_Functions::flattenSingleValue($firstPeriod);
        $salvage     = PHPExcel_Calculation_Functions::flattenSingleValue($salvage);
        $period      = PHPExcel_Calculation_Functions::flattenSingleValue($period);
        $rate        = PHPExcel_Calculation_Functions::flattenSingleValue($rate);
        $basis       = (is_null($basis)) ? 0 : (int) PHPExcel_Calculation_Functions::flattenSingleValue($basis);

        $fOneRate = $cost * $rate;
        $fCostDelta = $cost - $salvage;
        //    Note, quirky variation for leap years on the YEARFRAC for this function
        $purchasedYear = PHPExcel_Calculation_DateTime::YEAR($purchased);
        $yearFrac = PHPExcel_Calculation_DateTime::YEARFRAC($purchased, $firstPeriod, $basis);

        if (($basis == 1) && ($yearFrac < 1) && (PHPExcel_Calculation_DateTime::isLeapYear($purchasedYear))) {
            $yearFrac *= 365 / 366;
        }

        $f0Rate = $yearFrac * $rate * $cost;
        $nNumOfFullPeriods = intval(($cost - $salvage - $f0Rate) / $fOneRate);

        if ($period == 0) {
            return $f0Rate;
        } elseif ($period <= $nNumOfFullPeriods) {
            return $fOneRate;
        } elseif ($period == ($nNumOfFullPeriods + 1)) {
            return ($fCostDelta - $fOneRate * $nNumOfFullPeriods - $f0Rate);
        } else {
            return 0.0;
        }
    }


    /**
     * COUPDAYBS
     *
     * Returns the number of days from the beginning of the coupon period to the settlement date.
     *
     * Excel Function:
     *        COUPDAYBS(settlement,maturity,frequency[,basis])
     *
     * @access    public
     * @category Financial Functions
     * @param    mixed    settlement    The security's settlement date.
     *                                The security settlement date is the date after the issue
     *                                date when the security is traded to the buyer.
     * @param    mixed    maturity    The security's maturity date.
     *                                The maturity date is the date when the security expires.
     * @param    mixed    frequency    the number of coupon payments per year.
     *                                    Valid frequency values are:
     *                                        1    Annual
     *                                        2    Semi-Annual
     *                                        4    Quarterly
     *                                    If working in Gnumeric Mode, the following frequency options are
     *                                    also available
     *                                        6    Bimonthly
     *                                        12    Monthly
     * @param    integer        basis        The type of day count to use.
     *                                        0 or omitted    US (NASD) 30/360
     *                                        1                Actual/actual
     *                                        2                Actual/360
     *                                        3                Actual/365
     *                                        4                European 30/360
     * @return    float
     */
    public static function COUPDAYBS($settlement, $maturity, $frequency, $basis = 0)
    {
        $settlement = PHPExcel_Calculation_Functions::flattenSingleValue($settlement);
        $maturity   = PHPExcel_Calculation_Functions::flattenSingleValue($maturity);
        $frequency  = (int) PHPExcel_Calculation_Functions::flattenSingleValue($frequency);
        $basis      = (is_null($basis)) ? 0 : (int) PHPExcel_Calculation_Functions::flattenSingleValue($basis);

        if (is_string($settlement = PHPExcel_Calculation_DateTime::getDateValue($settlement))) {
            return PHPExcel_Calculation_Functions::VALUE();
        }
        if (is_string($maturity = PHPExcel_Calculation_DateTime::getDateValue($maturity))) {
            return PHPExcel_Calculation_Functions::VALUE();
        }

        if (($settlement > $maturity) ||
            (!self::isValidFrequency($frequency)) ||
            (($basis < 0) || ($basis > 4))) {
            return PHPExcel_Calculation_Functions::NaN();
        }

        $daysPerYear = self::daysPerYear(PHPExcel_Calculation_DateTime::YEAR($settlement), $basis);
        $prev = self::couponFirstPeriodDate($settlement, $maturity, $frequency, false);

        return PHPExcel_Calculation_DateTime::YEARFRAC($prev, $settlement, $basis) * $daysPerYear;
    }


    /**
     * COUPDAYS
     *
     * Returns the number of days in the coupon period that contains the settlement date.
     *
     * Excel Function:
     *        COUPDAYS(settlement,maturity,frequency[,basis])
     *
     * @access    public
     * @category Financial Functions
     * @param    mixed    settlement    The security's settlement date.
     *                                The security settlement date is the date after the issue
     *                                date when the security is traded to the buyer.
     * @param    mixed    maturity    The security's maturity date.
     *                                The maturity date is the date when the security expires.
     * @param    mixed    frequency    the number of coupon payments per year.
     *                                    Valid frequency values are:
     *                                        1    Annual
     *                                        2    Semi-Annual
     *                                        4    Quarterly
     *                                    If working in Gnumeric Mode, the following frequency options are
     *                                    also available
     *                                        6    Bimonthly
     *                                        12    Monthly
     * @param    integer        basis        The type of day count to use.
     *                                        0 or omitted    US (NASD) 30/360
     *                                        1                Actual/actual
     *                                        2                Actual/360
     *                                        3                Actual/365
     *                                        4                European 30/360
     * @return    float
     */
    public static function COUPDAYS($settlement, $maturity, $frequency, $basis = 0)
    {
        $settlement = PHPExcel_Calculation_Functions::flattenSingleValue($settlement);
        $maturity   = PHPExcel_Calculation_Functions::flattenSingleValue($maturity);
        $frequency  = (int) PHPExcel_Calculation_Functions::flattenSingleValue($frequency);
        $basis      = (is_null($basis)) ? 0 : (int) PHPExcel_Calculation_Functions::flattenSingleValue($basis);

        if (is_string($settlement = PHPExcel_Calculation_DateTime::getDateValue($settlement))) {
            return PHPExcel_Calculation_