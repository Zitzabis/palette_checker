<head>
    <title>MC Voter Tool</title>
    <?php
        if (!function_exists('str_contains')) {
            function str_contains (string $haystack, string $needle)
            {
                return empty($needle) || strpos($haystack, $needle) !== false;
            }
        }
        if (str_contains($_SERVER['SCRIPT_NAME'], "admin")) {
            echo("<link rel=\"stylesheet\" href=\"css/dashboard.css\">");
        }
        else {
            echo '<link rel="stylesheet" href="css/custom.css">';
            echo '<link rel="stylesheet" href="css/sidebar.css">';
        }
    ?>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Roboto" rel="stylesheet">
    
</head>