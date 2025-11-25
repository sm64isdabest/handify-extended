describe('Perfil e modo escuro', () => {
  it('Acessa perfil e alterna modo escuro', () => {
    cy.visit('View/profile.php');
    cy.get('.profile-user-name').should('exist');
    cy.get('#theme-toggle-btn').should('exist').click();
    cy.get('html').should('have.class', 'dark-mode');
    cy.get('#theme-toggle-btn').click();
    cy.get('html').should('not.have.class', 'dark-mode');
  });
});
