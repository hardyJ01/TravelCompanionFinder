<?php
// TravelCircle - Trip Data Management

// Featured Trips Data
$featuredTrips = [
    [
        'id' => 1,
        'title' => 'Mountain Hiking Adventure',
        'description' => 'Join fellow hikers for an unforgettable mountain trek through scenic trails and breathtaking views.',
        'image' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'duration' => '3 days',
        'price' => 299,
        'category' => 'adventure',
        'difficulty' => 'moderate',
        'location' => 'Rocky Mountains',
        'max_participants' => 12,
        'available_spots' => 8
    ],
    [
        'id' => 2,
        'title' => 'City Exploration Tour',
        'description' => 'Discover hidden gems and local culture in vibrant cities with like-minded urban explorers.',
        'image' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'duration' => '2 days',
        'price' => 199,
        'category' => 'cultural',
        'difficulty' => 'easy',
        'location' => 'Various Cities',
        'max_participants' => 15,
        'available_spots' => 12
    ],
    [
        'id' => 3,
        'title' => 'Underwater Adventure',
        'description' => 'Dive into crystal-clear waters and explore marine life with certified diving companions.',
        'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'duration' => '4 days',
        'price' => 449,
        'category' => 'water-sports',
        'difficulty' => 'advanced',
        'location' => 'Caribbean',
        'max_participants' => 8,
        'available_spots' => 5
    ],
    [
        'id' => 4,
        'title' => 'Desert Safari Experience',
        'description' => 'Experience the magic of the desert with camel rides, stargazing, and traditional Bedouin culture.',
        'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'duration' => '2 days',
        'price' => 349,
        'category' => 'adventure',
        'difficulty' => 'moderate',
        'location' => 'Sahara Desert',
        'max_participants' => 10,
        'available_spots' => 7
    ],
    [
        'id' => 5,
        'title' => 'Food & Wine Tour',
        'description' => 'Savor local cuisines and fine wines while exploring culinary traditions with food enthusiasts.',
        'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'duration' => '1 day',
        'price' => 149,
        'category' => 'culinary',
        'difficulty' => 'easy',
        'location' => 'Tuscany',
        'max_participants' => 12,
        'available_spots' => 9
    ],
    [
        'id' => 6,
        'title' => 'Photography Expedition',
        'description' => 'Capture stunning landscapes and wildlife with professional photographers and fellow enthusiasts.',
        'image' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'duration' => '5 days',
        'price' => 599,
        'category' => 'photography',
        'difficulty' => 'moderate',
        'location' => 'Patagonia',
        'max_participants' => 8,
        'available_spots' => 6
    ]
];

// Popular Destinations Data
$destinations = [
    [
        'name' => 'Bali, Indonesia',
        'image' => 'https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'trips' => '15+',
        'description' => 'Tropical paradise with rich culture'
    ],
    [
        'name' => 'Iceland',
        'image' => 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'trips' => '12+',
        'description' => 'Land of fire and ice'
    ],
    [
        'name' => 'Japan',
        'image' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'trips' => '20+',
        'description' => 'Ancient traditions meet modern innovation'
    ],
    [
        'name' => 'New Zealand',
        'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'trips' => '18+',
        'description' => 'Adventure capital of the world'
    ],
    [
        'name' => 'Morocco',
        'image' => 'https://blogassets.airtel.in/wp-content/uploads/2024/11/morocco.png',
        'trips' => '10+',
        'description' => 'Vibrant markets and desert landscapes'
    ],
    [
        'name' => 'Costa Rica',
        'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'trips' => '14+',
        'description' => 'Biodiversity hotspot and eco-adventures'
    ]
];

// Travel Stories Data
$stories = [
    [
        'title' => 'Finding Friendship on the Inca Trail',
        'excerpt' => 'How a solo traveler discovered lifelong friends while hiking to Machu Picchu...',
        'image' => 'https://images.unsplash.com/photo-1527004013197-933c4bb611b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'author' => 'Sarah Johnson',
        'date' => 'March 15, 2024',
        'read_time' => '5 min read'
    ],
    [
        'title' => 'Unexpected Adventures in Tokyo',
        'excerpt' => 'From getting lost in translation to finding the best ramen spot with locals...',
        'image' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'author' => 'Mike Chen',
        'date' => 'March 10, 2024',
        'read_time' => '7 min read'
    ],
    [
        'title' => 'Diving Deep: A Marine Biology Adventure',
        'excerpt' => 'Exploring coral reefs and marine life with fellow ocean enthusiasts...',
        'image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'author' => 'Emma Rodriguez',
        'date' => 'March 5, 2024',
        'read_time' => '6 min read'
    ],
    [
        'title' => 'Culinary Journey Through Italy',
        'excerpt' => 'From pasta-making classes to wine tastings with local families...',
        'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
        'author' => 'David Thompson',
        'date' => 'February 28, 2024',
        'read_time' => '8 min read'
    ]
];

// Helper Functions
function getTripById($id) {
    global $featuredTrips;
    foreach ($featuredTrips as $trip) {
        if ($trip['id'] == $id) {
            return $trip;
        }
    }
    return null;
}

function getTripsByCategory($category) {
    global $featuredTrips;
    return array_filter($featuredTrips, function($trip) use ($category) {
        return $trip['category'] === $category;
    });
}

function getTripsByDifficulty($difficulty) {
    global $featuredTrips;
    return array_filter($featuredTrips, function($trip) use ($difficulty) {
        return $trip['difficulty'] === $difficulty;
    });
}

function getTripsByPriceRange($minPrice, $maxPrice) {
    global $featuredTrips;
    return array_filter($featuredTrips, function($trip) use ($minPrice, $maxPrice) {
        return $trip['price'] >= $minPrice && $trip['price'] <= $maxPrice;
    });
}

function getAvailableTrips() {
    global $featuredTrips;
    return array_filter($featuredTrips, function($trip) {
        return $trip['available_spots'] > 0;
    });
}

function getPopularDestinations($limit = 6) {
    global $destinations;
    return array_slice($destinations, 0, $limit);
}

function getRecentStories($limit = 4) {
    global $stories;
    return array_slice($stories, 0, $limit);
}

// API-like functions for AJAX requests
if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    switch ($_GET['action']) {
        case 'get_trip':
            if (isset($_GET['id'])) {
                $trip = getTripById($_GET['id']);
                echo json_encode($trip);
            }
            break;
            
        case 'get_trips_by_category':
            if (isset($_GET['category'])) {
                $trips = getTripsByCategory($_GET['category']);
                echo json_encode(array_values($trips));
            }
            break;
            
        case 'get_available_trips':
            $trips = getAvailableTrips();
            echo json_encode(array_values($trips));
            break;
            
        case 'get_destinations':
            $destinations = getPopularDestinations();
            echo json_encode($destinations);
            break;
            
        case 'get_stories':
            $stories = getRecentStories();
            echo json_encode($stories);
            break;
            
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
    exit;
}

// Trip booking simulation (for demo purposes)
function bookTrip($tripId, $participantName, $email, $phone) {
    $trip = getTripById($tripId);
    
    if (!$trip) {
        return ['success' => false, 'message' => 'Trip not found'];
    }
    
    if ($trip['available_spots'] <= 0) {
        return ['success' => false, 'message' => 'No available spots'];
    }
    
    // In a real application, this would save to a database
    // For demo purposes, we'll just return a success message
    return [
        'success' => true,
        'message' => 'Booking successful! You will receive a confirmation email shortly.',
        'booking_id' => 'TC' . date('Ymd') . $tripId . rand(1000, 9999),
        'trip' => $trip
    ];
}

// Handle booking requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'book_trip') {
    header('Content-Type: application/json');
    
    $tripId = intval($_POST['trip_id']);
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    
    if (empty($name) || empty($email) || empty($phone)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
        exit;
    }
    
    $result = bookTrip($tripId, $name, $email, $phone);
    echo json_encode($result);
    exit;
}

// Search functionality
function searchTrips($query) {
    global $featuredTrips;
    $query = strtolower($query);
    
    return array_filter($featuredTrips, function($trip) use ($query) {
        return strpos(strtolower($trip['title']), $query) !== false ||
               strpos(strtolower($trip['description']), $query) !== false ||
               strpos(strtolower($trip['location']), $query) !== false;
    });
}

// Handle search requests
if (isset($_GET['search'])) {
    header('Content-Type: application/json');
    $query = $_GET['search'];
    $results = searchTrips($query);
    echo json_encode(array_values($results));
    exit;
}
?>

