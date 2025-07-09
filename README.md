# 📋 **Sistema de Gerenciamento de Tarefas**


> Desenvolvedor: Daniel Wictor<br>
> Um sistema simples e eficiente para criação, organização e acompanhamento de tarefas.

---


## 🛠️ **Tecnologias Utilizadas**

- [Laravel](https://laravel.com/) 
- [Livewire](https://livewire.laravel.com/) 
- [MySQL](https://www.mysql.com/) 
- [Docker](https://www.docker.com/) 
- [Pusher](https://pusher.com/docs/) 
- [AdminLTE](https://adminlte.io/) 
- [Laravel Queue](https://laravel.com/docs/8.x/queues) 
- [Laravel Scheduler](https://laravel.com/docs/8.x/scheduling) 

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
5. **Laravel Horizon** 
- Para monitorar e gerenciar as filas com uma interface visual, utilize o Horizon , ative o painel com o comando:
   ```bash
    php artisan horizon 
    ```
- Após executar o comando a interface pode ser acessada na URL<br>
     ```bash
         http://localhost:8000/horizon

6. **Sistema de filas**:
    Execute o sistema de filas para enviar Jobs:
    ```bash
    php artisan queue:work
    ```

## 🔧 Configuração do WebSocket (Pusher)

Para que as notificações em tempo real funcionem corretamente, é necessário configurar o serviço de broadcasting com o **Pusher**.

No arquivo `.env`, adicione suas credenciais:

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_APP_CLUSTER=us2
```

## 🔧 Configuração do MailTrap (Notificação por Email)

Para garantir que o disparo de email funcione corretamente, é necessário seguir as orientações.

No arquivo `.env`, adicione suas credenciais:

```env
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_URL=null
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=YOUR_MAIL_USERNAME
MAIL_PASSWORD=YOUR_MAIL_PASSWORD
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=YOUR_EMAIL_ADDRESS
MAIL_FROM_NAME="${APP_NAME}"
```



## 🛠️ **Deploy em Produção**

1. **Configuração de produção**:
    - Verifique se as variáveis de ambiente estão corretamente configuradas no arquivo `.env`.
    - Se estiver utilizando um servidor remoto, verifique as configurações do banco de dados e serviços auxiliares como fila e WebSocket.

2. **Configuração de Cache**
   - Em produção, é altamente recomendada a utilização de cache para otimizar a performance do sistema, especialmente em relação ao acesso ao banco de dados e ao carregamento de rotas. Você pode gerar o cache de configuração e rotas com os seguintes comandos:
        ```bash
           php artisan config:cache
           php artisan route:cache
        ```
   - Para que as sessões sejam mantidas de forma eficiente, também é recomendável configurar a utilização do cache de sessão ou do driver de banco de dados:
        ```bash
           SESSION_DRIVER=redis
        ```
3. **Certificado SSL**
   - Para garantir a segurança das comunicações em produção, especialmente utilizando WebSockets (Pusher) ou outros meios de comunicação em tempo real, é importante configurar corretamente o SSL/TLS em seu servidor.

   - Se estiver utilizando o Nginx ou Apache, certifique-se de que o HTTPS esteja corretamente configurado para proteger os dados trafegados.

## ⚠️ **Nota sobre produção:**


>Em ambiente de produção, executar o comando de verificação a cada 5 segundos pode causar sobrecarga desnecessária, especialmente com um número elevado de usuários ou tarefas.

>A frequência ideal para execução do scheduler dependerá do nível de criticidade do sistema. Em geral, um intervalo de 1 minuto é suficiente para verificar tarefas com vencimento próximo:

>Se a urgência de verificação for menor (ex: alertas diários), o agendamento pode ser ajustado para rodar a cada 5 ou 10 minutos


---

## 🚧 **Solução de Problemas**

Se encontrar algum erro durante a execução, aqui estão algumas dicas para solucioná-los:

- **Erro de conexão com o banco de dados**:
    - Verifique se o MySQL está rodando corretamente no Docker.
    - Execute `docker-compose logs mysql` para verificar o estado do serviço de banco de dados.

- **Erro de conexão com o banco de dados:**

    - Verifique se o MySQL está rodando corretamente no Docker.

    - Execute docker-compose logs mysql para verificar o estado do serviço de banco de dados.

- **Erros com Docker**:
    - Se o Docker não estiver rodando, execute `docker ps` para verificar se os containers estão em execução.
    - Caso haja problemas com a rede, tente reiniciar o Docker ou limpar volumes e imagens antigas.

- **Erro relacionado ao DB_USERNAME e DB_PASSWORD**

    - Se você receber um erro de "Access denied for user" ou "Can't connect to database" ao tentar acessar o MySQL no Docker, verifique o arquivo .env da sua aplicação para garantir que as variáveis de configuração do banco de dados estão corretas

- **Usuário e senha padrão**

   - Se você está usando o MySQL no Docker e não alterou as credenciais, o usuário padrão é geralmente root e a senha também é root.

   - Exemplo de configuração no .env:
     ```env
      DB_CONNECTION=mysql
      DB_HOST=todoList-db  # nome do container ou endereço de rede
      DB_PORT=3306
      DB_DATABASE=task_manager
      DB_USERNAME=root
      DB_PASSWORD=root
     ```
 - **Reiniciar os containers**

    - Às vezes, é necessário reiniciar o contêiner MySQL após alterar o .env. Para isso, execute:
      ```bash
       docker compose restart mysql
      ```
---

## 🧱 Arquitetura da Solução 
O sistema segue o padrão MVC com camadas bem definidas:

1. **Controller:** Recebe a requisição e delega à camada de serviço.

2. **Service:** Contém a lógica de negócio.

3. **Jobs:** Executam operações assíncronas.

4. **Scheduler:** Verifica periodicamente tarefas com vencimento próximo.

5. **Broadcast (Pusher):** Envia atualizações em tempo real ao frontend via Livewire.

## 🔄 Fluxo:
1. Uma tarefa é criada com data de vencimento.

2. O agendador (php artisan app:verificar-tarefas-vencimento) é executado a cada 5 segundos (ambiente de desenvolvimento).

3. Ele despacha um Job para verificar e alertar tarefas vencendo.

4. O Job emite um evento via Pusher.

5. O frontend escuta o evento via Livewire e atualiza a interface automaticamente.


## 💡 **Decisões Arquiteturais**

### **Tecnologia Laravel + Livewire**:
A escolha de **Laravel** para o backend oferece uma base robusta e fácil de escalar. Com **Livewire**, a interface reativa se torna simples de implementar sem a necessidade de recarregar a página, o que melhora a experiência do usuário.

### **Docker para Isolamento do Ambiente**:
O sistema foi configurado para uso do **Docker** , garantindo que o ambiente de desenvolvimento seja o mais próximo possível do ambiente de produção, facilitando o deploy e a portabilidade do projeto.

---


---
## 🧠 **Decisões Técnicas**

### 1. ✅ **Laravel como Framework Principal**
Escolhi o Laravel como framework pela sua robustez, excelente documentação, arquitetura MVC clara e ferramentas modernas (queues, broadcasting, validation, scheduling). Isso acelerou o desenvolvimento e garantiu uma base sólida.

### 2. ⚡ **Livewire para Interatividade Reativa**
Livewire foi usado para criar componentes dinâmicos e responsivos diretamente com PHP, sem necessidade de frameworks JS como Vue ou React.

#### Vantagens:
- Integração nativa com Laravel
- Menor curva de aprendizado
- Desenvolvimento rápido e manutenível

### 3. 🔄 **Filas com Jobs (Queue)**
A criação de notificações e alertas de vencimento foi feita de forma assíncrona utilizando o sistema de filas do Laravel, garantindo performance e melhor escalabilidade.

#### Vantagens:
- Evita travamento da interface
- Suporte a múltiplos drivers (Redis, DB, etc.)
- Melhor experiência do usuário

### 4. ⏱️ **Agendador (Scheduler) para Tarefas**
O comando é inicializado junto com o docker e verifica periodicamente as tarefas com vencimento próximo e dispara os alertas via job (está disponivel para uso manual tambem).
 ```bash
 php artisan app:verificar-tarefas-vencimento
 ```
#### Justificativa técnica:
- Automatiza lógica de negócio
- Reduz necessidade de ações manuais
- Ideal para lógica periódica (cron jobs)

### 5. 📡 **Notificações com WebSocket (Broadcasting)**
Implementação de notificações em tempo real usando Laravel Broadcasting com canais privados via Pusher.

#### Benefícios:
- Comunicação em tempo real com o frontend
- Canal seguro por usuário
- Experiência moderna e fluida

### 6. 🐳 **Ambiente Isolado com Docker**
O uso de Docker garantiu um ambiente de desenvolvimento idêntico ao de produção, evitando problemas de configuração e aumentando a portabilidade.

#### Vantagens:
- Isolamento completo entre serviços
- Ambiente reproduzível por qualquer colaborador
- Facilita deploy e testes

### 7. 🧩 **Interface com AdminLTE**
Optou-se anteriormente por utilizar o AdminLTE pela sua vasta gama de componentes prontos, combinado com  Livewire, buscando maior leveza e controle da UI.

### 8. 🌍 **Internacionalização (i18n) — Em Desenvolvimento**
Embora o projeto tenha sido estruturado para permitir tradução via resources/lang, o suporte completo a múltiplos idiomas ainda não foi entregue nesta versão.

#### Motivo técnico:
Priorizei a implementação de funcionalidades críticas como alertas, agendamento, filas e reatividade. O suporte multilíngue está mapeado como item da próxima entrega.

## 9. 📊 Visualização de Tarefas com Gráficos e Cards
Embora ainda não tenha sido implementado um filtro dinâmico por status diretamente na tabela principal, foi criada uma tela de controle que apresenta as tarefas de forma visual com:

Gráfico de prioridades (alta, média, baixa)

Cards informativos com a contagem de tarefas por status (pendente, em progresso, concluída)

Além disso, foi adicionado um **log** para monitorar quando uma tarefa é disparada. Esse log registra:
- A **O momento exato que a tarefa foi disparada**
- O **total de tarefas já disparadas**
- O **código da tarefa** disparada.

## Justificativa técnica:
Permite rápida análise do estado geral das tarefas

Fornece uma visão macro para usuários gestores

Reduz carga de interação com a tabela principal

## 10. ✉️ Notificação por E-mail — Em Desenvolvimento
Foi implementado o envio de e-mails na criação de uma tarefa , notificando sobre a tarefa criada.

## Justificativa Técnica:
Engajamento do usuário: Notificar os usuários sobre novas tarefas é essencial para garantir que todos os envolvidos no gerenciamento da tarefa estejam sempre atualizados, melhorando o engajamento e a resposta a prazos.

Escalabilidade: A implementação inicial de notificações por e-mail foca em eventos críticos como criação , enquanto em futuras versões será possível escalar essa funcionalidade para outros cenários, como alterações de proprietário ou vencimento das tarefas.

## 11. ✉️ Escolha do Mailtrap para Envio de E-mails

A solução de envio de e-mails foi configurada utilizando o Mailtrap, um serviço de captura e visualização de e-mails enviados durante o desenvolvimento. Ele é utilizado para testar e garantir que o envio de e-mails funcione corretamente, sem afetar o ambiente de produção ou enviar e-mails reais para os usuários.
Justificativa Técnica:

## Justificativa Técnica:

Ambiente Seguro para Desenvolvimento: O Mailtrap oferece um ambiente seguro e isolado onde os e-mails podem ser capturados e visualizados sem serem realmente entregues aos destinatários finais. Isso é extremamente útil para testes durante o desenvolvimento e para garantir que os e-mails estão sendo enviados corretamente antes de entrar em produção.

Facilidade de Configuração: A configuração do Mailtrap é simples e rápida, especialmente para um ambiente de desenvolvimento local ou staging, onde você não quer enviar e-mails reais enquanto está testando funcionalidades como notificações ou alertas.

Visualização de E-mails: Mailtrap permite visualizar como os e-mails serão formatados, ajudando a ajustar o conteúdo e o layout do e-mail antes de serem enviados para os usuários finais. Isso melhora a qualidade das notificações enviadas pela aplicação.

   
#### Proximas Atualizações:
- Alternância entre idiomas no painel
- Textos externos extraídos para arquivos de tradução
- Detecção de idioma por navegador ou configuração
- Sistema de autenticação por níveis de permissão (admin, usuário)
- Histórico de alterações de tarefas
- Upload de anexos em tarefas
- Implementação de DataTables na tabela de tarefas para permitir paginação, ordenação e busca eficiente, facilitando o uso com grandes volumes de dados
- Integração com serviços como Mailtrap, SMTP ou Mailgun.
- Histórico de notificações enviadas.
---
*"Como Obi-Wan Kenobi disse a Anakin Skywalker: 'Você deu o primeiro passo em uma longa jornada, jovem padawan.' Este projeto, assim como a jornada de Anakin, foi repleto de desafios e obstáculos superados. Com ele, um grande avanço foi conquistado, mas o aprendizado continua. O próximo nível de maestria está agora ao alcance. Que a Força do código esteja com você"*

