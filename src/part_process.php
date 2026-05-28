<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$conn = require 'partials/dbconnection.php';

$action = $_POST['action'] ?? '';

switch ($action) {

    // ── ADD ──────────────────────────────────────────────────────────────────
    case 'add':
        $sku     = trim($_POST['sku']           ?? '');
        $name    = trim($_POST['name']          ?? '');
        $brand   = trim($_POST['brand']         ?? '');
        $catId   = (int)($_POST['category_id']  ?? 0);
        $price   = (float)($_POST['price']      ?? 0);
        $stock   = (int)($_POST['stock']        ?? 0);
        $weight  = $_POST['weight_g'] !== '' ? (int)$_POST['weight_g'] : null;
        $mat     = trim($_POST['material']      ?? '');
        $compat  = trim($_POST['compatibility'] ?? '');
        $img     = trim($_POST['image_url']     ?? '');
        $desc    = trim($_POST['description']   ?? '');
        $feat    = isset($_POST['featured']) ? 1 : 0;

        $stmt = $conn->prepare(
            "INSERT INTO parts
                (sku, name, brand, category_id, price, stock, weight_g, material, compatibility, image_url, description, featured)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "sssidiiisssi",
            $sku, $name, $brand, $catId, $price, $stock, $weight, $mat, $compat, $img, $desc, $feat
        );
        $stmt->execute();
        $stmt->close();
        header('Location: index.php?added=1');
        exit;

    // ── EDIT ─────────────────────────────────────────────────────────────────
    case 'edit':
        $id      = (int)($_POST['id']           ?? 0);
        $sku     = trim($_POST['sku']           ?? '');
        $name    = trim($_POST['name']          ?? '');
        $brand   = trim($_POST['brand']         ?? '');
        $catId   = (int)($_POST['category_id']  ?? 0);
        $price   = (float)($_POST['price']      ?? 0);
        $stock   = (int)($_POST['stock']        ?? 0);
        $weight  = $_POST['weight_g'] !== '' ? (int)$_POST['weight_g'] : null;
        $mat     = trim($_POST['material']      ?? '');
        $compat  = trim($_POST['compatibility'] ?? '');
        $img     = trim($_POST['image_url']     ?? '');
        $desc    = trim($_POST['description']   ?? '');
        $feat    = isset($_POST['featured']) ? 1 : 0;

        $stmt = $conn->prepare(
            "UPDATE parts SET
                sku=?, name=?, brand=?, category_id=?, price=?, stock=?, weight_g=?,
                material=?, compatibility=?, image_url=?, description=?, featured=?
             WHERE id=?"
        );
        $stmt->bind_param(
            "sssidiiisssi i",
            $sku, $name, $brand, $catId, $price, $stock, $weight,
            $mat, $compat, $img, $desc, $feat, $id
        );
        $stmt->execute();
        $stmt->close();
        header('Location: index.php?edited=1');
        exit;

    // ── DELETE ────────────────────────────────────────────────────────────────
    case 'delete':
        $id = (int)($_POST['id'] ?? 0);
        $stmt = $conn->prepare("DELETE FROM parts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header('Location: index.php?deleted=1');
        exit;

    default:
        header('Location: index.php');
        exit;
}
