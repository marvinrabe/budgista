Feature: Budgets
  As a user
  In order to keep track of my money
  I need to be able to create multiple budgets

  Rules:
  - New budgets contain sample categories
  - I can create as many budgets as I want
  - Budgets have different currencies

  Scenario: Creating budget
    When I create a Budget with Name "Test"
    Then I should have a Budget with Name "Test"

  Scenario: Creating budget sample data
    When I create a Budget with Name "Test"
    Then Budget contains more than 1 Categories

  Scenario: Creating multiple budgets
    Given I have a Budget called "Test"
    When I create a Budget with Name "Test 2"
    Then I should have 2 Budgets

  Scenario: Unicode and Emojis
    When I create a Budget with Name "M҉y҉ ҉B҉u҉d҉g҉e҉t҉ 😂"
    Then I should have a Budget with Name "M҉y҉ ҉B҉u҉d҉g҉e҉t҉ 😂"

  Scenario: Deleting budget
    Given I have a Budget called "Test"
    When I delete the Budget with Name "Test"
    Then I shouldnt have a Budget with Name "Test"
    And I should have 0 Budgets
