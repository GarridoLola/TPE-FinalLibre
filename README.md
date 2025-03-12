# NutriAPP

## Descripción
El objetivo de este proyecto es desarrollar una página web que permita gestionar y visualizar información sobre grupos de alimentos y los alimentos que pertenecen a cada grupo, incluyendo detalles sobre su información nutricional. El sistema está diseñado para facilitar tanto la navegación pública como la gestión interna de los datos.

En este modelo, implementamos una relación de 1 a N entre grupos alimenticios y alimentos, o que significa que un grupo alimenticio puede contener varios alimentos, pero cada alimento pertenece a un único grupo.

### Usuarios no logueados:
Los usuarios que no inicien sesión podrán acceder únicamente a las secciones públicas de la página, que incluyen Home, Grupos de Alimentos y Alimentos. Tendrán la posibilidad de visualizar los detalles de cada grupo y sus alimentos, pero no podrán acceder a la sección administrativa. Para ello, será necesario iniciar sesión.

### Usuarios logueados:
Los usuarios registrados podrán ingresar a la sección de administración, donde podrán agregar, eliminar o modificar tanto los grupos de alimentos como los alimentos dentro de cada grupo. Además, podrán editar la información nutricional de cada alimento.

## Acceso administrador de datos:
    * Usuario: webadmin    
    * Contraseña: admin

## DER
![Diagrama Entidad Relación](/der.png)

### Despliegue del sitio (servidor Apache y MySQL):
Para desplegar el sitio web en un servidor con Apache y MySQL, lo primero que hay que hacer es clonar el repositorio git. Una vez que tenga el proyecto en el servidor, es necesario configurar la base de datos. Para eso, hay que importar en phpMyAdmin el archivo nutri_db.sql que se encuentra en la carpeta "nutriAPP", contiene la estructura y los datos iniciales de la base de datos.

Desde el sitio web, podrás gestionar los datos de los grupos de alimentos y los alimentos. Después de realizar los cambios necesarios, podrás cerrar sesión y volver al acceso público, donde los cambios se reflejarán de inmediato. 


## API REST

* Para esta sección, se utilizará la tabla de "Alimentos".

### Documentación de los Endpoints:
* Para obtener una lista de todos los alimentos existentes, utilizamos el verbo 'GET'. 
GET https://localhost/nutriAPP/API_REST/api/alimentos

* Para obtener un alimento en específico, utilizamos 'GET' junto con su ID. 
GET https://localhost/nutriAPP/API_REST/api/alimentos/{id}

* Para eliminar un alimento, utilizamos 'DELETE', agregándole el ID de dicho alimento. Ejemplo: DELETE https://localhost/nutriAPP/API_REST/api/alimentos/{id}


* Para agregar un alimento, utilizamos  'POST'. La información debe enviarse en formato JSON a través del body de la solicitud. 
POST https://localhost/nutriAPP/API_REST/api/alimentos

Ejemplo a insertar:

{

    "nombre_alimento": "Tomate",
    "ID_grupos": 12,
    "descripcion_alimento": "Los tomates son nutritivos y muy poco calóricos. Contienen grandes cantidades de vitamina C y ácido fólico.",
    "calorias": "22.00",
    "proteinas": "1.00",
    "carbohidratos": "3.50",
    "fibra": "1.40",
    "grasas": "0.11",
    "imagen_alimento": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRA7zTyW2YGgBcOP96ibWgtPBi3-44FGhcweQ&s"
}

* Para editar un alimento existente, utilizamos 'PUT'. 
La información debe ser enviada en formato JSON a través del body de la solicitud y debemos indicar el ID del alimento a modificar.
PUT https://localhost/nutriAPP/API_REST/api/alimentos/{id}

Ejemplo a insertar:

{

    "nombre_alimento": "Espinaca",
    "ID_grupos": 12,
    "descripcion_alimento": "La espinaca es una planta de hojas verdes, comestible y rica en nutrientes. Se consume tanto cruda como cocida y es conocida por su alto contenido de vitaminas A, C, K, ácido fólico, hierro y fibra. Es un alimento muy versátil, usado en ensaladas, sopas, ",
    "calorias": "23.00",
    "proteinas": "2.90",
    "carbohidratos": "3.60",
    "fibra": "2.20",
    "grasas": "0.40",
    "imagen_alimento": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSoVpyEvllMB2Wrj4Yeuu1FBdruHNBndnH8Vw&s"
}

* Para ordenar los alimentos, utilizamos 'GET', con los parámetros 'orderBy' (para especificar el campo de ordenamiento, como calorías, proteínas o ID_grupos) y 'orderDirection'(para definir el sentido del orden: 'ASC' para ascendente o 'DESC' para descendente).

*Nota: 'ASC' es la forma predeterminada.*

Ejemplo: 'GET' https://localhost/nutriAPP/API_REST/api/alimentos?orderBy=calorias

'GET' https://localhost/nutriAPP/API_REST/api/alimentos?orderBy=calorias&orderDirection=DESC

* Para filtrar los alimentos por un campo especifíco, utilizamos los parámetos 'filtro' (nombre del campo) y 'valor' (dato a buscar en el campo indicado).

*Nota: 'valor' debe tener el formato "0.00" (decimal) y ser mayor que 0.*

Ejemplo: utilizamos el verbo 'GET'.

'filtro' = proteinas, 'valor' = 6.64

https://localhost/nutriAPP/API_REST/api/alimentos?filtro=proteinas&valor=6.64 Obtiene todos los alimentos cuyo campo "proteinas" tenga el valor "6.64".

* Para paginar los resultados, utilizamos 'pagina' (número de página, por defecto 1) y 'limite' (cantidad máxima de alimentos por página). 

Ejemplo: utilizamos el verbo 'GET'

'pagina' = 1, 
'limite' = 5

https://localhost/nutriAPP/API_REST/api/alimentos?pagina=1&limite=5 Obtiene los primeros 5 alimentos disponibles.

* Autenticación: 
Para acceder a recursos protegdos, los usuarios deben autenticarse mediante un token:

GET https://localhost/nutriAPP/API_REST/api/user/token 
Este endpoint proporciona un token JWT a los usuarios que envíen sus credenciales en el encabezado de la solicitud, codificadas en Base64.
Si las credenciales son válidas, devuelve un token JWT para ser utilizado para autenticar futuras solicitudes. 

*Nombre de usuario:* webadmin
*Contraseña:* admin