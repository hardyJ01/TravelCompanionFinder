<?php
// Test file to check if trips.php variables are loading correctly
include 'trips.php';

echo "<h2>Testing Content Loading</h2>";

echo "<h3>Featured Trips:</h3>";
if (isset($featuredTrips)) {
    echo "✓ featuredTrips variable exists<br>";
    echo "Count: " . count($featuredTrips) . "<br>";
    foreach ($featuredTrips as $trip) {
        echo "- " . $trip['title'] . "<br>";
    }
} else {
    echo "✗ featuredTrips variable NOT found<br>";
}

echo "<h3>Destinations:</h3>";
if (isset($destinations)) {
    echo "✓ destinations variable exists<br>";
    echo "Count: " . count($destinations) . "<br>";
    foreach ($destinations as $dest) {
        echo "- " . $dest['name'] . "<br>";
    }
} else {
    echo "✗ destinations variable NOT found<br>";
}

echo "<h3>Stories:</h3>";
if (isset($stories)) {
    echo "✓ stories variable exists<br>";
    echo "Count: " . count($stories) . "<br>";
    foreach ($stories as $story) {
        echo "- " . $story['title'] . "<br>";
    }
} else {
    echo "✗ stories variable NOT found<br>";
}

echo "<h3>All Variables:</h3>";
echo "All defined variables: " . implode(', ', array_keys(get_defined_vars())) . "<br>";
?>
