# F5 Sites | Sistema Focalizador JavaScript (www.pomodoros.com.br)

[![GitHub version](https://img.shields.io/badge/wordpress--theme-dev-green.svg)](https://img.shields.io/badge/wordpress--theme-dev-red.svg) 
[![GitHub version](https://img.shields.io/badge/JavaScript-Inside-red.svg)](https://img.shields.io/badge/JavaScript--script-Inside-red.svg) 

Sistema Focalizador JavaScript é um tema de WordPress para criação de um servidor de Pomodoros.

Site Oficial: [Pomodoros.com.br](https:www.pomodoros.com.br) 

Documentação Oficial: [F5 Sites Pomodoros Project](https:projects.f5sites.com/pomodoros.com.br) 

Developd by: [Francisco Matelli Matulovic](https://www.franciscomat.com)

## DESCRIÇÃO

Cria um servidor de Pomodoros usando o WordPress. Um post tipo 'projectimer_focus' é criado e cada usuário que termina um "pomodoro" na verdade publica um post do tipo 'projectimer_focus'.

### CONFIGURAÇÃO

Basta instalar no diretório de temas e ativar os seguintes plugins

```
ranking-calendar
```

### USO

Acesse o endereço e deverá funcionar sem configurações avançadas.

Lembre-se de ativar o registro de usuários se quiser que eles mesmo se cadastrem, o sistema é o padrão do WordPress.

### DOCUMENTAÇÃO TÉCNICA
Parte da documentação mais específica para programadores.

#### Organização de Arquivos e Pastas
A estrutura dos arquivos é bastante simples

```
## PASTAS
/activity (buddypress) - para customizar a página de atividades padrão do plugin
/assets - são os arquivos adicionais, como bibliotecas externas de javascript
/colegas (buddypress) - para customizar a página de colegas (friends) padrão do plugin, mas o endpoint foi renomeado para colegas
/fonts - fontes para estilizar
/images - imagens adicionais
/languages - arquivos iniciais de linguagem, diretos em JavaScript, mas não é a melhor forma para internacionalizar, por isso foi interrompido
/pomodoro - AQUI ESTÁ O SISTEMA FOCALIZADOR JAVASCRIPT
/registration (buddypress) - para customizar a página de registro padrão do plugin
## ARQUIVOS
s - o sufixo 's' indica que é um sidebar, entrando em desuso já que será tudo configurado por código PHP puro.
t - o sufixo 't' indica que é um template, uma página modelo, carregado automaticamente via endpoint, sendo assim não precisa criar páginas no wp-admin.

```

### FLUXOGRAMA DE USO, VISÃO GERAL DO SISTEMA
Aqui está um diagrama para exemplificar o funcionamento completo do sistema de forma simplificada, tentando agregar o ponto de vista técnico de programação e de uso.