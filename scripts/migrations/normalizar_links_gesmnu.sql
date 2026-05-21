-- FEA-010: Normaliza links do GESMNU que estavam hardcoded para
-- https://www.gestou.com.br/... em URLs relativas. Isso faz o menu
-- funcionar tanto em local (localhost:8080) quanto em qualquer ambiente.
--
-- Os links eram absolutos para o domínio de produção, então clicar em
-- qualquer item do menu master fora de produção redirecionava pro site
-- de produção (geralmente caindo em "sem permissão" lá).
--
-- Idempotente.

UPDATE public."GESMNU"
   SET link = regexp_replace(link, '^https?://(www\.)?gestou\.com\.br/', '/')
 WHERE link LIKE 'https://www.gestou.com.br/%'
    OR link LIKE 'http://www.gestou.com.br/%'
    OR link LIKE 'https://gestou.com.br/%'
    OR link LIKE 'http://gestou.com.br/%';
