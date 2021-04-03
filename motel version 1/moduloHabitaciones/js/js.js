function iniciarTodo() {
    let verde="rgb(0 122 49)"
    let verdeDark="rgb(8 102 46)"
    let rojo="#9c0000"
    let rojoDark="rgb(130 8 8)"
    let azul="rgb(24 92 178)"
    let azulDark="rgb(0 59 132)"
    let amarillo="rgb(121 128 2)"
    let amarilloDark="rgb(93 102 8)"
    let lila="rgb(105 44 144 / 98%)"
    let lilaDark="rgb(76 4 106)"
    let element=document.querySelectorAll(".h5")
    let divs=document.querySelectorAll('.cuadradito')

    /* element=Array.from(element)
    */
    console.log(divs)
    element.forEach(aa => {
        prueba=aa.innerHTML
        if (prueba=="ocupada") {
            aa.style.color=rojo
        }else if(prueba=="limpieza"){
            aa.style.color=azul
        }else if(prueba=="cobrando"){
            aa.style.color=amarillo
        }else if(prueba=="verificacion2"){
            aa.style.color=lila
        }else if(prueba=="necesita limpieza"){
            aa.style.color=azul
        }else if(prueba=="MP"){
            aa.style.color=amarillo
        }else{
            aa.style.color=verde
        }
    });

    divs.forEach(aa => {
        /* console.log(aa) */
        prueba=aa.children[2].children[0].innerHTML
        console.log(prueba)
        /* aa.style.borderColor=rojo  */
        if(prueba=="ocupada"){
            aa.style.borderColor=rojoDark
        }else if((prueba=="cobrando")){
            aa.style.borderColor=amarilloDark
        }else if(prueba=="limpieza"){
            aa.style.color=azulDark
        }else if(prueba=="verificacion2"){
            aa.style.color=lilaDark
        }else if(prueba=="necesita limpieza"){
            aa.style.color=azulDark
        }else if(prueba=="MP"){
            aa.style.color=amarilloDark
        }else{
            aa.style.borderColor=verdeDark
        }
        $(aa).mousedown(function(e){
            //1: izquierda, 2: medio/ruleta, 3: derecho
             if(e.which == 3){
                 let habitacion="Habitacion N°"+e.delegateTarget.children[1].children[0].innerHTML
                 let estadoHabitacion=e.delegateTarget.children[2].children[0].innerHTML
                 let id=e.delegateTarget.children[0].id
                 console.log(e.delegateTarget.children[0].id)
                 if(estadoHabitacion=="ocupada"||estadoHabitacion=="cobrando"){
                    fetch('chimichurri/verHabitacionModal.php?id='+id)
                    .then(response => response.json())
                    .then((data) =>{ 
                        if(document.getElementById("modalN"+id)){
                            document.getElementById("modalN"+id).remove()
                        }
                        let modalClickDerecho=`<div class="modal fade" id="modalN${id}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-notify modal-success" role="document">
                        <!--Content-->
                        <div style="background: #dee2e6;" class="modal-content">
                            <!--Header-->
                            <div style="background:#a30000fc;" class="modal-header">
                            <p style="color: #adb4b4e6;font-size: 180%;" class="heading lead">${habitacion}</p>
                    
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</span>
                            </button>
                            </div>
                    
                            <!--Body-->
                            <div class="modal-body">
                            <div class="text-center">
                                ${data}
                            </div>
                            </div>
                    
                            <!--Footer-->
                            <div class="modal-footer">
                            <a type="button" data-dismiss="modal" style="background: #a40303 !important;color: #aca2a2;" class="btn btn-danger">Cerrar</a>
                            </div>
                        </div>
                        <!--/.Content-->
                        </div>
                    </div>`

                    $(modalClickDerecho).modal("show")
                    });

                        
                    /* $("#recargaHabit").load('chimichurri/verhab1.php?id='+id) */
                    

                }


              /* /////////////////FIN DE CLICK DERECHO/////////////////////////////////////////// */     
            }
         });
    
    
    });
    
}
iniciarTodo()