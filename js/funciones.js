function validarFormulario(formulario) {
    let datos = $('#' + formulario).serializeArray(); // Obtiene todos los campos del formulario
    let vacios = 0;
    let errores = [];

    datos.forEach(function(campo) {
        let nombreCampo = campo.name;
        let valorCampo = campo.value.trim();

        // Validar campos vacíos
        if (valorCampo === "") {
            vacios++;
            errores.push(`El campo ${nombreCampo} está vacío.`);
        }

        // Reglas de validación específicas por formulario y campo
        let regexUsuarioOEmail = /^[a-zA-Z0-9]+$|^\S+@\S+\.\S+$/;
        let regexNombreUsuario = /^[a-zA-ZÀ-ÿ\s]+$/u;
        let regexUsuario = /^[a-zA-Z0-9_.-]{3,16}$/;
        let regexNombreProducto = /^[a-zA-ZÀ-ÿ0-9\s\-_.]+$/u; // Permite letras, números, espacios, guiones, guiones bajos y puntos.
        let regexPrecio = /^\d+(\.\d{1,2})?$/; // Valida números enteros o decimales con hasta dos cifras decimales.
        let regexCantidad = /^[1-9]\d*$/; // Valida números enteros positivos (no permite cero).
        let regexStockMinimo = /^[0-9]+$/; //Valida numeros enteros positivos (incluye cero).
        let regexDireccion = /^[a-zA-Z0-9\s,.-]+$/; // Permite letras, números, espacios, comas y puntos
        let regexTelefono = /^\d{10}$/; // 10 dígitos
        let regexNombreNegocio = /^[a-zA-Z0-9\s&.,-]+$/;


        switch (formulario) {
            case 'frmLogin':
                if (nombreCampo === "usuario" && !regexUsuarioOEmail.test(valorCampo)) {
                    errores.push("El campo debe ser un nombre de usuario o un correo electrónico válido.");
                }
                if (nombreCampo === "password" && valorCampo.length < 6) {
                    errores.push("La contraseña debe tener al menos 6 caracteres.");
                }
                break;
            case 'frmRegistro':
                if (nombreCampo === "nombre" && !regexNombreUsuario.test(valorCampo)) {
                    errores.push("El campo debe ser un nombre de valido.");
                }
                if (nombreCampo === "apellido" && !regexNombreUsuario.test(valorCampo)) {
                    errores.push("El campo debe ser un apellido valido.");
                }
                if (nombreCampo === "usuario" && !regexUsuario.test(valorCampo)) {
                    errores.push("El campo debe ser un nombre de usuario válido.");
                }
                if (nombreCampo === "email" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valorCampo)) {
                    errores.push("El campo debe ser un correo electrónico válido.");
                }
                if (nombreCampo === "password" && valorCampo.length < 6) {
                    errores.push("La contraseña debe tener al menos 6 caracteres.");
                }
                break;
            case 'frmRegistroU':
                if (nombreCampo === "nombreU" && !regexNombreUsuario.test(valorCampo)) {
                    errores.push("El campo debe ser un nombre valido.");
                }
                if (nombreCampo === "apellidoU" && !regexNombreUsuario.test(valorCampo)) {
                    errores.push("El campo debe ser un apellido valido.");
                }
                if (nombreCampo === "usuarioU" && !regexUsuario.test(valorCampo)) {
                    errores.push("El campo debe ser un nombre de usuario válido.");
                }
                if (nombreCampo === "emailU" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valorCampo)) {
                    errores.push("El campo debe ser un correo electrónico válido.");
                }
                break;
            case 'frmArticulos':
                let inputFile = document.getElementById('imagen');  // Asegúrate que este ID coincida con tu campo en el HTML
                    
                // Validar nombre del producto
                if (nombreCampo === "nombre" && !regexNombreProducto.test(valorCampo)) {
                    errores.push("El campo nombre debe ser válido (sin caracteres especiales).");
                }
                    
                // Validar descripción del producto
                if (nombreCampo === "descripcion" && !regexNombreProducto.test(valorCampo)) {
                    errores.push("El campo descripción debe ser válido (sin caracteres especiales).");
                }
                
                // Validar precio
                if (nombreCampo === "precio" && !regexPrecio.test(valorCampo)) {
                    errores.push("El campo precio debe ser un número válido (puede incluir decimales).");
                }
                
                // Validar cantidad
                if (nombreCampo === "cantidad" && !regexCantidad.test(valorCampo)) {
                    errores.push("El campo cantidad debe ser un número entero positivo mayor a 0.");
                }
                    
                // Validar stock minimo
                 if (nombreCampo === "stock_minimo" && !regexStockMinimo.test(valorCampo)) {
                    errores.push("El campo stock minimo debe ser un número entero positivo.");
                }
                
                // Validar que se haya seleccionado un archivo solo si el campo imagen está presente
                if (nombreCampo === "imagen" && inputFile.files.length === 0) {
                    errores.push("Debes seleccionar una imagen.");
                }
                
                break;                
            case 'frmArticulosU':
                // Validar nombre del producto
                if (nombreCampo === "nombreU" && !regexNombreProducto.test(valorCampo)) {
                    errores.push("El campo nombre debe ser válido (sin caracteres especiales).");
                }
                
                // Validar descripción del producto
                if (nombreCampo === "descripcionU" && !regexNombreProducto.test(valorCampo)) {
                    errores.push("El campo descripción debe ser válido (sin caracteres especiales).");
                }

                // Validar precio
                if (nombreCampo === "precioU" && !regexPrecio.test(valorCampo)) {
                    errores.push("El campo precio debe ser un número válido (puede incluir decimales).");
                }

                // Validar cantidad
                // if (nombreCampo === "cantidad" && !regexCantidad.test(valorCampo)) {
                //     errores.push("El campo cantidad debe ser un número entero positivo.");
                // }
                //Valida stock minimo
                if (nombreCampo === "stock_minimoU" && !regexStockMinimo.test(valorCampo)) {
                    errores.push("El campo stock minimo debe ser un número entero positivo.");
                }
                break;
            case 'frmStockU':
                // Validar stock a añadir
                if (nombreCampo === "cantidadA" && !regexCantidad.test(valorCampo)) {
                    errores.push("El campo debe ser un número entero positivo mayor a cero.");
                }
                break;
            case 'frmCategorias':
                // Validar nombre de la categoría
                if (nombreCampo === "categoria" && !regexNombreProducto.test(valorCampo)) {
                    errores.push("El campo nombre debe ser válido (sin caracteres especiales).");
                }
                break;
            case 'frmCategoriaU':
                // Validar nombre de la categoría
                if (nombreCampo === "categoriaU" && !regexNombreProducto.test(valorCampo)) {
                    errores.push("El campo nombre debe ser válido (sin caracteres especiales).");
                }
                break;
            case 'frmClientes':
                if (nombreCampo === "nombre" && !regexNombreUsuario.test(valorCampo)) {
                    errores.push("El campo debe ser un nombre de valido.");
                }
                if (nombreCampo === "apellidos" && !regexNombreUsuario.test(valorCampo)) {
                    errores.push("El campo debe ser un apellido valido.");
                }
                if (nombreCampo === "direccion" && !regexDireccion.test(valorCampo)) {
                    errores.push("La dirección no es válida (solo letras, números y algunos caracteres permitidos).");
                }
                if (nombreCampo === "email" && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valorCampo)) {
                    errores.push("El campo debe ser un correo electrónico válido.");
                }
                if (nombreCampo === "telefono" && !regexTelefono.test(valorCampo)) {
                    errores.push("El teléfono debe contener exactamente 10 dígitos.");
                }
                break;
            case 'frmNegocio':
                // Validar nombre del negocio
                if (nombreCampo === "nombreNegocio" && !regexNombreNegocio.test(valorCampo)) {
                    errores.push("El nombre del negocio debe ser válido (sin caracteres especiales no permitidos).");
                }
                if (nombreCampo === "direccionNegocio" && !regexDireccion.test(valorCampo)) {
                    errores.push("La dirección no es válida (solo letras, números y algunos caracteres permitidos).");
                }
                if (nombreCampo === "telefonoNegocio" && !regexTelefono.test(valorCampo)) {
                    errores.push("El teléfono debe contener exactamente 10 dígitos.");
                }
                break;
            case 'frmNegocioU':
                // Validar nombre del negocio
                if (nombreCampo === "nombreU" && !regexNombreNegocio.test(valorCampo)) {
                    errores.push("El nombre del negocio debe ser válido (sin caracteres especiales no permitidos).");
                }
                if (nombreCampo === "direccionU" && !regexDireccion.test(valorCampo)) {
                    errores.push("La dirección no es válida (solo letras, números y algunos caracteres permitidos).");
                }
                if (nombreCampo === "telefonoU" && !regexTelefono.test(valorCampo)) {
                    errores.push("El teléfono debe contener exactamente 10 dígitos.");
                }
                break;


            // Agrega más validaciones para otros formularios si es necesario
        }
    });

    if (vacios > 0 || errores.length > 0) {
        let mensajeErrores = errores.join('<br>');
        alertify.alert('Errores', mensajeErrores); // Mostrar errores en una alerta
        return false; // Detiene el envío del formulario si hay errores
    }

    return true; // Si todo está bien, permite el envío del formulario
}
