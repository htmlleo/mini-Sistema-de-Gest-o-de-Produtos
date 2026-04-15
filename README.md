# Mini Sistema de Gestão de Produtos (CRUD)

Sistema web completo para gestão de produtos, fornecedores e vendas, desenvolvido em **PHP com Orientação a Objetos (POO)**, banco de dados **MySQL** e integração **AJAX**.

---

## Desenvolvedor

**Leonardo Estevão Alves**  
Registro Acadêmico: **00250458-1**

---

## Etapa 1 – Análise

Nesta etapa, foi realizada a análise do problema proposto para identificar as telas e elementos visuais necessários. O sistema foi projetado utilizando **Bootstrap 5** para garantir uma interface moderna, limpa e responsiva.

### Esboços de Tela (Wireframes)

Os esboços abaixo representam a estrutura visual planejada para o sistema, focando na usabilidade e na separação clara das funcionalidades solicitadas.

#### 1. Tela de Login e Cadastro
Esta tela permite o acesso seguro ao sistema e o registro de novos usuários.
![Esboço da Tela de Login](assets/docs/wireframes/login.png)

#### 2. Dashboard (As 4 Áreas)
O painel principal organiza as funcionalidades em quatro seções distintas para facilitar a navegação e o fluxo de trabalho.
![Esboço do Dashboard](assets/docs/wireframes/dashboard.png)

### Boas Práticas de UX Implementadas

Com base nas referências de UX Design, as seguintes práticas foram aplicadas no projeto:

- **Simplicidade e Clareza**: A interface utiliza um layout limpo, evitando o excesso de informações e focando nas ações principais do usuário.
- **Feedback Imediato**: O uso de **AJAX** permite que o usuário veja o resultado de suas ações (como cadastrar um produto ou adicionar à cesta) instantaneamente, sem recarregar a página.
- **Hierarquia Visual**: Títulos claros e botões com cores distintas (Azul para ações primárias, Verde para sucesso, Vermelho para perigo) ajudam o usuário a identificar rapidamente o que fazer.
- **Prevenção de Erros**: Validações via JavaScript/jQuery impedem o envio de formulários vazios ou a inclusão de produtos na cesta sem seleção prévia.
- **Navegação Intuitiva**: Menus de navegação e abas facilitam a localização das funções, mantendo o usuário orientado dentro do sistema.

---

## Objetivo do Projeto

Este sistema foi desenvolvido como um trabalho acadêmico de engenharia de software, com o objetivo de aplicar técnicas avançadas de:
- **Programação Orientada a Objetos (POO)**: Classes com responsabilidades únicas.
- **Relacionamento entre Objetos**: Produtos vinculados a fornecedores e itens vinculados a vendas.
- **Armazenamento Persistente**: Banco de dados MySQL com integridade referencial (Foreign Keys).
- **Autenticação Segura**: Login com hash **SHA-256**.
- **Comunicação Assíncrona (AJAX)**: Atualização de dados sem recarregar a página.

---

## Estrutura das 4 Áreas do Sistema

Conforme os requisitos do projeto, o Dashboard está dividido em:

1.  **ÁREA 1: CADASTRO**: Formulários para inclusão de Fornecedores e Produtos no banco de dados.
2.  **ÁREA 2: ATUALIZAÇÃO AJAX**: Listagem dinâmica de produtos e fornecedores que se atualiza automaticamente após cada cadastro.
3.  **ÁREA 3: SELEÇÃO**: Interface com checkboxes que permite ao usuário selecionar produtos e incluí-los na cesta (validação inclusa).
4.  **ÁREA 4: CESTA (RESUMO)**: Exibição dos itens selecionados, cálculo do valor total, contagem de produtos e funcionalidade de **Finalizar Compra**.

---

## Estrutura de Pastas e Arquivos

```
system/
├── classes/                → Lógica de Negócio (POO)
│   ├── Database.php        → Conexão Singleton PDO e criação automática do banco
│   ├── User.php            → Autenticação e Registro (Hash SHA-256)
│   ├── Product.php         → CRUD de Produtos e Relacionamentos
│   ├── Supplier.php        → CRUD de Fornecedores
│   ├── Cart.php            → Gestão da Cesta (Carrinho)
│   └── Sale.php            → Finalização de Vendas e Histórico
├── ajax/                   → Endpoints JSON para comunicação AJAX
│   ├── products.php        → Processa requisições de produtos
│   ├── suppliers.php       → Processa requisições de fornecedores
│   ├── cart.php            → Processa inclusão/remoção na cesta
│   └── sales.php           → Processa a finalização da compra
├── assets/                 → Recursos de Front-end
│   ├── css/style.css       → Estilos customizados e responsividade
│   ├── js/app.js           → Lógica jQuery/AJAX e manipulação do DOM
│   └── docs/wireframes/    → Esboços de tela (Etapa 1 - Análise)
├── index.php               → Tela de Login e Cadastro de Usuários
├── dashboard.php           → Painel Principal (As 4 Áreas)
├── logout.php              → Encerramento de sessão
├── database.sql            → Script SQL para criação manual (opcional)
└── README.md               → Documentação do projeto
```

---

## Tecnologias Utilizadas

| Tecnologia | Finalidade |
| :--- | :--- |
| **PHP 7.4+** | Back-end (POO, PDO, Sessions) |
| **MySQL** | Banco de Dados Relacional |
| **AJAX / jQuery** | Comunicação assíncrona e UX |
| **Bootstrap 5** | Framework CSS para layout responsivo |
| **SHA-256** | Algoritmo de criptografia para senhas |

---

## Como Instalar e Executar (XAMPP)

1.  **Copiar o Projeto**: Extraia a pasta `system` dentro do diretório `htdocs` do seu XAMPP (geralmente `C:\xampp\htdocs\system`).
2.  **Iniciar o Servidor**: Abra o Painel de Controle do XAMPP e inicie os módulos **Apache** e **MySQL**.
3.  **Configuração do Banco**:
    - O sistema está configurado para **criar o banco de dados automaticamente** na primeira execução.
    - Caso prefira manual: Acesse o `phpMyAdmin`, crie o banco `sistema_gestao` e importe o arquivo `database.sql`.
4.  **Acessar o Sistema**: Abra o navegador e digite: `http://localhost/system/`.
5.  **Primeiro Acesso**:
    - Vá na aba **"Cadastro"** na tela inicial e crie um novo usuário.
    - Faça o login com o e-mail e senha cadastrados.

---

## Regras de Negócio Implementadas

- **Unicidade na Cesta**: O sistema permite apenas uma unidade de cada produto por usuário na cesta (conforme solicitado).
- **Validação de Seleção**: O botão "Incluir na Cesta" só funciona se houver produtos selecionados via checkbox.
- **Finalização de Venda**: Ao finalizar a compra, os itens são movidos para um histórico de vendas (`sale_items`) e a cesta é esvaziada.
- **Segurança de Acesso**: Todas as páginas do dashboard e endpoints AJAX verificam se o usuário está logado via `$_SESSION`.

---

*Projeto desenvolvido para fins acadêmicos com foco em qualidade de código e engenharia de software.*
