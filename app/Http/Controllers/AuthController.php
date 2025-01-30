<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Valider les données envoyées dans la requête
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Retourner les erreurs de validation si elles existent
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Validation failure',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Vérifier les identifiants de l'utilisateur
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Récupérer l'utilisateur authentifié
            $user = Auth::user();

            // Créer un token avec Laravel Passport
            $token = $user->createToken('token')->accessToken;

            // Retourner une réponse avec le token
            return response()->json([
                'status' => 'success',
                'message' => 'Action completed successfully',
                'data' => [
                    'api_access_token' => $token,
                ],
            ], 200);
        } else {
            // Si les identifiants sont invalides
            return response()->json([
                'status' => 'failure',
                'message' => 'Invalid email or password',
            ], 401);
        }
    }
}
