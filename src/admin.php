<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — SpeedShop Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Syne:wght@600;700;800&display=swap">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .admin-header {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            padding: 40px;
            border-radius: 8px;
            margin-bottom: 40px;
            text-align: center;
        }

        .admin-header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .admin-section {
            background: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
        }

        .admin-section h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-family: inherit;
            font-size: 1rem;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ff4500;
            box-shadow: 0 0 0 3px rgba(255, 69, 0, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: linear-gradient(135deg, #ff4500 0%, #ff6a2a 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .stat-box-value {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .stat-box-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table thead {
            background: #f8f8f8;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .table th {
            font-weight: 600;
            color: #333;
        }

        .table tbody tr:hover {
            background: #f8f8f8;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .btn-edit {
            background: #4caf50;
            color: white;
        }

        .btn-delete {
            background: #f44336;
            color: white;
        }

        .note-box {
            background: #fff3cd;
            border-left: 4px solid #ff9800;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            color: #856404;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .table {
                font-size: 0.85rem;
            }

            .table th,
            .table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body style="background: #f8f8f8;">

<!-- Header -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="header__top-content">
                <span class="header__welcome">Admin Panel — Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <div>
                    <a href="index.php" style="color: var(--accent); text-decoration: none; margin-right: 20px;">← Back to Shop</a>
                    <a href="logout.php" class="header__logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="admin-container">
    <div class="admin-header">
        <h1>🛠️ Management Dashboard</h1>
        <p>Manage your scooter parts inventory and installations</p>
    </div>

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-box-value">87</div>
            <div class="stat-box-label">Parts in Stock</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-value">3</div>
            <div class="stat-box-label">Active Installations</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-value">€12,450</div>
            <div class="stat-box-label">Total Inventory Value</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-value">45</div>
            <div class="stat-box-label">Monthly Orders</div>
        </div>
    </div>

    <!-- ADD NEW PART -->
    <div class="admin-section">
        <h2>➕ Add New Part</h2>
        <div class="note-box">
            <strong>Note:</strong> Parts are stored in the MySQL database. After adding, refresh the shop page to see them.
        </div>
        <form method="POST" action="add_part.php">
            <div class="form-row">
                <div class="form-group">
                    <label>Part Name</label>
                    <input type="text" name="name" placeholder="e.g., Polini 70cc Cylinder Kit" required>
                </div>
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" name="brand" placeholder="e.g., Polini" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <option value="Engine">Engine</option>
                        <option value="Engine Internals">Engine Internals</option>
                        <option value="Transmission">Transmission</option>
                        <option value="Exhaust">Exhaust</option>
                        <option value="Carburator">Carburator</option>
                        <option value="Air Filter">Air Filter</option>
                        <option value="Brakes">Brakes</option>
                        <option value="Wheels & Tires">Wheels & Tires</option>
                        <option value="Ignition">Ignition</option>
                        <option value="Fuel">Fuel</option>
                        <option value="Body Parts">Body Parts</option>
                        <option value="Cooling">Cooling</option>
                        <option value="Suspension">Suspension</option>
                        <option value="Lights">Lights</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Accessories">Accessories</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Engine Type</label>
                    <select name="engine_type" required>
                        <option value="">Select Engine Type</option>
                        <option value="50cc 2-Stroke">50cc 2-Stroke</option>
                        <option value="50cc 4-Stroke">50cc 4-Stroke</option>
                        <option value="125cc 4-Stroke">125cc 4-Stroke</option>
                        <option value="300cc">300cc</option>
                        <option value="Universal">Universal</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Price (€)</label>
                    <input type="number" name="price" placeholder="99.99" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Stock Status</label>
                    <select name="stock_status" required>
                        <option value="In Stock">In Stock</option>
                        <option value="Low Stock">Low Stock</option>
                        <option value="Out of Stock">Out of Stock</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Performance Boost</label>
                <input type="text" name="performance_boost" placeholder="e.g., +15 HP" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" placeholder="Detailed description of the part..." required></textarea>
            </div>

            <button type="submit" class="btn btn--primary btn--large">Add Part to Database</button>
        </form>
    </div>

    <!-- LOG INSTALLATION -->
    <div class="admin-section">
        <h2>🔧 Log Installation</h2>
        <form method="POST" action="add_installation.php">
            <div class="form-row">
                <div class="form-group">
                    <label>Scooter Model</label>
                    <input type="text" name="scooter_model" placeholder="e.g., Yamaha Aerox" required>
                </div>
                <div class="form-group">
                    <label>Engine Block</label>
                    <input type="text" name="engine_block" placeholder="e.g., 50cc 2-Stroke" required>
                </div>
            </div>

            <div class="form-group">
                <label>Part Installed</label>
                <input type="text" name="part_name" placeholder="Part name" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="install_date" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="Completed">Completed</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Notes</label>
                <textarea name="notes" placeholder="Installation notes..."></textarea>
            </div>

            <button type="submit" class="btn btn--primary btn--large">Log Installation</button>
        </form>
    </div>

    <!-- INFO -->
    <div class="admin-section">
        <h2>📊 Database Information</h2>
        <p><strong>Database Name:</strong> scooter_shop</p>
        <p><strong>Tables:</strong> parts, installations</p>
        <p><strong>Access:</strong> <a href="http://localhost:8080" target="_blank">phpMyAdmin (localhost:8080)</a></p>
        <p><strong>Login:</strong> student / veiligwachtwoord</p>
        <p style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
            <strong>💡 Tip:</strong> The database has been pre-populated with 50+ scooter parts. You can view them in phpMyAdmin or directly browse them in the shop.
        </p>
    </div>
</div>

</body>
</html>
