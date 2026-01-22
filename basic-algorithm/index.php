<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Gin's Expedition - Final Fixed</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; max-width: 600px; margin: 40px auto; background-color: #f4f7f6; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .input-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; }
        button { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; }
        .result-box { margin-top: 20px; padding: 15px; border-left: 4px solid #007bff; background: #e9f2ff; line-height: 1.8; }
    </style>
</head>
<body>

<div class="card">
    <h2>Gin's Arrow Distributor</h2>
    <form method="POST">
        <div class="input-group"><label>Fire Arrows:</label><input type="number" name="fire" value="10" required></div>
        <div class="input-group"><label>Water Arrows:</label><input type="number" name="water" value="6" required></div>
        <div class="input-group"><label>Wind Arrows:</label><input type="number" name="wind" value="3" required></div>
        <div class="input-group"><label>Earth Arrows:</label><input type="number" name="earth" value="5" required></div>
        <button type="submit">Distribute Arrows</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $elements = [
            'fire'  => (int)$_POST['fire'],
            'water' => (int)$_POST['water'],
            'wind'  => (int)$_POST['wind'],
            'earth' => (int)$_POST['earth']
        ];

        $totalArrows = array_sum($elements);
        $numQuivers = ceil($totalArrows / 10);
        $quivers = array_fill(0, $numQuivers, ['fire'=>0, 'water'=>0, 'wind'=>0, 'earth'=>0]);

        foreach ($elements as $type => $count) {
            $base = floor($count / $numQuivers);
            $remainder = $count % $numQuivers;

            if ($type === 'fire') {
                for ($i = $numQuivers - 1; $i >= 0; $i--) {
                    $extra = ($remainder > 0) ? 1 : 0;
                    $quivers[$i][$type] = $base + $extra;
                    if ($remainder > 0) $remainder--;
                }
            } else {
                for ($i = 0; $i < $numQuivers; $i++) {
                    $extra = ($remainder > 0) ? 1 : 0;
                    $quivers[$i][$type] = $base + $extra;
                    if ($remainder > 0) $remainder--;
                }
            }
        }

        echo "<div class='result-box'><strong>Output:</strong><br>";
        foreach ($quivers as $idx => $q) {
            echo "Quiver " . ($idx + 1) . ": {$q['fire']} fire, {$q['water']} water, {$q['wind']} wind, {$q['earth']} earth<br>";
        }
        echo "</div>";
    }
    ?>
</div>

</body>
</html>