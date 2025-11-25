describe('Carrinho - site atual', () => {
  it('Usuário adiciona produto e acessa carrinho', () => {
    cy.visit('View/product.php');
    cy.get('.botoes_adc .add-to-cart, .purchase-buttons .add-to-cart').first().click();
    cy.get('button.cart').click();
    cy.get('#cart-popup').should('be.visible');
    cy.get('.cart-items').should('contain.text', 'Bolsa');
    cy.get('.cart-total').should('not.have.text', 'R$ 0,00');
  });
});
