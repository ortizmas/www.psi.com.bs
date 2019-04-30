KumbiaPHP Backend
=================

Proyecto base con la parte administrativa lista para usar en apps con kumbiaphp Beta2

Usuario: admin , clave: 123

Descripci�n
-----

EL backend es el m�dulo de administraci�n y configuraci�n de una aplicaci�n, a traves de el podremos gestionar las diferentes partes de la misma, desde el control de los usuarios de sistemas y sus privilegios, hasta llevar auditorias sobre las acciones que realizan los mismos dentro de la aplicaci�n.


Gesti�n de Usuarios
-----

Permite la creaci�n edici�n y eliminaci�n de usuarios de la aplicaci�n.

Los Usuarios tienen perfiles asociados, con ello se puede controlar que puede hacer cada usuario dependiendo de los perfiles que posea.

Gesti�n de Roles (Perfiles)
-----

Permite la creaci�n edici�n y eliminaci�n de Roles de la aplicaci�n.

Los roles son un identificador de que tipo de papel juega un usuario dentro de la aplicacion. 

Ejemplo: usuarios visitantes, moderadores, administradores, etc.

Gesti�n de Recursos
-----

Los recursos son cada uno de los m�dulos ( p�ginas ) que tiene la aplicaci�n.

Cada recurso est� identificado por una url.

Ejemplos de recursos Validos:

- admin/usuarios/crear     especificamos el modulo controlador y acci�n.
- articulos/crear          controlador y acci�n.
- inicio/*                 controlador y todas las acciones del mismo. 
- modulo/controlador/*     Modulo controlador y todas las acciones del mismo. 
- modulo/*/*               Modulo todos los controladores y acciones del mismo. 

Gesti�n de Privilegios ( Permisos de roles a recursos )
-----

Permite establecer a que recursos tiene acceso cada rol en la aplicacion.

Gesti�n de Menus
-----

Permite la creaci�n edici�n y eliminaci�n de Menus de la aplicaci�n.

Cada menu est� asociado a un recurso, esto con el fin de poder tener menus inteligentes que solo carguen los items
a los que un rol tenga acceso.

Ademas los items pueden tener items padres asociados para crear menus hijos.

<div>
						<!--<img src="demo/5.jpg" alt="picture">-->
						<p style="text-align: center; margin-bottom: -7px;">Est�s escuchando:  </p>
						<p style="text-align: center; margin-bottom: -7px;"><strong>RPU Noticias </strong></p>
						<p style="text-align: center; margin-bottom: -7px;">Lun. a Vie. de 12:00 a 12:30pm </p>
					</div>

					<div>
						<!--<img src="demo/4.jpg" alt="picture">
						<p style="text-align: center; margin-bottom: -7px;">Luego viene: </p>-->
						<p style="text-align: center; margin-bottom: -7px;"><strong>Telara�a Inform�tica</strong></p>
						<p style="text-align: center; margin-bottom: -7px;">Mi�rcoles 7:00 a 8:00pm </p>
					</div>

					<div>
						<!--<img src="demo/3.jpg" alt="picture">
						<p style="text-align: center; margin-bottom: -7px;">Luego viene: </p>-->
						<p style="text-align: center; margin-bottom: -7px;"><strong>Cooperaci�n en acci�n</strong></p>
						<p style="text-align: center; margin-bottom: -7px;">Mar. y Jue. de 7:00 a 8:00pm </p>
					</div>

					<div>
						<!--<img src="demo/2.jpg" alt="picture">
						<p style="text-align: center; margin-bottom: -7px;">Luego viene: </p>-->
						<p style="text-align: center; margin-bottom: -7px;"><strong>Punto Tecnol�gico</strong></p>
						<p style="text-align: center; margin-bottom: -7px;">Mi�rcoles 9:00 a 10:00pm </p>
					</div>
					<div>
						<!--<img src="demo/2.jpg" alt="picture">
						<p style="text-align: center; margin-bottom: -7px;">Luego viene: </p>-->
						<p style="text-align: center; margin-bottom: -7px;"><strong>Liderazgo Motivacional</strong></p>
						<p style="text-align: center; margin-bottom: -7px;">Mar. y Jue 8:00 a 9:00pm </p>
					</div>
					<div>
						<!--<img src="demo/2.jpg" alt="picture">
						<p style="text-align: center; margin-bottom: -7px;">Luego viene: </p>-->
						<p style="text-align: center; margin-bottom: -7px;"><strong>Cl�sicos de Siempre</strong></p>
						<p style="text-align: center; margin-bottom: -7px;">Jueves 9:00 a 10:00pm </p>
					</div>
					<div>
						<!--<img src="demo/2.jpg" alt="picture">
						<p style="text-align: center; margin-bottom: -7px;">Luego viene: </p>-->
						<p style="text-align: center; margin-bottom: -7px;"><strong>Feliz S�bado</strong></p>
						<p style="text-align: center; margin-bottom: -7px;">Viernes 5:30 a 6:30pm </p>
					</div>