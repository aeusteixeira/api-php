# Documentação da API PHP para Gerenciamento de Usuários e Endereços

## Descrição Geral da API
Esta API é projetada para gerenciar usuários e endereços. Ela permite listar, criar, atualizar e excluir usuários e endereços. Além disso, também permite listar e obter detalhes de cidades e estados.

## Endpoints de Usuários

### Listar todos os usuários
```http
GET /users
```

### Obter detalhes de um usuário específico
```http
GET /users/{id}
```

### Criar um novo usuário
```http
POST /users/create
```
Envie um JSON no corpo da requisição com os seguintes dados:

```json
{
    "name": "Nome do Usuário",
    "email": "email@dominio.com",
    "password": "senha"
}
```

| Parâmetro | Tipo | Descrição |
| :--- | :--- | :--- |
| `name` | `string` | **Obrigatório**. Nome do usuário |
| `email` | `string` | **Obrigatório**. Email do usuário |
| `password` | `string` | **Obrigatório**. Senha do usuário |

### Atualizar um usuário existente
```http
PUT /users/{id}/update
```
Envie um JSON no corpo da requisição com os seguintes dados:

```json
{
    "name": "Novo Nome do Usuário",
    "email": "novoemail@dominio.com",
    "password": "novasenha"
}
```

| Parâmetro | Tipo | Descrição |
| :--- | :--- | :--- |
| `name` | `string` | **Obrigatório**. Nome do usuário |
| `email` | `string` | **Obrigatório**. Email do usuário |
| `password` | `string` | **Obrigatório**. Senha do usuário |

### Excluir um usuário
```http
DELETE /users/{id}
```

## Endpoints de Endereços

### Listar todos os endereços
```http
GET /addresses
```

### Obter detalhes de um endereço específico
```http
GET /addresses/{id}
```

### Criar um novo endereço
```http
POST /addresses/create
```
Envie um JSON no corpo da requisição com os seguintes dados:

```json
{
    "user_id": 1,
    "city_id": 2,
    "street": "Rua dos Bobos, 123",
    "zip_code": "01106000"
}
```

| Parâmetro | Tipo | Descrição |
| :--- | :--- | :--- |
| `user_id` | `integer` | **Obrigatório**. ID do usuário associado |
| `city_id` | `integer` | **Obrigatório**. ID da cidade |
| `street` | `string` | **Obrigatório**. Nome da rua |
| `zip_code` | `string` | **Obrigatório**. Código postal |

### Atualizar um endereço existente
```http
PUT /addresses/{id}/update
```
Envie um JSON no corpo da requisição com os seguintes dados:

```json
{
    "user_id": 1,
    "city_id": 2,
    "street": "Rua dos Bobos, 123",
    "zip_code": "01106000"
}
```

| Parâmetro | Tipo | Descrição |
| :--- | :--- | :--- |
| `user_id` | `integer` | **Obrigatório**. ID do usuário associado |
| `city_id` | `integer` | **Obrigatório**. ID da cidade |
| `street` | `string` | **Obrigatório**. Nome da rua |
| `zip_code` | `string` | **Obrigatório**. Código postal |

### Excluir um endereço
```http
DELETE /addresses/{id}
```

## Endpoints de Cidades e Estados

### Listar todas as cidades
```http
GET /cities
```

### Obter detalhes de uma cidade específica
```http
GET /cities/{id}
```

### Listar todos os estados
```http
GET /states
```

### Obter detalhes de um estado específico
```http
GET /states/{id}
```

## Formato dos Dados
Os exemplos de solicitações e respostas em JSON para cada endpoint estão incluídos acima, bem como tabelas descrevendo os parâmetros e tipos de dados esperados. 

## Erros e Mensagens
- 200 OK: Requisição bem-sucedida.
- 400 Bad Request: A requisição contém dados inválidos.
- 404 Not Found: O recurso solicitado não foi encontrado.
- 500 Internal Server Error: Erro interno no servidor.