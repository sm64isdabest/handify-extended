describe('Acessar carrinho', () => {
  it('Usuário acessa carrinho', () => {
    cy.visit('src/pages/productView.html');
    cy.get('.purchase-info .add-to-cart').click();
    cy.get('.sair_pop').click();
    cy.get('.cart-btn').click();
    cy.get('#popup-produto-img').should('have.attr', 'src', '../images/produtos/bolsas/bolsa-palha.png');
    cy.get('#popup-produto-nome').should('contain', 'Bolsa de Palha');
    cy.get('.preco-riscado').contains('R$279,90');
    cy.get('.preco-destaque').contains('R$139,95');
    cy.get('.pag_pop').should('be.visible');
    });
})