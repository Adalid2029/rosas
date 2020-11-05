$(document).ready(function(){
    $("#agregar_administrativo").on("click", function(e) {
        parametrosModal(
            "#",
            "Asignar horario",
            "modal-lg",
            false,
            false
        );
    });


    function parametrosModal(idModal, titulo, tamano, onEscape, backdrop) {
        $(idModal + "-title").html(titulo);
        $(idModal + "-dialog").addClass(tamano);
        $(idModal).modal({
            backdrop: backdrop,
            keyboard: onEscape,
            focus: false,
            show: true
        });
    }
});
