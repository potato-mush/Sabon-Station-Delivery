<?php
// Set headers for JSON response
header("Content-Type: application/json");

// Connect to the database
include 'partials/_dbconnect.php';

// Get JSON input
$input = json_decode(file_get_contents("php://input"), true);
$message = $input['message'] ?? '';

if (empty($message)) {
    echo json_encode(["error" => "Message cannot be empty"]);
    exit;
}

// Generate a response based on keywords in the message
function generateResponse($message, $conn) {
    $message = strtolower($message);
    
    // Check for greetings
    if (strpos($message, 'hello') !== false || strpos($message, 'hi') !== false) {
        return "Hello! How can I assist you with Sabon Station products today?";
    }
    
    if (strpos($message, 'help') !== false) {
        return "I'm here to help! I can provide information about our products, categories, ordering process, or delivery details.";
    }
    
    // Search for specific products directly
    $sql = "SELECT productId, productName, productPrice, productCategorieId FROM products 
            WHERE LOWER(productName) LIKE '%" . mysqli_real_escape_string($conn, $message) . "%'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $productLinks = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $productLinks[] = "<a href='viewProduct.php?productid={$row['productId']}'>{$row['productName']} - ₱{$row['productPrice']}</a>";
        }
        
        return "I found the following products matching your query: <br>" . implode("<br>", $productLinks);
    }
    
    // Product related queries
    if (strpos($message, 'product') !== false || strpos($message, 'items') !== false) {
        // Get total product count
        $sql = "SELECT COUNT(*) as count FROM products";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $productCount = $row['count'];
        
        // Get popular products
        $sql = "SELECT productId, productName FROM products ORDER BY productId DESC LIMIT 3";
        $result = mysqli_query($conn, $sql);
        $popularProducts = [];
        while($row = mysqli_fetch_assoc($result)) {
            $popularProducts[] = "<a href='viewProduct.php?productid={$row['productId']}'>{$row['productName']}</a>";
        }
        
        return "We currently have {$productCount} products available. Some of our popular products include: <br>" . implode("<br>", $popularProducts) . "<br>You can browse all products by category from the home page.";
    }
    
    // Category related queries
    if (strpos($message, 'category') !== false || strpos($message, 'categories') !== false) {
        $sql = "SELECT categorieId, categorieName FROM categories";
        $result = mysqli_query($conn, $sql);
        $categories = [];
        while($row = mysqli_fetch_assoc($result)) {
            $categories[] = "<a href='viewProductList.php?catid={$row['categorieId']}'>{$row['categorieName']}</a>";
        }
        
        return "We offer products in the following categories: <br>" . implode("<br>", $categories) . "<br>Click any category to browse products.";
    }
    
    // Search for products by category
    if (strpos($message, 'fabric') !== false || strpos($message, 'conditioner') !== false || 
        strpos($message, 'car') !== false || strpos($message, 'shampoo') !== false) {
        
        $sql = "SELECT c.categorieId, c.categorieName 
                FROM categories c 
                WHERE LOWER(c.categorieName) LIKE '%" . mysqli_real_escape_string($conn, $message) . "%'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $catId = $row['categorieId'];
            $catName = $row['categorieName'];
            
            // Get products in this category
            $sql = "SELECT productId, productName, productPrice FROM products 
                    WHERE productCategorieId = $catId LIMIT 5";
            $result = mysqli_query($conn, $sql);
            
            $products = [];
            while($row = mysqli_fetch_assoc($result)) {
                $products[] = "<a href='viewProduct.php?productid={$row['productId']}'>{$row['productName']} - ₱{$row['productPrice']}</a>";
            }
            
            $categoryLink = "<a href='viewProductList.php?catid=$catId'>$catName</a>";
            return "Here are products in the $categoryLink category: <br>" . implode("<br>", $products) . 
                   "<br><a href='viewProductList.php?catid=$catId'>View all $catName products</a>";
        }
    }
    
    // Product price queries
    if (strpos($message, 'price') !== false || strpos($message, 'cost') !== false || strpos($message, 'how much') !== false) {
        // Extract product name from query
        $productKeywords = str_replace(['price', 'cost', 'how much', 'is', 'the', 'of', '?'], '', $message);
        $productKeywords = trim($productKeywords);
        
        if (!empty($productKeywords)) {
            $sql = "SELECT productId, productName, productPrice FROM products 
                    WHERE LOWER(productName) LIKE '%" . mysqli_real_escape_string($conn, $productKeywords) . "%'";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                return "The price of <a href='viewProduct.php?productid={$row['productId']}'>{$row['productName']}</a> is ₱{$row['productPrice']}.";
            }
        }
        
        // If no specific product was found
        return "Our prices are competitive and reflect the quality of our products. You can see the price of each item on its product page.";
    }
    
    // Order related queries
    if (strpos($message, 'order') !== false) {
        // Get total number of orders
        $sql = "SELECT COUNT(*) as count FROM orders";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $orderCount = $row['count'];
        
        return "To place an order, simply add items to your cart and proceed to checkout. We've processed {$orderCount} orders so far. If you have issues with an existing order, please <a href='contact.php'>contact customer service</a>.";
    }
    
    // Delivery related queries
    if (strpos($message, 'delivery') !== false || strpos($message, 'shipping') !== false) {
        $sql = "SELECT AVG(deliveryTime) as avgTime FROM deliverydetails";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $avgDeliveryTime = round($row['avgTime']);
        
        return "We offer delivery services within the city. Based on our records, the average delivery time is about {$avgDeliveryTime} minutes. Delivery times vary depending on your location. For more information, visit our <a href='contact.php'>contact page</a>.";
    }
    
    // Contact information
    if (strpos($message, 'contact') !== false) {
        // Get contact information from site details
        $sql = "SELECT email, contact1 FROM sitedetail";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        return "You can contact us through email at {$row['email']} or call us at {$row['contact1']}. You can also use our <a href='contact.php'>contact form</a> to send us a message.";
    }
    
    // Checkout and account information
    if (strpos($message, 'account') !== false || strpos($message, 'profile') !== false || strpos($message, 'login') !== false) {
        return "You can manage your account by visiting the <a href='viewProfile.php'>profile page</a>. If you don't have an account yet, please <a href='login.php'>login</a> or <a href='signup.php'>sign up</a>.";
    }
    
    if (strpos($message, 'thanks') !== false || strpos($message, 'thank you') !== false) {
        return "You're welcome! Is there anything else I can help you with regarding Sabon Station products or services?";
    }
    
    // Default response with helpful links
    return "Thank you for your message. We offer high-quality products at Sabon Station. How can I assist you further? Here are some helpful links:<br>
            <a href='index.php'>Home Page</a><br>
            <a href='viewCart.php'>Your Cart</a><br>
            <a href='contact.php'>Contact Us</a>";
}

// Get response
$response = generateResponse($message, $conn);

// Return response
echo json_encode(["reply" => $response]);
?>
