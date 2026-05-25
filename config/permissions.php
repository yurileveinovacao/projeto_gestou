<?php
/**
 * Configuração centralizada de permissões padrão.
 *
 * MENUS_PADRAO_NOVOS_ADMINS define a lista de id_mnu liberados por padrão
 * para qualquer admin recém-criado (incluindo: criação direta no master,
 * vinculação de empresa nova ao admin existente, e aprovação de empresa).
 *
 * Quando uma FEA adiciona uma nova tela cujo acesso deve fazer parte do
 * "kit básico" do admin, adicione o id_mnu correspondente nesta lista.
 *
 * NÃO inclui:
 * - id_mnu 34 e 36 (exclusivos do Líder RH) — ver upsertGESMPR_lider_menus
 * - $menus_suporte em master/controller/alterar_aprovacao_post.php
 *   (lista interna da Leve para usuários de suporte, semântica diferente)
 */

const MENUS_PADRAO_NOVOS_ADMINS = [
    1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,
    15, 16, 17, 20, 21, 22, 23, 31, 32, 33, 37, 57, 58,
    // FEA-009 — Folha > Autônomos (60) e Folha > RPA (61)
    60, 61,
];
