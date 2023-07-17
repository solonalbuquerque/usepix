# UsePIX

[![en](https://img.shields.io/badge/lang-en-red.svg)](./README.md) [![pt-BR](https://img.shields.io/badge/lang-ptbr-green.svg)](./README.pt-br.md)

  

The purpose of UsePIX.com.br is to facilitate the use of the PIX among users and for integration with systems.

  

Easily generate a charge for YOUR PIX key, let your customer choose how to pay and receive 100% of the amount, without fees or discounts and directly in your account, automatically.

  

Characteristics:

- Free: Regardless of the charge amount, you pay nothing to generate and receive payment.

- 100% of the PIX value: The PIX value is 100% for you, with no fees or discounts.

- Easy: No registrations, no registrations, no bureaucracy. You generate the charge and receive payment. That simple!

- Instant: Payment is instant, you receive the amount in your account in a few seconds automatically after full payment.

- Multi payments in a single PIX: You can receive multiple payments in a single PIX: one piece via card, another on another card, another via PIX, another via Paypal, another via MercadoPago, etc. Your customer chooses how to pay, which payment methods and you receive 100% of the amount.

- Generates QRCodes for static payments (fixed values) and dynamic ones (the customer types when scanning).

- It uses the semantics of facilitated URLs where, after the domain name, the first field will be the PIX key of the recipient and, after a slash, the value (if necessary).

  

## How it works?

- Generate a charge for your PIX key in the desired amount

- Send the link to your customer and let them choose how to pay

- Receive payment in your bank account in a few seconds

  

## How to pay?

We currently support multiple payments for the following means:

- Credit card

- PIX

- Mercado Pago

- PayPal

  

## What can you already do with UsePIX?

- charge a PIX and the customer pays in installments on more than one card or join more than one account to make the total value of the PIX;

- integrate into systems already ready to charge PIX and receive automatic notifications;

- a lot more stuff I can't think of right now!

  

## Systems that already use UsePIX

- https://card2pix.com/ - convert your card limit into PIX

  
  

---

  
  

## Installation

To install it, you must:

- Access the `_core` folder and run `composer install`

- Copy `.env.example` to `.env` and configure it

- For Optimus, run still inside the for _core: `php vendor/bin/optimus spark`, copy the codes and insert in the .env

  

## Database

Import the _core/_banco_usepix.sql file

  

## User access

When configuring and importing, access to the site should already be possible.

  

## Administrative Access

- Access the address: `https://usepix.com.br/adm/login/` (change for your URL)

- Enter the access data: username `admin` and password `123456`

  

## MercadoPago Configuration

- Access your Mercado Pago account and configure the system credentials in the .env (TOKEN_MP and PUBLIC_KEY_MP)

  

## API

The system already comes with a ready-to-use API.

Our API is open to use and you can integrate it into your systems very easily.

It is not necessary to have an account on our system to use the API.

To use the API, you don't need an access key.

The API is open to use and you can use it on your systems at no cost.

- View collection => https://elements.getpostman.com/redirect?entityId=4212303-7b255811-3244-4237-9060-d98e5b8229b9&entityType=collection&workspaceId=6834dda2-260b-4e2d-9dae-89ca49287675

  

## Much more than you can imagine!

The system already has much more than you can imagine.

Help is needed to document everything in more detail!

  

## Support

If you need something, go to the official website and request support.

  

## Code Maintenance

I encourage you to join so we can grow the project!

Make your contributions to the project!