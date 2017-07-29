<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    private $budgetRepository;
    private $budget;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->budgetRepository = new \AppBundle\Repository\InMemory\BudgetRepository();
    }


    /**
     * @When I create a Budget with Name :name
     */
    public function iCreateABudgetWithName($name)
    {
        $this->budget = $this->budgetRepository->create($name);
    }

    /**
     * @Then I should have a Budget with Name :name
     */
    public function iShouldHaveABudgetWithName($name)
    {
        try {
            $this->budget = $this->budgetRepository->findByName($name);
            Assert::assertInstanceOf(\AppBundle\Entity\Budget::class, $this->budget);
        } catch (\AppBundle\Exception\NotFoundException $e) {
            Assert::fail('Budget not found.');
        }
    }

    /**
     * @Then Budget contains more than :count Categories
     */
    public function budgetContainsMoreThanCategories($count)
    {
        Assert::assertGreaterThan(
            intval($count),
            count($this->budget->getCategories())
        );
    }

    /**
     * @Given I have a Budget called :name
     */
    public function iHaveABudgetCalled($name)
    {
        $this->budget = $this->budgetRepository->create($name);
    }

    /**
     * @Then I should have :count Budgets
     */
    public function iShouldHaveBudgets($count)
    {
        Assert::assertCount(
            intval($count),
            $this->budgetRepository->findAll()
        );
    }

    /**
     * @When I delete the Budget with Name :name
     */
    public function iDeleteTheBudgetWithName($name)
    {
        $this->budget = $this->budgetRepository->findByName($name);
        $this->budgetRepository->delete($this->budget);
        $this->budget = null;
    }

    /**
     * @Then I shouldnt have a Budget with Name :name
     */
    public function iShouldntHaveABudgetWithName($name)
    {
        try {
            $this->budgetRepository->findByName($name);
        } catch (\AppBundle\Exception\NotFoundException $e) {
            Assert::assertInstanceOf(\AppBundle\Exception\NotFoundException::class, $e);
        }
        Assert::assertNotInstanceOf(\AppBundle\Entity\Budget::class, $this->budget);
    }
}
