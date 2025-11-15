<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // Formulário para pedir o email
    public function requestForm()
    {
        return view('auth.forgot-password');
    }

    // Enviar e-mail com o token
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email não encontrado.');
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        $resetLink = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        // Enviar e-mail simples
        Mail::raw("Clique no link para redefinir a sua senha:\n\n $resetLink", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Redefinição de senha');
        });

        return back()->with('success', 'Enviamos um link para o seu email.');
    }

    // Formulário para redefinir senha
    public function resetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    // Atualizar senha
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$tokenData) {
            return back()->with('error', 'Token inválido ou expirado.');
        }

        // Atualiza a senha
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Remove o token usado
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect('/login')->with('success', 'Senha alterada com sucesso!');
    }
}
