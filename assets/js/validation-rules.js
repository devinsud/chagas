$(document).ready(function() {
  
        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z]+$/i.test(value);
        }, "Please enter only letters without space."); 
                    
        // validate contact form on keyup and submit
        $("#form1").validate({
            errorElement: "span", 
            //set the rules for the fild names
            rules: { ciclo: "required", barrio:"required", lote: "required", fecha: "required", manzana : "required" },
            //set error messages
            messages: { ciclo: "El ciclo es un campo requerido.", barrio: "Es un campo requerido.", lote: "Es un campo requerido.", fecha: "Es un campo requerido.", manzana: "Es un campo requerido." },
            errorElement: "span",
            errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
            }
        });
        $("#form1").removeAttr("novalidate");
});