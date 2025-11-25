describe('Header e Footer - site atual', () => {
  it('Testa navegação do header', () => {
    cy.visit('index.php');
    cy.get('nav').contains('Home').click();
    cy.url().should('include', 'index.php');
    cy.get('nav').contains('Sobre').click();
    cy.url().should('include', 'View/about.php');
    cy.get('nav').contains('Contato').click();
    cy.url().should('include', '#footer');
  });

  it('Testa redes sociais do footer', () => {
    cy.visit('index.php');
    cy.get('.bi-whatsapp').parent('a').should('have.attr', 'href', 'https://web.whatsapp.com/');
    cy.get('.bi-youtube').parent('a').should('have.attr', 'href', 'https://www.youtube.com/');
    cy.get('.bi-twitter-x').parent('a').should('have.attr', 'href', 'https://x.com/');
    cy.get('.bi-instagram').parent('a').should('have.attr', 'href', 'https://www.instagram.com/');
  });
});
