<!-- CONFIGURAÇÃO GLOBAL PARA AS DATATABLES -->

<!-- Estilo para não criar nova linha na caixa de texto da procura nas datatables -->
  <style type="text/css">
  .dataTables_filter{
    white-space: nowrap;
  }
  .dataTables_filter input{
    display:inline;
    margin-left:10px;
  }
</style>
  <script type="text/javascript">
      (function ($, DataTable) {

    // Datatable global configuration
    $.extend(true, DataTable.defaults, {
        language: {
            "sProcessing": "Em processamento...",
            "sLengthMenu": "Mostrar _MENU_ registos",
            "sZeroRecords": "Não há registos",
            "sEmptyTable": "Não há registos",
            "sInfo": "A apresentar desde o registos _START_ ao _END_ de un total de _TOTAL_ registos",
            "sInfoEmpty": "Não há registos",
            "sInfoFiltered": "(A filtrar de um total de _MAX_ registos)",
            "sInfoPostFix": "",
            "sSearch": "Procurar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "A carregar...",
            "oPaginate": {
                "sFirst": "Primeiro",
                "sLast": "Último",
                "sNext": "Seguinte",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Ativar para ordenar a coluna por ordem ascendente",
                "sSortDescending": ": Ativar para ordenar a coluna por ordem descendente"
            },

        },
        "dom":"<\'top\'f><'bottombuttons'>rtp",
        buttons: [
            'copy', 'excel', 'pdf'
        ],
        processing: true,
        serverSide: true,

    });

})(jQuery, jQuery.fn.dataTable);
    </script>
