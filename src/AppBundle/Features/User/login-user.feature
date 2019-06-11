Feature: LOGIN-user
  @javascript
  Scenario: Login User
    Given I am on "/login"
    When I fill in the following "Email@test8.com" in field "username"
    And I fill in the following "pass" in field "password"
    And I press "Entrar"
    Then I should be on "/login"
    And I should see "Estas logueado como usuario normal"
    And show last response