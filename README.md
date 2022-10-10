# Serviço de disparo de E-mail

- Aplicação disparo de e-mail com base em registros nas tabelas


## Disparo de log para o Telegram

- Caso haja algum erro na aplicação será disparado um Log pelo bot do telegram

- Configure no .env os dados
```
##SE SERÁ EXECUTADO
TELEGRAM_LOG=true

##NOME DO BOT
TELEGRAM_NAME_BOT=gustavo_teste_error_bot

##TOKEM DO BOT
TELEGRAM_API_BOT=5420279837:AAG5xr3UcpEnEj74sHa6sRswpIqAuZoGxqU

##CHAT PARA O MESMO SEJA ENVIADO
TELEGRAM_CHAT_ID=5691922497
```