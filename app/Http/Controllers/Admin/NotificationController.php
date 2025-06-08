<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Listar notificações do usuário
     */
    public function index(Request $request): JsonResponse|View
    {
        $user = Auth::user();
        
        // Dados fake para demonstração (remover quando o banco estiver funcionando)
        $fakeNotifications = collect([
            (object)[
                'id' => 1,
                'title' => 'Novo contato recebido',
                'message' => 'João Silva enviou uma mensagem através do formulário de contato',
                'type' => 'new_contact',
                'icon' => 'fi-rr-envelope',
                'color' => 'blue',
                'url' => route('admin.contacts.index'),
                'read_at' => null,
                'created_at' => now()->subMinutes(5),
            ],
            (object)[
                'id' => 2,
                'title' => 'Projeto aprovado',
                'message' => 'O projeto "Website Corporativo" foi aprovado pelo cliente',
                'type' => 'new_project',
                'icon' => 'fi-rr-briefcase',
                'color' => 'green',
                'url' => route('admin.projects.index'),
                'read_at' => null,
                'created_at' => now()->subHours(2),
            ],
            (object)[
                'id' => 3,
                'title' => 'Fatura paga',
                'message' => 'A fatura #001 foi paga com sucesso',
                'type' => 'invoice_paid',
                'icon' => 'fi-rr-money',
                'color' => 'emerald',
                'url' => route('admin.invoices.index'),
                'read_at' => null,
                'created_at' => now()->subHours(6),
            ],
            (object)[
                'id' => 4,
                'title' => 'Ticket de suporte',
                'message' => 'Novo ticket criado: "Problema com login"',
                'type' => 'support_ticket',
                'icon' => 'fi-rr-headset',
                'color' => 'orange',
                'url' => route('admin.support-tickets.index'),
                'read_at' => now()->subMinutes(10),
                'created_at' => now()->subDay(),
            ],
            (object)[
                'id' => 5,
                'title' => 'Bem-vindo ao sistema!',
                'message' => 'Seu perfil foi criado com sucesso. Complete suas informações.',
                'type' => 'success',
                'icon' => 'fi-rr-check-circle',
                'color' => 'green',
                'url' => route('admin.profile.index'),
                'read_at' => now()->subHours(1),
                'created_at' => now()->subDays(2),
            ],
        ]);

        // Simular paginação
        $notifications = new \Illuminate\Pagination\LengthAwarePaginator(
            $fakeNotifications,
            $fakeNotifications->count(),
            20,
            1,
            ['path' => request()->url()]
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'notifications' => $fakeNotifications->toArray(),
                'unread_count' => $fakeNotifications->where('read_at', null)->count(),
                'has_more' => false,
                'next_page' => null,
            ]);
        }

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Obter notificações não lidas para dropdown
     */
    public function getUnread(): JsonResponse
    {
        $user = Auth::user();
        
        // Dados fake para demonstração (remover quando o banco estiver funcionando)
        $fakeNotifications = [
            (object)[
                'id' => 1,
                'title' => 'Novo contato recebido',
                'message' => 'João Silva enviou uma mensagem através do formulário de contato',
                'type' => 'new_contact',
                'icon' => 'fi-rr-envelope',
                'color' => 'blue',
                'url' => route('admin.contacts.index'),
                'read_at' => null,
                'created_at' => now()->subMinutes(5)->toISOString(),
            ],
            (object)[
                'id' => 2,
                'title' => 'Projeto aprovado',
                'message' => 'O projeto "Website Corporativo" foi aprovado pelo cliente',
                'type' => 'new_project',
                'icon' => 'fi-rr-briefcase',
                'color' => 'green',
                'url' => route('admin.projects.index'),
                'read_at' => null,
                'created_at' => now()->subHours(2)->toISOString(),
            ],
            (object)[
                'id' => 3,
                'title' => 'Fatura paga',
                'message' => 'A fatura #001 foi paga com sucesso',
                'type' => 'invoice_paid',
                'icon' => 'fi-rr-money',
                'color' => 'emerald',
                'url' => route('admin.invoices.index'),
                'read_at' => null,
                'created_at' => now()->subHours(6)->toISOString(),
            ],
        ];

        return response()->json([
            'notifications' => $fakeNotifications,
            'unread_count' => count($fakeNotifications),
        ]);
    }

    /**
     * Marcar notificação como lida
     */
    public function markAsRead($notificationId): JsonResponse
    {
        // Simulação para demonstração (implementar com banco de dados depois)
        return response()->json([
            'success' => true,
            'unread_count' => 2, // Simular contagem reduzida
        ]);
    }

    /**
     * Marcar todas as notificações como lidas
     */
    public function markAllAsRead(): JsonResponse
    {
        // Simulação para demonstração (implementar com banco de dados depois)
        return response()->json([
            'success' => true,
            'unread_count' => 0,
        ]);
    }

    /**
     * Deletar notificação
     */
    public function destroy($notificationId): JsonResponse
    {
        // Simulação para demonstração (implementar com banco de dados depois)
        return response()->json([
            'success' => true,
            'unread_count' => 1, // Simular contagem reduzida
        ]);
    }

    /**
     * Limpar todas as notificações lidas
     */
    public function clearRead(): JsonResponse
    {
        $user = Auth::user();
        
        $deleted = Notification::forUser($user->id)
            ->whereNotNull('read_at')
            ->delete();

        return response()->json([
            'success' => true,
            'deleted_count' => $deleted,
            'unread_count' => $this->getUnreadCount(),
        ]);
    }

    /**
     * Criar nova notificação (para teste)
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|string|in:info,success,warning,error,new_contact,new_project,invoice_paid,support_ticket',
            'url' => 'nullable|url',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $notification = Notification::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'url' => $request->url,
            'expires_at' => $request->expires_at,
        ]);

        return response()->json([
            'success' => true,
            'notification' => $notification,
            'unread_count' => $this->getUnreadCount(),
        ]);
    }

    /**
     * Obter contagem de notificações não lidas
     */
    private function getUnreadCount(): int
    {
        return Notification::forUser(Auth::id())
            ->unread()
            ->notExpired()
            ->count();
    }

    /**
     * Verificar se há novas notificações (polling)
     */
    public function checkNew(Request $request): JsonResponse
    {
        // Simulação para demonstração (implementar com banco de dados depois)
        return response()->json([
            'has_new' => false,
            'new_notifications' => [],
            'unread_count' => 3,
            'last_check' => now()->toISOString(),
        ]);
    }

    /**
     * Redirecionar para URL da notificação e marcar como lida
     */
    public function redirect(Notification $notification)
    {
        // Verificar se a notificação pertence ao usuário
        if ($notification->user_id !== Auth::id()) {
            abort(404);
        }

        // Marcar como lida se não foi lida
        if (!$notification->isRead()) {
            $notification->markAsRead();
        }

        // Redirecionar para URL ou dashboard
        $url = $notification->url ?: route('admin.dashboard');
        
        return redirect($url);
    }
} 