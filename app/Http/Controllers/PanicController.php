<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Panic;
use App\Mail\PanicMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\SendPanicAlertJob;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PanicController extends Controller
{



    public function sendPanic(Request $request)
    {
        if (!auth()->check()) {
            $this->sendMessage("Authentication attempt fails!");
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'longitude' => 'required|string',
            'latitude' => 'required|string',
            'panic_type' => 'nullable|string',
            'details' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            $this->sendMessage("failure while submitting data: " . json_encode($validator->errors()));
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $panic = Panic::create([
                'user_id' => auth()->id(),
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'panic_type' => $request->panic_type,
                'reference_id' => Str::random(4),
                'user_name' => auth()->user()->name,
                'details' => $request->details,
                'status' => true,
            ]);

            SendPanicAlertJob::dispatch($panic);

            return response()->json([
                'status' => 'success',
                'message' => 'Panic raised successfully',
                'data' => $panic
            ], 200);
        } catch (\Exception $e) {
            $this->sendMessage("Internal server error: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getPanic()
    {
        if (!auth()->check()) {
            $this->sendMessage("Tentative d'accès non autorisée à la liste des paniques !");
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        try {
            $panics = Panic::with('user:id,name,email')->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Action completed successfully',
                'data' => [
                    'panics' => $panics
                ]
            ], 200);
        } catch (\Exception $e) {
            $this->sendMessage("Internal server error : " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cancelPanic($id)
    {
        if (!auth()->check()) {
            $this->sendMessage("Authentication attempt fails!");
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }

        try {
            $panic = Panic::findOrFail($id);
            $panic->status = false;
            $panic->save();

            // Envoi d'un e-mail pour informer de l'annulation
            $this->sendMessage("Panic alert with ID $id was canceled by " . auth()->user()->name);

            return response()->json([
                'status' => 'success',
                'message' => 'Panic canceled successfully.',
                'data' => $panic,
            ], 200);
        } catch (\Exception $e) {
            $this->sendMessage("Internal server error: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    private function sendMessage($message)
    {
        $email = "fuseboxtest01@gmail.com";

        Mail::to($email)->send(new PanicMail($message));
    }
}
