<?php

/** PHPExcel root directory */
if (!defined('PHPEXCEL_ROOT')) {
    /**
     * @ignore
     */
    define('PHPEXCEL_ROOT', dirname(__FILE__) . '/../../');
    require(PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php');
}

/**
 * PHPExcel_Reader_Excel2007
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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Reader
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */
class PHPExcel_Reader_Excel2007 extends PHPExcel_Reader_Abstract implements PHPExcel_Reader_IReader
{
    /**
     * PHPExcel_ReferenceHelper instance
     *
     * @var PHPExcel_ReferenceHelper
     */
    private $referenceHelper = null;

    /**
     * PHPExcel_Reader_Excel2007_Theme instance
     *
     * @var PHPExcel_Reader_Excel2007_Theme
     */
    private static $theme = null;

    /**
     * Create a new PHPExcel_Reader_Excel2007 instance
     */
    public function __construct()
    {
        $this->readFilter = new PHPExcel_Reader_DefaultReadFilter();
        $this->referenceHelper = PHPExcel_ReferenceHelper::getInstance();
    }

    /**
     * Can the current PHPExcel_Reader_IReader read the file?
     *
     * @param     string         $pFilename
     * @return     boolean
     * @throws PHPExcel_Reader_Exception
     */
    public function canRead($pFilename)
    {
        // Check if file exists
        if (!file_exists($pFilename)) {
            throw new PHPExcel_Reader_Exception("Could not open " . $pFilename . " for reading! File does not exist.");
        }

        $zipClass = PHPExcel_Settings::getZipClass();

        // Check if zip class exists
//        if (!class_exists($zipClass, false)) {
//            throw new PHPExcel_Reader_Exception($zipClass . " library is not enabled");
//        }

        $xl = false;
        // Load file
        $zip = new $zipClass;
        if ($zip->open($pFilename) === true) {
            // check if it is an OOXML archive
            $rels = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "_rels/.rels")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions());
            if ($rels !== false) {
                foreach ($rels->Relationship as $rel) {
                    switch ($rel["Type"]) {
                        case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument":
                            if (basename($rel["Target"]) == 'workbook.xml') {
                                $xl = true;
                            }
                            break;

                    }
                }
            }
            $zip->close();
        }

        return $xl;
    }


    /**
     * Reads names of the worksheets from a file, without parsing the whole file to a PHPExcel object
     *
     * @param     string         $pFilename
     * @throws     PHPExcel_Reader_Exception
     */
    public function listWorksheetNames($pFilename)
    {
        // Check if file exists
        if (!file_exists($pFilename)) {
            throw new PHPExcel_Reader_Exception("Could not open " . $pFilename . " for reading! File does not exist.");
        }

        $worksheetNames = array();

        $zipClass = PHPExcel_Settings::getZipClass();

        $zip = new $zipClass;
        $zip->open($pFilename);

        //    The files we're looking at here are small enough that simpleXML is more efficient than XMLReader
        $rels = simplexml_load_string(
            $this->securityScan($this->getFromZipArchive($zip, "_rels/.rels"), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions())
        ); //~ http://schemas.openxmlformats.org/package/2006/relationships");
        foreach ($rels->Relationship as $rel) {
            switch ($rel["Type"]) {
                case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument":
                    $xmlWorkbook = simplexml_load_string(
                        $this->securityScan($this->getFromZipArchive($zip, "{$rel['Target']}"), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions())
                    );  //~ http://schemas.openxmlformats.org/spreadsheetml/2006/main");

                    if ($xmlWorkbook->sheets) {
                        foreach ($xmlWorkbook->sheets->sheet as $eleSheet) {
                            // Check if sheet should be skipped
                            $worksheetNames[] = (string) $eleSheet["name"];
                        }
                    }
            }
        }

        $zip->close();

        return $worksheetNames;
    }


    /**
     * Return worksheet info (Name, Last Column Letter, Last Column Index, Total Rows, Total Columns)
     *
     * @param   string     $pFilename
     * @throws   PHPExcel_Reader_Exception
     */
    public function listWorksheetInfo($pFilename)
    {
        // Check if file exists
        if (!file_exists($pFilename)) {
            throw new PHPExcel_Reader_Exception("Could not open " . $pFilename . " for reading! File does not exist.");
        }

        $worksheetInfo = array();

        $zipClass = PHPExcel_Settings::getZipClass();

        $zip = new $zipClass;
        $zip->open($pFilename);

        $rels = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "_rels/.rels")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions()); //~ http://schemas.openxmlformats.org/package/2006/relationships");
        foreach ($rels->Relationship as $rel) {
            if ($rel["Type"] == "http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument") {
                $dir = dirname($rel["Target"]);
                $relsWorkbook = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "$dir/_rels/" . basename($rel["Target"]) . ".rels")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions());  //~ http://schemas.openxmlformats.org/package/2006/relationships");
                $relsWorkbook->registerXPathNamespace("rel", "http://schemas.openxmlformats.org/package/2006/relationships");

                $worksheets = array();
                foreach ($relsWorkbook->Relationship as $ele) {
                    if ($ele["Type"] == "http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet") {
                        $worksheets[(string) $ele["Id"]] = $ele["Target"];
                    }
                }

                $xmlWorkbook = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "{$rel['Target']}")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions());  //~ http://schemas.openxmlformats.org/spreadsheetml/2006/main");
                if ($xmlWorkbook->sheets) {
                    $dir = dirname($rel["Target"]);
                    foreach ($xmlWorkbook->sheets->sheet as $eleSheet) {
                        $tmpInfo = array(
                            'worksheetName' => (string) $eleSheet["name"],
                            'lastColumnLetter' => 'A',
                            'lastColumnIndex' => 0,
                            'totalRows' => 0,
                            'totalColumns' => 0,
                        );

                        $fileWorksheet = $worksheets[(string) self::getArrayItem($eleSheet->attributes("http://schemas.openxmlformats.org/officeDocument/2006/relationships"), "id")];

                        $xml = new XMLReader();
                        $res = $xml->xml($this->securityScanFile('zip://'.PHPExcel_Shared_File::realpath($pFilename).'#'."$dir/$fileWorksheet"), null, PHPExcel_Settings::getLibXmlLoaderOptions());
                        $xml->setParserProperty(2, true);

                        $currCells = 0;
                        while ($xml->read()) {
                            if ($xml->name == 'row' && $xml->nodeType == XMLReader::ELEMENT) {
                                $row = $xml->getAttribute('r');
                                $tmpInfo['totalRows'] = $row;
                                $tmpInfo['totalColumns'] = max($tmpInfo['totalColumns'], $currCells);
                                $currCells = 0;
                            } elseif ($xml->name == 'c' && $xml->nodeType == XMLReader::ELEMENT) {
                                $currCells++;
                            }
                        }
                        $tmpInfo['totalColumns'] = max($tmpInfo['totalColumns'], $currCells);
                        $xml->close();

                        $tmpInfo['lastColumnIndex'] = $tmpInfo['totalColumns'] - 1;
                        $tmpInfo['lastColumnLetter'] = PHPExcel_Cell::stringFromColumnIndex($tmpInfo['lastColumnIndex']);

                        $worksheetInfo[] = $tmpInfo;
                    }
                }
            }
        }

        $zip->close();

        return $worksheetInfo;
    }

    private static function castToBoolean($c)
    {
//        echo 'Initial Cast to Boolean', PHP_EOL;
        $value = isset($c->v) ? (string) $c->v : null;
        if ($value == '0') {
            return false;
        } elseif ($value == '1') {
            return true;
        } else {
            return (bool)$c->v;
        }
        return $value;
    }

    private static function castToError($c)
    {
//        echo 'Initial Cast to Error', PHP_EOL;
        return isset($c->v) ? (string) $c->v : null;
    }

    private static function castToString($c)
    {
//        echo 'Initial Cast to String, PHP_EOL;
        return isset($c->v) ? (string) $c->v : null;
    }

    private function castToFormula($c, $r, &$cellDataType, &$value, &$calculatedValue, &$sharedFormulas, $castBaseType)
    {
//        echo 'Formula', PHP_EOL;
//        echo '$c->f is ', $c->f, PHP_EOL;
        $cellDataType       = 'f';
        $value              = "={$c->f}";
        $calculatedValue    = self::$castBaseType($c);

        // Shared formula?
        if (isset($c->f['t']) && strtolower((string)$c->f['t']) == 'shared') {
//            echo 'SHARED FORMULA', PHP_EOL;
            $instance = (string)$c->f['si'];

//            echo 'Instance ID = ', $instance, PHP_EOL;
//
//            echo 'Shared Formula Array:', PHP_EOL;
//            print_r($sharedFormulas);
            if (!isset($sharedFormulas[(string)$c->f['si']])) {
//                echo 'SETTING NEW SHARED FORMULA', PHP_EOL;
//                echo 'Master is ', $r, PHP_EOL;
//                echo 'Formula is ', $value, PHP_EOL;
                $sharedFormulas[$instance] = array('master' => $r, 'formula' => $value);
//                echo 'New Shared Formula Array:', PHP_EOL;
//                print_r($sharedFormulas);
            } else {
//                echo 'GETTING SHARED FORMULA', PHP_EOL;
//                echo 'Master is ', $sharedFormulas[$instance]['master'], PHP_EOL;
//                echo 'Formula is ', $sharedFormulas[$instance]['formula'], PHP_EOL;
                $master = PHPExcel_Cell::coordinateFromString($sharedFormulas[$instance]['master']);
                $current = PHPExcel_Cell::coordinateFromString($r);

                $difference = array(0, 0);
                $difference[0] = PHPExcel_Cell::columnIndexFromString($current[0]) - PHPExcel_Cell::columnIndexFromString($master[0]);
                $difference[1] = $current[1] - $master[1];

                $value = $this->referenceHelper->updateFormulaReferences($sharedFormulas[$instance]['formula'], 'A1', $difference[0], $difference[1]);
//                echo 'Adjusted Formula is ', $value, PHP_EOL;
            }
        }
    }


    private function getFromZipArchive($archive, $fileName = '')
    {
        // Root-relative paths
        if (strpos($fileName, '//') !== false) {
            $fileName = substr($fileName, strpos($fileName, '//') + 1);
        }
        $fileName = PHPExcel_Shared_File::realpath($fileName);

        // Sadly, some 3rd party xlsx generators don't use consistent case for filenaming
        //    so we need to load case-insensitively from the zip file
        
        // Apache POI fixes
        $contents = $archive->getFromIndex(
            $archive->locateName($fileName, ZIPARCHIVE::FL_NOCASE)
        );
        if ($contents === false) {
            $contents = $archive->getFromIndex(
                $archive->locateName(substr($fileName, 1), ZIPARCHIVE::FL_NOCASE)
            );
        }

        return $contents;
    }


    /**
     * Loads PHPExcel from file
     *
     * @param     string         $pFilename
     * @return  PHPExcel
     * @throws     PHPExcel_Reader_Exception
     */
    public function load($pFilename)
    {
        // Check if file exists
        if (!file_exists($pFilename)) {
            throw new PHPExcel_Reader_Exception("Could not open " . $pFilename . " for reading! File does not exist.");
        }

        // Initialisations
        $excel = new PHPExcel;
        $excel->removeSheetByIndex(0);
        if (!$this->readDataOnly) {
            $excel->removeCellStyleXfByIndex(0); // remove the default style
            $excel->removeCellXfByIndex(0); // remove the default style
        }

        $zipClass = PHPExcel_Settings::getZipClass();

        $zip = new $zipClass;
        $zip->open($pFilename);

        //    Read the theme first, because we need the colour scheme when reading the styles
        $wbRels = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "xl/_rels/workbook.xml.rels")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions()); //~ http://schemas.openxmlformats.org/package/2006/relationships");
        foreach ($wbRels->Relationship as $rel) {
            switch ($rel["Type"]) {
                case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/theme":
                    $themeOrderArray = array('lt1', 'dk1', 'lt2', 'dk2');
                    $themeOrderAdditional = count($themeOrderArray);

                    $xmlTheme = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "xl/{$rel['Target']}")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions());
                    if (is_object($xmlTheme)) {
                        $xmlThemeName = $xmlTheme->attributes();
                        $xmlTheme = $xmlTheme->children("http://schemas.openxmlformats.org/drawingml/2006/main");
                        $themeName = (string)$xmlThemeName['name'];

                        $colourScheme = $xmlTheme->themeElements->clrScheme->attributes();
                        $colourSchemeName = (string)$colourScheme['name'];
                        $colourScheme = $xmlTheme->themeElements->clrScheme->children("http://schemas.openxmlformats.org/drawingml/2006/main");

                        $themeColours = array();
                        foreach ($colourScheme as $k => $xmlColour) {
                            $themePos = array_search($k, $themeOrderArray);
                            if ($themePos === false) {
                                $themePos = $themeOrderAdditional++;
                            }
                            if (isset($xmlColour->sysClr)) {
                                $xmlColourData = $xmlColour->sysClr->attributes();
                                $themeColours[$themePos] = $xmlColourData['lastClr'];
                            } elseif (isset($xmlColour->srgbClr)) {
                                $xmlColourData = $xmlColour->srgbClr->attributes();
                                $themeColours[$themePos] = $xmlColourData['val'];
                            }
                        }
                        self::$theme = new PHPExcel_Reader_Excel2007_Theme($themeName, $colourSchemeName, $themeColours);
                    }
                    break;
            }
        }

        $rels = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "_rels/.rels")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions()); //~ http://schemas.openxmlformats.org/package/2006/relationships");
        foreach ($rels->Relationship as $rel) {
            switch ($rel["Type"]) {
                case "http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties":
                    $xmlCore = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "{$rel['Target']}")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions());
                    if (is_object($xmlCore)) {
                        $xmlCore->registerXPathNamespace("dc", "http://purl.org/dc/elements/1.1/");
                        $xmlCore->registerXPathNamespace("dcterms", "http://purl.org/dc/terms/");
                        $xmlCore->registerXPathNamespace("cp", "http://schemas.openxmlformats.org/package/2006/metadata/core-properties");
                        $docProps = $excel->getProperties();
                        $docProps->setCreator((string) self::getArrayItem($xmlCore->xpath("dc:creator")));
                        $docProps->setLastModifiedBy((string) self::getArrayItem($xmlCore->xpath("cp:lastModifiedBy")));
                        $docProps->setCreated(strtotime(self::getArrayItem($xmlCore->xpath("dcterms:created")))); //! respect xsi:type
                        $docProps->setModified(strtotime(self::getArrayItem($xmlCore->xpath("dcterms:modified")))); //! respect xsi:type
                        $docProps->setTitle((string) self::getArrayItem($xmlCore->xpath("dc:title")));
                        $docProps->setDescription((string) self::getArrayItem($xmlCore->xpath("dc:description")));
                        $docProps->setSubject((string) self::getArrayItem($xmlCore->xpath("dc:subject")));
                        $docProps->setKeywords((string) self::getArrayItem($xmlCore->xpath("cp:keywords")));
                        $docProps->setCategory((string) self::getArrayItem($xmlCore->xpath("cp:category")));
                    }
                    break;
                case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties":
                    $xmlCore = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "{$rel['Target']}")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions());
                    if (is_object($xmlCore)) {
                        $docProps = $excel->getProperties();
                        if (isset($xmlCore->Company)) {
                            $docProps->setCompany((string) $xmlCore->Company);
                        }
                        if (isset($xmlCore->Manager)) {
                            $docProps->setManager((string) $xmlCore->Manager);
                        }
                    }
                    break;
                case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/custom-properties":
                    $xmlCore = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "{$rel['Target']}")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions());
                    if (is_object($xmlCore)) {
                        $docProps = $excel->getProperties();
                        foreach ($xmlCore as $xmlProperty) {
                            $cellDataOfficeAttributes = $xmlProperty->attributes();
                            if (isset($cellDataOfficeAttributes['name'])) {
                                $propertyName = (string) $cellDataOfficeAttributes['name'];
                                $cellDataOfficeChildren = $xmlProperty->children('http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes');
                                $attributeType = $cellDataOfficeChildren->getName();
                                $attributeValue = (string) $cellDataOfficeChildren->{$attributeType};
                                $attributeValue = PHPExcel_DocumentProperties::convertProperty($attributeValue, $attributeType);
                                $attributeType = PHPExcel_DocumentProperties::convertPropertyType($attributeType);
                                $docProps->setCustomProperty($propertyName, $attributeValue, $attributeType);
                            }
                        }
                    }
                    break;
                //Ribbon
                case "http://schemas.microsoft.com/office/2006/relationships/ui/extensibility":
                    $customUI = $rel['Target'];
                    if (!is_null($customUI)) {
                        $this->readRibbon($excel, $customUI, $zip);
                    }
                    break;
                case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument":
                    $dir = dirname($rel["Target"]);
                    $relsWorkbook = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "$dir/_rels/" . basename($rel["Target"]) . ".rels")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions());  //~ http://schemas.openxmlformats.org/package/2006/relationships");
                    $relsWorkbook->registerXPathNamespace("rel", "http://schemas.openxmlformats.org/package/2006/relationships");

                    $sharedStrings = array();
                    $xpath = self::getArrayItem($relsWorkbook->xpath("rel:Relationship[@Type='http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings']"));
                    $xmlStrings = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "$dir/$xpath[Target]")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions());  //~ http://schemas.openxmlformats.org/spreadsheetml/2006/main");
                    if (isset($xmlStrings) && isset($xmlStrings->si)) {
                        foreach ($xmlStrings->si as $val) {
                            if (isset($val->t)) {
                                $sharedStrings[] = PHPExcel_Shared_String::ControlCharacterOOXML2PHP((string) $val->t);
                            } elseif (isset($val->r)) {
                                $sharedStrings[] = $this->parseRichText($val);
                            }
                        }
                    }

                    $worksheets = array();
                    $macros = $customUI = null;
                    foreach ($relsWorkbook->Relationship as $ele) {
                        switch ($ele['Type']) {
                            case "http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet":
                                $worksheets[(string) $ele["Id"]] = $ele["Target"];
                                break;
                            // a vbaProject ? (: some macros)
                            case "http://schemas.microsoft.com/office/2006/relationships/vbaProject":
                                $macros = $ele["Target"];
                                break;
                        }
                    }

                    if (!is_null($macros)) {
                        $macrosCode = $this->getFromZipArchive($zip, 'xl/vbaProject.bin');//vbaProject.bin always in 'xl' dir and always named vbaProject.bin
                        if ($macrosCode !== false) {
                            $excel->setMacrosCode($macrosCode);
                            $excel->setHasMacros(true);
                            //short-circuit : not reading vbaProject.bin.rel to get Signature =>allways vbaProjectSignature.bin in 'xl' dir
                            $Certificate = $this->getFromZipArchive($zip, 'xl/vbaProjectSignature.bin');
                            if ($Certificate !== false) {
                                $excel->setMacrosCertificate($Certificate);
                            }
                        }
                    }
                    $styles     = array();
                    $cellStyles = array();
                    $xpath = self::getArrayItem($relsWorkbook->xpath("rel:Relationship[@Type='http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles']"));
                    $xmlStyles = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "$dir/$xpath[Target]")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions());
                    //~ http://schemas.openxmlformats.org/spreadsheetml/2006/main");

                    $numFmts = null;
                    if ($xmlStyles && $xmlStyles->numFmts[0]) {
                        $numFmts = $xmlStyles->numFmts[0];
                    }
                    if (isset($numFmts) && ($numFmts !== null)) {
                        $numFmts->registerXPathNamespace("sml", "http://schemas.openxmlformats.org/spreadsheetml/2006/main");
                    }
                    if (!$this->readDataOnly && $xmlStyles) {
                        foreach ($xmlStyles->cellXfs->xf as $xf) {
                            $numFmt = PHPExcel_Style_NumberFormat::FORMAT_GENERAL;
                            if ($xf["numFmtId"]) {
                                if (isset($numFmts)) {
                                    $tmpNumFmt = self::getArrayItem($numFmts->xpath("sml:numFmt[@numFmtId=$xf[numFmtId]]"));

                                    if (isset($tmpNumFmt["formatCode"])) {
                                        $numFmt = (string) $tmpNumFmt["formatCode"];
                                    }
                                }

                                // We shouldn't override any of the built-in MS Excel values (values below id 164)
                                //  But there's a lot of naughty homebrew xlsx writers that do use "reserved" id values that aren't actually used
                                //  So we make allowance for them rather than lose formatting masks
                                if ((int)$xf["numFmtId"] < 164 && PHPExcel_Style_NumberFormat::builtInFormatCode((int)$xf["numFmtId"]) !== '') {
                                    $numFmt = PHPExcel_Style_NumberFormat::builtInFormatCode((int)$xf["numFmtId"]);
                                }
                            }
                            $quotePrefix = false;
                            if (isset($xf["quotePrefix"])) {
                                $quotePrefix = (boolean) $xf["quotePrefix"];
                            }

                            $style = (object) array(
                                "numFmt" => $numFmt,
                                "font" => $xmlStyles->fonts->font[intval($xf["fontId"])],
                                "fill" => $xmlStyles->fills->fill[intval($xf["fillId"])],
                                "border" => $xmlStyles->borders->border[intval($xf["borderId"])],
                                "alignment" => $xf->alignment,
                                "protection" => $xf->protection,
                                "quotePrefix" => $quotePrefix,
                            );
                            $styles[] = $style;

                            // add style to cellXf collection
                            $objStyle = new PHPExcel_Style;
                            self::readStyle($objStyle, $style);
                            $excel->addCellXf($objStyle);
                        }

                        foreach ($xmlStyles->cellStyleXfs->xf as $xf) {
                            $numFmt = PHPExcel_Style_NumberFormat::FORMAT_GENERAL;
                            if ($numFmts && $xf["numFmtId"]) {
                                $tmpNumFmt = self::getArrayItem($numFmts->xpath("sml:numFmt[@numFmtId=$xf[numFmtId]]"));
                                if (isset($tmpNumFmt["formatCode"])) {
                                    $numFmt = (string) $tmpNumFmt["formatCode"];
                                } elseif ((int)$xf["numFmtId"] < 165) {
                                    $numFmt = PHPExcel_Style_NumberFormat::builtInFormatCode((int)$xf["numFmtId"]);
                                }
                            }

                            $cellStyle = (object) array(
                                "numFmt" => $numFmt,
                                "font" => $xmlStyles->fonts->font[intval($xf["fontId"])],
                                "fill" => $xmlStyles->fills->fill[intval($xf["fillId"])],
                                "border" => $xmlStyles->borders->border[intval($xf["borderId"])],
                                "alignment" => $xf->alignment,
                                "protection" => $xf->protection,
                                "quotePrefix" => $quotePrefix,
                            );
                            $cellStyles[] = $cellStyle;

                            // add style to cellStyleXf collection
                            $objStyle = new PHPExcel_Style;
                            self::readStyle($objStyle, $cellStyle);
                            $excel->addCellStyleXf($objStyle);
                        }
                    }

                    $dxfs = array();
                    if (!$this->readDataOnly && $xmlStyles) {
                        //    Conditional Styles
                        if ($xmlStyles->dxfs) {
                            foreach ($xmlStyles->dxfs->dxf as $dxf) {
                                $style = new PHPExcel_Style(false, true);
                                self::readStyle($style, $dxf);
                                $dxfs[] = $style;
                            }
                        }
                        //    Cell Styles
                        if ($xmlStyles->cellStyles) {
                            foreach ($xmlStyles->cellStyles->cellStyle as $cellStyle) {
                                if (intval($cellStyle['builtinId']) == 0) {
                                    if (isset($cellStyles[intval($cellStyle['xfId'])])) {
                                        // Set default style
                                        $style = new PHPExcel_Style;
                                        self::readStyle($style, $cellStyles[intval($cellStyle['xfId'])]);

                                        // normal style, currently not using it for anything
                                    }
                                }
                            }
                        }
                    }

                    $xmlWorkbook = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "{$rel['Target']}")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions());  //~ http://schemas.openxmlformats.org/spreadsheetml/2006/main");

                    // Set base date
                    if ($xmlWorkbook->workbookPr) {
                        PHPExcel_Shared_Date::setExcelCalendar(PHPExcel_Shared_Date::CALENDAR_WINDOWS_1900);
                        if (isset($xmlWorkbook->workbookPr['date1904'])) {
                            if (self::boolean((string) $xmlWorkbook->workbookPr['date1904'])) {
                                PHPExcel_Shared_Date::setExcelCalendar(PHPExcel_Shared_Date::CALENDAR_MAC_1904);
                            }
                        }
                    }

                    $sheetId = 0; // keep track of new sheet id in final workbook
                    $oldSheetId = -1; // keep track of old sheet id in final workbook
                    $countSkippedSheets = 0; // keep track of number of skipped sheets
                    $mapSheetId = array(); // mapping of sheet ids from old to new

                    $charts = $chartDetails = array();

                    if ($xmlWorkbook->sheets) {
                        foreach ($xmlWorkbook->sheets->sheet as $eleSheet) {
                            ++$oldSheetId;

                            // Check if sheet should be skipped
                            if (isset($this->loadSheetsOnly) && !in_array((string) $eleSheet["name"], $this->loadSheetsOnly)) {
                                ++$countSkippedSheets;
                                $mapSheetId[$oldSheetId] = null;
                                continue;
                            }

                            // Map old sheet id in original workbook to new sheet id.
                            // They will differ if loadSheetsOnly() is being used
                            $mapSheetId[$oldSheetId] = $oldSheetId - $countSkippedSheets;

                            // Load sheet
                            $docSheet = $excel->createSheet();
                            //    Use false for $updateFormulaCellReferences to prevent adjustment of worksheet
                            //        references in formula cells... during the load, all formulae should be correct,
                            //        and we're simply bringing the worksheet name in line with the formula, not the
                            //        reverse
                            $docSheet->setTitle((string) $eleSheet["name"], false);
                            $fileWorksheet = $worksheets[(string) self::getArrayItem($eleSheet->attributes("http://schemas.openxmlformats.org/officeDocument/2006/relationships"), "id")];
                            $xmlSheet = simplexml_load_string($this->securityScan($this->getFromZipArchive($zip, "$dir/$fileWorksheet")), 'SimpleXMLElement', PHPExcel_Settings::getLibXmlLoaderOptions());  //~ http://schemas.openxmlformats.org/spreadsheetml/2006/main");

                            $sharedFormulas = array();

                            if (isset($eleSheet["state"]) && (string) $eleSheet["state"] != '') {
                                $docSheet->setSheetState((string) $eleSheet["state"]);
                            }

                            if (isset($xmlSheet->sheetViews) && isset($xmlSheet->sheetViews->sheetView)) {
                                if (isset($xmlSheet->sheetViews->sheetView['zoomScale'])) {
                                    $docSheet->getSheetView()->setZoomScale(intval($xmlSheet->sheetViews->sheetView['zoomScale']));
                                }
                                if (isset($xmlSheet->sheetViews->sheetView['zoomScaleNormal'])) {
                                    $docSheet->getSheetView()->setZoomScaleNormal(intval($xmlSheet->sheetViews->sheetView['zoomScaleNormal']));
                                }
                                if (isset($xmlSheet->sheetViews->sheetView['view'])) {
                                    $docSheet->getSheetView()->setView((string) $xmlSheet->sheetViews->sheetView['view']);
                                }
                                if (isset($xmlSheet->sheetViews->sheetView['showGridLines'])) {
                                    $docSheet->setShowGridLines(self::boolean((string)$xmlSheet->sheetViews->sheetView['showGridLines']));
                                }
                                if (isset($xmlSheet->sheetViews->sheetView['showRowColHeaders'])) {
                                    $docSheet->setShowRowColHeaders(self::boolean((string)$xmlSheet->sheetViews->sheetView['showRowColHeaders']));
                                }
                                if (isset($xmlSheet->sheetViews->sheetView['rightToLeft'])) {
                                    $docSheet->setRightToLeft(self::boolean((string)$xmlSheet->sheetViews->sheetView['rightToLeft']));
                                }
                                if (isset($xmlSheet->sheetViews->sheetView->pane)) {
                                    if (isset($xmlSheet->sheetViews->sheetView->pane['topLeftCell'])) {
                                        $docSheet->freezePane((string)$xmlSheet->sheetViews->sheetView->pane['topLeftCell']);
                                    } else {
                                        $xSplit = 0;
                                        $ySplit = 0;

                                        if (isset($xmlSheet->sheetViews->sheetView->pane['xSplit'])) {
                                            $xSplit = 1 + intval($xmlSheet->sheetViews->sheetView->pane['xSplit']);
                                        }

                                        if (isset($xmlSheet->sheetViews->sheetView->pane['ySplit'])) {
                                            $ySplit = 1 + intval($xmlSheet->sheetViews->sheetView->pane['ySplit']);
                                        }

                                        $docSheet->freezePaneByColumnAndRow($xSplit, $ySplit);
                                    }
                                }

                                if (isset($xmlSheet->sheetViews->sheetView->selection)) {
                                    if (isset($xmlSheet->sheetViews->sheetView->selection['sqref'])) {
                                        $sqref = (string)$xmlSheet->sheetViews->sheetView->selection['sqref'];
                                        $sqref = explode(' ', $sqref);
                                        $sqref = $sqref[0];
                                        $docSheet->setSelectedCells($sqref);
                                    }
                                }
                            }

                 