<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Helpers\DocumentValidator;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'full_name',
        'person_type',
        'document',
        'phone',
        'whatsapp',
        'zip_code',
        'address',
        'address_number',
        'address_complement',
        'neighborhood',
        'city',
        'state',
        'country',
        'company_name',
        'position',
        'bio',
        'avatar',
        'preferences',
        'profile_completed_at',
        'abacatepay_customer_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'preferences' => 'array',
            'profile_completed_at' => 'datetime',
        ];
    }

    /**
     * Get display name (full_name or name)
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->full_name ?: $this->name;
    }

    /**
     * Get the user's avatar or generate initials
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            // Check if it's a URL (starts with http/https)
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar;
            }
            
            // It's a local file, use storage URL
            return asset('storage/' . $this->avatar);
        }

        // Generate avatar with initials
        $name = $this->display_name;
        $initials = '';
        
        $words = explode(' ', $name);
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
            if (strlen($initials) >= 2) break;
        }

        $color = ['3b82f6', '10b981', '8b5cf6', 'ef4444', 'f59e0b'][crc32($name) % 5];
        
        return "https://ui-avatars.com/api/?name={$initials}&background={$color}&color=ffffff&size=200";
    }

    /**
     * Get formatted document
     */
    public function getFormattedDocumentAttribute(): string
    {
        if (!$this->document) return '';
        
        return DocumentValidator::formatDocument($this->document, $this->person_type);
    }

    /**
     * Get formatted phone
     */
    public function getFormattedPhoneAttribute(): ?string
    {
        if (!$this->phone) return null;

        $phone = preg_replace('/\D/', '', $this->phone);
        
        if (strlen($phone) === 11) {
            // Celular: (00) 00000-0000
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $phone);
        } elseif (strlen($phone) === 10) {
            // Fixo: (00) 0000-0000
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $phone);
        }

        return $phone;
    }

    /**
     * Get full address
     */
    public function getFullAddressAttribute(): string
    {
        $address = $this->address;
        
        if ($this->address_number) {
            $address .= ', ' . $this->address_number;
        }
        
        if ($this->address_complement) {
            $address .= ', ' . $this->address_complement;
        }
        
        if ($this->neighborhood) {
            $address .= ' - ' . $this->neighborhood;
        }
        
        if ($this->city && $this->state) {
            $address .= ' - ' . $this->city . '/' . $this->state;
        }
        
        if ($this->zip_code) {
            $address .= ' - CEP: ' . $this->zip_code;
        }
        
        return $address;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is client
     */
    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    /**
     * Validate CPF
     */
    public static function validateCPF(string $cpf): bool
    {
        $cpf = preg_replace('/\D/', '', $cpf);
        
        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate CNPJ
     */
    public static function validateCNPJ(string $cnpj): bool
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);
        
        if (strlen($cnpj) !== 14) {
            return false;
        }

        $sequence = str_repeat($cnpj[0], 14);
        if ($cnpj === $sequence) {
            return false;
        }

        $weights1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $weights2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $weights1[$i];
        }
        
        $digit1 = ($sum % 11) < 2 ? 0 : 11 - ($sum % 11);
        
        if ($cnpj[12] != $digit1) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $weights2[$i];
        }
        
        $digit2 = ($sum % 11) < 2 ? 0 : 11 - ($sum % 11);
        
        return $cnpj[13] == $digit2;
    }

    /**
     * Check if profile is complete
     */
    public function isProfileComplete(): bool
    {
        // Campos realmente essenciais para considerar o perfil completo
        $essentialFields = [
            'full_name', 
            'person_type',
            'document', 
            'phone', 
        ];

        // Verificar se todos os campos essenciais estão preenchidos
        foreach ($essentialFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }

        // Validar documento (essencial para considerar completo)
        if ($this->person_type === 'fisica') {
            if (!self::validateCPF($this->document)) {
                return false;
            }
        } elseif ($this->person_type === 'juridica') {
            if (!self::validateCNPJ($this->document)) {
                return false;
            }
        }

        // Verificar se tem dados de contato básicos
        // Se tem pelo menos cidade e estado OU endereço completo, considera completo
        $hasBasicAddress = !empty($this->city) && !empty($this->state);
        $hasFullAddress = !empty($this->address) && !empty($this->zip_code);
        
        return $hasBasicAddress || $hasFullAddress;
    }

    /**
     * Get profile completion percentage
     */
    public function getProfileCompletionPercentage(): int
    {
        // Define campos por categoria com pesos diferentes
        $essentialFields = [
            'full_name' => 15,      // Nome é essencial
            'email' => 10,          // Email já vem preenchido do registro
            'person_type' => 10,    // Tipo de pessoa é importante
            'document' => 20,       // CPF/CNPJ é muito importante
            'phone' => 15,          // Telefone é essencial para contato
        ];

        $addressFields = [
            'zip_code' => 8,
            'address' => 8,
            'city' => 8,
            'state' => 6,
        ];

        $optionalFields = [
            'address_number' => 3,
            'neighborhood' => 3,
            'whatsapp' => 3,
            'bio' => 2,
        ];

        $totalPossiblePoints = array_sum($essentialFields) + array_sum($addressFields) + array_sum($optionalFields);
        $earnedPoints = 0;

        // Verificar campos essenciais
        foreach ($essentialFields as $field => $points) {
            if (!empty($this->$field)) {
                $earnedPoints += $points;
            }
        }

        // Verificar campos de endereço
        foreach ($addressFields as $field => $points) {
            if (!empty($this->$field)) {
                $earnedPoints += $points;
            }
        }

        // Verificar campos opcionais
        foreach ($optionalFields as $field => $points) {
            if (!empty($this->$field)) {
                $earnedPoints += $points;
            }
        }

        // Bônus para documento válido (não adiciona aos pontos totais, mas pode dar 100%)
        if (!empty($this->document) && !empty($this->person_type)) {
            $documentValid = false;
            if ($this->person_type === 'fisica') {
                $documentValid = self::validateCPF($this->document);
            } elseif ($this->person_type === 'juridica') {
                $documentValid = self::validateCNPJ($this->document);
            }
            
            // Se o documento é válido e temos dados essenciais, dá um boost
            if ($documentValid && $earnedPoints >= 50) {
                $earnedPoints += 5; // Bônus pequeno para documento válido
            }
        }

        // Calcular porcentagem
        $percentage = ($earnedPoints / $totalPossiblePoints) * 100;
        
        return min(100, max(0, intval($percentage)));
    }

    /**
     * Scope to get only admin users
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope to get only client users
     */
    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    /**
     * Relationships
     */
    public function clientProjects()
    {
        return $this->hasMany(ClientProject::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function ticketReplies()
    {
        return $this->hasMany(TicketReply::class);
    }

    public function assignedTickets()
    {
        return $this->hasMany(SupportTicket::class, 'assigned_to');
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function createdQuotes()
    {
        return $this->hasMany(Quote::class, 'created_by');
    }

    /**
     * Check if user has an accepted quote
     */
    public function hasAcceptedQuote(): bool
    {
        return $this->quotes()->where('status', 'aceito')->exists();
    }

    /**
     * Get latest accepted quote
     */
    public function getLatestAcceptedQuote(): ?Quote
    {
        return $this->quotes()->where('status', 'aceito')->latest()->first();
    }

    /**
     * Get user posts
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get user projects
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get user notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
