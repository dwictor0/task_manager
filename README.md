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
5. Para monitorar e gerenciar as filas com uma interface visual, utilize o Horizon , ative o painel com o comando:
   ```bash
    php artisan horizon 
    ```
6. Para gerar as credenciais do arquivo .env, execute o seguinte comando:
   ```bash
     php artisan key:generate
   ```


## 🛠️ **Deploy em Produção**

1. **Configuração de produção**:
    - Verifique se as variáveis de ambiente estão corretamente configuradas no arquivo `.env`.
    - Se estiver utilizando um servidor remoto, verifique as configurações do banco de dados e serviços auxiliares como fila e WebSocket.

2. **Sistema de filas**:
    Caso tenha configurado um sistema de filas para envio de e-mails ou notificações, execute os workers em background:
    ```bash
    php artisan queue:work
    ```
    Para monitorar as filas, você pode utilizar o **Laravel Horizon**.

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

## Justificativa técnica:
Permite rápida análise do estado geral das tarefas

Fornece uma visão macro para usuários gestores

Reduz carga de interação com a tabela principal

#### Proximas Atualizações:
- Alternância entre idiomas no painel
- Textos externos extraídos para arquivos de tradução
- Detecção de idioma por navegador ou configuração
- Sistema de autenticação por níveis de permissão (admin, usuário)
- Histórico de alterações de tarefas
- Upload de anexos em tarefas
- Implementação de DataTables na tabela de tarefas para permitir paginação, ordenação e busca eficiente, facilitando o uso com grandes volumes de dados
---
*"Como Obi-Wan Kenobi disse a Anakin Skywalker: 'Você deu o primeiro passo em uma longa jornada, jovem padawan.' Este projeto, assim como a jornada de Anakin, foi repleto de desafios e obstáculos superados. Com ele, um grande avanço foi conquistado, mas o aprendizado continua. O próximo nível de maestria está agora ao alcance. Que a Força do código esteja com você"*

