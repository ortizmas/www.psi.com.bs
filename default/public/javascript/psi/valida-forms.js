$(function(){
     $('input[placeholder], textarea').placeholder();
});
/***********Validar formulario*************/
    $.validator.setDefaults({
        errorElement: "label",
        onfocusout: function(element) { $(element).valid(); },
        success: function(label) 
        {
            /*
            var template = jQuery.validator.format("{0} is not a valid value");
            // later, results in 'abc is not a valid value'
            alert(template("abc"));
             */
           var name = label.attr('for');
            var elem = $("[name="+name+"]");
            if(name.search( new RegExp( "contrasena+|validacionCheck|cant", "i" ))<0)
            {
              var str  = (elem.data("success") !== undefined) ? elem.data("success") : "";
              label.addClass('success').html(str.replace(/\{value\}+/gi,elem.val())).insertAfter(name);
            }
        else
            {
              label.html("");   
            }
        },
        errorPlacement: function(error, element) 
        {
            var str  = element.data("error");
            //console.log(str);
            if( str !== undefined)
            {
                error.html(str).insertAfter(element);
            }
            else
                error.insertAfter(element);    
        },
        showErrors: function(errorMap, errorList) 
        {
            
            $.each(errorList, function() { 
                var name = this.element.getAttribute("name");
                if($("[name="+name+"]").next().length > 0 )
                    $("[name="+name+"]").next().remove();
            });

            this.defaultShowErrors();
        }


    });