Feature: Budgets
  As a user
  In order to keep track of my money
  I need to be able to create multiple budgets

  Rules:
  - New budgets contain sample categories
  - I can create as many budgets as I want
  - Budgets have localisation features (e.g. currencies)

  Scenario: Creating budget
    When I create a Budget with Name "Test"
    Then I should have a Budget with Name "Test"

  Scenario: Creating budget sample data
    When I create a Budget with Name "Test"
    Then Budget contains more than 1 Categories

  Scenario: Creating multiple budgets
    Given I have a Budget with Name "Test"
    When I create a Budget with Name "Test 2"
    Then I have 2 Budgets

  Scenario: Unicode and Emojis
    When I create a Budget with name "M҉y҉ ҉B҉u҉d҉g҉e҉t҉ 😂"
    Then I should have a Budget with Name "M҉y҉ ҉B҉u҉d҉g҉e҉t҉ 😂"

  Scenario: Deleting budget
    Given I have a Budget with Name "Test"
    When I delete the Budget with Name "Test"
    Then I shouldnt have a Budget with Name "Test"

  Scenario: Currency and localisation German defaults
    Given There is a User with locale "de_DE"
    When I create a Budget
    Then Currency should be "EUR"
    And Number format shoud be "1.000,00"
    And Currency placement should be "After"

  Scenario: Currency and localisation US defaults
    Given There is a User with locale "en_US"
    When I create a Budget
    Then Currency should be "USD"
    And Number format shoud be "1,000.00"
    And Currency placement should be "Before"

  Scenario: Changing currency
    Given There is a User with locale "en_US"
    When I change Curreny to "EUR"
    Then Currency should be "EUR"
