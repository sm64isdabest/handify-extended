describe('Aumentar/diminuir quantidade', () => {
  it('Usuário deve aumentar quantidade', () => {
    cy.visit('src/pages/productView.html');
    cy.get('.purchase-info .add-to-cart').click();
    cy.get('.popup-qty-btn.popup-qty-plus').should('be.visible');
    cy.get('.popup-qty-btn.popup-qty-plus').click();
    cy.get('.popup-indicador-qtd span.popup-qty-value').should('contain', '2');
  });
  it('Usuário deve diminuir quantidade', () => {
    cy.visit('src/pages/productView.html');
    cy.get('.purchase-info .add-to-cart').click();
    cy.get('.popup-qty-btn.popup-qty-minus').should('be.visible');
    cy.get('.popup-qty-btn.popup-qty-plus').click();
    cy.get('.popup-qty-btn.popup-qty-minus').click();
    cy.get('.popup-indicador-qtd span.popup-qty-value').should('contain', '1');
  });
});