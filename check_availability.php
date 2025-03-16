<?php
require_once('config.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkin'], $_POST['checkout'])) {
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    // Query for occupied rooms
    $occupiedRoomsQuery = $con->query("
        SELECT room_id, COUNT(*) as occupied 
        FROM transaction 
        WHERE status IN ('Pending', 'Check In') 
        AND (
            ('$checkin' BETWEEN checkin AND checkout) 
            OR ('$checkout' BETWEEN checkin AND checkout) 
            OR (checkin BETWEEN '$checkin' AND '$checkout')
        )
        GROUP BY room_id
    ");

    // Store occupied rooms in an array
    $occupiedRooms = [];
    while ($row = $occupiedRoomsQuery->fetch_assoc()) {
        $occupiedRooms[$row['room_id']] = $row['occupied'];
    }

    // Get all rooms
    $query = $con->query("SELECT * FROM room ORDER BY price ASC");

    $output = "<div class='row g-4 justify-content-center'>";

    while ($fetch = $query->fetch_assoc()) {
        $room_id = $fetch['room_id'];
        $room_type = $fetch['room_type'];
        $price = $fetch['price'];
        $photo = htmlspecialchars($fetch['photo']);
        $isRegular = ($room_type === "Regular Room");
        $totalRooms = ($isRegular) ? 15 : 2;
        $occupiedCount = $occupiedRooms[$room_id] ?? 0;
        $availableRooms = max(0, $totalRooms - $occupiedCount);

        $output .= "
            <div class='col-lg-6 col-md-6 d-flex justify-content-center'>
                <div class='room-item shadow rounded overflow-hidden'>
                    <div class='position-relative'>
                        <img class='img-fluid' src='$photo' alt='Room Image'>
                        <small class='position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded py-1 px-3 ms-4'>
                            ₩$price/Night
                        </small>
                    </div>
                    <div class='p-4 mt-2'>
                        <div class='d-flex justify-content-between mb-3'>
                            <h5 class='mb-0'>$room_type</h5>
                            <div class='ps-2'>";

        // Display 5 stars
        for ($i = 0; $i < 5; $i++) {
            $output .= '<small class="fa fa-star text-primary"></small>';
        }

        $output .= "  
                            </div>
                        </div>
                        <div class='d-flex mb-3'>
                            <small class='border-end me-3 pe-3'><i class='fa fa-bed text-primary me-2'></i>" .
            ($isRegular ? '1 Regular Size Bed' : '1 Queen Size Bed') . "</small>
                            <small class='border-end me-3 pe-3'><i class='fa fa-bath text-primary me-2'></i>1 Bath</small>
                            <small><i class='fa fa-wifi text-primary me-2'></i>Wifi</small>
                        </div>";

        // Different descriptions based on room type
        if ($isRegular) {
            $output .= "<p class='text-body mb-3'>Cozy beachfront room (25m²) good for 2 people with ocean-view balcony, air conditioning, and modern amenities. Features a comfortable regular bed, private bathroom with rain shower, and complimentary WiFi.</p>";
        } else {
            $output .= "<p class='text-body mb-3'>Spacious family accommodation (40m²) with panoramic ocean views, private balcony, premium queen bed, and expanded living area. Includes air conditioning, luxurious bathroom, and all resort amenities.</p>";
        }

        $output .= "<div class='d-flex justify-content-between'>
                            <a class='btn btn-sm btn-dark rounded py-2 px-4' 
                               href='add_reserve.php?room_id=$room_id&checkin=$checkin&checkout=$checkout'>
                                Book Now
                            </a>";

        // Display available rooms or "Fully Booked"
        if ($availableRooms > 0) {
            $output .= "<span class='text-success'>$availableRooms Available</span>";
        } else {
            $output .= "<span class='text-danger'>Fully Booked</span>";
        }

        $output .= "
                        </div>
                    </div>
                </div>
            </div>";
    }

    $output .= "</div>";

    echo $output;
}
?>