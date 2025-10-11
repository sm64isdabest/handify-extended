describe('Página de Vender Produtos', () => {
  beforeEach(() => {
  // Altere o caminho conforme seu ambiente local ou hospedado
  cy.visit('View/sell.php');
  });

  it('Deve carregar o logo e os links de navegação', () => {
    cy.get('header .logo').should('be.visible');
    cy.get('nav ul li a').contains('Contato');
    cy.get('nav ul li a').contains('Sobre');
  });

  it('Deve permitir preencher informações do produto', () => {
    cy.get('.nome-produto input').type('Camiseta Artesanal');
    cy.get('.valor-produto input').type('59.90');
    cy.get('.parcelas-produto input').type('3x de 19.97');
    cy.get('.descricao-produto input').type('Camiseta 100% algodão feita à mão');
  });

  it('Deve preencher quantidade e verificar botões desabilitados', () => {
    cy.get('.quantidade-produto input').type('10');
    cy.get('.comprar-agora').should('be.disabled');
    cy.get('.adicionar-carrinho').should('be.disabled');
  });

  it('Deve permitir adicionar informações de destaque', () => {
    cy.get('.botoes-destaque button').each(($btn) => {
      cy.wrap($btn).click();
    });
  });

  it('Deve preencher a descrição extra do produto', () => {
    cy.get('.quadro-descricao input').type('Produto sustentável e ecológico.');
  });

  it('Deve conter ícones sociais no rodapé', () => {
    cy.get('footer .social-icons a').should('have.length', 4);
  });

  it('Deve carregar o plugin VLibras', () => {
    cy.get('[vw]').should('exist');
    cy.get('[vw-access-button]').should('exist');
  });
});