# 📋 **TaskManager — Gerenciador de Tarefas**


> Um sistema simples e eficiente para criação, organização e acompanhamento de tarefas.

---

## 🚀 **Funcionalidades**

- ✅ Criar, listar, editar e excluir tarefas
- 🗂️ Organizar tarefas por status (pendente, concluída)
- 🔍 Filtro de tarefas por status: pendente e concluída
- 💡 Interface reativa com Livewire (sem recarregamento de página)

---

## 🛠️ **Tecnologias Utilizadas**

- [Laravel](https://laravel.com/) 
- [Livewire](https://livewire.laravel.com/) 
- [Tailwind CSS](https://tailwindcss.com/) 
- [Alpine.js](https://alpinejs.dev/) 
- [MySQL](https://www.mysql.com/) 

---

## ⚙️ **Instalação**

Siga os passos abaixo para rodar o projeto localmente:

1. **Clone o repositório** do projeto para sua máquina:
    ```bash
    git clone https://github.com/seu-usuario/seu-repositorio.git
    ```
2. **Copie o arquivo `.env`**:
    Copie o arquivo `.env.example` para `.env`:
    ```bash
    cp .env.example .env
    ```
3. **Suba os containers com Docker**:
    Para iniciar o ambiente, execute o comando abaixo:
    ```bash
    docker-compose up -d
    ```
    Esse comando vai configurar o ambiente com o servidor web, PHP, banco de dados e outros serviços necessários.

4. **Caso haja problemas com o Docker** (conexões ou inconsistências), execute os seguintes comandos para reiniciar a configuração:
    ```bash
    docker-compose down --rmi all
    docker-compose up -d
    ```

---

## 🛠️ **Deploy em Produção**

1. **Configuração de produção**:
    - Verifique se as variáveis de ambiente estão corretamente configuradas no arquivo `.env`.
    - Se estiver utilizando um servidor remoto, verifique as configurações do banco de dados e serviços auxiliares como fila e WebSocket.

2. **Sistema de filas**:
    Caso tenha configurado um sistema de filas para envio de e-mails ou notificações, execute os workers em background:
    ```bash
    php artisan queue:work
    ```
    Para monitorar as filas, você pode utilizar o **Laravel Horizon** (se configurado) ou outras ferramentas como o **Supervisor**.

---

## 🚧 **Solução de Problemas**

Se encontrar algum erro durante a execução, aqui estão algumas dicas para solucioná-los:

- **Erro de conexão com o banco de dados**:
    - Verifique se o MySQL está rodando corretamente no Docker.
    - Execute `docker-compose logs mysql` para verificar o estado do serviço de banco de dados.

- **Erros com Docker**:
    - Se o Docker não estiver rodando, execute `docker ps` para verificar se os containers estão em execução.
    - Caso haja problemas com a rede, tente reiniciar o Docker ou limpar volumes e imagens antigas.

---

## 💡 **Decisões Arquiteturais**

### **Tecnologia Laravel + Livewire**:
A escolha de **Laravel** para o backend oferece uma base robusta e fácil de escalar. Com **Livewire**, a interface reativa se torna simples de implementar sem a necessidade de recarregar a página, o que melhora a experiência do usuário.

### **Docker para Isolamento do Ambiente**:
Optamos pelo uso do **Docker** para garantir que o ambiente de desenvolvimento seja o mais próximo possível do ambiente de produção, facilitando o deploy e a portabilidade do projeto.

---

## 🔮 **Versão Atual**

- Implementação de status para melhorar o fluxo das tarefas.
- Mensagens de erro e sucesso mais claras.
- Organização do código com o uso de **Blade Components**.
- Configuração com **Docker** para facilitar a instalação e o ambiente de desenvolvimento.

---

## 🚀 **Versões Futuras**

- **Filtros Avançados**: Melhorias nos filtros de tarefas, incluindo busca por prioridade, prazo e outros critérios.
- **Notificações em Tempo Real**: Implementação de notificações para lembrar prazos e atualizações de tarefas.
- **Melhorias na Interface**: Tornar a interface ainda mais intuitiva e responsiva.

---


*"Como Obi-Wan Kenobi disse a Anakin Skywalker: 'Você deu o primeiro passo em uma longa jornada, jovem padawan.' Este projeto, assim como a jornada de Anakin, foi repleto de desafios e obstáculos superados. Com ele, um grande avanço foi conquistado, mas o aprendizado continua. O próximo nível de maestria está agora ao alcance. Que a Força do código esteja com você"*

---

### **Decisões Técnicas**
### 1. **Livewire para Interatividade**
**Livewire** foi escolhido para criar interfaces dinâmicas e reativas sem a necessidade de recarregar a página. Ele permite criar componentes reativos de forma simples, utilizando apenas PHP, sem depender de JavaScript pesado ou complexidade adicional.

#### Justificativa:
- **Integração Simples**: Permite interatividade em tempo real com o backend, sem a necessidade de configurar APIs REST ou WebSockets diretamente.
- **Facilidade de Manutenção**: Como o Livewire utiliza o Laravel diretamente, a manutenção e o desenvolvimento do código tornam-se mais simples, sem a necessidade de lidar com diferentes stacks de front-end (por exemplo, Vue.js ou React).

### 2. **MySQL como Banco de Dados**
Optou-se pelo **MySQL** devido à sua confiabilidade, escalabilidade e suporte a transações. Sendo um banco relacional, ele garante integridade de dados e performance no gerenciamento de grandes volumes de dados.

#### Justificativa:
- **Compatibilidade e Suporte**: O MySQL é uma escolha madura e amplamente utilizada no mercado. Possui suporte robusto no ecossistema Laravel e pode ser facilmente escalado se necessário.
- **Facilidade de Escalabilidade**: Caso a aplicação precise de mais recursos no futuro, o MySQL pode ser escalado horizontalmente ou verticalmente, conforme a necessidade.

### 3. **Docker para Isolamento do Ambiente**
A escolha do **Docker** foi feita para garantir que o ambiente de desenvolvimento e produção fosse o mais próximo possível, minimizando problemas de inconsistências entre ambientes e facilitando a configuração de dependências.

#### Justificativa:
- **Ambiente Consistente**: O uso do Docker permite que a aplicação rode em containers isolados, garantindo que todas as dependências estejam sempre na mesma versão.
- **Facilidade de Deploy e Escalabilidade**: O Docker facilita o deploy em qualquer ambiente, seja de desenvolvimento ou produção, e permite que a aplicação seja escalada facilmente conforme necessário.
- **Portabilidade**: A aplicação pode ser facilmente transportada para qualquer servidor ou infraestrutura que suporte Docker, sem a necessidade de configurar o ambiente manualmente.

### 4. **Sistema de Fila com Laravel**
A escolha de um **sistema de filas** (utilizando o Laravel Queue) foi para processar tarefas em segundo plano, como o envio de e-mails e a manipulação de dados pesados. A utilização de filas melhora a performance da aplicação, ao permitir que operações demoradas sejam processadas de forma assíncrona.

#### Justificativa:
- **Desempenho**: Com o uso de filas, as tarefas podem ser processadas sem bloquear a execução da aplicação, garantindo uma melhor experiência para o usuário.
- **Escalabilidade**: O Laravel Queue oferece suporte a diferentes drivers, como **Redis** ou **Database**, permitindo que a aplicação seja escalada facilmente conforme o número de usuários ou volume de dados aumente.

### 5. **WebSocket para Notificações em Tempo Real**
Para implementações de notificações em tempo real, foi escolhida a tecnologia **WebSockets**, que proporciona comunicação bidirecional eficiente entre o servidor e o cliente.

#### Justificativa:
- **Desempenho em Tempo Real**: A comunicação via WebSocket permite atualizações instantâneas no frontend sem a necessidade de polling constante, proporcionando uma experiência mais fluida para o usuário.
- **Escalabilidade**: Com a configuração do Laravel WebSockets ou Pusher, o sistema pode facilmente ser escalado para atender a um maior número de conexões simultâneas.

### 6. **Multilíngue com Laravel Localization**
A aplicação foi configurada para ser **multilíngue** com o recurso de **Laravel Localization**, permitindo que o usuário alterne entre os idiomas **Português** e **Inglês**.

#### Justificativa:
- **Acessibilidade Global**: Tornar a aplicação multilíngue facilita a expansão do projeto para diferentes regiões e amplia o alcance do público.
- **Facilidade de Manutenção**: O Laravel oferece suporte nativo para traduções e alternância de idiomas, o que torna a manutenção e o ajuste de textos simples.




---

