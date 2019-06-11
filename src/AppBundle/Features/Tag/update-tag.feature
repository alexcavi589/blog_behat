Feature: UPDATE-tag
  @javascript
  Scenario: Editar entrada
    Given I am on "/login"
    When I fill in the following "avillamil@optimeconsulting.com" in field "username"
    And I fill in the following "pass" in field "password"
    And I press "Entrar"
    Then I should be on "/home"
    And I am on "/category/1"
    When I click in link "Editar"
    Then I should be on "/entries/edit/45"
    When I fill in the following "test 1" in field "Etiquetas"
    When I fill in the following "test 1" in field "Titulo:"
    When I fill in the following "test 1" in field "Contenido:"
    When I fill in the following "public" in field "Estado:"
    When I fill in the following "Edicion test 3" in field "Categorias:"
    And I press "Guardar"
    Then I should be on "/home"
    And I should see "La entrada se ha editado correctamente"
    And show last response