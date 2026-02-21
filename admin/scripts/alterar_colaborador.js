$("#dataTable").DataTable({
  autoWidth: true,
  aaSorting: [[0, "desc"]],
  lengthMenu: [
    [16, 32, 64, -1],
    [16, 32, 64, "All"],
  ],
  searching: false,
  info: false,
});

// AÇÕES NO BLUR
$(function () {
  $("#referencia").on("blur", function () {
    var referencia = $(this).val();
    var id_cur = $("#curso").val();
    var blur_referencia = 1;

    if (id_cur !== "") {
      var dados = {
        referencia: referencia,
        id_cur: id_cur,
        blur_referencia: blur_referencia,
      };

      $.post(
        "controller/lancamento_cursos_exames_post.php",
        dados,
        function (retorno) {
          $("#vencimento").val(retorno);
        }
      );
    }
  });

  $("#curso").on("change", function () {
    var valCurso = $(this).val();
    var valref = $("#referencia").val();
    var blur_referencia = 1;

    if (valref !== "") {
      var dados = {
        referencia: valref,
        id_cur: valCurso,
        blur_referencia: blur_referencia,
      };

      $.post(
        "controller/lancamento_cursos_exames_post.php",
        dados,
        function (retorno) {
          $("#vencimento").val(retorno);
        }
      );
    }
  });
});

function usuario_inativo() {
  Swal.fire({
    icon: "info",
    title: "Info",
    title: "Atenção!",
    text: "O usuário está inativo!",
  });
}

$(function () {
  $(document).on("click", "#lancar-curso", function () {
    var btn_lancar = 1;

    if (btn_lancar !== "") {
      var dados = {
        btn_lancar: btn_lancar,
      };

      $.post("controller/colaboradores_post.php", dados, function (retorno) {
        switch (retorno) {
          case "1":
            $("#modal-lancar").modal("show");
            break;

          case "0":
            Swal.fire({
              icon: "info",
              title: "Attention!",
              title: "Atenção!",
              text: "Você não tem permissão para lançar Cursos/Exames. Verifique suas credenciais ou entre em contato com o suporte.",
              allowEscapeKey: false,
              closeOnClickOutside: false,
              allowOutsideClick: false,
            }).then((result) => {
              if (result.isConfirmed) {
                swal.close();
              }
            });
            break;
        }
      });
    }
  });
});

// CLICK NO BTN VISUALIZAR ANEXO - .visualizar_pdf
$(function () {
  $(document).on("click", ".visualizar_pdf", function () {
    var dados = {
      token: $(this).closest("tr").data("token"),
      btn_visualizar_anexo: 1,
    };

    $.post(
      "controller/alterar_colaborador_post.php",
      dados,
      function (retorno) {
        $("#visuAnexo").html(retorno);
        $("#anexo_modal").modal("show");
      }
    );
  });
});

$(function () {
  $(document).on("click", "#incluir_documento", function () {
    $("#modal-salvar-doc").modal("show");
  });
});

// FOCA NO INPUT DESCRICAO AO ABRIR O MODAL
$("#modal-lancar").on("shown.bs.modal", function () {
  // Seleciona o elemento input do campo "descricao"
  const inputModal = document.getElementById("curso");

  // Define o foco para o elemento input
  inputModal.focus();
});

// APAGA ALTERAÇÃO NO MODAL
$(function () {
  $("#modal-lancar").on("hidden.bs.modal", function () {
    $(this).find("form")[0].reset();
    $("input[required]").css("border-color", "");
    $("select[required]").css("border-color", "");
  });
});

// CLOSE MODAL
$(function () {
  $(document).on("click", ".close-modal", function () {
    $(".modal:visible").modal("hide");
  });
});

//Clique do botão CAKE para abrir modal externo trazendo a extrutura do CARTAO DE ANIVERSARIO
$(document).ready(function () {
  $(document).on("click", "#btn-aniversario", function () {
    var id_recebido = $(this).attr("id_usu");
    //alert(id_recebido);
    //verificar se há calor na variavel "id_recebido".
    if (id_recebido !== "") {
      var dados = {
        id_recebido: id_recebido,
      };
      $.post("cartao_de_aniversario.php", dados, function (retorna) {
        //alert(retorna);
        //Carregar o conteudo para o usuário
        $("#visuCartao").html(retorna);
        $("#visuModal").modal("show");
        $("#visuModal").addClass("show");

        // $(document).on('hidden.bs.modal', '#visuModal', function() {

        //     window.location.reload();

        // });
      });
    }
  });
});

//Clique do botão BAIXAR para efetuar o download do HTML convertido para JPEG
$(document).ready(function () {
  $(document).on("click", "#baixar", function () {
    domtoimage
      .toJpeg(document.getElementById("my-node"), {
        quality: 1,
      })
      .then(function (dataUrl) {
        var link = document.createElement("a");
        var nome_usuario = document.getElementById("nome_usuario").innerHTML;
        link.download = "CARTAO ANIVERSARIO" + nome_usuario + ".jpeg";
        link.href = dataUrl;
        link.click();
        // location.href = "tabela_funcionarios";
      });
  });
});

//Clique do botão BTN-REMOVERFOTO para efetuar o post para alterar a senha
$(document).ready(function () {
  $(document).on("click", "#btn-removerfoto", function () {
    Swal.fire({
      icon: "warning",
      title: "Atenção!",
      text: "Deseja remover a foto do colaborador?",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sim, remover!",
      cancelButtonText: "Não!",
    }).then((result) => {
      if (result.isConfirmed) {
        // Valor que define se o botão foi clicado
        var btn_removerfoto = 1;

        // Obtém os valores dos campos
        var dados_form = {
          colaborador_removerfoto: $("#form").attr("colaborador"),

          // Valor que valida o click no botão
          btn_removerfoto: btn_removerfoto,
        };

        // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
        $.post(
          "controller/colaboradores_post.php",
          dados_form,
          function (retorno) {
            if (retorno == 1) {
              // Exibe uma mensagem de sucesso e recarrega a pagina
              Swal.fire({
                icon: "success",
                title: "Success",
                title: "Sucesso!",
                text: "Foto removida com sucesso!",
                allowEscapeKey: false,
                closeOnClickOutside: false,
                allowOutsideClick: false,
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.reload();
                }
              });
            }
          }
        );
      } else {
        swal.close();
      }
    });
  });
});

$(document).ready(function () {
  $("#form").submit(function (event) {
    // Previne o comportamento padrão do formulário (recarregar a página)
    event.preventDefault();

    // Valor que define que o formulário foi submetido
    var btn_submit = 1;

    // Obtém os valores do formulário
    var dados_form = {
      colaborador: $("#form").attr("colaborador"),

      nome_update: $("#nome").val(),
      rg_update: $("#rg").val(),
      cpf_update: $("#cpf").val(),
      email_update: $("#email").val(),
      telefone_update: $("#telefone").val(),
      celular_update: $("#celular").val(),
      departamento_update: $("#departamento").val(),
      gestor_update: $("#gestor").val(),
      datanasc_update: $("#datanasc").val(),
      dataadmis_update: $("#dataadmis").val(),
      endereco_update: $("#endereco").val(),
      numero_update: $("#numero").val(),
      bairro_update: $("#bairro").val(),
      complemento_update: $("#complemento").val(),
      // estado_update: $("#estado").val(),
      cidade_update: $("#cidade").val(),
      cep_update: $("#cep").val(),
      pis_update: $("#pis").val(),
      ctps_update: $("#ctps").val(),
      tituloeleitor_update: $("#titulo_eleitor").val(),
      cbo_update: $("#cbo").val(),
      linkedin_update: $("#linkedin").val(),
      tiposalario_update: $("#tiposalario").val(),
      salario_update: $("#salario").val(),
      dependentes_update: $("#dependentes").val(),
      funcao_update: $("#funcao").val(),
      sexo_update: $("#sexo").val(),
      escolaridade_update: $("#escolaridade").val(),
      datarescisao_update: $("#datarescisao").val(),
      codintegracao_update: $("#cod_integracao").val(),
      agrdep_update: $("#agrdep").is(":checked"),
      bloqueado_update: $("#bloqueado").is(":checked"),

      // Valor que valida o envio do formulário
      btn_submit: btn_submit,
    };

    // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
    $.post("controller/colaboradores_post.php", dados_form, function (retorno) {
      // alert(retorno);

      // Se o retorno for igual a 1, os dados foram inseridos com sucesso
      if (retorno == 1) {
        // Exibe uma mensagem de sucesso e recarrega a pagina
        Swal.fire({
          icon: "success",
          title: "Success",
          title: "Sucesso!",
          text: "Informação atualizada com sucesso!",
          allowEscapeKey: false,
          closeOnClickOutside: false,
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            location.href = "colaboradores";
          }
        });
      }

      // Se o retorno for igual a 2, cpf ja cadastrado ativo
      else if (retorno == 2) {
        // Exibe uma mensagem de sucesso e recarrega a pagina
        Swal.fire({
          icon: "warning",
          title: "Warning",
          title: "Atenção!",
          text: "O CPF já está cadastrado para um colaborador ativo!",
          allowEscapeKey: false,
          closeOnClickOutside: false,
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            $("#cpf").val("");

            swal.close();
          }
        });
      }

      // Se o retorno for igual a 3, telefone ou celular ja cadastrado
      else if (retorno == 3) {
        // Exibe uma mensagem de sucesso e recarrega a pagina
        Swal.fire({
          icon: "warning",
          title: "Warning",
          title: "Atenção!",
          text: "O celular já está cadastrado para um colaborador ativo!",
          allowEscapeKey: false,
          closeOnClickOutside: false,
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            $("#celular").val("");

            swal.close();
          }
        });
      }

      // Se o retorno for igual a 4, e-mail ja cadastrado
      else if (retorno == 4) {
        // Exibe uma mensagem de sucesso e recarrega a pagina
        Swal.fire({
          icon: "warning",
          title: "Warning",
          title: "Atenção!",
          text: "O e-mail já está cadastrado para um colaborador ativo!",
          allowEscapeKey: false,
          closeOnClickOutside: false,
          allowOutsideClick: false,
        }).then((result) => {
          if (result.isConfirmed) {
            $("#email").val("");

            swal.close();
          }
        });

        // Se o retorno for igual a 5, cpf já cadastrado nesse cnpj
      } else if (retorno == 5) {
        // Exibe uma mensagem de erro usando o plugin SweetAlert2
        Swal.fire({
          icon: "warning",
          title: "Warning",
          title: "Atenção!",
          text: "O CPF já está cadastrado para um colaborador nesse CNPJ!",
        }).then((result) => {
          if (result.isConfirmed) {
            $("#cpf").val("");

            swal.close();
          }
        });

        // Se o retorno for igual a 6, data de nascimento incorreta
      } else if (retorno == 6) {
        // Exibe uma mensagem de erro usando o plugin SweetAlert2
        Swal.fire({
          icon: "warning",
          title: "Warning",
          title: "Atenção!",
          text: "A data de nascimento informada não existe!",
        }).then((result) => {
          if (result.isConfirmed) {
            swal.close();
          }
        });

        // Se o retorno for igual a 7, data de admissão incorreta
      } else if (retorno == 7) {
        // Exibe uma mensagem de erro usando o plugin SweetAlert2
        Swal.fire({
          icon: "warning",
          title: "Warning",
          title: "Atenção!",
          text: "A data de admissão informada não existe!",
        }).then((result) => {
          if (result.isConfirmed) {
            swal.close();
          }
        });

        // Se o retorno for igual a 8, data de nascimento menor que 15 anos
      } else if (retorno == 8) {
        // Exibe uma mensagem de erro usando o plugin SweetAlert2
        Swal.fire({
          icon: "warning",
          title: "Warning",
          title: "Atenção!",
          text: "A data de nascimento informada é menor que a idade permitida!",
        }).then((result) => {
          if (result.isConfirmed) {
            swal.close();
          }
        });

        // Se o retorno for igual a 9, data de admissão menor que a de nascimento
      } else if (retorno == 9) {
        // Exibe uma mensagem de erro usando o plugin SweetAlert2
        Swal.fire({
          icon: "warning",
          title: "Warning",
          title: "Atenção!",
          text: "A data de admissão informada é menor que a de nascimento!",
        }).then((result) => {
          if (result.isConfirmed) {
            swal.close();
          }
        });

        // Se o retorno for igual a 0, alguma campo não cumpriu os requisitos para a inserção dos dados
      } else if (retorno == 0) {
        // Exibe uma mensagem de erro usando o plugin SweetAlert2
        Swal.fire({
          icon: "warning",
          title: "Warning",
          title: "Atenção!",
          text: "Preencha os campos requeridos em todas as abas!",
        }).then((result) => {
          if (result.isConfirmed) {
            swal.close();
          }
        });
        // Caso não for nem 0 nem 1 houve erro no try e retorna um alerta com o erro exibido pelo catch
      } else {
        // alert(retorno);
        Swal.fire({
          icon: "error",
          title: "Please contact support.",
          title: "Favor entrar em contato com o suporte.",
          html: retorno,
        }).then((result) => {
          if (result.isConfirmed) {
            swal.close();
          }
        });
      }
    }).fail(function () {
      // Se houver uma falha na requisição, exibe um alerta com a mensagem "Fail"
      alert("Fail");
    });
  });
});

$(function () {
  $("#form-salvar-doc").submit(function (event) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append("submit_salvar_doc", 1);

    $.ajax({
      url: "controller/alterar_colaborador_post.php",
      type: "POST",
      data: formData,
      dataType: "json",
      contentType: false,
      processData: false,
      success: function (retorno) {
        switch (retorno.status) {
          case "SUCESSO":
            Swal.fire({
              icon: "success",
              title: "Sucesso!",
              text: "Documento salvo com sucesso!",
              allowOutsideClick: false,
              allowEscapeKey: false,
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.reload();
              }
            });
            break;

          case "ERRO_ARQUIVO":
            Swal.fire({
              icon: "error",
              title: "Atenção!",
              text: "Erro ao salvar o arquivo!",
              allowOutsideClick: false,
              allowEscapeKey: false,
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.reload();
              }
            });
            break;

          case "ERRO_CPF":
            Swal.fire({
              icon: "error",
              title: "Atenção!",
              text: "Erro ao identificar o colaborador!",
              allowOutsideClick: false,
              allowEscapeKey: false,
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.reload();
              }
            });
            break;

          case "ERRO_EXT":
            Swal.fire({
              icon: "info",
              title: "Atenção!",
              text: "Permitido salvar apenas documentos em pdf.",
              allowOutsideClick: false,
              allowEscapeKey: false,
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.reload();
              }
            });
            break;

          case "VALOR_INVALIDO":
            Swal.fire({
              icon: "info",
              title: "Atenção!",
              text: "Por favor, preencher todos os campos.",
              allowOutsideClick: false,
              allowEscapeKey: false,
            }).then((result) => {
              if (result.isConfirmed) {
                swal.close();
              }
            });
            break;

          case "SEM_ANEXO":
            Swal.fire({
              icon: "info",
              title: "Atenção!",
              text: "Por favor, selecionar um anexo.",
              allowOutsideClick: false,
              allowEscapeKey: false,
            }).then((result) => {
              if (result.isConfirmed) {
                swal.close();
              }
            });
            break;

          default:
            Swal.fire({
              icon: "error",
              title: "Atenção!",
              text: "Erro não identificado, favor entrar em contato com o suporte.",
              allowOutsideClick: false,
              allowEscapeKey: false,
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.reload();
              }
            });
            break;
        }
      },
    });
  });
});

$(function () {
  $("#form-modal-lancar").submit(function (event) {
    event.preventDefault();

    var submit_lancar = 1;

    if (submit_lancar !== "") {
      var dados = {
        curso: $("#curso").val(),
        datref: $("#referencia").val(),
        datvenc: $("#vencimento").val(),
        observacao: $("#observacao").val(),

        submit_lancar: submit_lancar,
      };

      $.post("controller/colaboradores_post.php", dados, function (retorno) {
        switch (retorno) {
          case "1":
            Swal.fire({
              icon: "success",
              title: "Sucesso!",
              text: "Curso/Exame lançado com sucesso!",
              allowOutsideClick: false,
              allowEscapeKey: false,
            }).then((result) => {
              if (result.isConfirmed) {
                // Recarrega a página se o usuário confirmar o alerta
                location.reload();
              }
            });
            break;

          case "0":
            Swal.fire({
              icon: "warning",
              title: "Atenção!",
              text: "Preencha todos os campos para concluir a ação!",
              allowOutsideClick: false,
              allowEscapeKey: false,
            }).then((result) => {
              if (result.isConfirmed) {
                // Fecha o alerta se o usuário confirmar
                swal.close();
              }
            });
            break;

          case "2":
            Swal.fire({
              icon: "warning",
              title: "Atenção!",
              text: "A data de referência informada é inválida!",
              allowOutsideClick: false,
              allowEscapeKey: false,
              didClose: () => {
                return [
                  // Define a cor da borda do elemento 'referencia' como vermelho e foca nele
                  $("#referencia").focus(),
                ];
              },
            });
            break;

          case "3":
            Swal.fire({
              icon: "warning",
              title: "Atenção!",
              text: "A data de vencimento informado é inválido!",
              allowOutsideClick: false,
              allowEscapeKey: false,
              didClose: () => {
                return [
                  // Define a cor da borda do elemento 'vencimento' como vermelho e foca nele
                  $("#vencimento").focus(),
                ];
              },
            });
            break;

          case "4":
            Swal.fire({
              icon: "warning",
              title: "Atenção!",
              text: "A data de referência não pode ser maior que o vencimento",
              allowOutsideClick: false,
              allowEscapeKey: false,
              didClose: () => {
                return [
                  // Foca no elemento 'referencia'
                  $("#referencia").focus(),
                ];
              },
            });
            break;

          case "5":
            Swal.fire({
              icon: "warning",
              title: "Atenção!",
              text: "Periodo não pode ser menor do que a carencia de aviso cadastrada para esse curso!",
              allowOutsideClick: false,
              allowEscapeKey: false,
            }).then((result) => {
              if (result.isConfirmed) {
                // Fecha o alerta se o usuário confirmar
                swal.close();
              }
            });
            break;

          default:
            Swal.fire({
              icon: "error",
              title: "Favor entrar em contato com o suporte.",
              html: retorno,
            }).then((result) => {
              if (result.isConfirmed) {
                // Recarrega a página se o usuário confirmar o alerta
                location.reload();
              }
            });
            break;
        }
      });
    }
  });
});

//Clique do botão EYE para realizar a troca do icone
$(document).ready(function () {
  $(document).on("click", ".lnr-eye-modal", function () {
    var senha = $("#troca-senha");
    senha.attr("type", senha.attr("type") === "password" ? "text" : "password");
    $(this).toggleClass("fa-eye-slash fa-eye");
  });
});

//Clique do botão EYE para realizar a troca do icone
$(document).ready(function () {
  $(document).on("click", ".lnr-eye1-modal", function () {
    var senha = $("#confirm-senha");
    senha.attr("type", senha.attr("type") === "password" ? "text" : "password");
    $(this).toggleClass("fa-eye-slash fa-eye");
  });
});

//Clique do botão BTN-SENHA para efetuar o post para alterar a senha
$(document).ready(function () {
  $(document).on("click", "#btn-senha", function () {
    Swal.fire({
      icon: "warning",
      title: "Atenção!",
      text: "Deseja alterar a senha do colaborador?",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sim, alterar!",
      cancelButtonText: "Não!",
    }).then((result) => {
      if (result.isConfirmed) {
        // Valor que define se o botão foi clicado
        var btn_senha = 1;

        // Obtém os valores dos campos
        var dados_form = {
          colaborador_senha: $("#form").attr("colaborador"),

          senha: $("#troca-senha").val(),
          confirm_senha: $("#confirm-senha").val(),

          // Valor que valida o click no botão
          btn_senha: btn_senha,
        };

        // Envia os dados do formulário para o arquivo PHP usando o método POST do jQuery
        $.post(
          "controller/colaboradores_post.php",
          dados_form,
          function (retorno) {
            // alert(retorno);

            switch (retorno) {
              case "0":
                // Exibe uma mensagem de sucesso e recarrega a pagina
                Swal.fire({
                  icon: "warning",
                  title: "Warning",
                  title: "Atenção!",
                  text: "A nova senha deve conter no mínimo 3 caracteres!",
                  allowEscapeKey: false,
                  closeOnClickOutside: false,
                  allowOutsideClick: false,
                }).then((result) => {
                  if (result.isConfirmed) {
                    // location.href = "politicas_codconduta";
                  }
                });

                break;

              case "1":
                // Exibe uma mensagem de sucesso e recarrega a pagina
                Swal.fire({
                  icon: "success",
                  title: "Success",
                  title: "Sucesso!",
                  text: "Senha alterada com sucesso!",
                  allowEscapeKey: false,
                  closeOnClickOutside: false,
                  allowOutsideClick: false,
                }).then((result) => {
                  if (result.isConfirmed) {
                    location.href = "colaboradores";
                  }
                });

                break;

              case "2":
                // Exibe uma mensagem de sucesso e recarrega a pagina
                Swal.fire({
                  icon: "warning",
                  title: "Warning",
                  title: "Atenção!",
                  text: "As duas senhas não coincidem!",
                  allowEscapeKey: false,
                  closeOnClickOutside: false,
                  allowOutsideClick: false,
                }).then((result) => {
                  if (result.isConfirmed) {
                    // location.href = "politicas_codconduta";
                  }
                });

                break;

              default:
                break;
            }
          }
        );
      }
    });
  });
});

$(document).ready(function () {
  $("#btn-voltar").click(function () {
    var btn_voltar = 1;

    if (btn_voltar !== "") {
      var dados = {
        btn_voltar: btn_voltar,
      };
      $.post("controller/colaboradores_post.php", dados, function (retorna) {
        location.href = "colaboradores";
      });
    }
  });
});

function check_form() {
  var inputs = document.getElementById("form").querySelectorAll("[required]");
  var len = inputs.length;
  var valid = true;
  for (var i = 0; i < len; i++) {
    if (!inputs[i].value) {
      valid = false;
    }
  }
  if (!valid) {
    var element = document.getElementById("btn-troca-senha");
    element.setAttribute("disabled", "disabled");
    return false;
  } else {
    return true;
  }
}

function moeda(a, e, r, t) {
  let n = "",
    h = (j = 0),
    u = (tamanho2 = 0),
    l = (ajd2 = ""),
    o = window.Event ? t.which : t.keyCode;
  a.value = a.value.replace("R$ ", "");
  if (((n = String.fromCharCode(o)), -1 == "0123456789".indexOf(n))) return !1;
  for (
    u = a.value.replace("R$ ", "").length, h = 0;
    h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r);
    h++
  );
  for (l = ""; h < u; h++)
    -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
  if (
    ((l += n),
    0 == (u = l.length) && (a.value = ""),
    1 == u && (a.value = "R$ 0" + r + "0" + l),
    2 == u && (a.value = "R$ 0" + r + l),
    u > 2)
  ) {
    for (ajd2 = "", j = 0, h = u - 3; h >= 0; h--)
      3 == j && ((ajd2 += e), (j = 0)), (ajd2 += l.charAt(h)), j++;
    if (ajd2.length < 13) {
      for (
        a.value = "R$ ", tamanho2 = ajd2.length, h = tamanho2 - 1;
        h >= 0;
        h--
      )
        a.value += ajd2.charAt(h);
      a.value += r + l.substr(u - 2, u);
    } else {
      a.value = "R$ ";
    }
  }
  return !1;
}

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  "use strict";
  window.addEventListener(
    "load",
    function () {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName("needs-validation");
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener(
          "submit",
          function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
              // alert("Preencha os campos requeridos em todas as abas!");
            }
            form.classList.add("was-validated");
          },
          false
        );
      });
    },
    false
  );
})();

// FUNÇÃO MÁSCARAS
function inputHandler(masks, max, event) {
  var c = event.target;
  var v = c.value.replace(/\D/g, "");
  var m = c.value.length > max ? 1 : 0;
  VMasker(c).unMask();
  VMasker(c).maskPattern(masks[m]);
  c.value = VMasker.toPattern(v, masks[m]);
}

// MÁSCARA RG
// var rgMask = ['99.999.999-9', '99.999.999-9'];
// var rg = document.querySelector('input[attrname=RG]');
// VMasker(rg).maskPattern(rgMask[0]);
// rg.addEventListener('input', inputHandler.bind(undefined, rgMask, 13), false);

// MÁSCARA CPF
var cpfMask = ["999.999.999-99", "999.999.999-99"];
var cpf = document.querySelector("input[attrname=cpf]");
VMasker(cpf).maskPattern(cpfMask[0]);
cpf.addEventListener("input", inputHandler.bind(undefined, cpfMask, 14), false);

// MÁSCARA TEL
var telMask = ["(999) 99999-9999", "(999) 99999-9999"];
var tel = document.querySelector("input[attrname=telefone]");
VMasker(tel).maskPattern(telMask[0]);
tel.addEventListener("input", inputHandler.bind(undefined, telMask, 16), false);

// MÁSCARA CEL
var celMask = ["(999) 99999-9999", "(999) 99999-9999"];
var cel = document.querySelector("input[attrname=celular]");
VMasker(cel).maskPattern(celMask[0]);
cel.addEventListener("input", inputHandler.bind(undefined, celMask, 16), false);

// MÁSCARA DATA
var datanascMask = ["99/99/9999", "99/99/9999"];
var datanasc = document.querySelector("input[attrname=datanasc]");
VMasker(datanasc).maskPattern(datanascMask[0]);
datanasc.addEventListener(
  "input",
  inputHandler.bind(undefined, datanascMask, 10),
  false
);

// MÁSCARA DATA
var dataadmisMask = ["99/99/9999", "99/99/9999"];
var dataadmis = document.querySelector("input[attrname=dataadmis]");
VMasker(dataadmis).maskPattern(dataadmisMask[0]);
dataadmis.addEventListener(
  "input",
  inputHandler.bind(undefined, dataadmisMask, 10),
  false
);

// MÁSCARA DATA
var datarescisaoMask = ["99/99/9999", "99/99/9999"];
var datarescisao = document.querySelector("input[attrname=datarescisao]");
VMasker(datarescisao).maskPattern(datarescisaoMask[0]);
datarescisao.addEventListener(
  "input",
  inputHandler.bind(undefined, datarescisaoMask, 10),
  false
);

// MÁSCARA REFERENCIA
var datarefMask = ["99/99/9999", "99/99/9999"];
var dataref = document.querySelector("input[attrname=referencia]");
VMasker(dataref).maskPattern(datarefMask[0]);
dataref.addEventListener(
  "input",
  inputHandler.bind(undefined, datarefMask, 10),
  false
);

// MÁSCARA VENCIMENTO
var datavencMask = ["99/99/9999", "99/99/9999"];
var datavenc = document.querySelector("input[attrname=vencimento]");
VMasker(datavenc).maskPattern(datavencMask[0]);
datavenc.addEventListener(
  "input",
  inputHandler.bind(undefined, datavencMask, 10),
  false
);

// MÁSCARA COMPETENCIA
var datavencMask = ["99/99/9999", "99/99/9999"];
var datavenc = document.querySelector("input[attrname=salvar_doc_competencia]");
VMasker(datavenc).maskPattern(datavencMask[0]);
datavenc.addEventListener(
  "input",
  inputHandler.bind(undefined, datavencMask, 10),
  false
);

// MÁSCARA CEP
var cepMask = ["99999-9999", "99999-999"];
var cep = document.querySelector("input[attrname=cep]");
VMasker(cep).maskPattern(cepMask[0]);
cep.addEventListener("input", inputHandler.bind(undefined, cepMask, 8), false);

// MÁSCARA DECIMAL
// var decimalMask = ['$ 9.999.999,99','$ 999.999,99', '$ 99.999,99', '$ 9.999,99', '$ 999,99', '$ 99,99', '$ 9,99', '$ 9'];
// var decimalMask = ['$ ,99','$ 9,99', '$ 99.999,99', '$ 9.999,99', '$ 999,99', '$ 99,99', '$ 9,99', '$ 9'];
// var decimal = document.querySelector('input[attrname=decimal]');
// VMasker(decimal).maskPattern(decimalMask[0]);
// decimal.addEventListener('input', inputHandler.bind(undefined, decimalMask, 25), false);

// INÍCIO SCRIPT COM ANIMAÇÃO RÁPIDA

$(function () {
  $("#estado").change(function () {
    if ($(this).val()) {
      $("#cidade").hide();
      $(".carregando").show();
      $.getJSON(
        "select_cidade_idusu.php?search=",
        {
          estado: $(this).val(),
          ajax: "true",
        },
        function (j) {
          var options =
            '<option value="" selected disabled>Escolha a Cidade</option>';
          for (var i = 0; i < j.length; i++) {
            options +=
              '<option value="' +
              j[i].id_mun +
              '" namespace="' +
              j[i].cep_mun +
              '">' +
              j[i].nome_mun +
              "</option>";
          }
          $("#cidade").html(options).show();
          $(".carregando").hide();
        }
      );
    } else {
      $("#cidade").html('<option value="">– Escolha Subcategoria –</option>');
    }
  });
});

// FIM ANIMAÇÃO RÁPIDA

document.getElementById("estado").onchange = function () {
  // var select = document.getElementById("estado");
  // var cep = select.options[select.selectedIndex].getAttribute("namespace");
  document.querySelector("[name='cep']").value = "";
};

document.getElementById("cidade").onchange = function () {
  var select = document.getElementById("cidade");
  var cep = select.options[select.selectedIndex].getAttribute("namespace");
  document.querySelector("[name='cep']").value = cep;
};

$(document).ready(function () {
  var valor = document.getElementById("departamento").value;

  if (valor != 0) {
    $("#agrdep").prop("disabled", false);
  }
});

$(document).ready(function () {
  // Escuta o evento de fechamento do modal
  $("#modal-salvar-doc").on("hidden.bs.modal", function () {
    // Limpa todos os inputs dentro do modal
    $(this).find("form")[0].reset(); // Limpa todos os campos do formulário

    // Caso seja necessário limpar campos específicos como arquivos ou selects que não se resetam com 'reset'
    $(this).find('input[type="file"]').val(""); // Limpa campo de arquivo
  });
});
