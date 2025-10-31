<?php

namespace App\Http\Controllers\Api;

use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Exception;

class NotificationApiController extends Controller
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $notifications = $this->notificationService->getUserNotifications(auth()->user());

            return $this->successResponse(
                $notifications,
                'Notifications retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve notifications', 500);
        }
    }

    public function count(): JsonResponse
    {
        try {
            $count = $this->notificationService->getUnreadCount(auth()->user());

            return $this->successResponse(
                ['count' => $count],
                'Notification count retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve notification count', 500);
        }
    }

    public function markAsRead(int $notificationId): JsonResponse
    {
        try {
            $result = $this->notificationService->markAsRead($notificationId, auth()->user());

            if (!$result) {
                return $this->errorResponse('Notification not found', 404);
            }

            return $this->successResponse(
                null,
                'Notification marked as read'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to mark notification as read', 500);
        }
    }
}