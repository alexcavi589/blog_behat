Feature: DELETE-tag
  @javascript
  Scenario: Eliminar etiqueta
    Given I am on "/tags"
    When I click in link "Eliminar"
    Then I should be on "/tags"
    #And I should see "La etiquetase ha eliminado correctamente"
    And show last response