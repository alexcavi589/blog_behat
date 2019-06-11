Feature: CREATE-tag
  @javascript
  Scenario: Añadir Etiqueta
    Given I am on "/tags"
    When I click in link "Añadir Etiqueta"
    Then I should be on "/tags/add"
    When I fill in the following "Nombre test 4" in field "Nombre:"
    When I fill in the following "Descripcion test 4" in field "Descripcion:"
    And I press "Guardar"
    Then I should be on "/tags"
    And I should see "La etiqueta se ha creado correctamente"
    And show last response