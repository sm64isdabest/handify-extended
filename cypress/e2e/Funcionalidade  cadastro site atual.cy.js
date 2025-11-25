describe('Cadastro - site atual', () => {
  it('Usuário realiza cadastro de consumidor', () => {
    cy.visit('View/sign-up.php');
    cy.get('#userName').type('João da Silva');
    cy.get('#userEmail').type('joaosilva@gmail.com');
    cy.get('#userPass').type('123456');
    cy.get('#userPassConfirm').type('123456');
    cy.get('#phone').type('11999999999');
    cy.get('#birthdate').type('2000-01-01');
    cy.get('#address').type('Rua Exemplo, 123');
    cy.get('button[type="submit"]').click();
    cy.url().should('include', 'index.php');
  });
});
