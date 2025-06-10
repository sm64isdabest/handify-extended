Feature: Funcionalidades do Header 

Scenario: Testagem da Header
    Given I am on the registration page
    When I click in the home field
    Given I am on the registration page
    When I click in the contact field
    Given I am on the about page
    Given I am on the registration page
    When I click in the about field
    Given I am on the about page
    Given I am on the registration page
    When I click on the enter
    Given I am on the registration page

Scenario: Testagem os icones das redes sociais
    Given I am on the registration page
    When I click in the whatsapp icon
    And I am on the whatsapp
    When I click in the youtube icon
    And I am on the youtube 
    When I click in the X(twitter) icon
    And I am on the X(twitter)
    When I click in the instagram icon
    And I am on the instagram

Feature: Funcionalidades de Cadastro

Scenario: Testagem do cadastro
    Given I am on the registration page
    When I enter "João da Silva" in the username field
    And I enter "joaosilva@gmail.com" in the email field
    And I enter "26981245" in the pass field
    And I enter "26981245" in the pass confirm field
    And I click on the For consumers button
    Given I am on the registration page
    When I enter "Carlos Santos" in the username field
    And I enter "carlossnts@gmail.com" in the email field
    And I enter "2509874" in the pass field
    And I enter "2509874" in the pass confirm field
    And I click in the For Stores button
    Given I am on the stores registration page
    When I enter "03848688000152" in the CNPJ field
    And I enter "Rua do jacare" in the adress field
    And I enter "71954123978" in the number field
    And I enter "Handify" in the store name field
    And I click in the Register button


Feature: Página Vender Produtos

     Background:
    Given I visit the sell products page

Scenario: Verify main elements of the page
    Then the logo should be visible
    And the "Contato" link should exist
    And the "Product Name" field should exist
    And the "Buy Now" button should be disabled
    And the "Add to Cart" button should be disabled

Scenario: Fill in product information
    When I fill in the product name with "Test Product"
    And I fill in the value with "199.99"
    And I fill in the installments with "3x"
    And I fill in the description with "Test description"
    And I fill in the quantity with "10"
    And I click on the highlight buttons
    Then the "Buy Now" button should be disabled
    And the "Add to Cart" button should be disabled


Feature: Product View

Scenario: User views the details of the "Straw Bag"
    Given that the user accesses the product page "Straw Bag"
    Then the product name should be displayed as "Straw Bag"
    And the original price should be displayed as "R$ 279.90 OFF"
    And the promotional price should be displayed as "R$ 139.95"
    And there should be the option "View payment methods"
    And the installment information should be "in 12x R$ 23.32*"
    And the color should be displayed as "Dark beige"
    And the handle color as "Brown"
    And the material as "Synthetic woven straw"
    And contain a buy button
    And contain an add to cart button

Feature: Add product to cart

    Scenario: User adds product to cart
    Given that the user is on the "Straw Bag" page
    When he clicks on the "Add to Cart" button
    Then the product should be added to the cart successfully
    And the product name should be displayed as "Straw Bag"
    And the image of the bag appears
    And the current price should be "R$ 139.95"
    And the original price should be "R$ 279.90"
    And the exit icon should be present

Feature: Increase/Decrease product quantity

Scenario: User increases product quantity
    Given that the user is viewing the "Cart"
    Then the product should be visible
    And should contain an option to increase the quantity
    When the user clicks on the "+" button
    Then the product quantity should be increased
    And the number 2 should appear in the quantity

Scenario: User decreases quantity of product
    Given that the user is viewing the "Cart"
    Then the product must be visible
    And must contain an option to decrease the quantity
    When the user clicks on the "-" button
    Then the quantity of the product must be reduced
    And the number 1 must appear in the quantity

Feature: Accessing the cart

Scenario: User accesses the cart icon
    Given that the user accesses the cart icon
    Then the added product must be visible
    And the title "Straw bag" must be visible
    And the current price must be "R$ 139.95"
    And the original price must be "R$ 279.90"
    And check the purchase summary

Feature: Access other products

Scenario: User accesses the cutlery rack
    Considering that the user accesses the product's cutlery rack
    Then the product should be visible
    And the title "Cutlery Rack" should be visible
    And the current price should be "R$ 78.90"
    And the original price should be "R$ 87.90"
