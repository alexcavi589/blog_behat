<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends pruebaContext  implements Context 
{

    private $buy;

    public function __construct()
    {
        $this->buy = new Ticket();
    }


     /**
     * @Given I have $:dTotal  for buy tickets
     */
    public function iHaveForBuyTickets($dTotal)
    {
        $this->buy->setTotalDinero($dTotal);
    }

    /**
     * @When decide to buy :cantidad tickets in :clase class
     */
    public function decideToBuyTicketsInClass($clase, $cantidad)
    {
        $this->buy->setCantTikets($cantidad);
        $this->buy->setClassTikets($clase); 
    }

    /**
     * @Then i have to pay $:cPago And i would stay $:cRestante
     */
    public function iHaveToPayAndIWouldStay($cPago, $cRestante)
    {
        $value = $this->buy->totalPrice();
        $devuelto = $this->buy->restanteTotalPrice($value);
        PHPUnit_Framework_Assert::assertEquals(
            floatval($cPago), $value
        );

        PHPUnit_Framework_Assert::assertEquals(
            floatval($cRestante), $devuelto
        );
    }

}
