<?php

require_once 'restrito.php';
require_once 'util.php';
require_once 'iuds_pdo.php';

use Shuchkin\SimpleXLSX;

require_once 'src/SimpleXLSX.php';

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU PORTAL - Início</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- <link href="style.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,600,700">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>

    <script src="js/sorttable.js"></script>

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        include_once 'menu_lateral.php';
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include_once 'barra_superior.php';
                ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Inconsistências Lote</h6>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">

                                <?php

                                $arquivo = "uploads/Cadastro_Funcionarios.xlsx";

                                if (isset($arquivo)) {
                                    if ($xlsx = SimpleXLSX::parse($arquivo)) {

                                ?>

                                        <table id="dataTable" class="table table-bordered sortable" width="100%" cellspacing="0">

                                            <?php

                                            $dim = $xlsx->dimension();
                                            $cols = $dim[0];

                                            foreach ($xlsx->readRows() as $k => $r) {
                                                if ($k == 0) {
                                                    echo '<thead>';
                                                    for ($i = 0; $i < $cols; $i++) {
                                                        echo '<th>' . (isset($r[$i]) ? $r[$i] : '&nbsp;') . '</th>';
                                                    }
                                                    echo '</thead>';
                                                } else {
                                                    // skip first row
                                                    echo '<tr>';
                                                    for ($i = 0; $i < $cols; $i++) {
                                                        echo '<td>' . (isset($r[$i]) ? $r[$i] : '&nbsp;') . '</td>';
                                                    }
                                                    echo '</tr>';
                                                }
                                            }

                                            ?>

                                        </table>

                                <?php

                                    } else {
                                        echo SimpleXLSX::parseError();
                                    }
                                }
                                ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- -------------------------------------------------------------------------------------------------------------------- -->

            <div id="visuModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document" style="width: 500px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ajuste Inconsistência</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form class="needs-validation" novalidate action="inconsistencias_lote" method="POST">
                            <div class="modal-body">

                                <?php

                                switch ($tipo_lote) {

                                    case "i":

                                        if ($contagem_inconsistencia > 0) {

                                ?>

                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="anocal">Ano Calendário</label>
                                                    <input type="text" class="form-control" style="text-transform:uppercase" id="anocal" name="anocal" attrname="anocal" maxlength="4" required>
                                                    <div class="invalid-feedback">
                                                        Inválido! Preencha a data corretamente!
                                                    </div>
                                                </div>
                                            </div>

                                <?php

                                        }

                                        break;
                                }

                                ?>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="btn-ajustar" class="btn btn-organograma">Ajustar</button>
                                <button type="button" id="fechar-modal" class="btn btn-outline-secondary" data-dismiss="modal">Fechar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <!-- End of Main Content -->

            <?php

            include_once 'footer.php';

            ?>

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/datatables-demo.js"></script>

            <!-- REQUISITOS MÁSCARAS JS -->
            <!-- <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script> -->
            <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js" type="text/javascript"></script>

            <!-- SWEET ALERT -->
            <link rel="stylesheet" href="vendor_sweeetalert/sweetalert2.min.css">
            <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
            <script src="vendor_sweeetalert/sweetalert2.all.min.js"></script>

</body>

</html>


<script>
    var indices = [];

    //Pega os indices
    $('#tblItens thead tr th').each(function() {
        indices.push($(this).text());
    });

    var arrayItens = [];

    //Pecorre todos os produtos
    $('#tblItens tbody tr').each(function(index) {

        var obj = {};

        //Controle o objeto
        $(this).find('td').each(function(index) {
            obj[indices[index]] = $(this).text();
        });

        //Adiciona no arrray de objetos
        arrayItens.push(obj);

    });

    //Mostra dados pegos no console
    console.log(arrayItens);

    //Envia para o php
    $.ajax({
        type: "POST",
        url: "suapagina.php",
        data: arrayItens,
        success: function(respostaDoPhp) {
            alert('Deu tudo certo');
        },
    });
</script>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                        alert("Preencha os campos requeridos em todas as abas!");
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    // FUNÇÃO MÁSCARAS
    function inputHandler(masks, max, event) {
        var c = event.target;
        var v = c.value.replace(/\D/g, '');
        var m = c.value.length > max ? 1 : 0;
        VMasker(c).unMask();
        VMasker(c).maskPattern(masks[m]);
        c.value = VMasker.toPattern(v, masks[m]);
    }

    // MÁSCARA DATA
    var anocalMask = ['9999', '9999'];
    var anocal = document.querySelector('input[attrname=anocal]');
    VMasker(anocal).maskPattern(anocalMask[0]);
    anocal.addEventListener('input', inputHandler.bind(undefined, anocalMask, 4), false);

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '#btn-voltar', function() {
            var voltar = 1;
            //alert(id_recebido);
            //verificar se há calor na variavel "id_recebido".
            if (voltar !== '') {

                var dados = {
                    voltar: voltar
                };
                $.post('inconsistencias_lote.php', dados, function(retorna) {

                    location.href = "lotes_processados";

                });

            }
        });
    });

    //Clique do botão detalhe quando não existirem eventos pendentes
    $(document).ready(function() {
        $(document).on('click', '.btn-inconsistencia', function() {
            var descr = $(this).attr("descr");
            //alert(id_recebido);
            //verificar se há calor na variavel "id_recebido".
            if (descr !== '') {

                if (descr === "ANOCAL") {

                    $('#visuModal').modal('show');

                }
            }
        });
    });
</script>

<?php
if (isset($_POST["voltar"])) {

    try {

        // Limpa a variavel de sessão
        unset($_SESSION["valores"]);
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST["btn-ajustar"])) {

    try {

        switch ($tipo_lote) {

            case "i";

                $tabela = 'public."GESIRR_' . $raiz_cnpj . '"';
                $anocal = $_POST["anocal"];
                $anoexe = intval($anocal) + 1;

                updateGESIRR_anocal($tabela, $anocal, $anoexe, $id_processamento);

                echo "<script language=javascript>
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'A inconsistência foi corrigida!',
                    icon: 'success',
                    confirmButtonColor: '#28a745',
                    confirmButtonText: 'OK!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = 'lotes_processados';
                    }else{
                        location.href = 'lotes_processados';
                    }
                })
                    </script>";

                break;
        }
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}
?>