describe('Visualização do produto', () => {
  it('deve exibir os detalhes da Bolsa de palha', () => {
    cy.visit('src/pages/product.html');
    cy.get('h1').contains('Bolsa de palha');
    cy.get('.old-price').contains('R$ 279,90 OFF');
    cy.get('.current-price').contains('R$ 139,95');
    cy.get('.payment-methods').contains('Ver meios de pagamentos');
    cy.get('.installments').contains('em 12x R$ 23,32*');
    cy.get('.bolsa').contains('Cor: Bege escuro');
    cy.get('.alça').contains('Cor da Alça: Marrom');
    cy.get('.palha').contains('Material: Palha trançada sintética');
  });
});