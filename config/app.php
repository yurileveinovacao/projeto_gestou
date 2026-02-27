<?php
/**
 * Configuração centralizada da aplicação.
 * Lê variáveis de ambiente com fallbacks para desenvolvimento.
 */

$app_url = getenv('APP_URL') ?: 'https://gestou.leveinovacao.com.br';
$contact_email = getenv('CONTACT_EMAIL') ?: 'contato@leveinovacao.com.br';
