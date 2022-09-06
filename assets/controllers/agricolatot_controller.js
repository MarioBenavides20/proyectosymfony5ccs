import { Controller } from "@hotwired/stimulus";

export default class extends Controller 
{
    static targets = ['sumtotal'];

    async connect()
        {
/// PARA UTILIZAR RETURN JSON E INDICAR LOS TOTALES
        //     const response = await fetch ('/viewcomprs/calculartotales', {
        //         method: 'POST',
        // });
        
        // var subtotal = JSON.parse(await response.text());
        // console.log(subtotal.total);
        // var subtotalvista = parseFloat(subtotal.subtotal);
        // var ivavista = parseFloat(subtotal.iva);
        // var totalvista =Number(subtotal.total);
        // document.getElementById('subtotal').innerHTML = "$" + subtotalvista;
        // document.getElementById('iva').innerHTML = "$" + ivavista;
        // document.getElementById('total').innerHTML = "$" + totalvista;
        // };

/// PARA UTILIZAR RETURN RENDER E INDICAR LOS TOTALES
        const response = await fetch ('/viewcomprs/calculartotales', {method: 'POST',});
        document.getElementById("tablatot").innerHTML = await response.text();
        // console.log(response.bodyUsed);
        // this.sumtotalTarget.innerHTML= await response.text(); //crear un twig y pprogramar la logica
        }

   async disconnect(){

        console.log('hola ingrese disconect');
        const response = await fetch ('/viewcomprs/calculartotales', {method: 'POST',});
        document.getElementById("tablatot").innerHTML = await response.text();

};
}