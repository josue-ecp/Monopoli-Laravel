<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\PaisesController;
use App\Http\Controllers\DesarrolladoresController;
use App\Http\Controllers\PersonajesController;
use App\Http\Controllers\PlataformasController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\BugsController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\TipopropiedadController;
use App\Http\Controllers\JugadorController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\PropiedadController;
use App\Http\Controllers\PropiedadxjugadorController;
use App\Http\Controllers\BuscadorController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RolxPermisoController;
use App\Http\Controllers\PersonajeController;


/*Route::get('/', function () {
    return view('welcome');
});*/
//Route::get('/', 'LandingController@index');


/*Route::get('/usuarios/insertar', 'UsuariosController@insertar');
Route::get('/usuarios/eliminar', 'UsuariosController@eliminar');
Route::get('/usuarios/editar', 'UsuariosController@editar');
Route::get('/usuarios/listar', 'UsuariosController@listar');*/


/*Route::get('/usuarios',[UsuariosController::class,'index'])->name('index_usuarios');
Route::get('/usuarios/formulario/{id?}',[UsuariosController::class,'formulario']);
//Route::get('/usuarios/save',[UsuariosController::class,'save']);
Route::post('/usuarios/save', [UsuariosController::class, 'save']);*/

//implementacion del candoado
Route::group (['middleware' => 'auth'], function(){

Route::match(array('GET','POST'),'/buscador',[BuscadorController::class,'index']);



Route::get('/permisos',[PermisoController::class,'index'])->name('index_permiso')->middleware('\App\Http\Middleware\Candado2:GEPER');
Route::get('/permisos/formulario/{id?}',[PermisoController::class,'formulario'])->middleware('\App\Http\Middleware\Candado2:GEPER');
//Route::get('/permisos/save',[PermisoController::class,'save'])->middleware('\App\Http\Middleware\Candado2:GEPER');
Route::post('/permisos/save', [PermisoController::class, 'save'])->middleware('\App\Http\Middleware\Candado2:GEPER');

Route::get('/usuario',[UsuariosController::class,'listado'])->name('index_usuarios')->middleware('\App\Http\Middleware\Candado2:GUSU');
Route::get('/usuario/formulario/{id?}',[UsuariosController::class,'formulario'])->middleware('\App\Http\Middleware\Candado2:GUSU');
Route::post('/usuario/save',[UsuariosController::class,'operaciones'])->middleware('\App\Http\Middleware\Candado2:GUSU');








Route::match(array('GET','POST'),'/buscador',[BuscadorController::class,'index'])->middleware('\App\Http\Middleware\Candado2:GEBUS');


Route::get('/propiedad',[PropiedadController::class,'listado'])->name('index_propiedad')->middleware('\App\Http\Middleware\Candado2:GEPRO');
Route::get('/propiedad/formulario/{id?}',[PropiedadController::class,'formulario'])->middleware('\App\Http\Middleware\Candado2:GEPRO');
Route::post('/propiedad/save',[PropiedadController::class,'operaciones'])->middleware('\App\Http\Middleware\Candado2:GEPRO');
Route::get('/propiedad/imagen/{nombre_foto?}',[PropiedadController::class,'mostrar_foto'])->middleware('\App\Http\Middleware\Candado2:GEPRO');
//Route::get('/propiedad/save',[PropiedadController::class,'save']);
//Route::post('/propiedad/save', [PropiedadController::class, 'save']);

Route::get('/jugador',[JugadorController::class,'listado'])->name('index_jugador')->middleware('\App\Http\Middleware\Candado2:GEJU');
Route::get('/jugador/formulario/{id?}',[JugadorController::class,'formulario'])->middleware('\App\Http\Middleware\Candado2:GEJU');
Route::post('/jugador/save',[JugadorController::class,'operaciones'])->middleware('\App\Http\Middleware\Candado2:GEJU');
Route::get('/jugador/imagen/{nombre_foto?}',[JugadorController::class,'mostrar_foto'])->middleware('\App\Http\Middleware\Candado2:GEJU');
//Route::get('/jugador/save',[JugadorController::class,'save'])->middleware('\App\Http\Middleware\Candado2:GEJU');
//Route::post('/jugador/save', [JugadorController::class, 'save'])->middleware('\App\Http\Middleware\Candado2:GEJU');

Route::get('/partida',[PartidaController::class,'index'])->name('index_partida')->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::get('/partida/formulario',[PartidaController::class,'formulario'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::get('/partida/formulario_unir',[PartidaController::class,'formulario_unir'])->middleware('\App\Http\Middleware\Candado2:GEPA');
//Route::get('/partida/save',[PartidaController::class,'save'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::post('/partida/save', [PartidaController::class, 'save'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::post('/partida/iniciar', [PartidaController::class, 'iniciar'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::post('/partida/unir', [PartidaController::class, 'unir'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::post('/partida/continuar', [PartidaController::class, 'continuar'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::post('/partida/jugar_turno', [PartidaController::class, 'jugar_turno'])->middleware('\App\Http\Middleware\Candado2:GEPA');

Route::post('/partida/comprar_propiedad', [PartidaController::class, 'comprar_propiedad'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::post('/partida/pagar_renta', [PartidaController::class, 'pagar_renta'])->middleware('\App\Http\Middleware\Candado2:GEPA');

//nuevo
Route::get('/partida/gestionarPropiedades',[PartidaController::class,'gestionarPropiedades'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::post('/partida/comprarHotel', [PartidaController::class, 'comprarHotel'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::post('/partida/verificarRegionYComprarHotel', [PartidaController::class, 'verificarRegionYComprarHotel'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::post('/partida/comprarRestauranteHotel', [PartidaController::class, 'comprarRestauranteHotel'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::post('/partida/comprarRestaurante', [PartidaController::class, 'comprarRestaurante'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::post('/partida/comprar_Linea_Area', [PartidaController::class, 'comprar_Linea_Area'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::post('/partida/comprar_Embajada', [PartidaController::class, 'comprar_Embajada'])->middleware('\App\Http\Middleware\Candado2:GEPA');
Route::post('/partida/comprar_Consulado', [PartidaController::class, 'comprar_Consulado'])->middleware('\App\Http\Middleware\Candado2:GEPA');
//nuevo




Route::get('/tipopropiedad',[TipopropiedadController::class,'index'])->name('index_tipopropiedad')->middleware('\App\Http\Middleware\Candado2:GETP');
Route::get('/tipopropiedad/formulario/{id?}',[TipopropiedadController::class,'formulario'])->middleware('\App\Http\Middleware\Candado2:GETP');
//Route::get('/tipopropiedad/save',[TipopropiedadController::class,'save'])->middleware('\App\Http\Middleware\Candado2:GETP');
Route::post('/tipopropiedad/save', [TipopropiedadController::class, 'save'])->middleware('\App\Http\Middleware\Candado2:GETP');

Route::get('/region',[RegionController::class,'listado'])->name('index_region')->middleware('\App\Http\Middleware\Candado2:GERE');
Route::get('/region/formulario/{id?}',[RegionController::class,'formulario'])->middleware('\App\Http\Middleware\Candado2:GERE');
Route::post('/region/save',[RegionController::class,'operaciones'])->middleware('\App\Http\Middleware\Candado2:GERE');
Route::get('/region/imagen/{nombre_foto?}',[RegionController::class,'mostrar_foto'])->middleware('\App\Http\Middleware\Candado2:GERE');
//Route::get('/region/save',[RegionController::class,'save']);
//Route::post('/region/save', [RegionController::class, 'save']);


Route::get('/propiedadxjugador',[PropiedadxjugadorController::class,'listado'])->name('index_propiedadxjugador')->middleware('\App\Http\Middleware\Candado2:GEPROJU');
Route::get('/propiedadxjugador/formulario/{id?}',[PropiedadxjugadorController::class,'formulario'])->middleware('\App\Http\Middleware\Candado2:GEPROJU');
Route::post('/propiedadxjugador/save',[PropiedadxjugadorController::class,'operaciones'])->middleware('\App\Http\Middleware\Candado2:GEPROJU');


Route::get('/rol', [RolController::class, 'index'])->name('index_rol')->middleware('\App\Http\Middleware\Candado2:GERO');
Route::get('/rol/permisos/{id}', [RolXPermisoController::class, 'formulario'])->middleware('\App\Http\Middleware\Candado2:GERO');
Route::post('/rol/permisos/save', [RolXPermisoController::class, 'save'])->middleware('\App\Http\Middleware\Candado2:GERO');
Route::get('/rol/formulario/{id?}', [RolController::class, 'formulario'])->middleware('\App\Http\Middleware\Candado2:GERO');
Route::post('/rol/save', [RolController::class, 'save'])->middleware('\App\Http\Middleware\Candado2:GERO');

Route::get('/sinpermiso',function(){

    return view('sinpermiso');
})->name('sinpermiso');

});






//semestre pasado/////////////////////////////////////////////////////////////////////////////////////////////////









//rutas de paises
Route::get('/paises',[PaisesController::class,'index'])->name('index_paises');
Route::get('/paises/formulario/{id?}',[PaisesController::class,'formulario']);
//Route::get('/paises/save',[PaisesController::class,'save']);
Route::post('/paises/save', [PaisesController::class, 'save']);


Route::get('/desarrolladores',[DesarrolladoresController::class,'index'])->name('index_desarrolladores');
Route::get('/desarrolladores/formulario/{id?}',[DesarrolladoresController::class,'formulario']);
//Route::get('/desarrolladores/save',[DesarrolladoresController::class,'save']);
Route::post('/desarrolladores/save', [DesarrolladoresController::class, 'save']);


Route::get('/productos', [ProductosController::class, 'index'])->name('index_productos');
Route::get('/productos/formulario/{id?}', [ProductosController::class, 'formulario']);
Route::post('/productos/save', [ProductosController::class, 'save']);


Route::get('/personajes', [PersonajesController::class, 'index'])->name('index_personajes');
Route::get('/personajes/formulario/{id?}', [PersonajesController::class, 'formulario']);
Route::post('/personajes/save', [PersonajesController::class, 'save']);

Route::get('/plataformas', [PlataformasController::class, 'index'])->name('index_plataformas');
Route::get('/plataformas/formulario/{id?}', [PlataformasController::class, 'formulario']);
Route::post('/plataformas/save', [PlataformasController::class, 'save']);

Route::get('/items', [ItemsController::class, 'index'])->name('index_items');
Route::get('/items/formulario/{id?}', [ItemsController::class, 'formulario']);
Route::post('/items/save', [ItemsController::class, 'save']);

Route::get('/landing', [LandingController::class, 'index']);



Route::get('/bugs',[BugsController::class,'index'])->name('index_bugs');
Route::get('/bugs/formulario/{id?}',[BugsController::class,'formulario']);
//Route::get('/bugs/save',[BugsController::class,'save']);
Route::post('/bugs/save', [BugsController::class, 'save']);

Route::get('/proveedores',[ProveedoresController::class,'index'])->name('index_proveedores');
Route::get('/proveedores/formulario/{id?}',[ProveedoresController::class,'formulario']);
//Route::get('/proveedores/save',[ProveedoresController::class,'save']);
Route::post('/proveedores/save', [ProveedoresController::class, 'save']);

Route::get('/personaje',[PersonajeController::class,'index'])->name('index_personaje');
Route::get('/personaje/formulario/{id?}',[PersonajeController::class,'formulario']);
//Route::get('/personaje/save',[PersonajeController::class,'save']);
Route::post('/personaje/save', [PersonajeController::class, 'save']);

//Semestre 4 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//Prueva de la plantilla 


Route::get('/test_plantilla',function(){

    return view('app.master');
});







/*Route::get('/propiedadxjugador',[PropiedadxjugadorController::class,'listado'])->name('index_propiedadxjugador');
Route::get('/propiedadxjugador/formulario/{id?}',[PropiedadxjugadorController::class,'formulario']);
Route::post('/propiedadxjugador/save',[PropiedadxjugadorController::class,'operaciones']);*/

//Route::get('/propiedadxjugador/save',[PropiedadxjugadorController::class,'save']);
//Route::post('/propiedadxjugador/save', [PropiedadxjugadorController::class, 'save']);



Route::get('/registrate',[JugadorController::class,'registrate'])->name('index');
Route::post('/autoregistro/save',[JugadorController::class,'autoregistro']);

Route::get('/login',[LoginController::class,'index'])->name('login');
Route::get('/',[LoginController::class,'index']);
Route::get('/error',[LoginController::class,'login']);
Route::get('/home/jugador',[JugadorController::class,'home'])->name('home_jugador');
Route::get('/home/administrador',[UsuariosController::class,'home'])->name('home_administrador');
Route::get('/logout',[LoginController::class,'cerrar_sesion'])->name('cerrar_sesion');
Route::post('/login/save',[LoginController::class,'login']);
