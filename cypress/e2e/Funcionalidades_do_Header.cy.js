describe('Funcionalidades do Header e footer', () => {
  beforeEach(() => {
    cy.visit('src/pages/sign-up.html')
  })

  it('Testando botões do header', () => {
    cy.get("nav").contains('Produtos').click()
    cy.url().should('include', 'index.html')
    cy.visit('src/pages/sign-up.html')
     cy.get("nav").contains('Contato').click()
     cy.url().should('include', 'about.html')
     cy.visit('src/pages/sign-up.html')
    cy.get("nav").contains('Sobre').click()
    cy.url().should('include', 'about.html')
    cy.visit('src/pages/sign-up.html')
    cy.get("nav").contains('Entrar').click()
     cy.url().should('include', 'sign-up.html')
  })

  it('Testanto redes sociais do footer', () => {
    cy.get('.bi-whatsapp')
    .parent('a')
    .should('have.attr', 'href', 'https://web.whatsapp.com/')
   cy.get('.bi-youtube')
   .parent('a')
   .should('have.attr', 'href', 'https://www.youtube.com/')
   cy.get('.bi-twitter-x')
   .parent('a')
   .should('have.attr', 'href', 'https://x.com/')
   cy.get('.bi-instagram')
    .parent('a')
    .should('have.attr', 'href', 'https://www.instagram.com/')
  })
})