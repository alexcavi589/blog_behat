Feature: CREATE-category
  @javascript
  Scenario: Añadir categoria

    Given I am on "/categories"
    When I click in link "Añadir categoria"
    Then I should be on "/categories/add"
    When I fill in the following "Nombre test 2" in field "Nombre:"
    When I fill in the following "Descripcion test 2" in field "Descripcion:"
    And I press "Guardar"
    Then I should be on "/categories"
    And I should see "La categoria se ha creado correctamente"
    And show last response