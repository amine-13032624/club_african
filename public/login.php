<?php
session_start();
require_once __DIR__ . '/../src/config/database.php';

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Email et mot de passe requis';
    } else {
        // Pour la démo, créer un compte simple
        // En production, utiliser une base de données
        $correct_email = 'admin@clubsportif.com';
        $correct_password = 'admin123'; // En production, utiliser password_hash()

        if ($email === $correct_email && $password === $correct_password) {
            $_SESSION['user_id'] = 1;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = 'Administrateur';
            header('Location: index.php');
            exit();
        } else {
            $error = 'Email ou mot de passe incorrect';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Sportif - Connexion</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="login-page">
    <!-- Canvas 3D en arrière-plan -->
    <canvas id="footballField3D" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;"></canvas>
    
    <div class="login-container" style="position: relative; z-index: 10;">
        <div class="login-box">
            <div class="login-header">
                <i class="fas fa-trophy"></i>
                <h1>Espérance Sportif de Tunis</h1>
                <p> Taraji++ </p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="<?php echo htmlspecialchars($email); ?>"
                        placeholder="admin@clubsportif.com"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="admin123"
                        required
                    >
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Se souvenir de moi</label>
                </div>

                <button type="submit" class="btn btn-danger btn-block" style="background-color: #DC143C; font-size: 1rem; padding: 0.9rem;">
                    Connexion
                </button>
            </form>

            <!--<div class="login-footer">
                <p>Données de test:</p>
                <p><strong>Email:</strong> admin@clubsportif.com</p>
                <p><strong>Mot de passe:</strong> admin123</p>
            </div>-->
        </div>
    </div>

    <script>
    // Même script 3D que la page d'accueil
    (function() {
        const canvas = document.getElementById('footballField3D');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);
        
        function drawSky() {
            const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
            gradient.addColorStop(0, '#1a472a');
            gradient.addColorStop(0.5, '#2d5a3d');
            gradient.addColorStop(1, '#0d2818');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        }
        
        function drawField() {
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;
            
            ctx.fillStyle = '#1a5d2a';
            ctx.beginPath();
            ctx.moveTo(centerX - 300, centerY - 150);
            ctx.lineTo(centerX + 300, centerY - 150);
            ctx.lineTo(centerX + 200, centerY + 300);
            ctx.lineTo(centerX - 200, centerY + 300);
            ctx.closePath();
            ctx.fill();
            
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.6)';
            ctx.lineWidth = 2;
            ctx.stroke();
            
            ctx.beginPath();
            ctx.moveTo(centerX, centerY - 150);
            ctx.lineTo(centerX, centerY + 300);
            ctx.stroke();
            
            ctx.beginPath();
            ctx.arc(centerX, centerY + 75, 40, 0, Math.PI * 2);
            ctx.stroke();
            
            ctx.fillStyle = 'rgba(255, 255, 255, 0.6)';
            ctx.beginPath();
            ctx.arc(centerX, centerY + 75, 3, 0, Math.PI * 2);
            ctx.fill();
        }
        
        class Player {
            constructor(x, y, team) {
                this.x = x;
                this.y = y;
                this.team = team;
                this.bobbing = Math.random() * Math.PI * 2;
                this.moving = Math.random() > 0.5;
                this.velocity = { x: (Math.random() - 0.5) * 0.5, y: (Math.random() - 0.5) * 0.3 };
            }
            
            update() {
                this.bobbing += 0.05;
                
                if (this.moving) {
                    this.x += this.velocity.x;
                    this.y += this.velocity.y;
                    
                    if (this.x > canvas.width + 50 || this.x < -50 || 
                        this.y > canvas.height + 50 || this.y < -50) {
                        this.moving = false;
                        this.x = canvas.width / 2 + (Math.random() - 0.5) * 400;
                        this.y = canvas.height / 2 + (Math.random() - 0.5) * 200;
                    }
                }
            }
            
            draw() {
                const bounce = Math.sin(this.bobbing) * 3;
                const color = this.team === 'home' ? '#FFD700' : '#000000';
                const outlineColor = this.team === 'home' ? '#DC143C' : '#FFFFFF';
                
                ctx.save();
                ctx.translate(this.x, this.y + bounce);
                
                ctx.fillStyle = '#f4a460';
                ctx.beginPath();
                ctx.arc(0, -15, 5, 0, Math.PI * 2);
                ctx.fill();
                
                ctx.fillStyle = color;
                ctx.fillRect(-4, -8, 8, 10);
                
                ctx.fillStyle = outlineColor;
                ctx.fillRect(-5, 2, 10, 5);
                
                ctx.strokeStyle = '#f4a460';
                ctx.lineWidth = 2;
                ctx.beginPath();
                ctx.moveTo(-2, 7);
                ctx.lineTo(-2, 15);
                ctx.stroke();
                
                ctx.beginPath();
                ctx.moveTo(2, 7);
                ctx.lineTo(2, 15);
                ctx.stroke();
                
                ctx.restore();
            }
        }
        
        const players = [];
        const homeTeam = [];
        const awayTeam = [];
        
        for (let i = 0; i < 6; i++) {
            const player = new Player(
                canvas.width / 2 - 200 + Math.random() * 150,
                canvas.height / 2 - 50 + Math.random() * 100,
                'home'
            );
            players.push(player);
            homeTeam.push(player);
        }
        
        for (let i = 0; i < 6; i++) {
            const player = new Player(
                canvas.width / 2 + 50 + Math.random() * 150,
                canvas.height / 2 - 50 + Math.random() * 100,
                'away'
            );
            players.push(player);
            awayTeam.push(player);
        }
        
        class Ball {
            constructor() {
                this.x = canvas.width / 2;
                this.y = canvas.height / 2;
                this.vx = 0;
                this.vy = 0;
                this.friction = 0.98;
            }
            
            update() {
                this.x += this.vx;
                this.y += this.vy;
                this.vx *= this.friction;
                this.vy *= this.friction;
                
                if (this.x > canvas.width) {
                    this.x = canvas.width;
                    this.vx *= -0.8;
                }
                if (this.x < 0) {
                    this.x = 0;
                    this.vx *= -0.8;
                }
                if (this.y > canvas.height) {
                    this.y = canvas.height;
                    this.vy *= -0.8;
                }
                if (this.y < 0) {
                    this.y = 0;
                    this.vy *= -0.8;
                }
            }
            
            draw() {
                ctx.fillStyle = '#FFFFFF';
                ctx.beginPath();
                ctx.arc(this.x, this.y, 4, 0, Math.PI * 2);
                ctx.fill();
                
                ctx.strokeStyle = '#000000';
                ctx.lineWidth = 1;
                ctx.stroke();
            }
        }
        
        const ball = new Ball();
        
        function animate() {
            drawSky();
            drawField();
            
            players.forEach(player => {
                player.update();
                player.draw();
                
                const dx = player.x - ball.x;
                const dy = player.y - ball.y;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < 10) {
                    ball.vx = (Math.random() - 0.5) * 3;
                    ball.vy = (Math.random() - 0.5) * 3 - 1;
                }
            });
            
            ball.update();
            ball.draw();
            
            requestAnimationFrame(animate);
        }
        
        animate();
    })();
    </script>
</body>
</html>
