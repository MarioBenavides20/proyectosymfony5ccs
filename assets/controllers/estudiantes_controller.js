import { Controller}  from "@hotwired/stimulus";

export default class extends Controller{
    static targets = ['formulario'];
    connect(){
        console.log("Stimulus OK");
    }
    async buscarMaterias(){
        const response = await fetch('/estudiantes/formbusqueda',{
            method: 'POST',
            body: new URLSearchParams(new FormData(this.element))
        });
        this.formularioTarget.innerHTML = await response.text();
    };
        
}