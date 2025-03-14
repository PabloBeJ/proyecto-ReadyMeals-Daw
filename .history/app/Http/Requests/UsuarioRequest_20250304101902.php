<?php


namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UsuarioRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a hacer este request
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }
    /**
     * Obtiene las reglas de validación para este request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        //Nombre requerido y máximo 255 caracteres
        //Email requerido, válido, único en la tabla usuarios y máximo 255 caracteres
        $rules = [
            'usuario' => 'required|max:255',
            'nombre' => 'required|max:255',
            'email' => 'required|regex:/^.+@.+$/i|unique:usuarios,email,'.$request->id.'|max:255',
        ];
        //Si estoy cambiando la clave (o es nuevo), password requerido y entre 8 y 16 caracteres
        if ($request->cambiar_clave) {
            $rules['password'] = 'required|min:8|max:16';
        }



        return $rules;


    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        Log::debug('Validation errors: ', $validator->errors()->toArray());
        parent::failedValidation($validator);
    }

}
