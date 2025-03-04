<?php
namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;
use Mail;
class AuthController extends Controller
{
    //Muestra la vista de acceso o login
    public function acceder()
    {
        return view('auth.acceso');
    }

    //Autentica al usuario
    public function autenticar(Request $request)
    {
        //Validación de datos (incluyendo la de activo)
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $credentials['activo'] = 1;
        //Si es correcto, inicio sesión y login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success','Hola chef espero que encuentres una receta ideal' );
        }

        //Si no, muestro mensaje de error
        return back()->withErrors([
            'email' => 'El email no está registrado.',
        ]);
    }
    //Muestra la vista de registro
    public function registro()
    {
        return view('auth.registro');
    }
    //Registra al usuario
    public function registrarse(Request $request)
{
    // Validation
    $request->validate([
        'usuario' => 'required|unique:usuarios',   // Ensure the username is unique
        'nombre' => 'required',
        'email' => 'required|email|unique:usuarios',
        'password' => 'required|confirmed|min:6',
        'perfilimg' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
    ]);

    // Collect form data
    $data = $request->all();

    // Handle image upload if exists
    if ($request->hasFile('perfilimg')) {
        $archivo = $request->file('perfilimg');
        $nombre = time() . '-' . $archivo->getClientOriginalName();

        // Move the image to the 'img' directory
        $archivo->move(public_path('img'), $nombre);
        $data['perfilimg'] = $nombre; // Store image name in the database
    } else {
        // If no image is uploaded, use a default image
        $data['perfilimg'] = 'chef.png';
    }

    // Create the new user
    $usuario = Usuario::create([
        'nombre' => $data['nombre'],
        'email' => $data['email'],
        'usuario' => $data['usuario'],
        'perfilimg' => $data['perfilimg'], // Store the image name
        'password' => Hash::make($data['password']),
    ]);

    // Login the user after registration
    Auth::login($usuario);

    // Redirect with success message
    return redirect("/")->with('success', 'Te has registrado correctamente. Bienvenido');
}
    //Salir del panel de administración
    public function salir(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('acceder')->with('success','Hasta pronto');
    }

    //Muestro el formulario para introducir el email
    public function email()
    {
        return view('auth.email');
    }

    //Genero y envío el enlace para restaurar la clave
    public function enlace(Request $request)
    {
        //Validación de email
        $request->validate([
            'email' => 'required|email|exists:usuarios',
        ]);
        //Generación de token y almacenado en la tabla password_resets
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        //Envío de email al usuario
        Mail::send('email.email', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Cambiar contraseña en CMS Laravel');
        });

        //Retorno
        return redirect('acceder')->with('success','Te hemos enviado un email a <strong>'.$request->email.'</strong> con un enlace para realizar el cambio de contraseña.');
    }

    //Muestro el formulario para cambiar la clave
    public function clave($token)
    {
        return view('auth.clave', ['token' => $token]);
    }
    //cambio la clave
    public function cambiar(Request $request)
    {
        //Valido datos
        $request->validate([
            'email' => 'required|email|exists:usuarios',
            'password' => 'required|min:8|max:16|confirmed',
            'password_confirmation' => 'required'
        ]);

        //Compruebo token válido
        $comprobarToken = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();
        if(!$comprobarToken){
            return back()->withInput()->with('danger','El enlace no es válido');
        }
        //Actualizo password
        Usuario::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        //Borro token para que no se pueda volver a usar
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        //Retorno
        return redirect('acceder')->with('success','La contraseña se ha cambiado correctamente.');
    }
}
