<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserSettingsController extends Controller
{
    public function NewPassword()
    {
        return view('configure_user_profile');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $userEmail = $user->email;
        $userPassword = $user->password;

        if ($request->password_actual != "") {
            $newPass = $request->password;
            $confirmPass = $request->confirm_password;
            $name = $request->name;

            // Verifico si la clave actual es igual a la clave del usuario en sesión
            if (password_verify($request->password_actual, $userPassword)) {

                // Valido que tanto la nueva contraseña como la confirmación sean iguales
                if ($newPass == $confirmPass) {
                    // Valido que la contraseña no sea menor a 6 caracteres
                    if (strlen($newPass) >= 6) {
                        $user->password = bcrypt($request->password);
                        $sqlBD = DB::table('users')
                            ->where('id', $user->id)
                            ->update(['password' => $user->password, 'name' => $name]);

                        return redirect()->back()->with('updateClave', 'La contraseña fue cambiada correctamente.');
                    } else {
                        return redirect()->back()->with('clavemenor', 'Recuerda que la contraseña debe tener al menos 6 caracteres.');
                    }
                } else {
                    return redirect()->back()->with('claveIncorrecta', 'Por favor, verifica que las contraseñas coincidan.');
                }
            } else {
                return back()->withErrors(['password_actual' => 'La contraseña no coincide']);
            }
        } else {
            $name = $request->name;
            $sqlBDUpdateName = DB::table('users')
                ->where('id', $user->id)
                ->update(['name' => $name]);
            return redirect()->back()->with('name', 'El nombre fue cambiado correctamente.');
        }
    }
}
