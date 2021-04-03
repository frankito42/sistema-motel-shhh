function entregado(idCarrito) {
    fetch('moduloHabitaciones/php/entregado.php?idCarrito='+idCarrito)
  .then(response => response.json())
  .then((data)=> {
    console.log(data)
    if (data=="ok") {
      document.getElementById("entregra"+idCarrito).classList.add('animated')
      document.getElementById("entregra"+idCarrito).classList.add('bounceOutRight')
      
      $('#entregra'+idCarrito).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', ()=>{
        document.getElementById("entregra"+idCarrito).remove()
      });
    }
  });
    
}
