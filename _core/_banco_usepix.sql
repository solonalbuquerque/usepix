-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 17-Jul-2023 às 03:13
-- Versão do servidor: 5.7.33
-- versão do PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `usepix`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario` varchar(150) DEFAULT NULL,
  `senha` varchar(250) DEFAULT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `primeiroNome` varchar(100) DEFAULT NULL,
  `titulo` varchar(150) DEFAULT NULL COMMENT 'titulo ou função',
  `email` varchar(150) DEFAULT NULL,
  `doc` varchar(20) DEFAULT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `blockedAt` datetime DEFAULT NULL,
  `vkey` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `afiliados`
--

CREATE TABLE `afiliados` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `codigo_acesso` varchar(10) NOT NULL,
  `cadastrado_em` datetime NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `chave_pix_deposito` varchar(255) NOT NULL,
  `saldo_disponivel` decimal(10,2) NOT NULL DEFAULT '0.00',
  `saldo_pendente` decimal(10,2) NOT NULL DEFAULT '0.00',
  `saldo_em_saque` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chaves`
--

CREATE TABLE `chaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chavepix_id` bigint(20) DEFAULT NULL,
  `chave` varchar(250) DEFAULT NULL COMMENT 'chave pix',
  `chave_tipo` varchar(20) DEFAULT NULL,
  `chave_valor` decimal(10,2) DEFAULT '0.00' COMMENT '1.00',
  `chave_identificador` varchar(50) DEFAULT NULL COMMENT 'identificador (mensalidade X do fulano)',
  `descricao` text COMMENT 'uma descrição extra',
  `qtd_pagamentos` int(10) DEFAULT '0',
  `valor_recebido` float(10,2) DEFAULT '0.00',
  `valor_repassado` float(10,2) DEFAULT '0.00',
  `valor_arepassar` float(10,2) DEFAULT '0.00',
  `status` varchar(20) DEFAULT 'captando' COMMENT 'captando, captado, ultrapassado, cancelado',
  `notification_url` varchar(255) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `blockedAt` datetime DEFAULT NULL,
  `removedAt` datetime DEFAULT NULL,
  `pixParceiro_id` bigint(20) DEFAULT NULL,
  `celularCliente` varchar(50) DEFAULT NULL,
  `emailCliente` varchar(150) DEFAULT NULL,
  `views` bigint(20) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chavespix`
--

CREATE TABLE `chavespix` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chave` varchar(250) DEFAULT NULL,
  `chave_tipo` varchar(20) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `blockedAt` datetime DEFAULT NULL,
  `removedAt` datetime DEFAULT NULL,
  `verificado_at` datetime DEFAULT NULL,
  `saldo` decimal(10,2) DEFAULT '0.00',
  `total_gerado` decimal(10,2) DEFAULT '0.00' COMMENT 'valor total das cobrancas',
  `total_arrecadado` decimal(10,2) DEFAULT '0.00' COMMENT 'total que pagaram (liquido sem as taxas)',
  `total_repassado` decimal(10,2) DEFAULT '0.00' COMMENT 'total repassado (depositado)',
  `total_pendente` decimal(10,2) DEFAULT '0.00' COMMENT 'ainda falta transferir',
  `qtd_pagamentos` bigint(10) DEFAULT '0' COMMENT 'quantidade de pagamentos pix',
  `qtd_gerados` bigint(10) DEFAULT '0',
  `dono_email` varchar(250) DEFAULT NULL,
  `dono_telefone` varchar(30) DEFAULT NULL COMMENT 'com o DDI e o DDD',
  `dono_nome` varchar(250) DEFAULT NULL,
  `dono_documento` varchar(30) DEFAULT NULL COMMENT 'CPF ou CNPJ',
  `valor_cobranca_minimo` decimal(10,2) DEFAULT '1.00',
  `valor_cobranca_maximo` decimal(10,2) DEFAULT '500.00',
  `valor_transferencia_minimo` decimal(10,2) DEFAULT '1.00',
  `valor_transferencia_maximo` decimal(10,2) DEFAULT '500.00',
  `status` varchar(50) DEFAULT 'ativo' COMMENT 'ativo, bloqueado, removido'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `chaves_payf`
--

CREATE TABLE `chaves_payf` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chave_id` bigint(20) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `metodo` varchar(20) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT '0.00',
  `infoStart` text,
  `retorno` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `emailesms`
--

CREATE TABLE `emailesms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ins` bigint(20) DEFAULT NULL,
  `userid` bigint(20) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `project` varchar(20) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `assunto` varchar(250) DEFAULT NULL,
  `message` text,
  `enviado` varchar(1) DEFAULT 's' COMMENT 's/n/p (em processo)',
  `enviadoAt` datetime DEFAULT NULL,
  `success` int(1) DEFAULT '0',
  `info` text,
  `vinculo_tipo` varchar(20) DEFAULT NULL,
  `vinculo_id` bigint(20) DEFAULT NULL,
  `vkey` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `financeiro`
--

CREATE TABLE `financeiro` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conta_id` bigint(20) DEFAULT NULL,
  `tipo` varchar(10) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT '0.00',
  `descricao` varchar(250) DEFAULT NULL,
  `informacoes` text,
  `createdAt` datetime DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `financeiro_contas`
--

CREATE TABLE `financeiro_contas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conta` varchar(250) DEFAULT NULL,
  `doc` varchar(20) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `nome` varchar(250) DEFAULT NULL,
  `responsavel_nome` varchar(250) DEFAULT NULL,
  `responsavel_doc` varchar(20) DEFAULT NULL,
  `responsavel_email` varchar(250) DEFAULT NULL,
  `responsavel_telefone` varchar(20) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `saldo` decimal(10,2) DEFAULT '0.00',
  `recebidos` decimal(10,2) DEFAULT '0.00',
  `saidas` decimal(10,2) DEFAULT '0.00',
  `temporario` decimal(10,2) DEFAULT '0.00',
  `saque_automatico` varchar(1) DEFAULT 's' COMMENT 's/n',
  `saque_automatico_minimo` decimal(10,2) DEFAULT '50.00',
  `saque_automatico_taxa_percentual` decimal(10,2) DEFAULT '1.00',
  `saque_automatico_taxa_fixa` decimal(10,2) DEFAULT '1.00',
  `saque_minimo` decimal(10,2) DEFAULT '10.00',
  `saque_taxa_percentual` decimal(10,2) DEFAULT '1.00',
  `saque_taxa_fixa` decimal(10,2) DEFAULT '1.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico`
--

CREATE TABLE `historico` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chave_id` bigint(20) DEFAULT NULL,
  `chavepix_id` bigint(20) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descricao` text,
  `vinculo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lancamentos`
--

CREATE TABLE `lancamentos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chave_id` bigint(20) DEFAULT NULL,
  `chavepix_id` bigint(20) DEFAULT NULL,
  `tipo` varchar(1) DEFAULT 'c' COMMENT 'c credito / d debito',
  `valor` decimal(10,2) DEFAULT '0.00' COMMENT 'valor que será injetado na chave',
  `valor_taxas` decimal(10,2) DEFAULT '0.00',
  `valor_total` decimal(10,2) DEFAULT '0.00',
  `valor_recebido` decimal(10,2) DEFAULT NULL COMMENT 'valor recebido no gateway',
  `modulo_pagamento` varchar(50) DEFAULT NULL,
  `meio_pagamento` varchar(50) DEFAULT NULL,
  `meio_pagamento_id` varchar(250) DEFAULT NULL,
  `status_pagamento` varchar(50) DEFAULT NULL COMMENT 'pendente, processando, concluido, cancelado',
  `status_pagamento_chave` varchar(50) DEFAULT NULL,
  `resposta_criacao` text,
  `resposta_pagamento` text,
  `createdAt` datetime DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pendente' COMMENT 'pendente, processando, concluido, cancelado',
  `status_motivo` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lancamentos_historico`
--

CREATE TABLE `lancamentos_historico` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lancamento_id` bigint(20) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  `status_anterior` varchar(50) DEFAULT NULL,
  `status_novo` varchar(50) DEFAULT NULL,
  `meio_pagamento_id` varchar(250) DEFAULT NULL,
  `meio_pagamento_tipo` varchar(50) DEFAULT NULL,
  `meio_pagamento_status` varchar(50) DEFAULT NULL,
  `meio_pagamento_resposta` text,
  `observacao` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs`
--

CREATE TABLE `logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(150) DEFAULT NULL,
  `detalhes` text,
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacoes_saque`
--

CREATE TABLE `solicitacoes_saque` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conta_id` bigint(20) DEFAULT NULL,
  `valor` float(10,2) DEFAULT NULL,
  `valor_taxas` decimal(10,2) DEFAULT '0.00',
  `valor_final` decimal(10,2) DEFAULT '0.00',
  `para_chavepix_id` bigint(20) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `resolvidoAt` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pendente' COMMENT 'pendente, na fila, concluido, cancelado',
  `status_motivo` varchar(250) DEFAULT NULL,
  `tipoSolicitacao` varchar(20) DEFAULT 'manual' COMMENT 'manual, automatica',
  `detalhes` text,
  `informacoesPagamento` text,
  `informacoesPagamentoBanco` varchar(50) DEFAULT NULL,
  `informacoesPagamentoMetodo` varchar(50) DEFAULT NULL,
  `informacoesPagamentoChave` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primeiroNome` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefone_verified_at` datetime DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `pfpj` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doc` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cep` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emailAt` datetime DEFAULT NULL,
  `vkey` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admins`
--
ALTER TABLE `admins`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices para tabela `afiliados`
--
ALTER TABLE `afiliados`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `chaves`
--
ALTER TABLE `chaves`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `chave` (`chave`);

--
-- Índices para tabela `chavespix`
--
ALTER TABLE `chavespix`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `chave` (`chave`);

--
-- Índices para tabela `chaves_payf`
--
ALTER TABLE `chaves_payf`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices para tabela `emailesms`
--
ALTER TABLE `emailesms`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `enviado` (`enviado`);

--
-- Índices para tabela `financeiro`
--
ALTER TABLE `financeiro`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices para tabela `financeiro_contas`
--
ALTER TABLE `financeiro_contas`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices para tabela `historico`
--
ALTER TABLE `historico`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices para tabela `lancamentos`
--
ALTER TABLE `lancamentos`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `chave_id` (`chave_id`),
  ADD KEY `chavepix_id` (`chavepix_id`),
  ADD KEY `tipo` (`tipo`);

--
-- Índices para tabela `lancamentos_historico`
--
ALTER TABLE `lancamentos_historico`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `lancamento_id` (`lancamento_id`);

--
-- Índices para tabela `logs`
--
ALTER TABLE `logs`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `tipo` (`tipo`);

--
-- Índices para tabela `solicitacoes_saque`
--
ALTER TABLE `solicitacoes_saque`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `telefone` (`telefone`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `afiliados`
--
ALTER TABLE `afiliados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `chaves`
--
ALTER TABLE `chaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `chavespix`
--
ALTER TABLE `chavespix`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `chaves_payf`
--
ALTER TABLE `chaves_payf`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `emailesms`
--
ALTER TABLE `emailesms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `financeiro`
--
ALTER TABLE `financeiro`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `financeiro_contas`
--
ALTER TABLE `financeiro_contas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historico`
--
ALTER TABLE `historico`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `lancamentos`
--
ALTER TABLE `lancamentos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `lancamentos_historico`
--
ALTER TABLE `lancamentos_historico`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `solicitacoes_saque`
--
ALTER TABLE `solicitacoes_saque`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;



INSERT INTO `admins` (`id`, `usuario`, `senha`, `nome`, `primeiroNome`, `titulo`, `email`, `doc`, `telefone`, `createdAt`, `updateAt`, `blockedAt`, `vkey`) VALUES
(1, 'admin', '$2y$12$rd/FdmOb0iv/S9/4VwBjRuhc0Va7JGd8SlMQZSPCvIyP6Y.k6AwRO', 'Administrador', 'ADMIN', 'CTO', 'admin@admin.com', NULL, NULL, NULL, NULL, NULL, 'ber98e9r8098re4er91');



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;