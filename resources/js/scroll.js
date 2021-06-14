let  divProfesores =  document.querySelectorAll('.departamento');
function mostrarScroll(){
    let scrollTop = document.body.scrollTop;
    for (let i = 0; i < divProfesores.length; i++) {
        const alturaAnimado = divProfesores[i].offsetTop;
        console.log(scrollTop);
        if(alturaAnimado -750 < scrollTop){
            divProfesores[i].style.opacity=1;
            divProfesores[i].classList.add("mostrarArriba");
            console.log('hola');
        }
        
    }
}

document.addEventListener('scroll',mostrarScroll)
