<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace Home\Supply;

use Home\Service\Data\DataExtractService as DE;
use Home\Common\Utility\PclZipController as Pclzip;
use Home\Common\Utility\XmlOperationUtility as Xml;

class Supply
{

	public function dataExtract() {
		return new DE();
	}

	public function zip() {
		return new PclZip();
	}

	public function xml() {
		return new Xml();
	}

}