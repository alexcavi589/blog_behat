Feature: UPDATE-category
  @javascript
  Scenario: Editar categoria
    Given I am on "/categories"
    When I click in link "Editar"
    Then I should be on "/categories/edit/1"
    When I fill in the following "Edicion test 3" in field "Nombre:"
    When I fill in the following "Descripcion test 3" in field "Descripcion:"
    And I press "Guardar"
    Then I should be on "/categories"
    And I should see "La categoria se ha editado correctamente"
    And show last response


