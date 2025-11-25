Feature: Header Features

Scenario: Header Testing
    Given I am on the registration page
    When I click the home field
    Given I am on the registration page
    When I click the contact field
    Given I am on the about page
    Given I am on the registration page
    When I click the about field
    Given I am on the about page
    Given I am on the registration page
    When I click the enter button
    Given I am on the registration page

Scenario: Social Media Icons Testing
    Given I am on the registration page
    When I click the whatsapp icon
    And I am on whatsapp
    When I click the youtube icon
    And I am on youtube
    When I click the X(twitter) icon
    And I am on X(twitter)
    When I click the instagram icon
    And I am on instagram

Feature: Registration Features

Scenario: Registration Testing
    Given I am on the registration page
    When I enter "João da Silva" in the username field
    And I enter "joaosilva@gmail.com" in the email field
    And I enter "26981245" in the password field
    And I enter "26981245" in the password confirm field
    And I click the For consumers button
    Given I am on the registration page
    When I enter "Carlos Santos" in the username field
    And I enter "carlossnts@gmail.com" in the email field
    And I enter "2509874" in the password field
    And I enter "2509874" in the password confirm field
    And I click the For Stores button
    Given I am on the stores registration page
    When I enter "03848688000152" in the CNPJ field
    And I enter "Rua do jacare" in the address field
    And I enter "71954123978" in the number field
    And I enter "Handify" in the store name field
    And I click the Register button

Feature: Sell Products Page

Background:
    Given I visit the sell products page

Scenario: Verify main elements of the page
    Then the logo should be visible
    And the "Contact" link should exist
    And the "Product Name" field should exist
    And the "Buy Now" button should be disabled
    And the "Add to Cart" button should be disabled

Scenario: Fill in product information
    When I fill in the product name with "Test Product"
    And I fill in the value with "199.99"
    And I fill in the installments with "3x"
    And I fill in the description with "Test description"
    And I fill in the quantity with "10"
    And I click the highlight buttons
    Then the "Buy Now" button should be disabled
    And the "Add to Cart" button should be disabled

Feature: Product View

Scenario: User views the details of the "Straw Bag"
    Given the user accesses the product page "Straw Bag"
    Then the product name should be displayed as "Straw Bag"
    And the original price should be displayed as "R$ 279.90 OFF"
    And the promotional price should be displayed as "R$ 139.95"
    And there should be the option "View payment methods"
    And the installment information should be "in 12x R$ 23.32*"
    And the color should be displayed as "Dark beige"
    And the handle color as "Brown"
    And the material as "Synthetic woven straw"
    And there should be a buy button
    And there should be an add to cart button

Feature: Add product to cart

Scenario: User adds product to cart
    Given the user is on the "Straw Bag" page
    When they click the "Add to Cart" button
    Then the product should be added to the cart successfully
    And the product name should be displayed as "Straw Bag"
    And the image of the bag should appear
    And the current price should be "R$ 139.95"
    And the original price should be "R$ 279.90"
    And the exit icon should be present

Feature: Increase/Decrease product quantity

Scenario: User increases product quantity
    Given the user is viewing the "Cart"
    Then the product should be visible
    And there should be an option to increase the quantity
    When the user clicks the "+" button
    Then the product quantity should be increased
    And the number 2 should appear in the quantity

Scenario: User decreases product quantity
    Given the user is viewing the "Cart"
    Then the product should be visible
    And there should be an option to decrease the quantity
    When the user clicks the "-" button
    Then the product quantity should be decreased
    And the number 1 should appear in the quantity

Feature: Accessing the cart

Scenario: User accesses the cart icon
    Given the user accesses the cart icon
    Then the added product should be visible
    And the title "Straw Bag" should be visible
    And the current price should be "R$ 139.95"
    And the original price should be "R$ 279.90"
    And the purchase summary should be checked

Feature: Access other products

Scenario: User accesses the cutlery rack
    Given the user accesses the product's cutlery rack
    Then the product should be visible
    And the title "Cutlery Rack" should be visible
    And the current price should be "R$ 78.90"
    And the original price should be "R$ 87.90"

Feature: Profile and Dark Mode

Scenario: Access profile and toggle dark mode
    Given I am on the profile page
    Then the profile name should be visible
    When I click the dark mode button
    Then dark mode should be enabled
    When I click the dark mode button again
    Then dark mode should be disabled

Feature: Add Card

Scenario: Add card on profile page
    Given I am on the profile page
    When I click the payments tab
    And I click the add card button
    And I fill in the cardholder name with "João Cartão"
    And I fill in the CPF or CNPJ with "123.456.789-00"
    And I fill in the email with "joaocartao@exemplo.com"
    And I fill in the phone with "11999999999"
    And I fill in the address with "Rua Cartão, 123"
    And I fill in the city with "São Paulo"
    And I fill in the state with "SP"
    And I fill in the postal code with "01000-000"
    And I submit the card form
    Then the card should be added

Feature: Card Payment

Scenario: Make payment with card
    Given I am on the payment card page
    When I select a saved card
    And I click the pay button
    Then the payment should be confirmed
    And I should be redirected to the payment confirmation page

Feature: Pix Payment

Scenario: Make payment with Pix
    Given I am on the payment Pix page
    Then the QR code should be visible
    And the total purchase amount should be visible
    When I copy the Pix key
    And I confirm the payment
    Then I should be redirected to the payment confirmation page

Feature: Payment Confirmation Page

Scenario: View confirmation page
    Given I am on the payment confirmation page
    Then the confirmation message should be visible
    And the button to return to home should be visible
