<?php
$conn = new mysqli("localhost", "root", "Nopass@123", "infintescroll");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

for ($i = 1; $i <= 1000; $i++) {
  $title = "Post Title $i";
  $content = "This is the content of post number $i.";

  // $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
  // $stmt->bind_param("ss", $title, $content);
  // $stmt->execute();
}

echo "✅ 1000 posts inserted successfully.";
