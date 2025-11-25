describe('Cadastro e acesso de loja', () => {
  it('Usuário cadastra loja e acessa perfil', () => {
    cy.visit('View/sign-up-store.php');
    cy.get('#storeName').type('Loja Teste');
    cy.get('#userEmail').type('lojateste@exemplo.com');
    cy.get('#userPass').type('123456');
    cy.get('#userPassConfirm').type('123456');
    cy.get('#cnpj').type('12345678000199');
    cy.get('#address').type('Rua Loja, 100');
    cy.get('#phone').type('11988887777');
    cy.get('button[type="submit"]').click();
    cy.url().should('include', 'index.php');
    cy.visit('View/profile.php');
    cy.get('.profile-user-name').should('contain.text', 'Loja Teste');
  });
});
