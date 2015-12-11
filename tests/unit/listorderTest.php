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
 * @copyright (C) (C) OXID eSales AG 2003-2015
 */

/**
 * Tests for oeExtendedOrderAdminListOrder class
 */
class oeExtendedOrderAdminListOrderTest extends OxidTestCase
{

    /**
     * oeExtendedOrderAdminListOrder::GetViewListSize() test case
     *
     * @return null
     */
    public function testGetViewListSize()
    {
        // testing..
        $oView = $this->getMock("oeExtendedOrderAdminListOrder", array("_getUserDefListSize"));
        $oView->expects($this->once())->method('_getUserDefListSize')->will($this->returnValue(999));
        $this->assertEquals(999, $oView->UNITgetViewListSize());
    }

    /**
     * Executes parent method parent::render(), passes data to Smarty engine
     * and returns name of template file "oeextendedorderadminlistorder.tpl".
     *
     * @return null
     */
    public function testRender()
    {
        $oNavTree = $this->getMock("oxnavigationtree", array("getDomXml"));
        $oNavTree->expects($this->once())->method('getDomXml')->will($this->returnValue(new DOMDocument));

        $oView = $this->getMock("oeExtendedOrderAdminListOrder", array("getNavigation"));
        $oView->expects($this->at(0))->method('getNavigation')->will($this->returnValue($oNavTree));
        $this->assertEquals("oeextendedorderadminlistorder.tpl", $oView->render());
    }

    /**
     * Testing formating where query
     *
     * @return null
     */
    public function testPrepareWhereQuery()
    {
        $aWhere = array("testField" => "testValue");
        $sSqlFull = "SELECT * FROM oxorderarticles WHERE 1";

        $oAdminList = oxNew("oxAdminList");
        $sWhere = $oAdminList->UNITprepareWhereQuery($aWhere, $sSqlFull);

        $oView = oxNew('oeExtendedOrderAdminListOrder');
        $this->assertEquals($sWhere . " group by oxorderarticles.oxartnum", $oView->UNITprepareWhereQuery($aWhere, $sSqlFull));
    }

    /**
     * Testing calculating list items
     *
     * @return null
     */
    public function testCalcListItemsCount()
    {
        $sSql = "SELECT * FROM oxcountry WHERE oxisoalpha2 LIKE 'A%' ";
        $iTotal = oxDb::getDb()->getOne("SELECT count(*) FROM oxcountry WHERE oxisoalpha2 LIKE 'A%' ");

        $oView = $this->getProxyClass("oeExtendedOrderAdminListOrder");
        $oView->UNITcalcListItemsCount($sSql);
        $this->assertEquals($iTotal, $oView->getNonPublicVar("_iListSize"));
        $this->assertEquals($iTotal, oxRegistry::getSession()->getVariable('iArtCnt'));
    }

    /**
     * Testing building select query string
     *
     * @return null
     */
    public function testBuildSelectString()
    {
        $sSql = 'select oxorderarticles.oxid, oxorder.oxid as oxorderid, max(oxorder.oxorderdate) as oxorderdate, oxorderarticles.oxartnum, sum( oxorderarticles.oxamount ) as oxorderamount, oxorderarticles.oxtitle, round( sum(oxorderarticles.oxbrutprice*oxorder.oxcurrate),2) as oxprice from oxorderarticles left join oxorder on oxorder.oxid=oxorderarticles.oxorderid where 1';

        $oView = oxNew('oeExtendedOrderAdminListOrder');
        $this->assertEquals($sSql, trim($oView->UNITbuildSelectString()));
    }

    /**
     * Testing building order by query string
     *
     * @return null
     */
    public function testPrepareOrderByQuery()
    {
        $this->setRequestParameter("sort", array(0 => array("oxorderamount" => "asc")));
        $sSql = "select * from oxorder, oxorderarticles";

        $oView = oxNew('oeExtendedOrderAdminListOrder');
        $sResultSql = "select * from oxorder, oxorderarticles order by oxorderamount";
        $this->assertEquals($sResultSql, trim($oView->UNITprepareOrderByQuery($sSql)));

        $this->setRequestParameter("sort", array(0 => array("oxorderdate" => "asc")));

        $oView = oxNew('oeExtendedOrderAdminListOrder');
        $sResultSql = "select * from oxorder, oxorderarticles group by oxorderarticles.oxartnum order by max(oxorder.oxorderdate) desc";
        $sSql = $oView->UNITprepareWhereQuery(array(), $sSql);
        $this->assertEquals($sResultSql, trim($oView->UNITprepareOrderByQuery($sSql)));
    }

}
