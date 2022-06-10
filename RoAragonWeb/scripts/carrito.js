//Rocío Aragón Escamilla
//2 DAW
document.addEventListener('DOMContentLoaded', () => {
    // Variables
    const baseDeDatos = [{
            id: 1,
            nombre: '10 fotos',
            precio: 10,
            imagen: '../img/fotos.jpg'
        },
        {
            id: 2,
            nombre: '20 fotos',
            precio: 20,
            imagen: '../img/fotos.jpg'
        },
        {
            id: 3,
            nombre: '30 fotos',
            precio: 30,
            imagen: '../img/fotos.jpg'
        },
        {
            id: 4,
            nombre: '20 fotos + impresión',
            precio: 30.99,
            imagen: '../img/fotos.jpg'
        },
        {
            id: 5,
            nombre: 'Fotografía de niños',
            precio: 45,
            imagen: '../img/fotos.jpg'
        },
        {
            id: 6,
            nombre: 'Impresión de fotos',
            precio: 3,
            imagen: '../img/fotos.jpg'
        }

    ];

    let carrito = [];
    const divisa = '€';
    const DOMitems = document.querySelector('#items');
    const DOMcarrito = document.querySelector('#carrito');
    const DOMtotal = document.querySelector('#total');
    const DOMbotonVaciar = document.querySelector('#boton-vaciar');
	const DOMbotonPagar = document.querySelector('#boton-pagar');
	const DOMWarnCarrito = document.querySelector('#warn-carrito');
	const DOMSuccessCarrito = document.querySelector('#success-carrito');
	const DOMErrorCarrito = document.querySelector('#error-carrito');
    const DOMSesion = document.querySelector('#nombre_sesion');

    // Funciones

    /**
     * Dibuja todos los productos a partir de la base de datos. No confundir con el carrito
     */
    function renderizarProductos() {
        baseDeDatos.forEach((info) => {
            // Estructura
            const miNodo = document.createElement('div');
            miNodo.classList.add('card', 'col-sm-4');
            // Body
            const miNodoCardBody = document.createElement('div');
            miNodoCardBody.classList.add('card-body');
            // Titulo
            const miNodoTitle = document.createElement('h5');
            miNodoTitle.classList.add('card-title');
            miNodoTitle.textContent = info.nombre;
            // Imagen
            const miNodoImagen = document.createElement('img');
            miNodoImagen.classList.add('img-fluid');
            miNodoImagen.setAttribute('src', info.imagen);
            // Precio
            const miNodoPrecio = document.createElement('p');
            miNodoPrecio.classList.add('card-text');
            miNodoPrecio.textContent = `${info.precio}${divisa}`;
            // Boton 
            const miNodoBoton = document.createElement('button');
            miNodoBoton.classList.add('btn', 'btn-success');
            miNodoBoton.textContent = '+';
            miNodoBoton.setAttribute('marcador', info.id);
            miNodoBoton.addEventListener('click', anyadirProductoAlCarrito);
            // Insertamos
            miNodoCardBody.appendChild(miNodoImagen);
            miNodoCardBody.appendChild(miNodoTitle);
            miNodoCardBody.appendChild(miNodoPrecio);
            miNodoCardBody.appendChild(miNodoBoton);
            miNodo.appendChild(miNodoCardBody);
            DOMitems.appendChild(miNodo);
        });
    }

    /**
     * Evento para añadir un producto al carrito de la compra
     */
    function anyadirProductoAlCarrito(evento) {
        // Anyadimos el Nodo a nuestro carrito
        carrito.push(evento.target.getAttribute('marcador'))
            // Actualizamos el carrito 
        renderizarCarrito();

    }

    /**
     * Dibuja todos los productos guardados en el carrito
     */
    function renderizarCarrito() {
        // Vaciamos todo el html
        DOMcarrito.textContent = '';
        // Quitamos los duplicados
        const carritoSinDuplicados = [...new Set(carrito)];
        // Generamos los Nodos a partir de carrito
        carritoSinDuplicados.forEach((item) => {
            // Obtenemos el item que necesitamos de la variable base de datos
            const miItem = baseDeDatos.filter((itemBaseDatos) => {
                // ¿Coincide las id? Solo puede existir un caso
                return itemBaseDatos.id === parseInt(item);
            });
            // Cuenta el número de veces que se repite el producto
            const numeroUnidadesItem = carrito.reduce((total, itemId) => {
                // ¿Coincide las id? Incremento el contador, en caso contrario no mantengo
                return itemId === item ? total += 1 : total;
            }, 0);
            // Creamos el nodo del item del carrito
            const miNodo = document.createElement('li');
            miNodo.classList.add('list-group-item', 'text-right', 'mx-2');
            miNodo.textContent = `${numeroUnidadesItem} x ${miItem[0].nombre} - ${miItem[0].precio}${divisa}`;
            // Boton de borrar
            const miBoton = document.createElement('button');
            miBoton.classList.add('btn', 'btn-danger', 'mx-5');
            miBoton.textContent = 'X';
            miBoton.style.marginLeft = '1rem';
            miBoton.dataset.item = item;
            miBoton.addEventListener('click', borrarItemCarrito);
            // Mezclamos nodos
            miNodo.appendChild(miBoton);
            DOMcarrito.appendChild(miNodo);
        });
        // Renderizamos el precio total en el HTML
        DOMtotal.textContent = calcularTotal();
		//console.log(carrito);
    }

    /**
     * Evento para borrar un elemento del carrito
     */
    function borrarItemCarrito(evento) {
        // Obtenemos el producto ID que hay en el boton pulsado
        const id = evento.target.dataset.item;
        // Borramos todos los productos
        carrito = carrito.filter((carritoId) => {
            return carritoId !== id;
        });
        // volvemos a renderizar
        renderizarCarrito();
    }

    /**
     * Calcula el precio total teniendo en cuenta los productos repetidos
     */
    function calcularTotal() {
        // Recorremos el array del carrito 
        return carrito.reduce((total, item) => {
            // De cada elemento obtenemos su precio
            const miItem = baseDeDatos.filter((itemBaseDatos) => {
                return itemBaseDatos.id === parseInt(item);
            });
            // Los sumamos al total
            return total + miItem[0].precio;
        }, 0).toFixed(2);
    }

    /**
     * Vacia el carrito y vuelve a dibujarlo
     */
    function vaciarCarrito() {
        // Limpiamos los productos guardados
        carrito = [];
        // Renderizamos los cambios
        renderizarCarrito();
    }
	
	/**
     * Valida que haya items en el carrito y se haya iniciado sesión y si es asi, envia el pedido
     */
    function validarCompra() {
        
		if(carrito.length!=0){
			if(DOMSesion!=null){
				//se ha iniciado sesion
				enviarPedido();
				vaciarCarrito();
			}else{
				//no se ha iniciado sesion
				DOMWarnCarrito.textContent = "Para hacer una compra debe iniciar sesión";
				DOMWarnCarrito.innerHTML = DOMWarnCarrito.innerHTML + "<button type=\"button\" id='cerrar-warn' class=\"close\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				DOMWarnCarrito.style.visibility = "visible";
				const DOMCerrarWarn = document.querySelector('#cerrar-warn');
				DOMCerrarWarn.addEventListener('click', cerrarWarn);
			}
		}else{
			DOMWarnCarrito.textContent = "Por favor, selecciona algún producto para comprar.";
			DOMWarnCarrito.innerHTML = DOMWarnCarrito.innerHTML + "<button type=\"button\" id='cerrar-warn' class=\"close\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			DOMWarnCarrito.style.visibility = "visible";
			const DOMCerrarWarn = document.querySelector('#cerrar-warn');
			DOMCerrarWarn.addEventListener('click', cerrarWarn);
		}
		
    }
	
	/**
     * Cerrar el alert del success del carrito
     */
    function cerrarSuccess() {
        DOMSuccessCarrito.style.visibility = "hidden";
    }
	
	/**
     * Cerrar el alert del warn del carrito
     */
    function cerrarWarn() {
        DOMWarnCarrito.style.visibility = "hidden";
    }
	
	/**
     * Cerrar el alert de error del carrito
     */
	function cerrarError() {
        DOMErrorCarrito.style.visibility = "hidden";
    }
	
	/**
     * enviar pedido a la bbdd
     */
    function enviarPedido() {
		productos = [];
		cantidades = [];
		precios = [];
		const carritoSinDuplicados = [...new Set(carrito)];
		carritoSinDuplicados.forEach((item) => {
            // Obtenemos el item que necesitamos de la variable base de datos
            const miItem = baseDeDatos.filter((itemBaseDatos) => {
                // ¿Coincide las id? Solo puede existir un caso
                return itemBaseDatos.id === parseInt(item);
            });
            // Cuenta el número de veces que se repite el producto
            const numeroUnidadesItem = carrito.reduce((total, itemId) => {
                // ¿Coincide las id? Incremento el contador, en caso contrario no mantengo
                return itemId === item ? total += 1 : total;
            }, 0);
            
			productos.push(`${miItem[0].nombre}`);
			cantidades.push(`${numeroUnidadesItem}`);
			precios.push(`${miItem[0].precio}`);
        });
		/*console.log(productos);
		console.log(cantidades);
		console.log(precios);*/
        var pedido = {
                "dni" : "00000000A",
                "productos" : productos,
				"cantidades" : cantidades,
				"precios" : precios
        };
        $.ajax({
                data:  pedido, //datos que se envian a traves de ajax
                url:   'PaginasPedidos/enviarPedido.php', //archivo que recibe la peticion
                type:  'post', //método de envio
				success: function(response) //una vez que el archivo recibe el request lo procesa y lo devuelve
				{
					console.log(response);
					var jsonData = JSON.parse(response);//parseamos la respuesta como un json para que sea mas facil de manejar
					
					if (jsonData.success == "1")
					{//ha ido bien
						DOMSuccessCarrito.innerHTML = "Compra realizada. Gracias!";
						DOMSuccessCarrito.innerHTML = DOMSuccessCarrito.innerHTML + "<button type=\"button\" id='cerrar-success' class=\"close\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
						DOMSuccessCarrito.style.visibility = "visible";
						const DOMCerrarSuccess = document.querySelector('#cerrar-success');
						DOMCerrarSuccess.addEventListener('click', cerrarSuccess);
					}
					else
					{//ha habido algun error
						DOMErrorCarrito.textContent = jsonData.message;
						DOMErrorCarrito.innerHTML = DOMErrorCarrito.innerHTML + "<button type=\"button\" id='cerrar-error' class=\"close\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
						DOMErrorCarrito.style.visibility = "visible";
						const DOMCerrarError = document.querySelector('#cerrar-error');
						DOMCerrarError.addEventListener('click', cerrarError);
					}
			   }
        });
    }

    // Eventos
    DOMbotonVaciar.addEventListener('click', vaciarCarrito);
	DOMbotonPagar.addEventListener('click', validarCompra);

    // Inicio
    renderizarProductos();
    renderizarCarrito();
	DOMWarnCarrito.style.visibility = "hidden";
	DOMSuccessCarrito.style.visibility = "hidden";
	DOMErrorCarrito.style.visibility = "hidden";
});