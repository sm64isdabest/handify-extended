describe('Funcionalidades de Cadastro', () => {
  beforeEach(() => {
    cy.visit('src/pages/sign-up.html');
  })

  it('Testanto o metodo de cadastro Consumidores', () => {
    cy.get('#userName').type('João da Silva')
    cy.get('#userEmail').type('joaosilva@gmail.com')
    cy.get('#userPass').type('26981245')
    cy.get('#userPassConfirm').type('26981245')
    .get('.active').contains('Para Consumidores').click();
    cy.get('#userName').type('Carlos Santos')
    .get('#userEmail').type('carlossnts@gmail.com')
    cy.get('#userPass').type('2509874')
    cy.get('#userPassConfirm').type('2509874')
    cy.get('.active1').contains('Para Lojas').click();
    cy.get('#userCNPJ').type('03848688000152')
    cy.get('#userEmail').type('Rua do jacare')
    cy.get('#userPass').type('71954123978')
    cy.get('#userPassConfirm').type('Handify')
    cy.get('.active').contains('Cadastrar').click();
})
})