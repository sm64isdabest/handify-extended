describe('Visualização de produto - site atual', () => {
  it('Exibe detalhes de um produto', () => {
    cy.visit('View/product.php');
    cy.get('h1').should('exist');
    cy.get('.price .old-price').should('exist');
    cy.get('.installments').should('exist');
    cy.get('.payment-methods').should('exist');
    cy.get('.botoes_adc .add-to-cart').should('exist');
  });
});
