<?php
$conn = new mysqli("localhost", "root", "Nopass@123", "infintescroll");

//slower way to get the last id and limit
// $limit = $_POST["limit"];
// $start = $_POST["start"];

// $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $start, $limit";
// $result = $conn->query($sql);

// $output = '';
// while ($row = $result->fetch_assoc()) {
//     $output .= "<div class='post' data-id='{$row['id']}'>
//                     <h3>{$row['title']}</h3>
//                     <p>{$row['content']}</p>
//                 </div>";
// }

// echo $output;




//faster way to get the last id and limit
$limit = $_POST["limit"] ?? 10;
$lastId = $_POST['last_id'] ?? PHP_INT_MAX;

$sql = "SELECT id, title, content FROM posts WHERE id < ? ORDER BY id DESC LIMIT ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $lastId, $limit);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "No more posts";
    exit;
}

$output = '';
while ($row = $result->fetch_assoc()) {
    $output .= "<div class='post'>
                <h3>{$row['title']}</h3>
                <p>{$row['content']}</p>
              </div>";
}

echo $output;
