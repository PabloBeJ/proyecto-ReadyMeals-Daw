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
        $row = Usuario::create([
            'usuario' => $request->usuario,
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
            $archivo->move(public_path() . "/img/", $nombre);
            Usuario::where('id', $row->id)->update(['perfilimg' => $nombre]);
            $texto = " e imagen subida.";
        } else {
            $texto = "Hola";
        }
        return redirect('admin/usuarios')->with('success', 'Usuario <strong>' . $request->nombre . 'Archivo de imagen' . $archivo . '</strong> creado </strong> guardada' . $texto);
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
        $row = Usuario::findOrFail($id);
        if ($request->cambiar_clave == "on") {
            // Set a variable to track the error message
            $errorMessage = null;
            // Check if the old password matches the current password in the database
            switch (true) {
                case !Hash::check($request->password, $row->password):
                    $errorMessage = 'Contraseña incorrecta';
                    break;

                // Check if the new password is at least 8 characters
                case strlen($request->new_password) < 8:
                    $errorMessage = 'La nueva contraseña debe tener al menos 8 caracteres';
                    break;

                // Ensure the new password matches the confirmation password
                case $request->new_password !== $request->password_confirmation:
                    $errorMessage = 'Las contraseñas no coinciden';
                    break;

                // Ensure the new password is different from the old password
                case $request->old_password === $request->new_password:
                    $errorMessage = 'La nueva contraseña debe ser diferente de la anterior';
                    break;
            }

            // If there's an error message, return redirect with the danger message
            if ($errorMessage) {
                return redirect('admin/usuarios/editar/' . $row->id)->with('danger', $errorMessage);
            }
            // If no errors, proceed with updating the password
            $row->password = Hash::make($request->new_password);
            $row->save();
            return redirect('admin/usuarios/editar/' . $row->id)->with('success', 'Contraseña actualizada exitosamente');
        }
        Usuario::where('id', $row->id)->update([
            'usuario' => $request->usuario,
            'nombre' => $request->nombre,
            'email' => $request->email,
            'usuarios' => ($request->usuarios) ? 1 : 0,
            'comidas' => ($request->comidas) ? 1 : 0,
        ]);
        //Imagen
        if ($request->hasFile('perfilimg')) {
            $archivo = $request->file('perfilimg');
            $nombre = $archivo->getClientOriginalName();
            $archivo->move(public_path() . "/img/", $nombre);
            Usuario::where('id', $row->id)->update(['perfilimg' => $nombre]);
            $texto = " e imagen subida.";
        } else {
            $texto = ".";
        }

        return redirect('admin/usuarios/editar/' . $row->id)->with('success', 'Usuario <strong>' . $request->usuario . '</strong> guardado' . $texto);
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

        $imagen = public_path() . "/img/" . $row->perfilimg;
        if (file_exists($imagen)) {
            unlink($imagen);
        }
        Usuario::destroy($row->id);
        return redirect('/')->with('success', 'Usuario <strong>' . $row->nombre . '</strong> `se ha borrado hasta la proxima');
    }
}
