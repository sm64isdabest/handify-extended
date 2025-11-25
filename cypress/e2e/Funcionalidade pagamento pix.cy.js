describe('Pagamento com Pix', () => {
  it('Usuário realiza pagamento com Pix', () => {
    cy.visit('View/payment-pix.php');
    cy.get('#qrcode').should('exist');
    cy.get('#checkout-total').should('exist').and('not.have.text', 'R$ 0,00');
    cy.get('.pix-key, #pixKey').should('exist');
    cy.get('.edit-btn, .copy-button').contains('Copiar').click({ multiple: true });
    cy.get('#confirm-payment').click();
    cy.url().should('include', 'payment-confirmed.php');
  });
});
