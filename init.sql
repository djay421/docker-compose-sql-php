CREATE DATABASE IF NOT EXISTS scooterparts;
USE scooterparts;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT IGNORE INTO users (username, password) VALUES ('admin', '$2y$10$YourHashHere');
INSERT IGNORE INTO users (username, password) VALUES ('mechanic', '$2y$10$YourHashHere');

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    color_class VARCHAR(50) DEFAULT 'badge--body'
);

INSERT IGNORE INTO categories (name, slug, color_class) VALUES
    ('Engine',       'engine',      'badge--engine'),
    ('Exhaust',      'exhaust',     'badge--exhaust'),
    ('Suspension',   'suspension',  'badge--suspension'),
    ('Brakes',       'brakes',      'badge--brakes'),
    ('Body & Frame', 'body',        'badge--body'),
    ('Electrical',   'electrical',  'badge--electrical'),
    ('Drivetrain',   'drivetrain',  'badge--drivetrain'),
    ('Fuel System',  'fuel',        'badge--fuel');

CREATE TABLE IF NOT EXISTS parts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(100),
    category_id INT,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock INT NOT NULL DEFAULT 0,
    compatibility TEXT,
    description TEXT,
    weight_g INT,
    material VARCHAR(100),
    image_url VARCHAR(500),
    featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

INSERT IGNORE INTO parts
  (sku, name, brand, category_id, price, stock, compatibility, description, weight_g, material, image_url, featured)
VALUES
-- ENGINE
('ENG-001', 'High-Performance Piston Kit 50cc', 'Polini', 1, 89.95, 18, 'Peugeot 103, MBK 51, Honda Vision 50', 'Forged aluminum piston with chrome rings, oversize +2mm. Designed for high-RPM reliability and power gains.', 320, 'Forged Aluminum', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80', 1),
('ENG-002', 'Racing Cylinder 70cc Nikasil', 'Malossi', 1, 149.00, 9,  'Peugeot Speedfight, Vivacity, TKT', 'Nikasil-coated aluminum cylinder with transfer ports for maximum scavenging. +20hp potential.', 1100, 'Nikasil Aluminum', 'https://images.unsplash.com/photo-1629385704773-94ea96b0acea?w=600&q=80', 1),
('ENG-003', 'Racing Crankshaft 10mm Pin', 'DR Racing', 1, 112.50, 6,  'Honda Dio, Kymco, SYM Orbit', 'Reinforced steel racing crankshaft with oversized 10mm wrist pin. Needle bearing big-end.', 2200, 'Chromoly Steel', 'https://images.unsplash.com/photo-1619551734325-81176a4a0893?w=600&q=80', 0),
('ENG-004', 'Cylinder Head 50cc Performance', 'Minarelli', 1, 64.00, 14, 'Yamaha Jog, Aerox, BW''s 50', 'CNC-machined combustion chamber, higher compression ratio 12:1, improved squish band.', 580, 'Aluminum Alloy', 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=600&q=80', 0),
('ENG-005', 'Reed Valve Block Carbon Fiber', 'Polini', 1, 38.50, 25, 'Universal AM6, Derbi, Minarelli', 'Carbon-fibre petals for faster response and higher rpm. 6-petal configuration, +15% flow rate.', 85, 'Carbon Fiber', 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?w=600&q=80', 0),
-- EXHAUST
('EXH-001', 'Full Race Exhaust System 28mm', 'Tecnigas Next R', 2, 179.00, 7,  'Peugeot Speedfight 2, Vivacity', 'Stainless expansion chamber with silencer. Hand-TIG welded. +8 km/h top speed gain.', 2800, 'Stainless 304', 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=600&q=80', 1),
('EXH-002', 'Arrow Racing Exhaust Titanium', 'Arrow', 2, 285.00, 3,  'Vespa GTS 300, GT 200', 'Full titanium race exhaust, 60% lighter than stock. DN 54mm outlet. Euro 4 compliant.', 1100, 'Grade 5 Titanium', 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=600&q=80', 1),
('EXH-003', 'Expansion Chamber 50cc Street', 'Giannelli', 2, 95.00, 12, 'Derbi, Aprilia RS, MBK', 'Street-legal expansion chamber, powder-coated black. Bolt-on fitment, no modifications needed.', 2100, 'Mild Steel', 'https://images.unsplash.com/photo-1622200421183-f5e45f76cf84?w=600&q=80', 0),
('EXH-004', 'Carbon End Can Silencer', 'Leovince', 2, 67.00, 19, 'Universal 28-32mm inlet', 'Carbon fiber end cap with aluminum core. Slip-on fit. DB killer included.', 650, 'Carbon / Aluminum', 'https://images.unsplash.com/photo-1490007424572-be16c1a3e29c?w=600&q=80', 0),
-- SUSPENSION
('SUS-001', 'Adjustable Front Fork Springs', 'YSS', 3, 59.00, 22, 'Most 50cc–125cc scooters (38mm fork)', 'Progressive rate springs 0.8–1.2 N/mm. 5-position preload adjuster. Anodized red.', 480, 'Spring Steel', 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?w=600&q=80', 0),
('SUS-002', 'Rear Shock Absorber Sport 340mm', 'Bitubo', 3, 129.00, 10, 'Piaggio Zip, Liberty, Fly 50–150', 'Twin-tube hydraulic rear shock. 6-position preload. Oil + gas charged. Red spring.', 1200, 'Steel / Aluminum', 'https://images.unsplash.com/photo-1597766353939-a1ece35a6ede?w=600&q=80', 1),
('SUS-003', 'Steering Damper Kit', 'Öhlins', 3, 215.00, 4,  'Yamaha TMAX 500/530, Kymco AK550', 'Hydraulic steering stabilizer with remote adjuster. Prevents high-speed weave. CNC mount.', 780, 'Aluminum / Steel', 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?w=600&q=80', 0),
-- BRAKES
('BRK-001', 'Front Brake Disc 190mm Wave', 'Galfer', 4, 42.00, 30, 'Honda PCX 125, SH 125/150', 'Stainless wave-pattern disc. 190mm diameter, 3.5mm thick. Weight saving 25% vs OEM.', 520, 'Stainless 420 HB', 'https://images.unsplash.com/photo-1558981359-219d6364c9c8?w=600&q=80', 0),
('BRK-002', 'Brembo Racing Caliper CNC', 'Brembo', 4, 310.00, 2,  'Universal radial mount 100mm', 'CNC-machined Brembo monobloc caliper. 4-piston. Radial mount. Titanium bolts included.', 820, 'CNC Aluminum 7075', 'https://images.unsplash.com/photo-1558618047-f4e90feda3a8?w=600&q=80', 1),
('BRK-003', 'Sintered Brake Pads Front', 'EBC', 4, 22.50, 45, 'Most 50–150cc scooters', 'Sintered metal compound for wet & dry performance. Low dust, long-lasting. Pre-bedded.', 180, 'Sintered Metal', 'https://images.unsplash.com/photo-1493238792000-8113da705763?w=600&q=80', 0),
('BRK-004', 'Stainless Brake Line Kit', 'Goodridge', 4, 34.99, 28, 'Piaggio MP3, Beverly 300', 'Braided stainless steel lines reduce flex 100%. Includes all fittings and banjo bolts.', 220, 'Stainless Braided', 'https://images.unsplash.com/photo-1582562124811-c09040d0a901?w=600&q=80', 0),
-- BODY & FRAME
('BOD-001', 'Carbon Fiber Front Fairing', 'Bodystyle', 5, 189.00, 5,  'Yamaha Aerox 50, 2020–2024', 'Dry carbon 3K twill weave fairing. UV clear coat. 300g vs 1100g OEM plastic.', 300, 'Carbon Fiber 3K', 'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?w=600&q=80', 1),
('BOD-002', 'Rear Hugger Carbon', 'Puig', 5, 78.00, 11, 'Honda Forza 125 2019+', 'Gloss carbon rear hugger. Prevents tyre spray on shock/chain. Bolts directly to swingarm.', 190, 'Carbon Fiber', 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=600&q=80', 0),
('BOD-003', 'Universal Screen Sport Dark Smoke', 'MRA', 5, 55.00, 16, 'Universal 250–530mm width', 'Polycarbonate dark smoke screen. +80mm height. Pre-drilled holes, no trimming needed.', 380, 'Polycarbonate', 'https://images.unsplash.com/photo-1558980394-0a06c4631733?w=600&q=80', 0),
('BOD-004', 'Frame Slider Set CNC Aluminum', 'R&G', 5, 48.99, 20, 'Vespa GTS 125–300, 2017+', 'CNC 6061-T6 sliders. Delrin pucks absorb impacts. Prevents catastrophic frame damage.', 360, 'Aluminum + Delrin', 'https://images.unsplash.com/photo-1582647509711-c8aa8a8bda71?w=600&q=80', 0),
-- ELECTRICAL
('ELC-001', 'Racing CDI Ignition Unit', 'Polini', 6, 44.00, 33, 'Minarelli / Yamaha 50cc', 'Performance CDI removes rev-limiter. Optimized advance curve for racing cams.', 95, 'ABS + Electronic', 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=600&q=80', 0),
('ELC-002', 'LED Headlight H4 6000K 60W', 'Osram', 6, 32.00, 50, 'Universal H4 socket', 'Canbus-ready LED H4 bulb. 6000K white. Plug-and-play. IP67 waterproof. 5000 lm.', 60, 'Aluminum / LED', 'https://images.unsplash.com/photo-1603791440384-56cd371ee9a7?w=600&q=80', 0),
('ELC-003', 'Li-Ion Battery 12V 6Ah Lithium', 'Shorai', 6, 98.00, 8,  'Universal YTX7A-BS replacement', 'Lithium-iron-phosphate battery. 70% lighter than lead-acid. 1000+ charge cycles.', 450, 'LiFePO4', 'https://images.unsplash.com/photo-1593941707882-a5bba14938c7?w=600&q=80', 1),
('ELC-004', 'Ignition Coil High Output', 'Ducati Energia', 6, 26.50, 24, 'Most Italian 50cc scooters', 'High-output coil 40kV spark energy. OEM replacement, direct fit. Improved cold start.', 210, 'Epoxy Resin / Steel', 'https://images.unsplash.com/photo-1558618048-fbd6a5012551?w=600&q=80', 0),
-- DRIVETRAIN
('DRV-001', 'Racing Variator Kit', 'Malossi', 7, 89.00, 15, 'Piaggio / Gilera 50cc Leader', 'CNC variator with 18g tungsten sliders and contra spring kit. Optimized for 70cc kits.', 550, 'Aluminum / Tungsten', 'https://images.unsplash.com/photo-1598300056393-4aac492f4344?w=600&q=80', 1),
('DRV-002', 'Reinforced Drive Belt', 'Gates', 7, 18.50, 60, 'Yamaha / MBK 50–100cc', 'Kevlar-reinforced V-belt. Heat-resistant to 160°C. Longer life vs OEM belt.', 140, 'Kevlar / Rubber', 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?w=600&q=80', 0),
('DRV-003', 'Torque Driver Clutch Sport', 'Polini', 7, 55.00, 18, 'Minarelli / Derbi 50cc', 'Reinforced clutch with uprated springs. Reduces engagement RPM for faster launch.', 420, 'Aluminum / Steel', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80', 0),
-- FUEL
('FUL-001', 'Performance Carburettor 17.5mm', 'PHBH Dellorto', 8, 72.00, 9,  'Universal Minarelli / Piaggio', 'Dellorto PHBH 17.5mm carb. Slide type. Ideal for 70cc kits. Includes jets 70–100.', 310, 'Zinc Die-Cast', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&q=80', 1),
('FUL-002', 'Fuel Tap Petcock with Filter', 'Pingel', 8, 28.00, 22, 'Universal M16x1.5 thread', 'High-flow 5/16" petcock with inline filter. Reserve position. 3x OEM flow rate.', 95, 'Brass / Nylon', 'https://images.unsplash.com/photo-1581092795360-fd1ca04f0952?w=600&q=80', 0),
('FUL-003', 'Power Jet Kit for Dellorto/Keihin', 'Malossi', 8, 19.50, 35, 'PHBH, PHBL, PHVA carburettors', 'Power jet kit adds extra fuel at WOT. Eliminates lean-out. Includes jets 35/40/45/50.', 30, 'Brass', 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?w=600&q=80', 0);
