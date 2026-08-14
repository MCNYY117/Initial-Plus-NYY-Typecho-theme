/**
 * Weather System v5.2
 * 视觉粒子效果 + 5分钟自动循环（数据由导航栏JS通过API获取并同步）
 */
const WeatherSystem = {
    canvas: null,
    ctx: null,
    width: 0,
    height: 0,
    particles: [],
    animationId: null,
    currentType: 'none', 
    container: null,
    autoCycleTimer: null,
    cycleSequence: ['sunny', 'rain', 'snow', 'none'],
    cycleIndex: 0,

    init: function() {
        this.container = document.getElementById('weather-container');
        if (this.container) {
            this.container.style.pointerEvents = 'none';
            this.container.style.zIndex = '0';
        }
        this.canvas = document.getElementById('weather-canvas');
        if (!this.canvas || !this.container) return;

        this.ctx = this.canvas.getContext('2d');
        this.resize();
        window.addEventListener('resize', () => this.resize());

        // 恢复上次的视觉主题（导航栏API会覆盖此值）
        var saved = localStorage.getItem('weather') || 'none';
        this.setWeather(saved);

        // 5分钟后启动自动循环（导航栏API如果成功会通过 setWeather 重置计时器）
        this.autoCycleTimer = setTimeout(() => {
            this.startAutoCycle();
        }, 5 * 60 * 1000);
    },

    // ===========================
    // 自动循环（5分钟切换一次）
    // ===========================
    startAutoCycle: function() {
        this.stopAutoCycle();
        var currentIdx = this.cycleSequence.indexOf(this.currentType);
        this.cycleIndex = currentIdx >= 0 ? currentIdx : 0;

        this.autoCycleTimer = setInterval(() => {
            this.cycleIndex = (this.cycleIndex + 1) % this.cycleSequence.length;
            this.setWeather(this.cycleSequence[this.cycleIndex]);
            this.syncToggleButton();
        }, 5 * 60 * 1000);
    },

    stopAutoCycle: function() {
        if (this.autoCycleTimer) {
            clearInterval(this.autoCycleTimer);
            this.autoCycleTimer = null;
        }
    },

    syncToggleButton: function() {
        var btn = document.getElementById('weather-btn');
        if (btn) {
            btn.innerHTML = '<i class="ti ' + this.getCurrentIconClass() + '"></i>';
        }
    },

    // ===========================
    // 视觉渲染
    // ===========================
    resize: function() {
        if (!this.container) return;
        this.width = this.container.offsetWidth;
        this.height = this.container.offsetHeight;
        this.canvas.width = this.width;
        this.canvas.height = this.height;
    },

    setWeather: function(type) {
        if (type === this.currentType) return;
        this.stopLoop();
        this.clearSunny();
        this.particles = [];
        if (this.ctx) this.ctx.clearRect(0, 0, this.width, this.height);

        if (this.canvas) {
            this.canvas.style.pointerEvents = 'none';
            if (type === 'none') this.canvas.classList.remove('active');
            else this.canvas.classList.add('active');
        }

        this.currentType = type;
        localStorage.setItem('weather', type);

        var html = document.documentElement;
        if (type === 'rain' || type === 'snow') html.classList.add('weather-overcast');
        else html.classList.remove('weather-overcast');

        switch (type) {
            case 'sunny': this.startSunny(); break;
            case 'rain': this.initRain(); this.startLoop(); break;
            case 'snow': this.initSnow(); this.startLoop(); break;
            default: break;
        }
    },

    startSunny: function() {
        if (!this.container.querySelector('.sun-spot')) {
            var s1 = document.createElement('div'); s1.className = 'sun-spot spot-1';
            var s2 = document.createElement('div'); s2.className = 'sun-spot spot-2';
            var s3 = document.createElement('div'); s3.className = 'sun-spot spot-3';
            this.container.appendChild(s1);
            this.container.appendChild(s2);
            this.container.appendChild(s3);
        }
    },

    clearSunny: function() {
        var spots = this.container.querySelectorAll('.sun-spot');
        spots.forEach(function(el) { el.remove(); });
    },

    initSnow: function() {
        var count = window.innerWidth < 768 ? 40 : 80;
        for (var i = 0; i < count; i++) {
            this.particles.push({
                x: Math.random() * this.width,
                y: Math.random() * this.height,
                r: Math.random() * 2 + 1,
                vy: Math.random() * 0.5 + 0.3,
                swing: Math.random() * Math.PI * 2,
                swingSpeed: Math.random() * 0.02 + 0.01
            });
        }
    },

    drawSnow: function() {
        this.ctx.clearRect(0, 0, this.width, this.height);
        this.ctx.fillStyle = "rgba(255, 255, 255, 0.9)";
        this.ctx.beginPath();
        for (var i = 0; i < this.particles.length; i++) {
            var p = this.particles[i];
            this.ctx.moveTo(p.x, p.y);
            this.ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2, true);
            p.y += p.vy;
            p.swing += p.swingSpeed;
            p.x += Math.sin(p.swing) * 0.5;
            if (p.x > this.width + 5 || p.x < -5 || p.y > this.height) {
                if (i % 3 > 0) { p.x = Math.random() * this.width; p.y = -10; }
                else { p.x = Math.random() > 0.5 ? -5 : this.width + 5; p.y = Math.random() * this.height; }
            }
        }
        this.ctx.fill();
    },

    initRain: function() {
        var count = window.innerWidth < 768 ? 60 : 120;
        for (var i = 0; i < count; i++) {
            this.particles.push({
                x: Math.random() * this.width,
                y: Math.random() * this.height,
                l: Math.random() * 20 + 10,
                vx: -0.5 + Math.random() * 0.5,
                vy: Math.random() * 10 + 15
            });
        }
    },

    drawRain: function() {
        this.ctx.clearRect(0, 0, this.width, this.height);
        this.ctx.lineWidth = 1.5;
        this.ctx.lineCap = 'round';
        this.ctx.strokeStyle = 'rgba(84, 107, 133, 0.5)';
        this.ctx.beginPath();
        for (var i = 0; i < this.particles.length; i++) {
            var p = this.particles[i];
            this.ctx.moveTo(p.x, p.y);
            this.ctx.lineTo(p.x + p.vx, p.y + p.l);
            p.x += p.vx;
            p.y += p.vy;
            if (p.y > this.height) { p.x = Math.random() * this.width; p.y = -p.l - 10; }
        }
        this.ctx.stroke();
    },

    startLoop: function() {
        var self = this;
        var loop = function() {
            if (self.currentType === 'rain') { self.drawRain(); self.animationId = requestAnimationFrame(loop); }
            else if (self.currentType === 'snow') { self.drawSnow(); self.animationId = requestAnimationFrame(loop); }
        };
        loop();
    },

    stopLoop: function() {
        if (this.animationId) { cancelAnimationFrame(this.animationId); this.animationId = null; }
    },

    toggleNext: function() {
        var types = ['none', 'sunny', 'rain', 'snow'];
        var idx = types.indexOf(this.currentType);
        this.setWeather(types[(idx + 1) % types.length]);
        return this.getCurrentIconClass();
    },

    getCurrentIconClass: function() {
        switch(this.currentType) {
            case 'none': return 'ti-cloud-off';
            case 'sunny': return 'ti-sun';
            case 'rain': return 'ti-cloud-rain';
            case 'snow': return 'ti-snowflake';
            default: return 'ti-cloud-off';
        }
    }
};

window.WeatherSystem = WeatherSystem;
