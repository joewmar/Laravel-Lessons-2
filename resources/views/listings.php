<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Native</title>
</head>
<body>
    <h1><?php echo $heading?></h1>
    <?php foreach($listings as $listing): ?>
        <h2><?php echo $listing['title']; ?></h2>
        <p><?php echo $listing['description']; ?></p>
    <?php endforeach; ?>
</body>
</html>