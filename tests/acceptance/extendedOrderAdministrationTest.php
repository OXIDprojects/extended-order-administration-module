<?php
/**
 * This file is part of OXID eSales Extended Order Admin module.
 *
 * OXID eSales Extended Order Admin module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eSales Extended Order Admin module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eSales Extended Order Admin module.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category      module
 * @package       oeextendedorderadmin
 * @author        OXID eSales AG
 * @link          http://www.oxid-esales.com/
 * @copyright     (C) OXID eSales AG 2003-2015
 */

/** Search and sorting in admin. */
class oeExtendedOrderAdministrationTest extends \OxidEsales\TestingLibrary\AcceptanceTestCase
{
    /**
     * Activates Extended Order Admin module
     *
     * @param string $sTestSuitePath
     *
     * @throws Exception
     */
    public function addTestData($sTestSuitePath)
    {
        parent::addTestData($sTestSuitePath);

        $this->open(shopURL . "admin");
        $this->loginAdminForModule("Extensions", "Modules");

        $this->openListItem("OE Extended Order Admin");
        if ($this->isElementPresent('module_activate')) {
            $this->clickAndWait("module_activate");
        }
    }

    /**
     * SearchingOrder list
     *
     * @group search_sort
     */
    public function testSearchOrderList()
    {
        $this->loginAdminForModule("Administer Orders", "Order Summary");
        $this->assertElementPresent("liste");
        $this->assertEquals("Sum: 156.30", $this->clearString($this->getText("//div[@id='liste']/span")));
        //search
        $this->type("where[oxorderarticles][oxtitle]", "en šÄßüл");
        $this->clickAndWait("submitit");
        $this->assertEquals("Test product 0 [EN] šÄßüл", $this->getText("//tr[@id='row.1']/td[4]"));
        $this->assertElementPresent("link=1 EN product šÄßüл");
        $this->assertElementPresent("link=11 EN product šÄßüл");
        $this->assertElementPresent("link=12 EN product šÄßüл");
        $this->type("where[oxorderarticles][oxtitle]", "en 12");
        $this->clickAndWait("submitit");
        $this->assertEquals("12 EN product šÄßüл", $this->getText("//tr[@id='row.1']/td[4]"));
        $this->assertElementNotPresent("//tr[@id='row.2']/td[4]");
        $this->assertEquals("en 12", $this->getValue("where[oxorderarticles][oxtitle]"));
        $this->type("where[oxorderarticles][oxtitle]", "");
        $this->type("where[oxorderarticles][oxartnum]", "100");
        $this->clickAndWait("submitit");
        $this->assertElementPresent("link=10010");
        $this->assertElementPresent("link=10011");
        $this->assertElementPresent("link=10012");
        $this->type("where[oxorderarticles][oxartnum]", "10012");
        $this->clickAndWait("submitit");
        $this->assertEquals("10012", $this->getText("//tr[@id='row.1']/td[2]"));
        $this->assertElementNotPresent("//tr[@id='row.2']/td[2]");
        $this->assertEquals("10012", $this->getValue("where[oxorderarticles][oxartnum]"));
        $this->type("where[oxorderarticles][oxartnum]", "");
        $this->type("where[oxorder][oxorderdate]", "2008-04-21");
        $this->clickAndWait("submitit");
        $this->assertElementPresent("link=2008-04-21 14:54:33");
        $this->assertElementPresent("link=2008-04-21 15:07:46");
        $this->assertElementPresent("link=2008-04-21 15:02:54");
        $this->type("where[oxorder][oxorderdate]", "2008-04-21 14");
        $this->clickAndWait("submitit");
        $this->assertElementPresent("link=2008-04-21 14:54:33");
        $this->assertElementPresent("link=2008-04-21 14:54:33");
        $this->assertElementPresent("link=2008-04-21 14:59:08");
        $this->assertEquals("2008-04-21 14", $this->getValue("where[oxorder][oxorderdate]"));
        $this->type("where[oxorder][oxorderdate]", "");
        $this->clickAndWait("submitit");
    }

    /**
     * Sorting Order list
     *
     * @group search_sort
     */
    public function testSortOrderList()
    {
        $this->loginAdminForModule("Administer Orders", "Order Summary");
        //sorting
        $this->clickAndWait("link=Date");
        $this->assertEquals("2008-04-21 15:07:46", $this->getText("//tr[@id='row.1']/td[1]"));
        $this->assertEquals("2008-04-21 15:02:54", $this->getText("//tr[@id='row.2']/td[1]"));
        $this->assertEquals("2008-04-21 14:54:33", $this->getText("//tr[@id='row.3']/td[1]"));
        $this->clickAndWait("link=Date");
        $this->assertEquals("10011", $this->getText("//tr[@id='row.1']/td[2]"));
        $this->assertEquals("10012", $this->getText("//tr[@id='row.2']/td[2]"));
        $this->assertEquals("10010", $this->getText("//tr[@id='row.3']/td[2]"));
        $this->clickAndWait("link=Prod.No.");
        $this->assertEquals("1000", $this->getText("//tr[@id='row.1']/td[2]"));
        $this->assertEquals("10010", $this->getText("//tr[@id='row.2']/td[2]"));
        $this->assertEquals("10011", $this->getText("//tr[@id='row.3']/td[2]"));
        $this->clickAndWait("link=Date");
        $this->assertEquals("11", $this->getText("//tr[@id='row.1']/td[3]"));
        $this->assertEquals("16", $this->getText("//tr[@id='row.2']/td[3]"));
        $this->assertEquals("3", $this->getText("//tr[@id='row.3']/td[3]"));
        $this->clickAndWait("link=Quantity");
        $this->assertEquals("2", $this->getText("//tr[@id='row.7']/td[3]"));
        $this->assertEquals("3", $this->getText("//tr[@id='row.8']/td[3]"));
        $this->assertEquals("11", $this->getText("//tr[@id='row.9']/td[3]"));
        $this->assertEquals("16", $this->getText("//tr[@id='row.10']/td[3]"));
        $this->clickAndWait("link=Date");
        $this->assertEquals("11 EN product šÄßüл", $this->getText("//tr[@id='row.1']/td[4]"));
        $this->assertEquals("12 EN product šÄßüл", $this->getText("//tr[@id='row.2']/td[4]"));
        $this->assertEquals("1 EN product šÄßüл", $this->getText("//tr[@id='row.3']/td[4]"));
        $this->clickAndWait("link=Description");
        $this->assertEquals("1 EN product šÄßüл", $this->getText("//tr[@id='row.1']/td[4]"));
        $this->assertEquals("11 EN product šÄßüл", $this->getText("//tr[@id='row.2']/td[4]"));
        $this->assertEquals("12 EN product šÄßüл", $this->getText("//tr[@id='row.3']/td[4]"));
        $this->assertEquals("4.50", $this->getText("//tr[@id='row.1']/td[5]"));
        $this->clickAndWait("link=Date");
        $this->assertEquals("19.80", $this->getText("//tr[@id='row.1']/td[5]"));
        $this->assertEquals("32.00", $this->getText("//tr[@id='row.2']/td[5]"));
        $this->assertEquals("4.50", $this->getText("//tr[@id='row.3']/td[5]"));
        $this->clickAndWait("link=Sum");
        $this->assertEquals("4.50", $this->getText("//tr[@id='row.7']/td[5]"));
        $this->assertEquals("19.80", $this->getText("//tr[@id='row.8']/td[5]"));
        $this->assertEquals("32.00", $this->getText("//tr[@id='row.9']/td[5]"));
    }
}
