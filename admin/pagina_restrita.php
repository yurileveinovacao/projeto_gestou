<?php
//Faz a requisição da Sessão
require 'restrito.php';

//FUNÇÕES INSERT, UPDATE, DELETE E SELECT
require_once "iuds_pdo.php";

//ARQUIVO DE UTILITÁRIOS
require_once "util.php";

$pagina_atual = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
$tipo_menu = 'admin';

foreach (selectGESMNU_link($pagina_atual, $tipo_menu) as $select_gesmnu_id) {

    $id_mnu_page = $select_gesmnu_id['id_mnu'];
}

if (!empty($id_mnu_page)) {
    
    foreach (selectGESMPR_permissao($id_emp_default, $id_usa_default, $id_mnu_page) as $select_permissao_usa) {

        $situac_permissao_page = $select_permissao_usa['situac'];
    }
} else {

    $situac_permissao_page = 1;
}

if ($situac_permissao_page == 1) { ?>

    <!-- INICIO PAGE CONTENT -->
    <div class="container-fluid">

    <?php } else { ?>

        <!-- INICIO PAGE CONTENT -->
        <div class="container-fluid" style="display: none;">

        <?php
        echo "<script>
            Swal.fire({
                icon: 'info',
                title: 'Atenção!',
                text: 'Você não tem permissão para acessar esta página. Verifique suas credenciais ou entre em contato com o suporte.',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = 'index';
                }
            });
        </script>";
    } ?>