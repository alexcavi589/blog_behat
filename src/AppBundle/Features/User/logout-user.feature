Feature: LOGOUT-user
  @javascript
  Scenario: Logout
    Given I am on "/home"
    When I click in link "dropdown-toggle"
    And I click in link "Salir"
    Then I should be on "/logout"
    And I should see "Identifícate"
    And show last response