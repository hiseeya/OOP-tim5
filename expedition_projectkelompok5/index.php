<?php
require_once __DIR__ . '/Transaction.php';
require_once __DIR__ . '/Expedition.php';

$transaction = new Transaction();
$services = $transaction->getAllServices(); // ambil semua paket dari tabel services
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
            die("<div class='alert'>Jarak $origin ke $destination belum tersedia di database.</div>");
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
    }

    $result = $transaction->createTransaction($expedition, $serviceId, $customerName, $distance, $route);
}

$history = $transaction->getAllTransactions();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ekspedisi</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function toggleInput() {
        let type = document.getElementById("service_type").value;
        document.getElementById("city_input").style.display = (type === "instant" || type === "regular") ? "block" : "none";
        document.getElementById("distance_input").style.display = (type === "distance") ? "block" : "none";
    }
    </script>
</head>
<body onload="toggleInput()">
<div class="container">
    
    <h1>Daftar Layanan Ekspedisi</h1>
    <div class="services">
        <?php foreach ($services as $service): ?>
            <div class="card">
                <img src="<?= htmlspecialchars($service['image']) ?>" alt="<?= $service['name'] ?>">
                <h3><?= htmlspecialchars($service['name']) ?></h3>
                <p><?= htmlspecialchars($service['description']) ?></p>
                <p><strong>Rp <?= number_format($service['base_price'], 0, ',', '.') ?></strong></p>
            </div>
        <?php endforeach; ?>
    </div> 

    
    <h1>Form Pemesanan Ekspedisi</h1>
    <form method="post">
        <label>Nama Customer:</label>
        <input type="text" name="customer_name" required>

        <label>Jenis Ekspedisi:</label>
        <select name="service_type" id="service_type" onchange="toggleInput()" required>
            <option value="instant">Instant</option>
            <option value="regular">Regular</option>
            <option value="distance">Tergantung Jarak</option>
        </select>

        <div id="city_input">
            <label>Kota Asal:</label>
            <select name="origin">
                <option value="Jakarta">Jakarta</option>
                <option value="Surabaya">Surabaya</option>
                <option value="Bandung">Bandung</option>
            </select>

            <label>Kota Tujuan:</label>
            <select name="destination">
                <option value="Jakarta">Jakarta</option>
                <option value="Surabaya">Surabaya</option>
                <option value="Bandung">Bandung</option>
            </select>
        </div>

        <div id="distance_input">
            <label>Jarak (km):</label>
            <input type="number" name="distance">
        </div>

        <button type="submit">Buat Transaksi</button>
    </form>

    
    <?php if ($result): ?>
        <h2>Hasil Transaksi</h2>
        <table>
            <tr><th>Customer</th><td><?= htmlspecialchars($result['customer']) ?></td></tr>
            <tr><th>Layanan</th><td><?= htmlspecialchars($result['service']) ?></td></tr>
            <?php if ($result['route']): ?>
                <tr><th>Rute</th><td><?= htmlspecialchars($result['route']) ?></td></tr>
            <?php endif; ?>
            <tr><th>Jarak</th><td><?= htmlspecialchars($result['distance']) ?> km</td></tr>
            <tr><th>Total Harga</th><td>Rp<?= number_format($result['price'], 0, ',', '.') ?></td></tr>
        </table>
    <?php endif; ?>

    <!-- Riwayat transaksi -->
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
</div>
</body>
</html>
