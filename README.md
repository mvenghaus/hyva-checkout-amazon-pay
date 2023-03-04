# hyva-checkout-amazon-pay
Hyvä Themes Compatibility module for Amazon_Pay

## Features
- Rendering Amzaon Pay Button in cart methods
- ViewModel to render Amazon Pay Button wherever you want
- Automatically create address in address book if not exists
- In Amazon Checkout - Toolbar to "Go back to Standard" or "Change Address or Payment on Amazon"
- In Amazon Checkout - Only Amazon Pay as method available
- GDPR (Cookie Consent) Handling - add extra attributes to script tag via config (currently not editable via admin)

## Todo
- Amazon Login
- Handle incomplete addresses from amazon
- More error handling
- Tests
- ...

## Installation

**!! You need at least the RC version of Hyva Checkout (you need to buy it) !!**

1. Add repository to your composer.json
```
"mvenghaus/hyva-checkout-amazon-pay": {
    "type": "git",
    "url": "https://github.com/mvenghaus/hyva-checkout-amazon-pay"
}
```
2. Install pakage
```
composer require mvenghaus/hyva-checkout-amazon-pay 
```