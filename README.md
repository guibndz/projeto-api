# Projeto API (PHP)

API REST simples em **PHP** para gerenciamento de usuários, com persistência em arquivo JSON e documentação via OpenAPI.

## 📁 Estrutura do projeto

```text
projeto-api/
├── data/
│   └── data.json
└��─ src/
    ├── config/
    │   └── config.php
    ├── public/
    │   └── index.php
    ├── src/
    │   ├── apis.php
    │   ├── controllers.php
    │   ├── data.php
    │   ├── services.php
    │   └── validation.php
    └── views/
        ├── docs.html
        └── openapi.json
```

## 🚀 Tecnologias

- PHP
- JSON (persistência de dados)
- HTML (página de documentação)
- OpenAPI (especificação da API)

## ⚙️ Como executar o projeto

### Pré-requisitos

- PHP 8+ instalado
- Terminal (Linux/macOS) ou PowerShell/CMD (Windows)

### Passos

1. Clone o repositório:
   ```bash
   git clone https://github.com/guibndz/projeto-api.git
   ```

2. Entre na pasta do projeto:
   ```bash
   cd projeto-api
   ```

3. Suba um servidor local PHP apontando para a pasta `src/public`:
   ```bash
   php -S localhost:8000 -t src/public
   ```

4. Acesse no navegador:
   - API: `http://localhost:8000`
   - Docs (se roteado): `http://localhost:8000/docs`
   - Ou diretamente: `src/views/docs.html`

> Dependendo da configuração de rotas em `index.php` / `apis.php`, o caminho da documentação pode variar.

## 🧠 Arquitetura (visão geral)

- **`public/index.php`**: ponto de entrada da aplicação.
- **`src/apis.php`**: definição/roteamento dos endpoints.
- **`src/controllers.php`**: controladores HTTP (GET, POST, PUT, PATCH, etc).
- **`src/services.php`**: regras de negócio da API.
- **`src/data.php`**: leitura/escrita dos dados no arquivo JSON.
- **`src/validation.php`**: validações de payload e parâmetros.
- **`config/config.php`**: configurações gerais.
- **`data/data.json`**: base de dados local.

## 📌 Endpoints (resumo)

Com base no controller, a API possui operações para usuários como:

- `GET` → listar usuários
- `POST` → criar usuário
- `PUT` → atualizar usuário completo por ID
- `PATCH` → atualizar usuário parcialmente por ID
- `DELETE` → remover usuário (se implementado no restante do arquivo)

### Exemplo de payload (POST/PUT/PATCH)

```json
{
  "name": "João Silva",
  "email": "joao@email.com"
}
```

## 🧪 Exemplos de uso (cURL)

### Listar usuários
```bash
curl -X GET "http://localhost:8000/users"
```

### Criar usuário
```bash
curl -X POST "http://localhost:8000/users" \
  -H "Content-Type: application/json" \
  -d '{"name":"Maria","email":"maria@email.com"}'
```

### Atualizar usuário (PUT)
```bash
curl -X PUT "http://localhost:8000/users?id=1" \
  -H "Content-Type: application/json" \
  -d '{"name":"Maria Silva","email":"maria.silva@email.com"}'
```

### Atualização parcial (PATCH)
```bash
curl -X PATCH "http://localhost:8000/users?id=1" \
  -H "Content-Type: application/json" \
  -d '{"name":"Maria S."}'
```

## 📚 Documentação da API

A documentação está em:

- `src/views/openapi.json`
- `src/views/docs.html`

Se o projeto estiver configurado para servir a página de docs, basta abrir a rota correspondente no navegador.

## ❗ Tratamento de erros

Pelos controllers, a API utiliza respostas JSON com códigos HTTP, por exemplo:

- `200` OK
- `201` Criado
- `404` Não encontrado
- `422` Erro de validação

## 🤝 Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/minha-feature`)
3. Commit suas alterações (`git commit -m "feat: minha feature"`)
4. Push para a branch (`git push origin feature/minha-feature`)
5. Abra um Pull Request

## 📄 Licença

Defina aqui a licença do projeto (ex.: MIT).  
Caso ainda não exista, adicione um arquivo `LICENSE` no repositório.
