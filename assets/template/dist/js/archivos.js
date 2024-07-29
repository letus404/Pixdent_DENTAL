$( document ).ready(function(){

  $("#upFile").on("click", function () {
    $("#getFile").click();
    return false;
  });

  $("#getFile").on("change", function () {
    $("#upFile").removeClass("btn-light");
    $("#upFile").addClass("btn-primary");
    $("#ico-btn-file").removeClass("fa-upload");
    $("#ico-btn-file").addClass("fa-check");
    return false;
  });


  $("body").on("submit", "#formArchivos", function () {
    var formData = new FormData($("#formArchivos").get(0));
    $("#smtArchivo").prop('disabled', true);
    $.ajax({
      url: base_url+"mantenimiento/Ocurrencias/addOcurrencias",
      type: "POST",
      // dataType: "json",
      data: formData,
      contentType: false,
      processData: false,
      success: function (resultadoItem) {
        //location.reload();
      },
      error: function (data) {
        $("#error").html(data['responseText']);
      }
    });
    return false;
  });


  $(".delArchivo").on("click", function () {
    var idArchivo = $(this).data("id");
    $.ajax({
      url: base_url+"principal/delFile",
      type: "POST",
      // dataType: "json",
      data: {idArchivo:idArchivo},
      success: function (resultadoItem) {
        location.reload();
      },
      error: function (data) {
        $("#error").html(data['responseText']);
      }
    });
    return false;
  });



}); // fin funcion ready
