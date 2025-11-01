<div>
    @if ($notificationsCount > 0)
        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
            {{ $notificationsCount }}<span class="sr-only">unread messages</span>
        </span>
    @endif
</div>
