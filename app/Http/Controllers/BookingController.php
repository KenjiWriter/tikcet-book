<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $destinationId = $request->get('destination_id');
        $destination = null;

        if ($destinationId) {
            $destination = Destination::find($destinationId);
        }

        // Sample destinations for booking form
        $destinations = [
            (object)[
                'id' => 1,
                'name' => 'Zakopane - Perła Tatr',
                'description' => 'Odkryj magię Zakopanego i Tatr. Górskie szlaki, regionalna kuchnia i niesamowite widoki.',
                'price' => 450,
                'duration' => '3 dni',
                'max_people' => 12,
                'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'included' => ['Transport', 'Noclegi', '2 posiłki dziennie', 'Przewodnik', 'Ubezpieczenie'],
                'activities' => ['Hiking w Tatrach', 'Zwiedzanie Zakopanego', 'Krupówki', 'Termy Chochołowskie']
            ],
            (object)[
                'id' => 2,
                'name' => 'Gdańsk - Perła Bałtyku',
                'description' => 'Historyczne Gdańsk, bursztynowe plaże i morskie przygody nad Bałtykiem.',
                'price' => 380,
                'duration' => '4 dni',
                'max_people' => 15,
                'image' => 'https://images.unsplash.com/photo-1544986581-efac024faf62?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'included' => ['Transport', 'Noclegi', 'Śniadania', 'Przewodnik', 'Muzea'],
                'activities' => ['Stare Miasto', 'Westerplatte', 'Sopot', 'Muzeum Bursztynu']
            ],
            (object)[
                'id' => 3,
                'name' => 'Kraków - Miasto Królów',
                'description' => 'Królewska stolica Polski z zamkiem na Wawelu i zabytkowym rynkiem.',
                'price' => 320,
                'duration' => '3 dni',
                'max_people' => 20,
                'image' => 'https://images.unsplash.com/photo-1578836537282-3171d77f8632?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'included' => ['Transport', 'Noclegi', 'Przewodnik', 'Wejściówki', 'Degustacja'],
                'activities' => ['Zamek Wawel', 'Rynek Główny', 'Kazimierz', 'Kopalnie Soli']
            ]
        ];

        if ($destinationId && !$destination) {
            // If specific destination requested, find it from our sample data
            $destination = collect($destinations)->firstWhere('id', (int)$destinationId);
        }

        return view('booking.create', compact('destinations', 'destination'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'destination_id' => 'required|integer',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'participants' => 'required|integer|min:1|max:20',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'special_requests' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:card,bank_transfer,paypal'
        ]);

        // Calculate total price (this would normally come from database)
        $destinations = [
            1 => ['name' => 'Zakopane - Perła Tatr', 'price' => 450],
            2 => ['name' => 'Gdańsk - Perła Bałtyku', 'price' => 380],
            3 => ['name' => 'Kraków - Miasto Królów', 'price' => 320]
        ];

        $destinationData = $destinations[$validated['destination_id']] ?? null;

        if (!$destinationData) {
            return back()->withErrors(['destination_id' => 'Wybrana destynacja nie istnieje.']);
        }

        $totalPrice = $destinationData['price'] * $validated['participants'];

        // Create booking
        $booking = new Booking();
        $booking->booking_number = 'PL-' . strtoupper(Str::random(8));
        $booking->user_id = Auth::id(); // Will be null if not logged in
        $booking->destination_id = $validated['destination_id'];
        $booking->destination_name = $destinationData['name'];
        $booking->start_date = $validated['start_date'];
        $booking->end_date = $validated['end_date'];
        $booking->participants = $validated['participants'];
        $booking->total_price = $totalPrice;
        $booking->status = 'pending';
        $booking->customer_details = [
            'name' => $validated['customer_name'],
            'email' => $validated['customer_email'],
            'phone' => $validated['customer_phone']
        ];
        $booking->payment_details = [
            'method' => $validated['payment_method'],
            'status' => 'pending',
            'amount' => $totalPrice
        ];
        $booking->special_requests = $validated['special_requests'];

        $booking->save();

        return redirect()->route('booking.payment', $booking->id)
                        ->with('success', 'Rezerwacja została utworzona! Numer rezerwacji: ' . $booking->booking_number);
    }

    public function payment($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        return view('booking.payment', compact('booking'));
    }

    public function processPayment(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        $validated = $request->validate([
            'payment_method' => 'required|in:card,bank_transfer,paypal',
            'card_number' => 'required_if:payment_method,card|string',
            'card_expiry' => 'required_if:payment_method,card|string',
            'card_cvv' => 'required_if:payment_method,card|string',
            'card_name' => 'required_if:payment_method,card|string'
        ]);

        // Simulate payment processing
        $paymentSuccess = rand(1, 10) > 1; // 90% success rate for demo

        if ($paymentSuccess) {
            $booking->status = 'confirmed';
            $booking->payment_details = array_merge($booking->payment_details ?? [], [
                'status' => 'completed',
                'paid_at' => now(),
                'transaction_id' => 'TXN-' . strtoupper(Str::random(12))
            ]);
            $booking->save();

            return redirect()->route('booking.confirmation', $booking->id)
                           ->with('success', 'Płatność została przetworzona pomyślnie!');
        } else {
            return back()->withErrors(['payment' => 'Wystąpił błąd podczas przetwarzania płatności. Spróbuj ponownie.']);
        }
    }

    public function confirmation($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        return view('booking.confirmation', compact('booking'));
    }

    public function myBookings()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Musisz być zalogowany, aby zobaczyć swoje rezerwacje.');
        }

        $bookings = Booking::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('booking.my-bookings', compact('bookings'));
    }

    public function show($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        // Check if user owns this booking (if logged in)
        if (Auth::check() && $booking->user_id !== Auth::id()) {
            abort(403, 'Nie masz uprawnień do przeglądania tej rezerwacji.');
        }

        return view('booking.show', compact('booking'));
    }

    public function cancel($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        // Check if user owns this booking (if logged in)
        if (Auth::check() && $booking->user_id !== Auth::id()) {
            abort(403, 'Nie masz uprawnień do anulowania tej rezerwacji.');
        }

        if ($booking->status === 'cancelled') {
            return back()->withErrors(['booking' => 'Ta rezerwacja została już anulowana.']);
        }

        if ($booking->status === 'completed') {
            return back()->withErrors(['booking' => 'Nie można anulować zakończonej rezerwacji.']);
        }

        $booking->status = 'cancelled';
        $booking->save();

        return back()->with('success', 'Rezerwacja została anulowana.');
    }

    private function getDestinations()
    {
        return [
            [
                'id' => 1,
                'name' => 'Zakopane',
                'description' => 'Stolica polskich Tatr - góry, kuligi i oscypek',
                'image' => '/images/destinations/zakopane.jpg',
                'price' => 199,
                'original_price' => 249,
                'type' => 'górskie',
                'duration' => '3 dni',
                'rating' => 4.8,
                'activities' => ['Narty/snowboard', 'Wędrówki górskie', 'Kuligi', 'Termy'],
                'highlights' => ['Kasprowy Wierch', 'Morskie Oko', 'Krupówki'],
                'included' => ['Transport', 'Noclegi 3*', 'Śniadania', 'Przewodnik'],
                'not_included' => ['Obiady', 'Kolacje', 'Bilety wstępu', 'Ubezpieczenie']
            ],
            [
                'id' => 2,
                'name' => 'Gdańsk',
                'description' => 'Perła Bałtyku - historia, kultura i morze',
                'image' => '/images/destinations/gdansk.jpg',
                'price' => 249,
                'original_price' => 299,
                'type' => 'nadmorskie',
                'duration' => '4 dni',
                'rating' => 4.9,
                'activities' => ['Plaże', 'Muzea', 'Żuraw portowy', 'Amber Sky Wheel'],
                'highlights' => ['Stare Miasto', 'Westerplatte', 'Sopot'],
                'included' => ['Transport', 'Noclegi 4*', 'Śniadania', 'Przewodnik', 'Muzeum Bursztynu'],
                'not_included' => ['Obiady', 'Kolacje', 'Dodatkowe atrakcje']
            ],
            [
                'id' => 3,
                'name' => 'Kraków',
                'description' => 'Królewskie miasto pełne magii i historii',
                'image' => '/images/destinations/krakow.jpg',
                'price' => 179,
                'original_price' => 219,
                'type' => 'kulturalne',
                'duration' => '3 dni',
                'rating' => 4.9,
                'activities' => ['Wawel', 'Rynek Główny', 'Kazimierz', 'Kopalnia soli'],
                'highlights' => ['Zamek Wawel', 'Sukiennice', 'Wieliczka'],
                'included' => ['Transport', 'Noclegi 3*', 'Śniadania', 'Przewodnik', 'Bilety do Wieliczki'],
                'not_included' => ['Obiady', 'Kolacje', 'Dodatkowe muzea']
            ]
        ];
    }
}
