describe('Acessar outro produto', () => {
  it('Usuário acessa o produto Suporte de Faqueiros através de outras ofertas', () => {
    cy.visit('src/pages/productView.html');
    cy.get('.offers-container .card[data-slug="suporte-de-faqueiros"]').first().click();
    cy.get('h5, h1').should('contain', 'Suporte de Faqueiros');
    cy.contains('R$ 78,90').should('exist');
    cy.contains('R$ 89,70 OFF').should('exist');
  });
}); 