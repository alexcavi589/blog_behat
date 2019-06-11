<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ElementNotFoundException;


/**
 * Defines application features from the specific context.
 */
class pruebaContext extends DefaultContext implements Context
{   
    public function __construct()
    {

    }

     /**
     * @When I click in link :arg1
     */
    public function iClickOnTheLink($link)
    {   
      $this->clickLink($link);
    }

    /**
     * @When I click in botton :arg1
     */
    public function iClickInBotton($button)
    {
       $this->pressButton($button);
    }

    /**
     * @When I fill in the following :arg1 in field :arg2
     */
    public function iFillInTheFollowingInField($value, $key)
    {
      //var_dump($value);var_dump($key);
      $this->fillField($key,$value);
      //var_dump( $this->fillField($key,$value));
    }



}
