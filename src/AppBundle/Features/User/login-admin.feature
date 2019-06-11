Feature: LOGIN-admin
  @javascript
  Scenario: Login Admin
    Given I am on "/login"
    When I fill in the following "avillamil@optimeconsulting.com" in field "username"
    And I fill in the following "pass" in field "password"
    And I press "Entrar"
    Then I should be on "/login"
    And I should see "Estas logueado como ADMINISTRADOR"
    And show last response