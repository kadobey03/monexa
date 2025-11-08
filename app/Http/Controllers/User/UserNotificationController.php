<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotificationController extends Controller
{
    protected $notificationService;

    /**
     * Create a new controller instance.
     *
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Show user's notifications
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            $title = 'Notifications';

        return view('user.notifications.index', [
            'notifications' => $notifications,
            'title' => $title
        ]);
    }

    /**
     * Mark notification as read
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|integer|exists:notifications,id'
        ]);

        $notification = Notification::find($request->notification_id);

        if (!$notification || $notification->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Notification not found or unauthorized.');
        }

        $this->notificationService->markAsRead($request->notification_id);

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllAsRead()
    {
        $count = $this->notificationService->markAllAsReadForUser(Auth::id());

        return redirect()->back()->with('success', "{$count} notifications marked as read.");
    }

    /**
     * Delete notification
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|integer|exists:notifications,id'
        ]);

        $notification = Notification::find($request->notification_id);

        if (!$notification || $notification->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Notification not found or unauthorized.');
        }

        $this->notificationService->deleteNotification($request->notification_id);

        return redirect()->back()->with('success', 'Notification deleted.');
    }

    /**
     * Web route version of markAsRead for form submissions
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function webMarkAsRead(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|integer|exists:notifications,id'
        ]);

        $notification = Notification::find($request->notification_id);

        if (!$notification || $notification->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Notification not found or unauthorized.');
        }

        $this->notificationService->markAsRead($request->notification_id);

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    /**
     * Web route version of deleteNotification for form submissions
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function webDeleteNotification(Request $request)
    {
        $request->validate([
            'notification_id' => 'required|integer|exists:notifications,id'
        ]);

        $notification = Notification::find($request->notification_id);

        if (!$notification || $notification->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Notification not found or unauthorized.');
        }

        $this->notificationService->deleteNotification($request->notification_id);

        return redirect()->route('notifications')->with('success', 'Notification deleted successfully.');
    }

    /**
     * Get unread notifications count
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnreadCount()
    {
        $count = $this->notificationService->countUnreadForUser(Auth::id());

        return response()->json([
            'unread_count' => $count
        ]);
    }

    /**
     * Mark all notifications as read (AJAX version)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsReadAjax()
    {
        try {
            $count = $this->notificationService->markAllAsReadForUser(Auth::id());
            
            return response()->json([
                'success' => true,
                'message' => "{$count} bildirim okundu olarak işaretlendi.",
                'marked_count' => $count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bildirimler işaretlenirken hata oluştu.'
            ], 500);
        }
    }

    /**
     * Mark single notification as read (AJAX version)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsReadAjax(Request $request)
    {
        try {
            $request->validate([
                'notification_id' => 'required|integer|exists:notifications,id'
            ]);

            $notification = Notification::find($request->notification_id);

            if (!$notification || $notification->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bildirim bulunamadı veya yetkisiz erişim.'
                ], 403);
            }

            $success = $this->notificationService->markAsRead($request->notification_id);
            
            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Bildirim okundu olarak işaretlendi.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Bildirim işaretlenirken hata oluştu.'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bildirim işaretlenirken hata oluştu.'
            ], 500);
        }
    }

    /**
     * Display the specified notification
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        $title = 'Notification Details';

        // Check if the notification belongs to the authenticated user
        if ($notification->user_id != Auth::id()) {
            return redirect()->route('notifications')->with('error', 'Unauthorized access to this notification.');
        }

        return view('user.notifications.show', compact('notification', 'title'));
    }
}
