-- =============================================================
-- SCHEMA COMPLETO: Sabor em Clique
-- Observação: Caso esteja atualizando uma base existente, execute
--   ALTER TABLEs ao invés de dropar. Este script recria tudo.
-- Encoding modernizado para utf8mb4.
-- =============================================================

CREATE DATABASE IF NOT EXISTS `sabor_em_clique_receitas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sabor_em_clique_receitas`;

-- -------------------------------------------------------------
-- Tabela: paises
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `paises`;
CREATE TABLE `paises` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_paises_nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Tabela: tipos_refeicao
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `tipos_refeicao`;
CREATE TABLE `tipos_refeicao` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_tipos_refeicao_nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Tabela: categorias
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_categorias_nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Tabela: usuarios
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_usuarios_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Tabela: receitas
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `receitas`;
CREATE TABLE `receitas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `pais_id` INT(11) NOT NULL,
  `tipo_refeicao_id` INT(11) NOT NULL,
  `categoria_id` INT(11) NOT NULL,
  `ingredientes` TEXT NOT NULL,
  `preparo` TEXT NOT NULL,
  `info_adicional` TEXT DEFAULT NULL,
  `usuario_id` INT(11) NOT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `tempo_preparo` VARCHAR(100) DEFAULT NULL,
  `dificuldade` ENUM('Fácil','Média','Difícil') DEFAULT NULL,
  `views` INT(11) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_receitas_pais` (`pais_id`),
  KEY `idx_receitas_tipo` (`tipo_refeicao_id`),
  KEY `idx_receitas_categoria` (`categoria_id`),
  KEY `idx_receitas_usuario` (`usuario_id`),
  KEY `idx_receitas_nome` (`nome`),
  KEY `idx_receitas_views` (`views`),
  CONSTRAINT `fk_receitas_paises` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_receitas_tipos` FOREIGN KEY (`tipo_refeicao_id`) REFERENCES `tipos_refeicao` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_receitas_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_receitas_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Sugestões adicionais:
-- * Criar índices compostos conforme padrões de busca (ex: (categoria_id, views)) se necessário.
-- * Popular dados via data.sql separado para manter separação schema/dados.
-- =============================================================