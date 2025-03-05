$(document).ready(function () {

    //Sidenav en móviles
    $('.sidenav').sidenav();
    $('.modal').modal();  // Initializes the modal
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.modal');
        M.Modal.init(elems);
    });
    //Mensajes
    var input_tipo = $("input[name=tipo-mensaje]");
    var input_texto = $("input[name=texto-mensaje]");
    if (input_tipo.length && input_texto.length) {
        //var contenido = $('<span class="'+ input_tipo.val() +'">'+ input_texto.val() +'</span>');
        M.toast({ html: input_texto.val(), classes: input_tipo.val() + " lighten-5" });
    }
    //Ocultar toast
    $(".toast").click(function () {
        $(this).hide();
    });
    //Cambiar clave
    $("input[type=checkbox][name=cambiar_clave]").click(function () {
        $("#password").toggleClass("hide");
        $("#new_password").toggleClass("hide");
        $("#passwordRepeat").toggleClass("hide");
    });

    //Fecha
    $(".datepicker").datepicker({
        firstDay: true,
        format: 'dd-mm-yyyy',
        i18n: {
            months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
            weekdays: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
            weekdaysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
            weekdaysAbbrev: ["D", "L", "M", "M", "J", "V", "S"]
        }
    });
});
function addRow() {
    //Add row
    row = '';
    row += '<tr><td><input type="text"  placeholder="Añadir Ingrediente" required name="ingredientes[]" class="form-control"></td>' +
        '   <td><input type="text" placeholder="Añadir Peso" required name="peso[]" class="form-control"></td>';
    row += '<td><button class="btn btn-outline-danger delete_row">Eliminar</button></td></tr>';
    //Añado despues de la etiqueta tbody la variable de row
    $("tbody").append(row);
}
function removeRow() {
    //Elimino el atributo mas cercano
    $("#add_table").on('click', '.delete_row', function () {
        $(this).closest('tr').remove();
    });
}
