$('#dataTable').DataTable({
    autoWidth: true,
    "aaSorting": [
        [0, "desc"]
    ],
    "lengthMenu": [
        [16, 32, 64, -1],
        [16, 32, 64, "All"]
    ]
}).on('draw', function() {

    // // Marca todos os Checkbox, menos os disabled
    // $("#checkTodos").click(function() {
    //     $('input:checkbox').not(":disabled").prop('checked', this.checked);
    // });

    // // Habilita o botão excluir se tiver um checkbox marcado
    // $("input:checkbox").click(function() {
    //     var cont = $(".selecionar:not(:disabled):checked").length;
    //     $("#btn-excluir").prop("disabled", cont ? false : true);
    // });

    // // Marca o checkbox "checkTodos" se todos os checkbox estiverem marcados e desmarca se tiver pelo menos 1 desmarcado
    // $("input:checkbox").click(function() {
    //     var cont = $(".selecionar:not(:disabled):checked").length;
    //     var cont_total = $(".selecionar:not(:disabled)").length;
    //     var check_todos = cont == cont_total;
    //     $("#checkTodos").prop("checked", check_todos ? true : false);
    // });
});