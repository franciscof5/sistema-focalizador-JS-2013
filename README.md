# F5 Sites | Sistema Focalizador JavaScript (www.pomodoros.com.br)

[![GitHub version](https://img.shields.io/badge/wordpress--theme-dev-green.svg)](https://img.shields.io/badge/wordpress--theme-dev-red.svg) 
[![GitHub version](https://img.shields.io/badge/JavaScript-Inside-red.svg)](https://img.shields.io/badge/JavaScript--script-Inside-red.svg) 

Sistema Focalizador JavaScript é um tema de WordPress para criação de um servidor de Pomodoros.

Site Oficial: [Pomodoros.com.br](https://www.pomodoros.com.br) 

Documentação Oficial: [F5 Sites Pomodoros Project](https://projects.f5sites.com/pomodoros.com.br) 

Developd by: [Francisco Matelli Matulovic](https://www.franciscomat.com)

## DESCRIÇÃO

Cria um servidor de Pomodoros usando o WordPress. Um post tipo 'projectimer_focus' é criado e cada usuário que termina um "pomodoro" na verdade publica um post do tipo 'projectimer_focus'.

### CONFIGURAÇÃO

Basta instalar no diretório de temas e ativar os seguintes plugins

```
# FREE
* buddypress
* contact-form7 + honeypot
* ical-feeds
* advanced-excerpt
# CUSTOM
* fnetwork-top-authors (fork do top-authors)
* ranking-calendar (fork do *calendar*)
* wp-csv-pomodoros (fork do wp-csv)
* opcional: f5sites-shared-posts-and-tax
```

### WP POST OBJECT
O sistema herda as funções básica do wordpress, assim para o tipo projectimer_focus temos as seguintes definições para o objeto WP_POST

```
post_type:projectimer_focus
post_status:
* completed = usuário terminou um pomodoro (timer completed).
* private = usuário terminou um pomodoro de forma privada e só ele pode ver (timer completed in private, only author can see).
* draft = tarefa modelo para lista de tarefas abaixo da tarefa atual (task model for todo list).
* trash = tarefa modelo completada, riscada da lista de tareras (task model completed).
* pending_review = para registrar a tarefa atual e cada usuário do sistema só deve ter um único post deste tipo, se não tiver pelo menos um é um usuário novo que nunca usou o sistema ou antigo de uma versão anterior a este esquema, se tiver mais de um é devido a bug ou falha anterior, quando o usuário modifica o formulário da tarefa atual ele atualiza o seu único post do tipo pending_review.
post_date: registra quando o timer encerra, verifica com o PHP a data de início (when timer rings)
post_categories: incialmente configuradas como Estudo, Trabalho e Pessoal, podem no futuro serem customizadas pelos usuários
post_tags: coração do sistema, já que o sistema de tags do WordPress é que permite que o Pomodoros tenha seu uso de forma inovadora, cada tag é um projeto, assim pode-se usar mais de uma tag e "etiquetar" muito melhor o seu tempo. A tag.php é o template para exibir os projetos, que carregam os dados da TAG, a tag então é o elemento mais importante do sistema, já que o usuário está mais preocupado com a visão de longo prazo.

```

### USO

Acesse o endereço e deverá funcionar sem configurações avançadas.

Lembre-se de ativar o registro de usuários se quiser que eles mesmo se cadastrem, o sistema é o padrão do WordPress.

### DOCUMENTAÇÃO TÉCNICA
Parte da documentação mais específica para programadores.

#### Organização de Arquivos e Pastas
A estrutura dos arquivos é bastante simples

```
#
PASTAS
/activity (buddypress) - para customizar a página de atividades padrão do plugin
/assets - são os arquivos adicionais, como bibliotecas externas de javascript
/colegas (buddypress) - para customizar a página de colegas (friends) padrão do plugin, mas o endpoint foi renomeado para colegas
/fonts - fontes para estilizar
/images - imagens adicionais
/languages - arquivos iniciais de linguagem, diretos em JavaScript, mas não é a melhor forma para internacionalizar, por isso foi interrompido
/pomodoro - AQUI ESTÁ O SISTEMA FOCALIZADOR JAVASCRIPT
/registration (buddypress) - para customizar a página de registro padrão do plugin
#
ARQUIVOS
tag.php - a página de visualização do projeto, já que os projetos são tags
#SUFIXOS
* s - o sufixo 's' indica que é um sidebar, entrando em desuso já que será tudo configurado por código PHP puro.
* part - identifica partes do layout do sistema
* (desuso) t - o sufixo 't' indica que é um template, uma página modelo, carregado automaticamente via endpoint, sendo assim não precisa criar páginas no wp-admin.

```

### FLUXOGRAMA DE USO, VISÃO GERAL DO SISTEMA
Aqui está um diagrama para exemplificar o funcionamento completo do sistema de forma simplificada, tentando agregar o ponto de vista técnico de programação e de uso.