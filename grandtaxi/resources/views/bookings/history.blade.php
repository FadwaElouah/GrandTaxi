<x-app-layout>
    <!-- Navigation Bar -->
<nav class="bg-blue-600 p-4 text-white">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="text-2xl font-bold">GrandTaxiGo</a>
        <div class="flex items-center space-x-4">
            <a href="/driver-dashboard" class="hover:text-blue-200">Dashboard</a>
            <a href="/profile" class="hover:text-blue-200">Profile</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="hover:text-blue-200">Logout</button>
            </form>
        </div>
    </div>
</nav>
    <div class="container mx-auto p-6">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold mb-6">Trip History</h1>
            <div class="space-y-4">
                @foreach ($bookings as $booking)
                    <div class="p-4 border rounded-lg">
                        <p><strong>Pickup:</strong> {{ $booking->pickupLocation->name }}</p>
                        <p><strong>Destination:</strong> {{ $booking->destinationLocation->name }}</p>
                        <p><strong>Scheduled At:</strong> {{ $booking->scheduled_at->format('Y-m-d H:i') }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
                        @if ($booking->status === 'pending')
                            <form action="{{ route('cancel-booking', $booking) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Cancel Booking</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
