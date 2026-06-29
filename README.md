# Mão de Vaca

Aplicação de **controle financeiro pessoal** construída com **Laravel 12** e **Filament 4**. Permite gerenciar carteiras, receitas, despesas, categorias, recorrências e parcelamentos, com um painel administrativo e dashboard de indicadores.

## Stack

- **PHP 8.3+** / **Laravel 12**
- **Filament 4** (painel administrativo em `/admin`)
- **MySQL 8**
- **TailwindCSS 4** + **Vite 6** (landing page e tema do painel)
- **Laravel Sail** (ambiente Docker)

## Funcionalidades

- **Carteiras (`Wallet`)** com saldo inicial
- **Receitas (`Income`)** e **Despesas (`Expense`)** categorizadas
- **Categorias** de receitas e despesas
- **Recorrências (`Recurrence`)** — diária, semanal, mensal, anual ou única
- **Parcelas (`Parcel`)** geradas automaticamente a partir das recorrências, com data de vencimento e status de pagamento
- **Saldos (`Balance`)** consolidados por carteira/mês/ano
- **Dashboard** com indicadores (carteira, saldo, receitas do mês) e gráfico de receitas do ano

## Como rodar (Laravel Sail)

Pré-requisitos: **Docker** e **Docker Compose**.

```bash
# 1. Copie o arquivo de ambiente
cp .env.example .env

# 2. Suba os containers (primeira vez faz o build da imagem)
./vendor/bin/sail up -d --build

# 3. Gere a chave da aplicação
./vendor/bin/sail artisan key:generate

# 4. Rode as migrations
./vendor/bin/sail artisan migrate

# 5. Instale e compile os assets de front-end
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

A aplicação fica disponível em:

- **Landing page:** http://localhost:8080
- **Painel administrativo:** http://localhost:8080/admin

> Dica: crie um alias para encurtar os comandos: `alias sail='./vendor/bin/sail'`

### Criar um usuário de acesso ao painel

```bash
./vendor/bin/sail artisan make:filament-user
```

### Desenvolvimento de front-end (hot reload)

```bash
./vendor/bin/sail npm run dev
```

## Serviços e portas

| Serviço        | Porta | Descrição                          |
|----------------|-------|------------------------------------|
| `laravel.test` | 8080  | Aplicação (Nginx/PHP via Sail)     |
| `laravel.test` | 5173  | Vite (dev server)                  |
| `mysql`        | 3306  | Banco de dados MySQL 8             |

Configuração padrão do banco (definida no `.env`):

| Variável      | Valor         |
|---------------|---------------|
| `DB_DATABASE` | `mao_de_vaca` |
| `DB_USERNAME` | `mao`         |
| `DB_PASSWORD` | `secret`      |

## Comandos úteis

```bash
./vendor/bin/sail up -d        # subir os containers
./vendor/bin/sail down         # parar os containers
./vendor/bin/sail artisan ...  # comandos artisan
./vendor/bin/sail test         # rodar os testes
```
