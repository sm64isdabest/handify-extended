describe('Adicionar cartão', () => {
  it('Usuário adiciona cartão na página de perfil', () => {
    cy.visit('View/profile.php');
    cy.get('#payments').should('exist').click();
    cy.get('#add-card-btn').click();
    cy.get('#addCardModal').should('be.visible');
    cy.get('#cardholderName').type('João Cartão');
    cy.get('#cardTaxId').type('123.456.789-00');
    cy.get('#cardEmail').type('joaocartao@exemplo.com');
    cy.get('#cardPhone').type('11999999999');
    cy.get('#addressLine1').type('Rua Cartão, 123');
    cy.get('#city').type('São Paulo');
    cy.get('#state').type('SP');
    cy.get('#postalCode').type('01000-000');
    cy.get('#add-card-form').submit();
    cy.get('#addCardModal').should('not.be.visible');
  });
});
