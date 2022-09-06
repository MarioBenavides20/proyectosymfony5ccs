import { Controller}  from "@hotwired/stimulus";

export default class extends Controller{
    static targets = ['formulario', 'buscador', 'closemodal', 'form', 'msj'];
    limpiarfrm(){
        // console.log("Stimulus OK");
        this.element.reset();
        this.closemodalTarget.click();
    }
    async buscarAutores(){
        const response = await fetch('/libros/formbusqueda',{
            method: 'POST',
            body: new URLSearchParams(new FormData(this.element))
        });
        this.formularioTarget.innerHTML = await response.text();
        this.buscadorTarget.click();
    };

    
    async validarLibro(){
        
        const response = await fetch('/libros/validarLibro',{
            method: 'POST',
            body: new URLSearchParams(new FormData(this.element))
        });
        //this.valLibroTarget.innerHTML = await response.text();
        var data = JSON.parse(await response.text());
        var validacion = data.result;
        
        //IMPORTANTE CAMBIAR ESTA ESTRATEGIA
        if (validacion == 1){
            console.log(this.element);
            this.msjTarget.innerHTML = "Este libro ya existe en la base de datos"; //Es lo mismo de get element By id solo que ese es java scrip puro y aca es con stimulus
            document.getElementById("libros_nombre").style.borderColor = "#dc3545";  
            document.getElementById("libros_nombre").style.backgroundImage = "url('https://cdn-icons-png.flaticon.com/512/929/929416.png')";        
            document.getElementById("libros_nombre").style.boxShadow = "0 0 0 .2rem rgba(255,0,0,0.3)";
           
            // consultar targets para evitar de usar true 
           // por medio de dataset junto a target
           
            const gbutton = this.element[5]
            gbutton.disabled= true;
            const sautor = this.element[2]
            sautor.disabled= true;
            const seditorial = this.element[3]
            seditorial.disabled= true;
            
            
        } else {
            //console.log(this.element);
            document.getElementById("msj_libroinv").innerHTML = " ";
            document.getElementById("libros_nombre").style.borderColor = "#28a745";  
            document.getElementById("libros_nombre").style.backgroundImage = "url('https://cdn-icons-png.flaticon.com/512/190/190411.png')";        
            document.getElementById("libros_nombre").style.boxShadow = "0 0 0 .2rem rgba(40,167,69,.25)";
            const button = this.element[5]
            button.disabled = false;
            const sautor = this.element[2]
            sautor.disabled= false;
            const seditorial = this.element[3]
            seditorial.disabled= false;
            
        }
        // console.log(validacion);
        // $existeLibro = !empty($libro)?1:0;

    };
        
}
