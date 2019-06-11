Feature: REGISTRAR-user
  @javascript
  Scenario: Login
    Given I am on "/login"
    When I fill in the following "test11" in field "Nombre"
    And I fill in the following "test11" in field "Apellido"
    And I fill in the following "Email@test11.com" in field "Email"
    And I fill in the following "pass" in field "Contraseña"
    And I press "Guardar"
    And I should see "El usuario se ha creado correctamente"
    Then I should be on "/login"
    And show last response