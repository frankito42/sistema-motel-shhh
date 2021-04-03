let data
async function aaa() {
    
   await fetch('js/traerCantidadStock.php')
    .then(response => response.json())
    .then(a => data=a)

    data.forEach(element => {
        if(element.cantidad<=0)
        document.getElementById(element.articulo).value=0
        
    });
    return data
}
  
aaa() 


function menos(id) {
    if(document.getElementById(id).value>1){
        document.getElementById(id).value--
    }
   
}
function mas(id) {

    let resultado = data.find(aaa=>aaa.articulo==id)
    
    if(document.getElementById(id).value<parseInt(resultado.cantidad)){
        console.log(resultado.cantidad)
        console.log(id)
        document.getElementById(id).value++
    }
}
