describe('Pagamento com cartão', () => {
  it('Usuário realiza pagamento com cartão', () => {
    cy.visit('View/payment-card.php');
    cy.get('#checkout-total').should('exist').and('not.have.text', 'R$ 0,00');
    cy.get('.card-list .order-card, #cards-box .card-option').first().should('exist');
    cy.get('.edit-btn, #pay-btn').contains('Pagar').click({ multiple: true });
    cy.get('.modal-content, body').should('exist');
    cy.get('form, #select-card-form').submit();
    cy.url().should('include', 'payment-confirmed.php');
  });
});
