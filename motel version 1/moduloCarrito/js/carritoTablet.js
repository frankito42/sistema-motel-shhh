let img=document.getElementsByClassName("myImg")
let titulo=document.getElementById("tituloProducto")
img.forEach(element=>{


element.addEventListener("click",()=>{
    titulo.innerHTML=element.parentNode.parentNode.firstChild.nextElementSibling.innerHTML
    document.getElementById("cargarImg").src=element.src
    $("#mostarImg").modal("show")
})

}

);
