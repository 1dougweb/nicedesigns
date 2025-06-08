<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Helpers\DocumentValidator;

class ProfileController extends Controller
{
    /**
     * Display the admin profile page
     */
    public function index(): View
    {
        $user = Auth::user();
        
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update the admin profile
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'full_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'person_type' => 'nullable|in:fisica,juridica',
            'document' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $request->has('person_type') && $request->input('person_type')) {
                        $personType = $request->input('person_type');
                        $document = preg_replace('/\D/', '', $value);
                        
                        if ($personType === 'fisica') {
                            if (!DocumentValidator::validateCPF($document)) {
                                $fail('O CPF informado é inválido.');
                            }
                        } elseif ($personType === 'juridica') {
                            if (!DocumentValidator::validateCNPJ($document)) {
                                $fail('O CNPJ informado é inválido.');
                            }
                        }
                    }
                },
            ],
            'phone' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'address_number' => 'nullable|string|max:20',
            'address_complement' => 'nullable|string|max:100',
            'neighborhood' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:2',
            'country' => 'nullable|string|max:100',
            'company_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        // Limpar formatação dos campos - usando apenas campos que existem na validação
        $data = $request->only([
            'name', 'full_name', 'email', 'person_type', 'document', 'phone', 'whatsapp',
            'zip_code', 'address', 'address_number', 'address_complement', 'neighborhood',
            'city', 'state', 'country', 'company_name', 'position', 'bio'
        ]);

        // Limpar formatação apenas se os campos existirem e não estiverem vazios
        if (!empty($data['document'])) {
            $data['document'] = preg_replace('/\D/', '', $data['document']);
        }
        if (!empty($data['phone'])) {
            $data['phone'] = preg_replace('/\D/', '', $data['phone']);
        }
        if (!empty($data['whatsapp'])) {
            $data['whatsapp'] = preg_replace('/\D/', '', $data['whatsapp']);
        }
        if (!empty($data['zip_code'])) {
            $data['zip_code'] = preg_replace('/\D/', '', $data['zip_code']);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            // Delete old avatar if it exists and is a local file
            if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        } else {
            // Remove avatar from data if no file was uploaded to preserve existing avatar
            unset($data['avatar']);
        }

        // Verificar se o perfil está sendo completado pela primeira vez
        $wasIncomplete = !$user->isProfileComplete();
        
        $user->update($data);
        
        // Marcar perfil como completo se estava incompleto
        if ($wasIncomplete && $user->fresh()->isProfileComplete()) {
            $user->update(['profile_completed_at' => now()]);
        }

        return redirect()->route('admin.profile.index')
            ->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Update the admin password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Senha atualizada com sucesso!');
    }

    /**
     * Upload avatar via AJAX
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old avatar if it exists and is a local file
        if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        
        $user->update(['avatar' => $avatarPath]);

        return response()->json([
            'success' => true,
            'avatar_url' => $user->fresh()->avatar_url,
            'message' => 'Foto atualizada com sucesso!'
        ]);
    }

    /**
     * Remove avatar
     */
    public function removeAvatar(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Delete avatar file if it exists and is a local file
        if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Foto removida com sucesso!');
    }

    /**
     * Validate document via AJAX
     */
    public function validateDocument(Request $request)
    {
        $request->validate([
            'document' => 'required|string',
            'person_type' => 'required|in:fisica,juridica',
        ]);

        $document = preg_replace('/\D/', '', $request->document);
        $personType = $request->person_type;

        $isValid = false;
        $message = '';

        if ($personType === 'fisica') {
            $isValid = DocumentValidator::validateCPF($document);
            $message = $isValid ? 'CPF válido' : 'CPF inválido';
        } elseif ($personType === 'juridica') {
            $isValid = DocumentValidator::validateCNPJ($document);
            $message = $isValid ? 'CNPJ válido' : 'CNPJ inválido';
        }

        return response()->json([
            'valid' => $isValid,
            'message' => $message,
            'formatted' => DocumentValidator::formatDocument($document, $personType),
        ]);
    }
} 