<?php

require "Product.php";
require "DatabaseConnection.php";
require "EmailSender.php";

class Exchange {
	private $receiver;
	private $product;
	private $dateDebut;
	private $dateFin;
	private $emailSender;
	private $databaseConnection;

	public function __construct($receiver, $product, $dateDebut, $dateFin, $emailSender, $databaseConnection){
		$this->receiver = $receiver;
		$this->product = $product;
		$this->dateDebut = $dateDebut;
		$this->dateFin = $dateFin;
		$this->emailSender = $emailSender;
		$this->databaseConnection = $databaseConnection;
	}

	public function save()
	{
		if ($this->receiver->isValid() && $this->product->isValid() && $this->checkDates())
		{
			return $this->databaseConnection->saveExchange($this);
		}
		else
		{
			return !$this->emailSender->sendEmail($this->receiver, "Fatal Error");
		}
	}

	private function checkDates()
	{
		$now = new DateTime(date("Y-m-d"));

		return $now->getTimestamp() < $this->dateDebut->getTimestamp() && $this->dateDebut->getTimestamp() <= $this->dateFin->getTimestamp();
	}

	public function setReceiver($receiver)
	{
		$this->receiver = $receiver;
	}

	public function setProduct($product)
	{
		$this->product = $product;
	}

	public function setDateDebut($dateDebut)
	{
		$this->dateDebut = $dateDebut;
	}

	public function setDateFin($dateFin)
	{
		$this->dateFin = $dateFin;
	}
}