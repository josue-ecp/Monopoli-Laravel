<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class Candado2
{
       /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $clave)
    {

        //dd('Hola des el candado2');
        // Hacer la logica para determinar si un usuario

        /**
         * select usuario.email
         *      ,permiso.nombre
         *      ,permiso.clave
         *      ,permiso.id as idpermiso
         *      ,rol.nombre as nombrerol
         * from usuario
         * join rol on rol.id=usuario.idrol
         * join rolxpermiso on rol.id=rolxpermiso.idrol
         * join permiso on rolxpermiso.idpermiso=permiso.id
         * where usuario.id=2
         * and permiso.clave='GUSU'
         */

        // 1.- Recupero el usuario que inicio sesion
        $usuario = Auth::user();
        
        $validacion = DB::table('usuario')
            ->join('rol', 'rol.id', '=', 'usuario.idrol')
            ->join('rolxpermiso', 'rol.id', '=', 'rolxpermiso.idrol')
            ->join('permiso', 'rolxpermiso.idpermiso', '=', 'permiso.id')
            ->select(
                'usuario.email',
                'permiso.nombre',
                'permiso.clave',
                'permiso.id as idpermiso',
                'rol.nombre as nombrerol'
            )
            ->where('usuario.id', $usuario->id)
            ->where('permiso.clave', '=', $clave)
            ->first();
          

        if ($validacion) {
            // Tiene un permiso en especifico
            // Si tiene el permiso ejecuta la línea de abajo
            return $next($request);
        } else {

            
            return redirect()->route('sinpermiso');
        }

        // Si no tiene entonces hacer otra cosa*/
        return $next($request);
    }

}
