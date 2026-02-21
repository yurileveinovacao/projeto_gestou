<?php

//Faz a requisição da Sessão
require '../restrito.php';
require '../util.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="refresh" content="600; servicos">
    <link rel="icon" type="image/png" href="../../img/logo.ico" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GESTOU - Services</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="../js/sorttable.js"></script>

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <script src="https://unpkg.com/boxicons@2.1.1/dist/boxicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>    

</head>

<body id="page-top" onload="reload_pagina();">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php

        include_once '../menu_lateral.php';

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

                    <!-- <div id="teste">

                    </div> -->

                    <div class="col-md-12">

                        <div class="row">

                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="h2">Atualizado <span id="data"></span></div>
                                    </div>

                                    <div class="col-md-6 textalign-right">
                                        <a href="../index"><button type="button" class="btn btn-organograma btn-icon-split-organograma"><i class="fas fa-sign-out-alt"></i> Voltar</button></a>
                                    </div>

                                </div>

                                <hr class="mb-3">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="h5" id="envio">Aniversário</div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="card h-100">
                                            <div class="card-body user-select-none">
                                                <div>
                                                    <div class="row" style="margin-top: 15px;">
                                                    <?php
                                                     foreach (select_GESJOB(1) as $gesjob) {
                                                        $situac_gesjob_1 = $gesjob["situac"];
                                                        }
                                                        if ($situac_gesjob_1 == 1) {
                                                            ?>

                                                                    <div class="col mr-2 text-center">
                                                                        <span class="h6 mb-0 font-weight-bold text-center">SERVIÇO ATIVO</span> <br> <a href="servicos.php?de=1"> <span class="text-success"><i class='bx bxs-toggle-right bx-lg' title="Ativo"></i></span></a> 
                                                                    </div>

                                                            <?php
                                                        } else {
                                                            ?>
                                                                    <div class="col mr-2 text-center">
                                                                        <span class="h6 mb-0 font-weight-bold text-center">SERVIÇO INATIVO</span> <br> <a href="servicos.php?ha=1"> <span class="text-danger"><i class='bx bxs-toggle-left bx-lg' title="Inativo"></i></span></a>
                                                                    </div>
                                                            <?php
                                                        }
                                                    ?>
                                                        <!-- <button type="button" id="on_aniversario" class="btn btn-secondary m-auto" onclick="on_aniversario()" title="ON">ON</i></button> desativei os botoes--> 
                                                        <!-- <button type="button" id="off_aniversario" class="btn btn-secondary m-auto" onclick="off_aniversario()" title="OFF">OFF</button> desativei os botoes-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="card-success h-100">
                                            <div class="card-body user-select-none">
                                                <div class="row align-items-center padding-2em">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-white text-center">ENVIADO <br> <small>(ÚLT. 7 DIAS)</small> <br> <span id="card_aniversario1" class="h3 mb-0 font-weight-bold text-white"></span>
                                                            <br><button type="button" class="btn btn-success" data-toggle="modal" data-target="#Visualizar7" name="modal" title="Visualizar enviados (ÚLT. 7 DIAS)"><i class="fas fa-eye"></i></button>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-auto">
                                                        <i class="fas fa-building fa-2x text-primary"></i>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="card-success h-100">
                                            <div class="card-body user-select-none">
                                                <div class="row align-items-center padding-2em">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-white text-center">ENVIADO <br> <small>(ÚLT. 90 DIAS)</small> <br> <span id="card_aniversario2" class="h3 mb-0 font-weight-bold text-white"></span>
                                                            <br><button type="button" class="btn btn-success" data-toggle="modal" data-target="#Visualizar90" name="modal" title="Visualizar enviados (ÚLT. 7 DIAS)"><i class="fas fa-eye"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="card-primary h-100">
                                            <div class="card-body user-select-none">
                                                <div class="row align-items-center padding-2em">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-white text-center">ENVIADO <br> <small>(HOJE)</small> <br> <span id="card_aniversario3" class="h3 mb-0 font-weight-bold text-white"></span>
                                                            <br><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#VisualizarHoje" name="modal" title="Visualizar enviados (Hoje)"><i class="fas fa-eye"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="card-warning h-100">
                                            <div class="card-body user-select-none">
                                                <div class="row align-items-center padding-2em">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-white text-center">A ENVIAR <br> <small>(PRÓX. 7 DIAS)</small> <br> <span id="card_aniversario4" class="h3 mb-0 font-weight-bold text-white"></span>
                                                            <br><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#VisualizarPro7" name="modal" title="Visualizar a enviar (PRÓX. 7 DIAS)"><i class="fas fa-eye"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="card-warning h-100">
                                            <div class="card-body user-select-none">
                                                <div class="row align-items-center padding-2em">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-white text-center">A ENVIAR <br> <small>(PRÓX. 90 DIAS)</small> <br> <span id="card_aniversario5" class="h3 mb-0 font-weight-bold text-white"></span>
                                                            <br><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#VisualizarPro90" name="modal" title="Visualizar a enviar (PRÓX. 90 DIAS)"><i class="fas fa-eye"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- fim linha 1 -->

                                <hr>


                                <!-- <div class="row">

                                    <div class="col-md-2">
                                        <div class="card h-100">
                                            <div class="card-body user-select-none">
                                                <div class="row align-items-center padding-2em">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-gray-800">EMPRESA</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-building fa-2x text-primary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-1">

                                    </div>

                                    <div class="col-md-3">
                                        <div class="card h-100">
                                            <div class="card-body user-select-none">
                                                <div class="row align-items-center padding-2em">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-gray-800">EMPRESA</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-building fa-2x text-primary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card h-100">
                                            <div class="card-body user-select-none">
                                                <div class="row align-items-center padding-2em">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-gray-800">EMPRESA</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-building fa-2x text-primary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card h-100">
                                            <div class="card-body user-select-none">
                                                <div class="row align-items-center padding-2em">
                                                    <div class="col mr-2">
                                                        <div class="h6 mb-0 font-weight-bold text-gray-800">EMPRESA</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-building fa-2x text-primary"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div> -->

                            </div>

                        </div>

                    </div>

                </div>

            </div>

                                    
                                        <!-- <div class="card h-100">
                                            <div class="card-body user-select-none">
                                                <div>
                                                    <div class="row" style="margin-top: 15px;">
                                                     <php
                                                     foreach (select_GESJOB(1) as $gesjob) {
                                                        $situac_gesjob_1 = $gesjob["situac"];
                                                        }
                                                        if ($situac_gesjob_1 == 1) {
                                                            ?>
                                                                    <div class="card h-100">
                                                                        <div class="card-body user-select-none">
                                                                            <div class="row align-items-center padding-2em">
                                                                                <div class="col mr-2">
                                                                                    <div class="h6 mb-0 font-weight-bold text-center">SERVIÇO ATIVO <br> <a href="servicos.php?de=1"> <span class="text-success"><i class='bx bxs-toggle-right bx-lg' title="Ativo"></i></span> </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            <php
                                                        } else {
                                                            ?>
                                                                    <div class="card h-100">
                                                                        <div class="card-body user-select-none">
                                                                            <div class="row align-items-center padding-2em">
                                                                                <div class="col mr-2">
                                                                                    <div class="h6 mb-0 font-weight-bold text-center">SERVIÇO INATIVO <br> <a href="servicos.php?ha=1"> <span class="text-danger"><i class='bx bxs-toggle-left bx-lg' title="Inativo"></i></span></a> </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            <php
                                                        }
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                    



            <!-- End of Main Content -->



            <!-- Footer -->
            <?php

            include_once 'footer.php';

            ?>

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Bootstrap core JavaScript-->
            <script src="../vendor/jquery/jquery.min.js"></script>
            <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="../js/sb-admin-2.min.js"></script>

            <!-- Page level plugins -->
            <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="../js/demo/datatables-demo.js"></script>

            <!-- SWEET ALERT -->
            <!-- <link rel="stylesheet" href="../vendor_sweeetalert/sweetalert2.min.css"> -->
            <!-- <script src="vendor_sweeetalert/sweetalert2.js"></script> -->
            <!-- <script src="../vendor_sweeetalert/sweetalert2.all.min.js"></script> -->

                <!-- Inicio Modal 7DIAS-->
                <div id="Visualizar7" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Conteúdo do modal-->
                    <div class="modal-content">

                    <!-- Cabeçalho do modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Visualizar enviados (ÚLT. 7 DIAS)</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Corpo do modal -->
                    <div class="modal-body">
                        <p>Detalhe dos envios</p>

                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">Id usuário</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Nascimento</th>
                            <th scope="col">Data de envio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach (select_ANIVERSARIOS_DETALHE_7DIAS() as $linha) {
                            if ($linha != 0) {
                            
                            ?>
                        
                            <tr>
                            <th scope="row"><?php echo $linha['id_usu'];  ?></th>
                            <td><?php echo $linha['nome'];  ?></td>
                            <td><?php echo $linha['empresa'];  ?></td>
                            <td><?php echo $linha['datanascimento'];  ?></td>
                            <td><?php echo $linha['datatu_env_aniversario'];  ?></td>
                            </tr>                    
                        
                            <?php
                                } // if
                            } // foreach
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                            <th scope="col">Id usuário</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Nascimento</th>
                            <th scope="col">Data de envio</th>
                            </tr>
                        </tfoot>
                        </table>
                    </div>

                    <!-- Rodapé do modal-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
                    </div>
                    </div>
                </div>
                </div>
                <!-- Fim Modal 7DIAS-->

                <!-- Inicio Modal 90DIAS-->
                <div id="Visualizar90" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Conteúdo do modal-->
                    <div class="modal-content">

                    <!-- Cabeçalho do modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Visualizar enviados (ÚLT. 90 DIAS)</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Corpo do modal -->
                    <div class="modal-body">
                        <p>Detalhe dos envios</p>

                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">Id usuário</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Nascimento</th>
                            <th scope="col">Data de envio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach (select_ANIVERSARIOS_DETALHE_90DIAS() as $linha) {
                            if ($linha != 0) {
                            
                            ?>
                        
                            <tr>
                            <th scope="row"><?php echo $linha['id_usu'];  ?></th>
                            <td><?php echo $linha['nome'];  ?></td>
                            <td><?php echo $linha['empresa'];  ?></td>
                            <td><?php echo $linha['datanascimento'];  ?></td>
                            <td><?php echo $linha['datatu_env_aniversario'];  ?></td>
                            </tr>                    
                        
                            <?php
                                } // if
                            } // foreach
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                            <th scope="col">Id usuário</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Nascimento</th>
                            <th scope="col">Data de envio</th>
                            </tr>
                        </tfoot>
                        </table>
                    </div>

                    <!-- Rodapé do modal-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
                    </div>
                    </div>
                </div>
                </div>
                <!-- Fim Modal 90DIAS-->

                <!-- Inicio Modal HOJE-->
                <div id="VisualizarHoje" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Conteúdo do modal-->
                    <div class="modal-content">

                    <!-- Cabeçalho do modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Visualizar enviados (HOJE)</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Corpo do modal -->
                    <div class="modal-body">
                        <p>Detalhe dos envios</p>

                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">Id usuário</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Nascimento</th>
                            <th scope="col">Data de envio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach (select_ANIVERSARIOS_DETALHE_HOJE() as $linha) {
                            if ($linha != 0) {
                            
                            ?>
                        
                            <tr>
                            <th scope="row"><?php echo $linha['id_usu'];  ?></th>
                            <td><?php echo $linha['nome'];  ?></td>
                            <td><?php echo $linha['empresa'];  ?></td>
                            <td><?php echo $linha['datanascimento'];  ?></td>
                            <td><?php echo $linha['datatu_env_aniversario'];  ?></td>
                            </tr>                    
                        
                            <?php
                                } // if
                            } // foreach
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                            <th scope="col">Id usuário</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Nascimento</th>
                            <th scope="col">Data de envio</th>
                            </tr>
                        </tfoot>
                        </table>
                    </div>

                    <!-- Rodapé do modal-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                    </div>
                    </div>
                </div>
                </div>
                <!-- Fim Modal HOJE-->

                <!-- Inicio Modal Pro7-->
                <div id="VisualizarPro7" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Conteúdo do modal-->
                    <div class="modal-content">

                    <!-- Cabeçalho do modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Visualizar a enviar (PRÓX. 7 DIAS)</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Corpo do modal -->
                    <div class="modal-body">
                        <p>Detalhe dos envios</p>

                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">Id usuário</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Nascimento</th>
                            <th scope="col">Próximo aniversário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach (select_ANIVERSARIOS_DETALHE_PRO7() as $linha) {
                            if ($linha != 0) {
                            
                            ?>
                        
                            <tr>
                            <th scope="row"><?php echo $linha['id_usu'];  ?></th>
                            <td><?php echo $linha['nome'];  ?></td>
                            <td><?php echo $linha['empresa'];  ?></td>
                            <td><?php echo $linha['datanascimento'];  ?></td>
                            <td><?php echo $linha['prox_aniversario'];  ?></td>
                            </tr>                    
                        
                            <?php
                                } // if
                            } // foreach
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                            <th scope="col">Id usuário</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Nascimento</th>
                            <th scope="col">Próximo aniversário</th>
                            </tr>
                        </tfoot>
                        </table>
                    </div>

                    <!-- Rodapé do modal-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Fechar</button>
                    </div>
                    </div>
                </div>
                </div>
                <!-- Fim Modal Pro7-->

                <!-- Inicio Modal Pro90-->
                <div id="VisualizarPro90" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Conteúdo do modal-->
                    <div class="modal-content">

                    <!-- Cabeçalho do modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Visualizar a enviar (PRÓX. 90 DIAS)</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Corpo do modal -->
                    <div class="modal-body">
                        <p>Detalhe dos envios</p>

                        <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">Id usuário</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Nascimento</th>
                            <th scope="col">Próximo aniversário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach (select_ANIVERSARIOS_DETALHE_PRO90() as $linha) {
                            if ($linha != 0) {
                            
                            ?>
                        
                            <tr>
                            <th scope="row"><?php echo $linha['id_usu'];  ?></th>
                            <td><?php echo $linha['nome'];  ?></td>
                            <td><?php echo $linha['empresa'];  ?></td>
                            <td><?php echo $linha['datanascimento'];  ?></td>
                            <td><?php echo $linha['prox_aniversario'];  ?></td>
                            </tr>                    
                        
                            <?php
                                } // if
                            } // foreach
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                            <th scope="col">Id usuário</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Empresa</th>
                            <th scope="col">Nascimento</th>
                            <th scope="col">Próximo aniversário</th>
                            </tr>
                        </tfoot>
                        </table>
                    </div>

                    <!-- Rodapé do modal-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Fechar</button>
                    </div>
                    </div>
                </div>
                </div>
                <!-- Fim Modal Pro90-->
                
</body>

</html>
<script>
    function sem_acesso() {
        Swal.fire({
            icon: "warning",
            title: "Warning",
            title: 'Atenção!',
            text: 'Não existe layout cadastrado para essa funcionalidade!'
        });
    }
</script>

<script>
    let tempo;
    let tempo2;

    function on_aniversario() {

        //AÇÃO NO BOTÃO ON
        $("#on_aniversario").removeClass("btn-secondary");
        $("#on_aniversario").addClass("btn-success");

        if ($("#off_aniversario").is(".btn-danger")) {
            //AÇÃO NO BOTÃO OFF
            $("#off_aniversario").removeClass("btn-danger");
            $("#off_aniversario").addClass("btn-secondary");
        }

        // var tempo = window.setInterval(carrega, 10000);

        carrega();

        tempo2 = setInterval(function() {
            tempo = window.setTimeout(carrega, 1000);
            document.location.reload();
        }, 3600000)

        function carrega() {
            $("#envio").load("envio_email_aniversario.php");
            $("#data").load("data.php");
            $("#card_aniversario1").load("card_aniversario1.php");
            $("#card_aniversario2").load("card_aniversario2.php");
            $("#card_aniversario3").load("card_aniversario3.php");
            $("#card_aniversario4").load("card_aniversario4.php");
            $("#card_aniversario5").load("card_aniversario5.php");
            // $('#teste').attr('onload', 'carrega()');
        }

        situac = 1;

        if (situac !== '') {
            var dados = {
                situac: situac,
            };
            $.post('update.php', dados, function(retorna) {
                //alert(retorna);
                //Carregar o conteudo para o usuário
                // $("#visuDetalheHolerite").html(retorna);
                // $('#visuDetalheModal').modal('show');
            });
        }

        // envia_email = 1;
        // if (envia_email !== '') {
        //     var dados = {
        //         envia_email: envia_email,
        //     };
        //     $.post('envio_email_aniversario.php', dados, function(retorna) {
        //         //alert(retorna);
        //         //Carregar o conteudo para o usuário
        //         // $("#visuDetalheHolerite").html(retorna);
        //         // $('#visuDetalheModal').modal('show');
        //     });
        // }
    }

    function off_aniversario() {

        //AÇÃO NO BOTÃO ON
        $("#off_aniversario").removeClass("btn-secondary");
        $("#off_aniversario").addClass("btn-danger");

        if ($("#on_aniversario").is(".btn-success")) {
            //AÇÃO NO BOTÃO OFF
            $("#on_aniversario").removeClass("btn-success");
            $("#on_aniversario").addClass("btn-secondary");
        }

        carrega();

        function carrega() {
            $("#data").load("data.php");
            $("#card_aniversario1").load("card_aniversario1.php");
            $("#card_aniversario2").load("card_aniversario2.php");
            $("#card_aniversario3").load("card_aniversario3.php");
            $("#card_aniversario4").load("card_aniversario4.php");
            $("#card_aniversario5").load("card_aniversario5.php");
            // $('#teste').attr('onload', 'carrega()');
        }

        // $('#teste').attr('onload', '');
        clearTimeout(tempo);
        clearInterval(tempo2);

        situac = 0;

        if (situac !== '') {
            var dados = {
                situac: situac,
            };
            $.post('update.php', dados, function(retorna) {
                //alert(retorna);
                //Carregar o conteudo para o usuário
                // $("#visuDetalheHolerite").html(retorna);
                // $('#visuDetalheModal').modal('show');

            });
        }

    }

    // function carrega_valores() {

    //     carregar();

    //     function carregar() {
    //         $("#card_aniversario1").load("card_aniversario1.php");
    //         $("#card_aniversario2").load("card_aniversario2.php");
    //         $("#card_aniversario3").load("card_aniversario3.php");
    //         $("#card_aniversario4").load("card_aniversario4.php");
    //         $("#card_aniversario5").load("card_aniversario5.php");
    //         // $('#teste').attr('onload', 'carrega()');
    //     }
    // }
</script>

<?php

// foreach (selectGESSER_aniversario() as $gesser) 
//     {
//         $situac_gesser = $gesser["situac"];
//     }
//     if ($situac_gesser == 1) {
//         echo "<script>document.getElementById('on_aniversario').click();</script>";
//     } else {
//         echo "<script>document.getElementById('off_aniversario').click();</script>";
//     }



//Consulta situac do JOB 1
foreach (select_GESJOB(1) as $gesjob) {
    $situac_gesjob = $gesjob["situac"];
}

if($situac_gesjob == 1){
    echo "<script language=javascript>on_aniversario(); </script>";
}else{
    echo "<script language=javascript>off_aniversario(); </script>";
}

if (isset($_REQUEST['de'])) {
    try {
        $id_job = $_REQUEST["de"];
        $situac = 0;
        updateGESJOB($situac, $id_job);
        $_SESSION["situac_id_job_1"] = $situac;
        echo "<script language=javascript>
                location.href = 'servicos';
                off_aniversario();        
        </script>";
    } catch (PDOException $erro) {
        echo $erro->getMessage();
    }
}

if (isset($_REQUEST['ha'])) {
    try{
        $id_job = $_REQUEST["ha"];
        $situac = 1;
        updateGESJOB($situac, $id_job);
        $_SESSION["situac_id_job_1"] = $situac;
        echo "<script language=javascript>
            location.href = 'servicos';
            on_aniversario();
        </script>";
    }catch (PDOException $erro) {
        echo $erro->getMessage();
    }
  
}

?>