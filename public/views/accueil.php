<div class="home-hero">
    <canvas id="footballField3D"></canvas>
    
    <div class="hero-content">
        <div class="hero-text">
            <h1>Bienvenue au Club Sportif</h1>
            <p>Gestion complète de votre club de football</p>
            <a href="index.php?page=dashboard" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-right"></i> Accéder au tableau de bord
            </a>
        </div>
    </div>
</div>

<style>
.home-hero {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

#footballField3D {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: block;
}

.hero-content {
    position: relative;
    z-index: 10;
    text-align: center;
    color: white;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
}

.hero-text h1 {
    font-size: 4rem;
    margin-bottom: 1rem;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.hero-text p {
    font-size: 1.5rem;
    margin-bottom: 2rem;
    font-weight: 300;
}

.btn-lg {
    padding: 15px 40px !important;
    font-size: 1.2rem !important;
}

@media (max-width: 768px) {
    .hero-text h1 {
        font-size: 2rem;
    }
    
    .hero-text p {
        font-size: 1rem;
    }
}
</style>

<script>
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
    
    // Gradient de ciel
    function drawSky() {
        const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
        gradient.addColorStop(0, '#1a472a');
        gradient.addColorStop(0.5, '#2d5a3d');
        gradient.addColorStop(1, '#0d2818');
        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    }
    
    // Terrain de football 3D
    function drawField() {
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        
        // Perspective du terrain
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
        
        // Ligne du milieu
        ctx.beginPath();
        ctx.moveTo(centerX, centerY - 150);
        ctx.lineTo(centerX, centerY + 300);
        ctx.stroke();
        
        // Cercle central
        ctx.beginPath();
        ctx.arc(centerX, centerY + 75, 40, 0, Math.PI * 2);
        ctx.stroke();
        
        // Point central
        ctx.fillStyle = 'rgba(255, 255, 255, 0.6)';
        ctx.beginPath();
        ctx.arc(centerX, centerY + 75, 3, 0, Math.PI * 2);
        ctx.fill();
    }
    
    // Joueurs 3D
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
            
            // Tête
            ctx.fillStyle = '#f4a460';
            ctx.beginPath();
            ctx.arc(0, -15, 5, 0, Math.PI * 2);
            ctx.fill();
            
            // Corps
            ctx.fillStyle = color;
            ctx.fillRect(-4, -8, 8, 10);
            
            // Shorts
            ctx.fillStyle = outlineColor;
            ctx.fillRect(-5, 2, 10, 5);
            
            // Jambes
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
    
    // Création des joueurs
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
    
    // Balle
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
    
    // Animation loop
    function animate() {
        drawSky();
        drawField();
        
        players.forEach(player => {
            player.update();
            player.draw();
            
            // Collision avec la balle
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
