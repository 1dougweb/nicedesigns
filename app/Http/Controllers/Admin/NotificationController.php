<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications
     */
    public function index(Request $request): View
    {
        $query = Notification::forAdmins()
            ->notExpired()
            ->orderBy('created_at', 'desc');

        // Filtro por tipo
        if ($request->filled('type') && $request->type !== 'all') {
            $query->ofType($request->type);
        }

        // Filtro por status (lidas/não lidas)
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->unread();
            } elseif ($request->status === 'read') {
                $query->whereNotNull('read_at');
            }
        }

        $notifications = $query->paginate(20);

        // Estatísticas
        $stats = [
            'total' => Notification::forAdmins()->notExpired()->count(),
            'unread' => Notification::forAdmins()->unread()->notExpired()->count(),
            'today' => Notification::forAdmins()->notExpired()->whereDate('created_at', today())->count(),
        ];

        // Opções de tipos para filtro
        $typeOptions = [
            'all' => 'Todos',
            Notification::TYPE_NEW_CONTACT => 'Novos Contatos',
            Notification::TYPE_NEW_PROJECT => 'Novos Projetos',
            Notification::TYPE_PROJECT_APPROVED => 'Projetos Aprovados',
            Notification::TYPE_PROJECT_REJECTED => 'Projetos Rejeitados',
            Notification::TYPE_INVOICE_PAID => 'Faturas',
            Notification::TYPE_SUPPORT_TICKET => 'Suporte',
            Notification::TYPE_INFO => 'Informações',
            Notification::TYPE_SUCCESS => 'Sucesso',
            Notification::TYPE_WARNING => 'Avisos',
        ];

        return view('admin.notifications.index', compact(
            'notifications',
            'stats',
            'typeOptions'
        ));
    }

    /**
     * Get unread notifications (AJAX)
     */
    public function getUnread(): JsonResponse
    {
        $notifications = Notification::forAdmins()
            ->unread()
            ->notExpired()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $unreadCount = Notification::forAdmins()
            ->unread()
            ->notExpired()
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Check for new notifications (AJAX)
     */
    public function checkNew(Request $request): JsonResponse
    {
        $lastCheck = $request->get('last_check', now()->subHour());
        
        $unreadCount = Notification::forAdmins()
            ->unread()
            ->notExpired()
            ->count();

        $hasNew = Notification::forAdmins()
            ->where('created_at', '>', $lastCheck)
            ->exists();

        $latestNotifications = Notification::forAdmins()
            ->unread()
            ->notExpired()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'unread_count' => $unreadCount,
            'has_new' => $hasNew,
            'notifications' => $latestNotifications,
            'last_check' => now()->toISOString(),
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification): JsonResponse
    {
        // Verificar se a notificação é para admins
        if ($notification->user_id !== null && !$notification->user->isAdmin()) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notificação marcada como lida'
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(): JsonResponse
    {
        $updated = Notification::forAdmins()
            ->unread()
            ->notExpired()
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => "Todas as {$updated} notificações foram marcadas como lidas",
            'updated_count' => $updated
        ]);
    }

    /**
     * Delete notification
     */
    public function destroy(Notification $notification): JsonResponse
    {
        // Verificar se a notificação é para admins
        if ($notification->user_id !== null && !$notification->user->isAdmin()) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notificação removida'
        ]);
    }

    /**
     * Redirect to notification URL and mark as read
     */
    public function redirect(Notification $notification): RedirectResponse
    {
        // Verificar se a notificação é para admins
        if ($notification->user_id !== null && !$notification->user->isAdmin()) {
            abort(403, 'Acesso negado');
        }

        // Marcar como lida se ainda não foi
        if (!$notification->isRead()) {
            $notification->markAsRead();
        }

        // Redirecionar para a URL da notificação ou dashboard se não houver URL
        $redirectUrl = $notification->url ?: route('admin.dashboard');

        return redirect($redirectUrl);
    }
} 