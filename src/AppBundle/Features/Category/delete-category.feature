Feature: DELETE-category
  @javascript
  Scenario: Eliminar categoria
    Given I am on "/categories"
    When I click in link "Eliminar"
    Then I should be on "/categories"
    #And I should see "La categoria se ha eliminado correctamente"
    And show last response