import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['buscador', 'formulario', 'closeregistro', 'valcampsub', 'valiva',
        'valcampvriv', 'valcamptot', 'msj', 'valprovee', 'valproduc', 'selectForm'];

    limpiarfrm() {
        console.log("Stimulus OK");
        this.element.reset();
        this.closeregistroTarget.click();
    }

    ///////////////////////// VALIDACION DEL SELECTOR PROVEEDORES /////////////////////////
    async buscarProveedores() {
        this.buscadorTarget.click();
    };

    ///////////////////////// VALIDACION DEL LOS CAMPOS DE DETALLES DE LA COMPRA /////////////////////////
    operacion() {
        console.log(this.element);
        var cantidad = Number(this.element[1].value);
        var vrunidad = Number(this.element[2].value);
        var subtotal = cantidad * vrunidad;
        var iva = Number(this.element[4].value)
        // console.log(subtotal);
        this.valcampsubTarget.value = subtotal;

        if (iva < 1 || iva > 19) {

            this.valivaTarget.innerHTML = "Solo se le puede aplicar hasta el 19%"
            this.valcampvrivTarget.value = 0;
            this.valcamptotTarget.value = 0;
            this.element[7].disabled=true;
        } else {
            this.valivaTarget.innerHTML = " "
            var vriva = (subtotal * iva) / 100;
            this.valcampvrivTarget.value = vriva;
            var total = subtotal + vriva;
            this.valcamptotTarget.value = total;
            this.element[7].disabled=false;
        }

    };

    async grDetalles(){
        this.element.reset();
    };

    ///////////////////////// VALIDACION DEL MODAL PROVEEDOR /////////////////////////
    async validarproveedor() {

        const response = await fetch('/viewcomprs/validarproveedor', {
            method: 'POST',
            body: new URLSearchParams(new FormData(this.element))
        });
        var data = JSON.parse(await response.text());
        var validacion = data.resultprovee;

        if (validacion == 1) {
            this.msjTarget.innerHTML = "Este proveedor ya existe"; //Es lo mismo de get element By id solo que ese es java scrip puro y aca es con stimulus
            this.valproveeTarget.style.borderColor = "#dc3545";
            this.valproveeTarget.style.backgroundImage = "url('https://cdn-icons-png.flaticon.com/512/929/929416.png')";
            this.valproveeTarget.style.boxShadow = "0 0 0 .2rem rgba(255,0,0,0.3)";

            this.selectFormTargets.forEach((element) => {
                element.disabled = true;
            })
        } else {
            this.msjTarget.innerHTML = " ";
            this.valproveeTarget.style.borderColor = "#28a745";
            this.valproveeTarget.style.backgroundImage = "url('https://cdn-icons-png.flaticon.com/512/190/190411.png')";
            this.valproveeTarget.style.boxShadow = "0 0 0 .2rem rgba(40,167,69,.25)";

            this.selectFormTargets.forEach((element) => {
                element.disabled = false;
            })
        }
    };

    ///////////////////////// VALIDACION DEL MODAL PRODUCTO /////////////////////////
    async validarproducto() {

        console.log(this.element);
        const response = await fetch('/viewcomprs/validarproducto', {
            method: 'POST',
            body: new URLSearchParams(new FormData(this.element))
        });
        var data = JSON.parse(await response.text());
        var validacion = data.resultproduc;

        if (validacion == 1) {

            this.msjTarget.innerHTML = "Este producto ya existe"; //Es lo mismo de get element By id solo que ese es java scrip puro y aca es con stimulus
            this.valproducTarget.style.borderColor = "#dc3545";
            this.valproducTarget.style.backgroundImage = "url('https://cdn-icons-png.flaticon.com/512/929/929416.png')";
            this.valproducTarget.style.boxShadow = "0 0 0 .2rem rgba(255,0,0,0.3)";

            this.selectFormTargets.forEach((element) => {
                element.disabled = true;
            })

        } else {
            this.msjTarget.innerHTML = " ";
            this.valproducTarget.style.borderColor = "#28a745";
            this.valproducTarget.style.backgroundImage = "url('https://cdn-icons-png.flaticon.com/512/190/190411.png')";
            this.valproducTarget.style.boxShadow = "0 0 0 .2rem rgba(40,167,69,.25)";

            this.selectFormTargets.forEach((element) => {
                element.disabled = false;
            })
        }

    };
    

}
