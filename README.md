# ranking-em-movimento

Projeto em PHP puro para gerenciamento e consulta de rankings de movimentos.

## Abordagem e Decisões técnicas
- Como uma das exigências do projeto foi o desenvolvimento sem uso de frameworks, optei por construir uma estrutura base inicial, o essencial que um framework resolveria, como roteamento, injeção de dependências e organização em camadas. Isso me permitiu focar na lógica principal e na estruturação do código, mantendo uma organização clara e escalável, mesmo sem o suporte de um framework completo.

- Com relação ao acesso ao banco de dados, optei por usar PDO diretamente, criando uma classe de conexão que gerencia a instância do PDO, essa decisão foi tomada para manter a simplicidade e evitar a complexidade de um ORM, visto que trata-se de um projeto simples e de teste, onde a performance e a flexibilidade de um ORM não seriam necessárias.

- As controllers mantiveram-se simples, focando apenas em receber as requisições, delegar a lógica para os serviços e retornar as respostas. A lógica de negócio foi encapsulada nos serviços, garantindo uma separação clara de responsabilidades e facilitando a manutenção e evolução do código.

- Alguns padrões de projeto foram utilizados afim de demonstrar boas práticas, como o padrão Repository para abstrair o acesso aos dados e o padrão Service para encapsular a lógica de negócio, isso ajuda a manter o código organizado.

- Por fim, o projeto foi encapsulado em um container Docker, garantindo que ele possa ser facilmente executado em qualquer ambiente sem a necessidade de configuração prévia.

## Estrutura do Projeto

```
src/
  Controllers/
  Core/
  Database/
  Helpers/
  Repository/
  Services/
public/
  index.php
  .htaccess
docker-compose.yml
Dockerfile
.env.example
```

## Pré-requisitos

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

## Como executar o projeto

1. **Clone o repositório:**
	```bash
	git clone <url-do-repositorio>
	cd ranking-em-movimento
	```

2. **Configure as variáveis de ambiente:**
	- Copie o arquivo `.env.example` para `.env` e ajuste se necessário:
	  ```bash
	  cp .env.example .env
	  ```
	- As variáveis de conexão já estão definidas no `docker-compose.yml` e `.env.example`.

3. **Suba os containers:**
	```bash
	docker-compose up --build
	```

4. **Acesse a aplicação:**
	- O backend estará disponível em: [http://localhost:8080](http://localhost:8080)

5. **Banco de Dados:**
	- O serviço MySQL será iniciado automaticamente com o banco `tecnofit_database`.
	- O arquivo `tecnofit_database.sql` será importado automaticamente na primeira execução.

## Endpoints

- Os endpoints podem ser acessados via `/public` (exemplo: `/movranking?movement=1`).

## Estrutura das Pastas

- `src/Controllers`: Controllers da aplicação.
- `src/Core`: Núcleo do framework (Router, etc).
- `src/Database`: Conexão com o banco de dados.
- `src/Helpers`: Helpers utilitários.
- `src/Repository`: Repositórios de dados.
- `src/Services`: Serviços de negócio.
- `public/`: Arquivos públicos e ponto de entrada (`index.php`).

## Parar os containers

```bash
docker-compose down -v
```

---