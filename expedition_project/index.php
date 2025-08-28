<?php
require_once 'includes/Expedition.php';
require_once 'includes/Transaction.php';

$expedition = new Expedition();
$transaction = new Transaction();
$services = $expedition->getServices();
$transactions = $transaction->getTransactions();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['service_id'];
    $customer_name = $_POST['customer_name'];
    $distance = $_POST['distance'] ?? 0;
    $transaction->createTransaction($service_id, $customer_name, $distance);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekspedisi Cepat</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Ekspedisi</h1>
        <h2>Layanan Kami</h2>
        <div class="services">
            <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <img src="<?php echo $service['image']; ?>" alt="<?php echo $service['name']; ?>">
                    <h3><?php echo $service['name']; ?></h3>
                    <p><?php echo $service['description']; ?></p>
                    <p>Harga: Rp <?php echo number_format($service['base_price'], 2); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Buat Transaksi</h2>
        <form method="POST">
            <label for="customer_name">Nama Pelanggan:</label>
            <input type="text" id="customer_name" name="customer_name" required>
            
            <label for="service_id">Layanan:</label>
            <select id="service_id" name="service_id" required>
                <?php foreach ($services as $service): ?>
                    <option value="<?php echo $service['id']; ?>"><?php echo $service['name']; ?></option>
                <?php endforeach; ?>
            </select>
            
            <label for="distance">Jarak (km, untuk layanan berbasis jarak):</label>
            <input type="number" id="distance" name="distance" step="0.1" min="0">
            
            <button type="submit">Buat Transaksi</button>
        </form>

        <h2>Riwayat Transaksi</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>Layanan</th>
                <th>Jarak (km)</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
            <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?php echo $t['id']; ?></td>
                    <td><?php echo $t['customer_name']; ?></td>
                    <td><?php echo $t['service_name']; ?></td>
                    <td><?php echo $t['distance']; ?></td>
                    <td>Rp <?php echo number_format($t['total_price'], 2); ?></td>
                    <td><?php echo $t['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>