<div align="center">

# 🍽️ Sabor em Clique

Plataforma moderna para descoberta, busca e gestão de receitas: desempenho rápido, busca inteligente, interface responsiva e API pronta para expansão.

</div>

## ✨ Visão Geral
Aplicação web em **PHP + MySQL** com frontend em **HTML/CSS/JS** (vanilla) focada em:
- Exploração de receitas por Destaques, Populares (mais vistas) e listagem geral.
- Busca rápida com sugestões em tempo real e suporte a múltiplos ingredientes.
- Estrutura de dados preparada para SEO, métricas (views) e expansão futura.

## ✅ Principais Funcionalidades

### Usuários & Autenticação
- Cadastro, login, logout, alteração de dados e senha.
- Recuperação / redefinição simulada de senha.
- Controle de sessão e rotas protegidas.

### Receitas
- Cadastro com foto, país, tipo de refeição e categoria.
- Edição/remoção (autor ou admin).
- Campos enriquecidos: `tempo_preparo`, `dificuldade`, `views` (contador para ranking).
- Exibição detalhada estruturada e pronta para futura inclusão de JSON-LD.

### Página Inicial
- Seção Destaques (carrossel aleatório via `?featured=1`).
- Seção Populares ordenada por `views`.
- Grid "Nossas Receitas" com filtros dinâmicos de categoria (pills) carregadas via API.

### Busca Inteligente
- Barra global com autocomplete (até 8 sugestões instantâneas).
- Busca simples (nome ou ingrediente) com destaque do termo.
- Busca multi-ingredientes (separados por vírgula) com ranking por número de combinações e exibição de tags.
- Paginação na página de resultados (`buscar_receitas.php`).

### Administração
- Painel admin básico (`/paginas/admin/painel.php`).
- Gerenciamento de duplicatas (`Gerenciar_duplicatas.php`).

### Segurança
- Senhas com `password_hash()` / `password_verify()`.
- Prepared Statements em acessos sensíveis.
- Escapagem consistente com `htmlspecialchars()`.
- Charset unificado `utf8mb4` (banco + conexão + JSON).

### Frontend & Acessibilidade
- Design responsivo (CSS Grid + Flexbox).
- Menu hambúrguer acessível (`aria-*` + teclado).
- Foco rápido com atalho `/` na busca.
- Realce semântico dos termos (`<mark>` estilizado).

## 📁 Estrutura (resumida)
```
saboremclique/
  config.php
  database.sql
  data.sql
  index.php
  api/
    get_receitas.php
  css/
    style.css
  js/
    script.js
  paginas/
    includes/{header.php,footer.php}
    comidas/{buscar_receitas.php,buscar_por_ingredientes.php,cadastrar_receita.php,...}
    usuarios/{login.php,criar_usuario.php,...}
    admin/painel.php
  uploads/receitas/
```

## 🗄️ Banco de Dados (principais tabelas)
`receitas`
| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | INT PK | Identificador |
| nome | VARCHAR(255) | Nome da receita |
| pais_id | INT FK | País de origem |
| tipo_refeicao_id | INT FK | Café, almoço, etc. |
| categoria_id | INT FK | Categoria culinária |
| ingredientes | TEXT | Lista livre (texto) |
| preparo | TEXT | Modo de preparo |
| info_adicional | TEXT | Observações |
| usuario_id | INT FK | Autor |
| foto | VARCHAR(255) | Nome do arquivo ou URL |
| tempo_preparo | VARCHAR(100) | Ex: 30 min |
| dificuldade | ENUM('Fácil','Média','Difícil') | Dificuldade |
| views | INT | Contador de visualizações |
| created_at / updated_at | TIMESTAMP | Auditoria |

Outras: `usuarios`, `categorias`, `paises`, `tipos_refeicao`.

## 🔌 API Pública (Inicial)
Endpoint principal: `GET /saboremclique/api/get_receitas.php`

Parâmetros suportados:
| Parâmetro | Exemplo | Descrição |
|-----------|---------|-----------|
| `featured` | `1` | Retorna 6 receitas aleatórias (ignora demais) |
| `q` | frango | Busca em nome OU ingredientes |
| `categoria_id` | 3 | Filtra por categoria |
| `order` | `recent` | Opções: `recent`, `views`, `az`, `za` |
| `page` | 2 | Página (paginação) |
| `limit` | 12 | Máx 50 |

Resposta (exemplo simplificado):
```json
{
  "receitas": [ {"id":1,"nome":"Pizza Margherita","foto":"...","views":42,"dificuldade":"Fácil","tempo_preparo":"30 min"} ],
  "categorias": [ {"id":1,"nome":"Massas"} ],
  "pagination": {"page":1,"limit":20,"total":120,"pages":6}
}
```

## ⚙️ Instalação / Setup
1. Copie a pasta `saboremclique` para `C:\xampp\htdocs\`.
2. Inicie Apache + MySQL no XAMPP.
3. Acesse `http://localhost/phpmyadmin`.
4. Importe `database.sql` (cria schema `sabor_em_clique_receitas`).
5. Importe `data.sql` (dados de exemplo + ajustes de `tempo_preparo` e `dificuldade`).
6. Verifique `config.php` (credenciais default: root / vazio).
7. Garanta permissão de escrita em `uploads/receitas/`.
8. Acesse `http://localhost/saboremclique/`.

## 🧪 Testes Manuais Rápidos
- Abrir home: conferir Destaques, Populares e grid principal.
- Digitar na busca: ver sugestões (>=2 caracteres).
- Buscar: testar `frango`, `tomate, queijo`.
- Acessar receita: verificar incremento futuro de `views` (a lógica pode ser adicionada em `visualizar_receita.php`).
- Filtrar categorias: clicar pills e ver atualização da grid via XHR.

## 🔒 Boas Práticas Aplicadas
- Charset consistente `utf8mb4` (previne truncamento de emojis ou acentos).
- Prepared statements onde há entrada dinâmica.
- Escape de saída (`htmlspecialchars`).
- Separação Schema (`database.sql`) x Dados (`data.sql`).
- Função única de montagem de caminhos de imagem (`get_foto_src`).

## 🚀 Roadmap (Próximas Etapas)
- Incrementar coluna `views` em visualizações reais.
- Favoritos / lista pessoal do usuário.
- "Recentemente vistos" (localStorage + fallback server-side futuro).
- Dark Mode (CSS variables já facilitam).
- Skeleton loading enquanto aguarda fetch.
- JSON-LD (Recipe schema) para SEO.
- Campos estruturados para nutrientes (expansão futura).
- Filtros combinados (categoria + país + dificuldade).
- Ordenação adicional: preparo mais rápido, aleatórias do dia.
- Sistema de avaliação e comentários moderados.

## 🛠️ Requisitos Técnicos
- PHP >= 7.4 (recomendado 8.x)
- MySQL/MariaDB com InnoDB
- Extensões: `mysqli`, `mbstring`, `json`
- Navegador moderno (ES6+)

## 🧩 Convenções Internas
- URL base configurada em `config.php` via `BASE_URL`.
- API retorna JSON sempre com: `receitas`, `categorias`, `pagination`.
- Limite máximo seguro de listagem: 50 (evita sobrecarga na home).

## 📌 Notas para Contribuição
Sugestões de melhoria podem focar em: caching de categorias, compressão de imagens no upload, sanitização mais granular de ingredientes (tokenização), criação de migrations incrementais ao invés de recriar o schema.

---
Feito com ❤️ e fome de código.

