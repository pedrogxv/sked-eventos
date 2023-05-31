# Sked Eventos

## Como rodar o projeto?

1. Após clonar o projeto, copie o arquivo ``.env.example`` para um novo arquivo chamado ``.env`` 
e preencha as credenciais solicitadas.
2. Execute ``composer install`` para instalar as dependências.
3. É necessário que o banco definido em ``DB_NAME`` no arquivo .env já exista,
pois o sistema irá executar as migrations nele automaticamente.
4. Para rodar o projeto, use: ```php -S localhost:8080``` e abra o navegador
nesta mesma url.
5. Lembre-se de colocar as credenciais corretas para seu banco sql no ``.env``

### Especificações Técnicas

- Versão PHP suportada: ``^8.2``
- Dependências utilizadas:
  - [Twig](https://twig.symfony.com/) (Template Engine)
  - [Tailwind CSS](https://tailwindcss.com/) (Estilização do front)
  - [PDO](https://www.php.net/manual/pt_BR/book.pdo.php) (Comunicação com o banco de dados)
  - [HeroIcons](https://www.heroicons.com) (Ícones do front-end)

Este projeto foi construído com php vanilla com base em conceitos de MVC
e POO, sua estrutura também foi bastante baseado no framework Laravel.

### Estrutura de pastas do projeto

##### App/

Esta pasta é responsável pelos arquivos executados dentro da aplicação.

##### Routes

Arquivos contendo as rotas do projeto acessíveis via requisições.

##### Views

Pasta responsável por armazenar os arquivos de view (.html).

### Inicialização do Projeto

A partir do momento em que a aplicação está no ar ela se inicia pelo arquivo:
``index.php`` que por sua vez chama outro arquivo, o ``boot.php``.

O arquivo ```boot.php``` é responsável por configurar alguns elementos
da aplicação (como o Dotenv, por exemplo) e também por executar a
rota requisitada pelo usuário, além de executar as migrations do banco
caso necessário.

### Rotas

Todas as rotas podem ser encontradas dentro da pasta ```routes/```, por
baixo dos panos temos o arquivo ``App/RouteLoader`` responsável por 
registrar as rotas e executa-las conforme configurado.

### Controllers

A rota é responsável por chamar um controller que irá ser executado, 
estes controllers podem ser encontrados em ``App/Controllers``.

### View

Uma das ações de um Controller é o carregamento de uma View (html), 
seu funcionamento por baixo dos panos pode ser encontrado em 
``App/View.php``.

### Model

Um ``Model`` é responsável por representar um objeto do banco de dados,
neste projeto apenas o Model de Evento é utilizado (representando a 
tabela de eventos no banco de dados).

Um model pode definir desde os campos da tabela até suas regras e também 
operações utilizando o PDO, tudo isso pode ser encontrado em 
``App/Concerns/Model.php``.

### Validator

O ``Validator`` é responsável por validar um tipo de dado, seu funcionamento 
e suas regras disponíveis podem ser encontrados em ``App/Validator.php``.

Um exemplo de validador são os atributos do modelo ``Evento``:
```php
protected array $rules = [
    'titulo' => ["string", "min:5", "required"],
    'descricao' => ["string"],
    'inicio' => ["datetime", "after:agora", "required"],
    'termino' => ["datetime", "after:inicio", "required"],
];
```
Neste caso temos um array onde a chave é o campo e o valor são as regras.

Além disso, os validadores são responsáveis por passar seus erros 
para variavéis de sessão, que por sua vez são renderizados na view 
para um melhor feedback do usuário.

### SessionBag

A mochila da sessão é responsável por carregar valores úteis de uma 
requisição. Veja mais em ``App/SessionBag.php``.

### Migrations e PDO

As migrations são responsáveis por manter um versionamento no banco, 
no caso deste projeto esse conceito foi mais simplificado e apenas 
usado para criação de tabelas, sua estrutura pode ser encontrado em 
``App/Database/Migrations`` e sua execução em 
``App/Database/MigrationLoader.php``.

O PDO foi utilizado para operações com o banco e sua base é encontrada 
em ``App/Database/PDOConnector.php``;
