<?php

require "Exchange.php";

class ExchangeTest extends PHPUnit_Framework_TestCase {

	private $exchange;

	public function testSave()
	{
		$this->assertTrue($this->exchange->save());
	}

	public function testSaveMineur()
	{
		$receiver = $this->createMock("User", array("sebastien.souphron.esgi@gmail.com", "sebastien", "souphron", 24));

		$this->exchange->setReceiver($receiver);
		$this->assertFalse($this->exchange->save());
	}

	public function testSaveFausseDate()
	{
		$dateDebut = new DateTime("1994-10-29");

		$this->exchange->setDateDebut($dateDebut);
		$this->assertFalse($this->exchange->save());
	}

	public function setUp()
	{
		$receiver = $this->createMock("User", array("isValid"), array(null, null, null, null));
		$receiver->expects($this->any())->method("isValid")->will($this->returnValue(true));

		$product = $this->createMock("Product", array("isValid"), array(null, null, null));
		$product->expects($this->any())->method("isValid")->will($this->returnValue(true));

		$emailSender = $this->createMock("EmailSender", array("sendEmail"), array());
		$emailSender->expects($this->any())->method("sendEmail")->will($this->returnValue(true));

		$databaseConnection = $this->createMock("databaseConnection", array("saveExchange"), array());
		$databaseConnection->expects($this->any())->method("saveExchange")->will($this->returnValue(true));

		$dateDebut = new DateTime("2020-01-01");
		$dateFin = new DateTime("2026-01-01");

		$this->exchange = new Exchange($receiver, $product, $dateDebut, $dateFin, $emailSender, $databaseConnection);
	}

	public function tearDown() {
		$this->exchange = null;
	}
}