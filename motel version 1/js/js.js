if ($("#mensajeEliminar").length > 0) {
  
    setTimeout(()=>{
      document.querySelector("#mensajeEliminar").remove()
    },4000)
}
if ($("#editadoCorrecto").length > 0) {
  
    setTimeout(()=>{
      document.querySelector("#editadoCorrecto").remove()
    },3000)
}


function azul(ip) {
  $.get("http://"+ip+"/?TCA")
  console.log("azul")
}
function rojo(ip) {
  $.get("http://"+ip+"/?TCR")
}
function lila(ip) {
  $.get("http://"+ip+"/?TCL")
}
function verde(ip) {
  $.get("http://"+ip+"/?TCV")
}
function celeste(ip) {
  $.get("http://"+ip+"/?TCM")
}
function amarillo(ip) {
  $.get("http://"+ip+"/?TCY")
}
function flash(ip) {
  $.get("http://"+ip+"/?FLA")
}
function apagar(ip) {
  $.get("http://"+ip+"/?TCN")
}
function prender(ip) {
  $.get("http://"+ip+"/?TCW")
}
