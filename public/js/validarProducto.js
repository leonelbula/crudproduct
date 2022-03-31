$(".producto").on("click", ".btnEliminar", function(){

  var id = $(this).attr("idProducto");

  swal({
        title: '¿Está seguro de borrar este registro?',
        text: "¡Si no lo está puede cancelar la accíón!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar!'
      }).then(function(result){
        if (result.value) {
          
            window.location = "delete/"+id;
        }

  })

})

