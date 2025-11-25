describe('Página de confirmação de pagamento', () => {
  it('Usuário visualiza página de confirmação', () => {
    cy.visit('View/payment-confirmed.php');
    cy.get('h1, h2, h3').should('contain.text', 'Pagamento Confirmado');
    cy.get('.edit-btn').contains('Voltar para Home').should('exist');
  });
});
