# UsePIX

[![en](https://img.shields.io/badge/lang-en-red.svg)](./README.md) [![pt-BR](https://img.shields.io/badge/lang-ptbr-green.svg)](./README.pt-br.md)

  

O objetivo do UsePIX.com.br é facilitar o uso do PIX entre usuários e para integrações com sistemas.

  

Gere facilmente uma cobrança para a SUA chave PIX, deixe seu cliente escolher como pagar e receba 100% do valor, sem taxas nem descontos e direto em sua conta, de forma automática.

  

Características:

- Grátis: Independente do valor da cobrança, você não paga nada para gerar e receber o pagamento.

- 100% do valor do PIX: O valor do PIX é 100% para você, sem taxas nem descontos.

- Fácil: Sem registros, sem cadastros, sem burocracia. Você gera a cobrança e recebe o pagamento. Simples assim!

- Instantâneo: O pagamento é instantâneo, você recebe o valor em sua conta em poucos segundos de forma automática após o pagamento integral.

- Multi pagamentos em um único PIX: Você pode receber vários pagamentos em um único PIX: um pedaço via cartão, outro em outro cartão, outro via PIX, outro via Paypal, outro via MercadoPago, etc. O seu cliente escolhe como pagar, quais os métodos de pagamento e você recebe 100% do valor.

- Gera QRCodes de pagamentos estáticos (valores fixos) e dinâmicos (o cliente digita quando escanear).

- Utiliza-se da semântica de URLs facilitadas onde, após o nome do domínio, o primeiro campo será a chave PIX de quem recebe e, após uma barra, o valor (se necessário).

  

## Como Funciona?

- Gere uma cobrança para a sua chave PIX no valor desejado

- Envie o link para o seu cliente e deixe ele escolher como pagar

- Receba o pagamento em sua conta bancária em poucos segundos

  

## Como Pagar?

Atualmente suportamos múltiplos pagamentos para os seguintes meios:

- Cartão de Crédito

- PIX

- Mercado Pago

- PayPal

  

## O que já se pode fazer com o UsePIX?

- cobrar um PIX e o cliente pagar parcelado em mais de um cartão ou juntar mais de uma conta para fazer o valor total do PIX;

- integrar em sistemas já prontos para fazer cobrança PIX e receber as notificações automáticas;

- muito mais coisa que não consigo pensar agora!

  

## Sistemas que já utilizam o UsePIX

- https://card2pix.com/ - converta o limite do seu cartão em PIX

  
  

---

  
  

## Instalação

Para instalar ele, deve-se:

- Acessar a pasta `_core` e rodar `composer install`

- Copiar o `.env.example` para `.env` e configurá-lo

- Para o Optimus, rodar ainda dentro da para _core: `php vendor/bin/optimus spark`, copiar os códigos e inserir no .env

  

## Banco de Dados

Importar o arquivo _core/_banco_usepix.sql

  

## Acesso do usuário

Ao configurar e importar, o acesso no site já deverá ser possível.

  

## Acesso Administrativo

- Acesse o endereço: `https://usepix.com.br/adm/login/` (trocar por sua URL)

- Digite os dados de acesso: usuário `admin` e senha `123456`

  

## Configuração do MercadoPago

- Acesse sua conta do Mercado Pago e configure as credenciais do sistema no .env (TOKEN_MP e PUBLIC_KEY_MP)

  

## API

O sistema já vem com uma API pronta para uso.

A nossa API é de uso aberto e você pode integrar em seus sistemas de forma muito fácil.

Não é necessário ter conta no nosso sistema para utilizar a API.

Para utilizar a API, você não precisa ter uma chave de acesso.

A API é de uso aberto e você pode utilizar em seus sistemas sem custo algum.

- View collection => https://elements.getpostman.com/redirect?entityId=4212303-7b255811-3244-4237-9060-d98e5b8229b9&entityType=collection&workspaceId=6834dda2-260b-4e2d-9dae-89ca49287675

  

## Muito mais do que você imagina!

O sistema já tem muito mais coisa do que você possa imaginar.

Falta ajuda para documentar tudo com mais detalhamento!

  

## Suporte

Se precisar de algo, acesse o site oficial e solicite suporte.

  

## Manutenção do Código

Incentivo-o a se juntar para crescermos o projeto!

Faça as suas contribuições no projeto!