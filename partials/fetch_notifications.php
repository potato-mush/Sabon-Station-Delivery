<?php
session_start();
include '_dbconnect.php';

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true) {
    echo json_encode(['error' => 'Not logged in']);
    exit();
}

$userId = $_SESSION['userId'];

// Mark notifications as read
if(isset($_POST['markRead'])) {
    $sql = "UPDATE notifications SET status = 1 WHERE userId = ? AND status = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    echo json_encode(['success' => true]);
    exit();
}

// Fetch notifications
$sql = "SELECT *, DATE_FORMAT(timestamp, '%d %b %Y %h:%i %p') as formatted_time 
        FROM notifications 
        WHERE userId = ? 
        ORDER BY timestamp DESC 
        LIMIT 10";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
$unreadCount = 0;

while($row = $result->fetch_assoc()) {
    if($row['status'] == 0) {
        $unreadCount++;
    }
    $notifications[] = [
        'id' => $row['id'],
        'message' => $row['message'],
        'status' => $row['status'],
        'timestamp' => $row['formatted_time']
    ];
}

echo json_encode([
    'notifications' => $notifications,
    'unreadCount' => $unreadCount
]);
?>
