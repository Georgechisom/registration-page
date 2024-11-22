<?php 
include 'db_connect.php';

// Sample data to search through 
$data = [   ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'], 
            ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com'], 
            ['id' => 3, 'name' => 'Charlie', 'email' => 'charlie@example.com'], 
            ['id' => 4, 'name' => 'David', 'email' => 'david@example.com'],
            ['id' => 5, 'name' => 'Alice', 'email' => 'ali@example.com'], 
            ['id' => 6, 'name' => 'Alice', 'email' => 'aliyu@example.com'],
        ]; 
        
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    // Get the search term from the input 
    $search = trim($_POST['search']); 
    if (!empty($search)) { 
        // Filter the data based on the search term 
        $filteredData = array_filter($data, function ($item) use ($search) { 
            return stripos($item['name'], $search) !== false || stripos($item['email'], $search) !== false; 
            }); 
        // Display filtered results 
        echo '<h3>Search Results:</h3>'; 
        if (!empty($filteredData)) { 
            foreach ($filteredData as $result) { 
            echo '<p>' . htmlspecialchars($result['name']) . ' (' . htmlspecialchars($result['email']) . ')</p>'; } 
        } else { 
            echo '<p>No results found for "' . htmlspecialchars($search) . '".</p>'; } 
        } else { 
            echo '<p>Please enter a search term.</p>'; 
        } 
} 
                    
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>PHP Search Filter</title> 
</head> 
<body> 
    <form method="POST" action=""> 
        <label for="search">Search:</label> 
        <input type="text" id="search" name="search" placeholder="Enter search term"> 
        <button type="submit">Search</button> 
    </form> 
</body> 
</html> 
