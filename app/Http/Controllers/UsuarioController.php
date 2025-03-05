<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Comida;
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

        // Start with validation for password if it's marked for change
        $errorMessage = null;

        // Validate password only if it's being changed
        if ($request->cambiar_clave == "on") {
            // Check if old password is correct
            if (!Hash::check($request->password, $row->password)) {
                $errorMessage = 'Contraseña incorrecta';
            }
            // Check if new password is at least 8 characters
            elseif (strlen($request->new_password) < 8) {
                $errorMessage = 'La nueva contraseña debe tener al menos 8 caracteres';
            }
            // Check if new password matches confirmation
            elseif ($request->new_password !== $request->password_confirmation) {
                $errorMessage = 'Las contraseñas no coinciden';
            }
            // Ensure new password is different from old password
            elseif ($request->old_password === $request->new_password) {
                $errorMessage = 'La nueva contraseña debe ser diferente de la anterior';
            }
        }

        // If there's an error with password, return with error message and don't proceed
        if ($errorMessage) {
            return redirect('admin/usuarios/editar/' . $row->id)->with('danger', $errorMessage);
        }

        // Now validate other fields: email, name, and image
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return redirect('admin/usuarios/editar/' . $row->id)->with('danger', 'Email no válido');
        }

        // If there's a file, validate image
        if ($request->hasFile('perfilimg') && !$request->file('perfilimg')->isValid()) {
            return redirect('admin/usuarios/editar/' . $row->id)->with('danger', 'Error al cargar la imagen');
        }

        // Now, if no errors, proceed with updating the user info
        // First, update the password if it was changed and validated
        if ($request->cambiar_clave == "on") {
            $row->password = Hash::make($request->new_password);
        }

        // Update other fields (name, email, etc.)
        $row->usuario = $request->usuario;
        $row->nombre = $request->nombre;
        $row->email = $request->email;
        $row->usuarios = ($request->usuarios) ? 1 : 0;
        $row->comidas = ($request->comidas) ? 1 : 0;

        // Handle image upload if there's a file
        if ($request->hasFile('perfilimg')) {
            $archivo = $request->file('perfilimg');
            $nombre = $archivo->getClientOriginalName();
            $archivo->move(public_path() . "/img/", $nombre);
            $row->perfilimg = $nombre;
        }
        // Save the updated user data
        $row->save();

        // Redirect with success message
        return redirect('admin/usuarios/editar/' . $row->id)
            ->with('success', 'Usuario <strong>' . $request->usuario . '</strong> guardado correctamente');
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
        // Find the user by ID
        $row = Usuario::findOrFail($id);
        // Skip the password check for admins (if the current user is not an admin)
        if (!auth()->user()->usuarios) {
            // Manually check the password without using the request validation
            if (!request()->has('password') || !Hash::check(request()->password, $row->password)) {
                return redirect()->back()->with('danger', 'Contraseña incorrecta, no se eliminó la cuenta.');
            }
        }

        // Delete user's comidas
        Comida::where('autor', $row->id)->delete();

        // Delete profile image if it's not the default one
        $imagen = public_path() . "/img/" . $row->perfilimg;
        if ($row->perfilimg && file_exists($imagen) && basename($imagen) !== 'chef.png') {
            unlink($imagen);
        }

        // Delete the user
        Usuario::destroy($row->id);

        return redirect('/')->with('success', 'Una pena usuario <strong>' . $row->nombre . '</strong> y todas sus comidas han sido eliminadas.');
    }

}
