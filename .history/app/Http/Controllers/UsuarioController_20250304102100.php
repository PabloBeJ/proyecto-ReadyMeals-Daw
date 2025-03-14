<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Http\Requests\UsuarioRequest;
class UsuarioController extends Controller
{
    public function __construct()
    {
        /**
         * Asigno el middleware auth al controlador,
         * de modo que sea necesario estar al menos autenticado
         */
        $this->middleware('auth');
    }
    /**
     * Mostrar un listado de elementos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Obtengo todos los usuarios ordenados por nombre
        $rowset = Usuario::orderBy("nombre", "ASC")->get();

        return view('admin.usuarios.index', [
            'rowset' => $rowset,
        ]);
    }
    /**
     * Mostrar el formulario para crear un nuevo elemento
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        //Creo un nuevo usuario vacío
        $row = new Usuario();
        return view('admin.usuarios.editar', [
            'row' => $row,
        ]);
    }
    /**
     * Guardar un nuevo elemento en la bbdd
     *
     * @param \App\Http\Requests\UsuarioRequest $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(UsuarioRequest $request)
    {
        $row =   Usuario::create([
            'usuario'=> $request-> usuario,
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usuarios' => ($request->usuarios) ? 1 : 0,
            'comidas' => ($request->comidas) ? 1 : 0,
        ]);

        //Imagen
        if ($request->hasFile('perfilimg')) {
            $archivo = $request->file('perfilimg');
            $nombre = $archivo->getClientOriginalName();
            $archivo->move(public_path()."/img/", $nombre);
            Usuario::where('id', $row->id)->update(['perfilimg' => $nombre]);
            $texto = " e imagen subida.";
        }
        else{
            $texto = "Hola";
        }
        return redirect('admin/usuarios')->with('success', 'Usuario <strong>' . $request->nombre  .'Archivo de imagen'.$archivo . '</strong> creado </strong> guardada'.$texto );
    }
    /**
     * Mostrar el formulario para editar un elemento
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
        //Obtengo el usuario o muestro error
        $row = Usuario::where('id', $id)->firstOrFail();

        return view('admin.usuarios.editar', [
            'row' => $row,
        ]);


    }
    /**
     * Actualizar un elemento en la bbdd
     *
     * @param \App\Http\Requests\UsuarioRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function actualizar(UsuarioRequest $request, $id)
    {

    if ($request->fails()) {

          // Stop execution with an error
          abort(400, 'Validation failed. Check logs for more details.');

        Log::debug('Validation errors: ', $request->errors()->toArray());
    }

        $row = Usuario::findOrFail($id);

        Usuario::where('id', $row->id)->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => ($request->cambiar_clave) ? Hash::make($request->password) : $row->password,
            'usuarios' => ($request->usuarios) ? 1 : 0,
            'comidas' => ($request->comidas) ? 1 : 0,
        ]);
        //Imagen
        if ($request->hasFile('perfilimg')) {
            $archivo = $request->file('perfilimg');
            $nombre = $archivo->getClientOriginalName();
            $archivo->move(public_path()."/img/", $nombre);
            Usuario::where('id', $row->id)->update(['perfilimg' => $nombre]);
            $texto = " e imagen subida.";
        }else{
            $texto = ".";
        }

        return redirect('admin/usuarios/editar/'.$row->id)->with('success', 'Usuario <strong>' . $request->usuario . '</strong> guardado'.$texto);
    }

    /**
     * Activar o desactivar elemento.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function activar($id)
    {
        $row = Usuario::findOrFail($id);
        $valor = ($row->activo) ? 0 : 1;
        $texto = ($row->activo) ? "desactivado" : "activado";
        Usuario::where('id', $row->id)->update(['activo' => $valor]);
        return redirect('admin/usuarios')->with('success', 'Usuario <strong>' . $row->name . '</strong> ' . $texto . '.');
    }
    /**
     * Borrar elemento.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function borrar($id)
    {
        $row = Usuario::findOrFail($id);
        Usuario::destroy($row->id);
        return redirect('admin/usuarios')->with('success', 'Usuario <strong>' . $row->nombre . '</strong> borrado');
    }
}
