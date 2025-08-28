<?php
require_once 'Transaction.php';
require_once 'Expedition.php';

$transaction = new Transaction();
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = $_POST['customer_name'];
    $serviceType  = $_POST['service_type'];
    $route = null;
    $distance = 0;
    $serviceId = 0;
    $expedition = null;

    if ($serviceType === 'instant' || $serviceType === 'regular') {
        $origin = $_POST['origin'];
        $destination = $_POST['destination'];
        $route = $origin . " → " . $destination;

        $stmt = $transaction->getDB()->prepare("SELECT distance FROM city_distances WHERE origin = ? AND destination = ?");
        $stmt->execute([$origin, $destination]);
        $row = $stmt->fetch();

        if (!$row) {
            die("Jarak antara $origin dan $destination belum tersedia di database.");
        }
        $distance = $row['distance'];

        if ($serviceType === 'instant') {
            $expedition = new InstantExpedition("Instant", 50000);
            $serviceId = 1;
        } else {
            $expedition = new RegularExpedition("Regular", 20000);
            $serviceId = 2;
        }
    } elseif ($serviceType === 'distance') {
        $distance = (int) $_POST['distance'];
        $expedition = new DistanceExpedition("Distance Based", 5000);
        $serviceId = 3;
    } else {
        die("Jenis ekspedisi tidak valid.");
    }

    $result = $transaction->createTransaction($expedition, $serviceId, $customerName, $distance, $route);
}

$history = $transaction->getAllTransactions();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ekspedisi</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background: #333; color: #fff; }
    </style>
    <script>
    function toggleInput() {
        let type = document.getElementById("service_type").value;
        document.getElementById("city_input").style.display = (type === "instant" || type === "regular") ? "block" : "none";
        document.getElementById("distance_input").style.display = (type === "distance") ? "block" : "none";
    }
    </script>    
</head>
<body onload="toggleInput()">
    <h1>Form Pemesanan Ekspedisi</h1>
    <form method="post">
        <label>Nama Customer:</label><br>
        <input type="text" name="customer_name" required><br><br>

        <label>Jenis Ekspedisi:</label><br>
        <select name="service_type" id="service_type" onchange="toggleInput()" required>
            <option value="instant">Instant</option>
            <option value="regular">Regular</option>
            <option value="distance">Tergantung Jarak</option>
        </select><br><br>

        <div id="city_input">
            <label>Kota Asal:</label>
            <select name="origin">
                <option value="Jakarta">Jakarta</option>
                <option value="Surabaya">Surabaya</option>
                <option value="Bandung">Bandung</option>
            </select><br><br>

            <label>Kota Tujuan:</label>
            <select name="destination">
                <option value="Jakarta">Jakarta</option>
                <option value="Surabaya">Surabaya</option>
                <option value="Bandung">Bandung</option>
            </select><br><br>
        </div>

        <div id="distance_input">
            <label>Jarak (km):</label><br>
            <input type="number" name="distance"><br><br>
        </div>

        <button type="submit">Buat Transaksi</button>
    </form>

    <?php if ($result): ?>
        <h2>Hasil Transaksi</h2>
        <p>Customer: <?= htmlspecialchars($result['customer']) ?></p>
        <p>Layanan: <?= htmlspecialchars($result['service']) ?> (ID <?= $result['service_id'] ?>)</p>
        <?php if ($result['route']): ?>
            <p>Rute: <?= htmlspecialchars($result['route']) ?></p>
        <?php endif; ?>
        <p>Jarak: <?= htmlspecialchars($result['distance']) ?> km</p>
        <p>Total Harga: Rp<?= number_format($result['price'], 0, ',', '.') ?></p>
    <?php endif; ?>

    <h2>Riwayat Transaksi</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Pelanggan</th>
            <th>Layanan</th>
            <th>Rute</th>
            <th>Jarak (km)</th>
            <th>Total Harga</th>
            <th>Tanggal</th>
        </tr>
        <?php foreach ($history as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['customer_name']) ?></td>
            <td><?= htmlspecialchars($row['service_name']) ?></td>
            <td><?= htmlspecialchars($row['route'] ?? '-') ?></td>
            <td><?= $row['distance'] ?></td>
            <td>Rp <?= number_format($row['total_price'], 2, ',', '.') ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
