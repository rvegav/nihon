<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//mantenimiento
$route['ciudades'] = 'ciudades/Ciudades';
$route['add_ciudad'] = 'ciudades/Ciudades/add';
$route['edit_ciudad/(:num)'] = 'ciudades/Ciudades/edit/$1';
$route['delete_ciudad/(:num)'] = 'ciudades/Ciudades/delete/$1';
$route['update_ciudad'] = 'ciudades/Ciudades/update';
$route['store_ciudad'] = 'ciudades/Ciudades/store';

$route['proveedores'] = 'proveedores/Proveedores';
$route['add_proveedor'] = 'proveedores/Proveedores/add';
$route['edit_proveedor/(:num)'] = 'proveedores/Proveedores/edit/$1';
$route['delete_proveedor/(:num)'] = 'proveedores/Proveedores/delete/$1';
$route['update_proveedor'] = 'proveedores/Proveedores/update';
$route['store_proveedor'] = 'proveedores/Proveedores/store';

$route['productos'] = 'productos/Productos';
$route['add_producto'] = 'productos/Productos/add';
$route['edit_producto/(:num)'] = 'productos/Productos/edit/$1';
$route['delete_producto/(:num)'] = 'productos/Productos/delete/$1';
$route['update_producto'] = 'productos/Productos/update';
$route['store_producto'] = 'productos/Productos/store';

$route['tipo_productos'] = 'tipo_productos/Tipos_Productos';
$route['add_tipo_producto'] = 'tipo_productos/Tipos_Productos/add';
$route['edit_tipo_producto/(:num)'] = 'tipo_productos/Tipos_Productos/edit/$1';
$route['delete_tipo_producto/(:num)'] = 'tipo_productos/Tipos_Productos/delete/$1';
$route['update_tipo_producto'] = 'tipo_productos/Tipos_Productos/update';
$route['store_tipo_producto'] = 'tipo_productos/Tipos_Productos/store';

$route['personas'] = 'personas/Personas';
$route['add_persona'] = 'personas/Personas/add';
$route['edit_persona/(:num)'] = 'personas/Personas/edit/$1';
$route['delete_persona/(:num)'] = 'personas/Personas/delete/$1';
$route['update_persona'] = 'personas/Personas/update';
$route['store_persona'] = 'personas/Personas/store';

$route['clientes'] = 'clientes/Clientes';
$route['add_cliente'] = 'clientes/Clientes/add';
$route['edit_cliente/(:num)'] = 'clientes/Clientes/edit/$1';
$route['delete_cliente/(:num)'] = 'clientes/Clientes/delete/$1';
$route['update_cliente'] = 'clientes/Clientes/update';
$route['store_cliente'] = 'clientes/Clientes/store';

$route['especies'] = 'especies/Especies';
$route['add_especie'] = 'especies/Especies/add';
$route['edit_especie/(:num)'] = 'especies/Especies/edit/$1';
$route['delete_especie/(:num)'] = 'especies/Especies/delete/$1';
$route['update_especie'] = 'especies/Especies/update';
$route['store_especie'] = 'especies/Especies/store';

$route['razas'] = 'razas/Razas';
$route['add_raza'] = 'razas/Razas/add';
$route['edit_raza/(:num)'] = 'razas/Razas/edit/$1';
$route['delete_raza/(:num)'] = 'razas/Razas/delete/$1';
$route['update_raza'] = 'razas/Razas/update';
$route['store_raza'] = 'razas/Razas/store';

//control de stock

$route['stock'] = 'control_stock/Control_Stock';
$route['add_producto_stock'] = 'control_stock/Control_Stock/add';
$route['edit_producto_stock/(:num)'] = 'control_stock/Control_Stock/edit/$1';
$route['update_producto_stock'] = 'control_stock/Control_Stock/update';
$route['store_producto_stock'] = 'control_stock/Control_Stock/store';

//seguridad

$route['roles'] = 'roles/Roles';
$route['add_roles'] = 'roles/Roles/add';
$route['edit_roles/(:num)'] = 'roles/Roles/edit/$1';
$route['delete_roles/(:num)'] = 'roles/Roles/delete/$1';
$route['update_roles'] = 'roles/Roles/update';
$route['store_roles'] = 'roles/Roles/store';
$route['usuarios'] = 'usuarios/Usuarios';
