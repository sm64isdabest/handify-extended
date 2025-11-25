describe('Página de Vender Produtos', () => {
  it('Acessa página de venda e preenche dados', () => {
    cy.visit('View/sell.php');
    cy.get('.nome-produto input').type('Produto Cypress');
    cy.get('.valor-produto input').type('99.90');
    cy.get('.parcelas-produto input').type('2x de 49.95');
    cy.get('.descricao-produto input').type('Descrição do produto Cypress');
    cy.get('.quantidade-produto input').type('5');
    cy.get('.botoes-destaque button').first().click();
    cy.get('.quadro-descricao input').type('Produto ecológico.');
    cy.get('footer .social-icons a').should('have.length', 4);
  });
});
