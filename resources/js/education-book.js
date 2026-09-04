import * as THREE from 'three';
import gsap from 'gsap';

class Education3DBook {
    constructor() {
        this.container = document.getElementById('book-canvas');
        if (!this.container) return;

        this.data = window.TALOG20_DATA || { jurusans: [], logoUrl: '', berandaUrl: '/beranda' };
        this.width = window.innerWidth;
        this.height = window.innerHeight;

        this.scene = null;
        this.camera = null;
        this.renderer = null;

        // Book parts
        this.bookGroup = null;
        this.coverGroup = null;
        this.backCover = null;
        this.spine = null;
        this.pages = [];
        this.currentPage = 0;
        this.totalPages = 4; // 0: Closed, 1: Welcome/Logo, 2: Majors Page, 3: Finale

        // Interaction state
        this.isOpen = false;
        this.isAnimating = false;
        this.mouse = { x: 0, y: 0, targetX: 0, targetY: 0 };
        this.raycaster = new THREE.Raycaster();
        this.pointer = new THREE.Vector2();

        this.particles = null;

        this.init();
    }

    init() {
        this.createScene();
        this.createLights();
        this.createEnvironment();
        this.createBook();
        this.createParticles();
        this.setupEventListeners();
        this.setupHUD();

        this.animate();

        // Auto start sequence after brief pause
        setTimeout(() => {
            this.showHUD();
            this.openBook();
        }, 800);
    }

    createScene() {
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0x091E42);
        this.scene.fog = new THREE.FogExp2(0x091E42, 0.04);

        const fov = this.width < 768 ? 60 : 45;
        this.camera = new THREE.PerspectiveCamera(fov, this.width / this.height, 0.1, 100);
        this.camera.position.set(0, 3.2, 7.5);
        this.camera.lookAt(0, 0, 0);

        this.renderer = new THREE.WebGLRenderer({
            canvas: this.container,
            antialias: true,
            powerPreference: 'high-performance',
        });
        this.renderer.setSize(this.width, this.height);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
        this.renderer.toneMappingExposure = 1.1;
    }

    createLights() {
        const ambientLight = new THREE.AmbientLight(0xfff6ea, 1.2);
        this.scene.add(ambientLight);

        // Main key light from top-front-right
        const mainLight = new THREE.DirectionalLight(0xfff1d6, 2.2);
        mainLight.position.set(5, 8, 5);
        mainLight.castShadow = true;
        mainLight.shadow.mapSize.width = 1024;
        mainLight.shadow.mapSize.height = 1024;
        mainLight.shadow.camera.near = 0.5;
        mainLight.shadow.camera.far = 20;
        mainLight.shadow.bias = -0.001;
        this.scene.add(mainLight);

        // Warm accent fill light from top-left
        const fillLight = new THREE.DirectionalLight(0xffaa55, 1.0);
        fillLight.position.set(-6, 4, 3);
        this.scene.add(fillLight);

        // Cyan / cool subtle rim light from behind
        const rimLight = new THREE.DirectionalLight(0x4a90e2, 1.2);
        rimLight.position.set(0, -2, -6);
        this.scene.add(rimLight);

        // Warm book reading point light
        const pointLight = new THREE.PointLight(0xff9933, 1.5, 10);
        pointLight.position.set(0, 3, 2);
        this.scene.add(pointLight);
    }

    createEnvironment() {
        // Wood-tone desk / pedestal beneath book
        const deskGeo = new THREE.CylinderGeometry(8, 9, 0.4, 64);
        const deskMat = new THREE.MeshStandardMaterial({
            color: 0x051329,
            roughness: 0.6,
            metalness: 0.2,
        });
        const desk = new THREE.Mesh(deskGeo, deskMat);
        desk.position.y = -1.5;
        desk.receiveShadow = true;
        this.scene.add(desk);

        // Subtle decorative concentric glow rings on desk
        const ringGeo = new THREE.RingGeometry(2.8, 3.0, 64);
        const ringMat = new THREE.MeshBasicMaterial({
            color: 0xff6b00,
            transparent: true,
            opacity: 0.25,
            side: THREE.DoubleSide,
        });
        const ring = new THREE.Mesh(ringGeo, ringMat);
        ring.rotation.x = -Math.PI / 2;
        ring.position.y = -1.29;
        this.scene.add(ring);
    }

    createBook() {
        this.bookGroup = new THREE.Group();
        this.bookGroup.position.set(0, -0.2, 0);
        this.bookGroup.rotation.x = 0.35; // Tilt up toward camera
        this.scene.add(this.bookGroup);

        const bookWidth = 2.4;
        const bookHeight = 3.3;
        const bookDepth = 0.28;

        // Cover textures
        const coverMaterial = new THREE.MeshStandardMaterial({
            color: 0x071b3b,
            roughness: 0.4,
            metalness: 0.3,
        });

        const goldTrimMaterial = new THREE.MeshStandardMaterial({
            color: 0xffa500,
            roughness: 0.3,
            metalness: 0.85,
        });

        // Pages block (right side block)
        const blockGeo = new THREE.BoxGeometry(bookWidth, bookHeight * 0.98, bookDepth);
        const blockMaterials = [
            new THREE.MeshStandardMaterial({ color: 0xf5eedc, roughness: 0.8 }), // right edges
            new THREE.MeshStandardMaterial({ color: 0xf5eedc, roughness: 0.8 }), // left
            new THREE.MeshStandardMaterial({ color: 0xf0e6ce, roughness: 0.9 }), // top edges
            new THREE.MeshStandardMaterial({ color: 0xf0e6ce, roughness: 0.9 }), // bottom edges
            new THREE.MeshStandardMaterial({ map: this.createPageTexture(1) }), // front (right page)
            new THREE.MeshStandardMaterial({ color: 0x071b3b }), // back
        ];
        this.pageBlock = new THREE.Mesh(blockGeo, blockMaterials);
        this.pageBlock.position.set(bookWidth / 2, 0, -bookDepth / 2);
        this.pageBlock.castShadow = true;
        this.pageBlock.receiveShadow = true;
        this.bookGroup.add(this.pageBlock);

        // Back cover (static base)
        const backCoverGeo = new THREE.BoxGeometry(bookWidth + 0.1, bookHeight + 0.1, 0.05);
        this.backCover = new THREE.Mesh(backCoverGeo, coverMaterial);
        this.backCover.position.set(bookWidth / 2, 0, -bookDepth - 0.025);
        this.backCover.castShadow = true;
        this.bookGroup.add(this.backCover);

        // Spine (cylinder segment)
        const spineGeo = new THREE.CylinderGeometry(bookDepth / 2 + 0.02, bookDepth / 2 + 0.02, bookHeight + 0.1, 16, 1, false, 0, Math.PI);
        this.spine = new THREE.Mesh(spineGeo, goldTrimMaterial);
        this.spine.rotation.z = Math.PI / 2;
        this.spine.rotation.y = Math.PI / 2;
        this.spine.position.set(0, 0, -bookDepth / 2);
        this.bookGroup.add(this.spine);

        // Front Cover Pivot Group (pivot placed at spine edge x=0)
        this.coverGroup = new THREE.Group();
        this.coverGroup.position.set(0, 0, 0.02);

        // Front cover mesh
        const frontCoverGeo = new THREE.BoxGeometry(bookWidth + 0.1, bookHeight + 0.1, 0.04);
        const frontCoverMaterials = [
            coverMaterial, coverMaterial, coverMaterial, coverMaterial,
            new THREE.MeshStandardMaterial({ map: this.createCoverTexture() }), // Outer front face
            new THREE.MeshStandardMaterial({ map: this.createPageTexture(0) }), // Inside front page
        ];
        const frontCoverMesh = new THREE.Mesh(frontCoverGeo, frontCoverMaterials);
        frontCoverMesh.position.set(bookWidth / 2 + 0.05, 0, 0.02);
        frontCoverMesh.castShadow = true;
        this.coverGroup.add(frontCoverMesh);

        this.bookGroup.add(this.coverGroup);
    }

    createCoverTexture() {
        const canvas = document.createElement('canvas');
        canvas.width = 1024;
        canvas.height = 1400;
        const ctx = canvas.getContext('2d');

        // Background dark academic navy
        const grad = ctx.createLinearGradient(0, 0, 1024, 1400);
        grad.addColorStop(0, '#0F2B5C');
        grad.addColorStop(0.5, '#091E42');
        grad.addColorStop(1, '#051329');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, 1024, 1400);

        // Gold ornamental border
        ctx.strokeStyle = '#E5A020';
        ctx.lineWidth = 14;
        ctx.strokeRect(40, 40, 944, 1320);

        ctx.strokeStyle = 'rgba(229, 160, 32, 0.4)';
        ctx.lineWidth = 4;
        ctx.strokeRect(60, 60, 904, 1280);

        // Corner flourishes
        const corners = [[60, 60], [964, 60], [60, 1340], [964, 1340]];
        corners.forEach(([cx, cy]) => {
            ctx.fillStyle = '#FFA500';
            ctx.beginPath();
            ctx.arc(cx, cy, 12, 0, Math.PI * 2);
            ctx.fill();
        });

        // Gold title text
        ctx.textAlign = 'center';
        ctx.fillStyle = '#FFFFFF';
        ctx.font = 'bold 56px Inter, sans-serif';
        ctx.fillText('SMKN 20 JAKARTA', 512, 380);

        ctx.fillStyle = '#FFA500';
        ctx.font = 'bold 74px Outfit, sans-serif';
        ctx.fillText('TALOG20', 512, 480);

        ctx.fillStyle = 'rgba(255, 255, 255, 0.85)';
        ctx.font = '28px Inter, sans-serif';
        ctx.fillText('PORTAL TUGAS AKHIR SISWA', 512, 540);

        // Center emblem divider
        ctx.strokeStyle = '#FFA500';
        ctx.lineWidth = 3;
        ctx.beginPath();
        ctx.moveTo(312, 580);
        ctx.lineTo(712, 580);
        ctx.stroke();

        // Center decorative circle for logo
        ctx.beginPath();
        ctx.arc(512, 780, 140, 0, Math.PI * 2);
        ctx.fillStyle = 'rgba(255, 255, 255, 0.08)';
        ctx.fill();
        ctx.strokeStyle = '#FFA500';
        ctx.lineWidth = 6;
        ctx.stroke();

        // Load logo image onto canvas if available
        if (this.data.logoUrl) {
            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.onload = () => {
                ctx.drawImage(img, 402, 670, 220, 220);
                texture.needsUpdate = true;
            };
            img.src = this.data.logoUrl;
        }

        // Subtitle bottom
        ctx.fillStyle = '#FFA500';
        ctx.font = 'bold 30px Inter, sans-serif';
        ctx.fillText('BERKARAKTER • UNGGUL • BERPRESTASI', 512, 1080);

        ctx.fillStyle = 'rgba(255, 255, 255, 0.6)';
        ctx.font = '22px Inter, sans-serif';
        ctx.fillText('Tahun Pelajaran 2024 / 2025', 512, 1140);

        const texture = new THREE.CanvasTexture(canvas);
        texture.anisotropy = 4;
        return texture;
    }

    createPageTexture(pageIndex) {
        const canvas = document.createElement('canvas');
        canvas.width = 1024;
        canvas.height = 1400;
        const ctx = canvas.getContext('2d');

        // Elegant cream paper background
        const bgGrad = ctx.createLinearGradient(0, 0, 1024, 1400);
        bgGrad.addColorStop(0, '#FAF7F0');
        bgGrad.addColorStop(1, '#F3ECE0');
        ctx.fillStyle = bgGrad;
        ctx.fillRect(0, 0, 1024, 1400);

        // Subtle margin lines
        ctx.strokeStyle = 'rgba(15, 43, 92, 0.15)';
        ctx.lineWidth = 2;
        ctx.strokeRect(60, 60, 904, 1280);

        if (pageIndex === 0) {
            // Left inside cover / Prologue
            ctx.textAlign = 'center';
            ctx.fillStyle = '#0F2B5C';
            ctx.font = 'bold 44px Outfit, sans-serif';
            ctx.fillText('Selamat Datang', 512, 220);

            ctx.fillStyle = '#FF6B00';
            ctx.font = 'bold 32px Inter, sans-serif';
            ctx.fillText('di TALOG SMKN 20', 512, 280);

            ctx.strokeStyle = '#FF6B00';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.moveTo(380, 320);
            ctx.lineTo(644, 320);
            ctx.stroke();

            ctx.textAlign = 'left';
            ctx.fillStyle = '#2D3748';
            ctx.font = '26px Inter, sans-serif';
            const lines = [
                'TALOG20 adalah gerbang digital terpadu',
                'untuk memonitor, membimbing, dan',
                'mendokumentasikan karya Tugas Akhir',
                'siswa-siswi berprestasi SMKN 20 Jakarta.',
                '',
                'Melalui kolaborasi antara Guru Penguji,',
                'Guru Pembimbing, dan Siswa, setiap',
                'proses pembelajaran tercipta secara',
                'transparan, terukur, dan bermakna.',
                '',
                'Mari wujudkan karya inovatif terbaik',
                'untuk masa depan bangsa yang gemilang!'
            ];
            let y = 400;
            lines.forEach(l => {
                ctx.fillText(l, 140, y);
                y += 46;
            });

            // Seal bottom
            ctx.textAlign = 'center';
            ctx.fillStyle = '#A0AEC0';
            ctx.font = 'italic 20px Inter, sans-serif';
            ctx.fillText('SMKN 20 Jakarta — Melangkah dengan Pasti', 512, 1260);

        } else {
            // Right page / Jurusan listing
            ctx.textAlign = 'center';
            ctx.fillStyle = '#0F2B5C';
            ctx.font = 'bold 40px Outfit, sans-serif';
            ctx.fillText('KONSENTRASI KEAHLIAN', 512, 180);

            ctx.fillStyle = '#FF6B00';
            ctx.font = 'bold 22px Inter, sans-serif';
            ctx.fillText('SMKN 20 JAKARTA', 512, 220);

            ctx.strokeStyle = '#FF6B00';
            ctx.lineWidth = 3;
            ctx.beginPath();
            ctx.moveTo(400, 246);
            ctx.lineTo(624, 246);
            ctx.stroke();

            // Jurusan cards
            const jurusans = this.data.jurusans || [];
            const displayList = jurusans.length > 0 ? jurusans : [
                { nama: 'Akuntansi & Keuangan Lembaga', kode: 'AKL', deskripsi: 'Pencatatan keuangan modern & audit.' },
                { nama: 'Otomatisasi & Tata Kelola Perkantoran', kode: 'OTKP', deskripsi: 'Administrasi perkantoran & korespondensi.' },
                { nama: 'Bisnis Daring & Pemasaran', kode: 'BDP', deskripsi: 'Digital marketing & e-commerce.' },
                { nama: 'Rekayasa Perangkat Lunak', kode: 'RPL', deskripsi: 'Pengembangan web, mobile & software.' }
            ];

            let startY = 310;
            displayList.slice(0, 4).forEach((j, idx) => {
                // Card background
                ctx.fillStyle = 'rgba(15, 43, 92, 0.05)';
                ctx.beginPath();
                ctx.roundRect(100, startY, 824, 175, 16);
                ctx.fill();

                ctx.strokeStyle = 'rgba(255, 107, 0, 0.4)';
                ctx.lineWidth = 2;
                ctx.stroke();

                // Number badge
                ctx.fillStyle = '#FF6B00';
                ctx.beginPath();
                ctx.arc(150, startY + 45, 26, 0, Math.PI * 2);
                ctx.fill();

                ctx.fillStyle = '#FFFFFF';
                ctx.font = 'bold 24px Inter, sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText(String(idx + 1), 150, startY + 54);

                // Major name
                ctx.textAlign = 'left';
                ctx.fillStyle = '#0F2B5C';
                ctx.font = 'bold 28px Outfit, sans-serif';
                ctx.fillText(j.nama || 'Jurusan', 200, startY + 50);

                // Code tag
                if (j.kode) {
                    ctx.fillStyle = '#E2E8F0';
                    ctx.beginPath();
                    ctx.roundRect(830, startY + 28, 74, 30, 8);
                    ctx.fill();

                    ctx.fillStyle = '#0F2B5C';
                    ctx.font = 'bold 18px Inter, sans-serif';
                    ctx.textAlign = 'center';
                    ctx.fillText(j.kode, 867, startY + 49);
                }

                // Description
                ctx.textAlign = 'left';
                ctx.fillStyle = '#4A5568';
                ctx.font = '22px Inter, sans-serif';
                const desc = (j.deskripsi || 'Program keahlian unggulan berstandar industri.').slice(0, 68);
                ctx.fillText(desc + (desc.length >= 68 ? '...' : ''), 200, startY + 95);

                startY += 205;
            });

            ctx.textAlign = 'center';
            ctx.fillStyle = '#718096';
            ctx.font = 'italic 20px Inter, sans-serif';
            ctx.fillText('Klik tombol "Masuk ke Beranda" untuk memulai', 512, 1260);
        }

        const texture = new THREE.CanvasTexture(canvas);
        texture.anisotropy = 4;
        return texture;
    }

    createParticles() {
        const particleCount = 120;
        const geometry = new THREE.BufferGeometry();
        const positions = new Float32Array(particleCount * 3);
        const scales = new Float32Array(particleCount);

        for (let i = 0; i < particleCount * 3; i += 3) {
            positions[i] = (Math.random() - 0.5) * 16;
            positions[i + 1] = Math.random() * 8 - 2;
            positions[i + 2] = (Math.random() - 0.5) * 12;
            scales[i / 3] = Math.random();
        }

        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        geometry.setAttribute('scale', new THREE.BufferAttribute(scales, 1));

        const material = new THREE.PointsMaterial({
            color: 0xffaa44,
            size: 0.08,
            transparent: true,
            opacity: 0.6,
            blending: THREE.AdditiveBlending,
        });

        this.particles = new THREE.Points(geometry, material);
        this.scene.add(this.particles);
    }

    setupHUD() {
        this.brandBadge = document.getElementById('brand-badge');
        this.bottomCta = document.getElementById('bottom-cta');
        this.btnSkip = document.getElementById('btn-skip');
        this.pageInfo = document.getElementById('page-info');
        this.btnBeranda = document.getElementById('btn-beranda');
        this.overlay = document.getElementById('transition-overlay');

        if (this.btnBeranda) {
            this.btnBeranda.addEventListener('click', (e) => {
                e.preventDefault();
                this.transitionToBeranda();
            });
        }

        if (this.btnSkip) {
            this.btnSkip.addEventListener('click', (e) => {
                e.preventDefault();
                this.transitionToBeranda();
            });
        }
    }

    showHUD() {
        if (this.brandBadge) this.brandBadge.style.opacity = '1';
        if (this.bottomCta) this.bottomCta.style.opacity = '1';
        if (this.btnSkip) this.btnSkip.style.opacity = '1';
        if (this.pageInfo) this.pageInfo.style.opacity = '1';
    }

    openBook() {
        if (this.isOpen || this.isAnimating) return;
        this.isAnimating = true;

        // Smooth opening animation with GSAP
        gsap.to(this.coverGroup.rotation, {
            y: -Math.PI * 0.94,
            duration: 2.2,
            ease: 'power3.inOut',
            onUpdate: () => {
                // Adjust position slightly to emulate real spine tension
                this.coverGroup.position.z = Math.sin(-this.coverGroup.rotation.y) * 0.05 + 0.02;
            },
            onComplete: () => {
                this.isOpen = true;
                this.isAnimating = false;
                this.updatePageDots(1);
            }
        });

        // Lift & center book smoothly as it opens
        gsap.to(this.bookGroup.position, {
            x: 0.8,
            y: 0.1,
            z: 0.4,
            duration: 2.2,
            ease: 'power3.inOut',
        });

        gsap.to(this.bookGroup.rotation, {
            x: 0.45,
            y: 0.08,
            duration: 2.2,
            ease: 'power3.inOut',
        });
    }

    updatePageDots(idx) {
        const dots = document.querySelectorAll('.page-dot');
        dots.forEach((dot, i) => {
            if (i === idx) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    transitionToBeranda() {
        if (this.overlay) {
            this.overlay.classList.add('active');
        }

        // Camera zoom in cinematic effect
        gsap.to(this.camera.position, {
            z: 2.5,
            y: 1.0,
            duration: 0.6,
            ease: 'power2.in',
            onComplete: () => {
                window.location.href = this.data.berandaUrl || '/beranda';
            }
        });
    }

    setupEventListeners() {
        window.addEventListener('resize', () => this.onResize());

        window.addEventListener('pointermove', (e) => {
            this.mouse.targetX = (e.clientX / this.width - 0.5) * 2;
            this.mouse.targetY = (e.clientY / this.height - 0.5) * 2;
            this.pointer.x = (e.clientX / this.width) * 2 - 1;
            this.pointer.y = -(e.clientY / this.height) * 2 + 1;
        });

        // Click canvas to toggle or interact
        this.container.addEventListener('click', () => {
            if (!this.isOpen && !this.isAnimating) {
                this.openBook();
            }
        });
    }

    onResize() {
        this.width = window.innerWidth;
        this.height = window.innerHeight;
        this.camera.aspect = this.width / this.height;
        this.camera.fov = this.width < 768 ? 60 : 45;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(this.width, this.height);
    }

    animate() {
        requestAnimationFrame(() => this.animate());

        // Smooth mouse parallax lerp
        this.mouse.x += (this.mouse.targetX - this.mouse.x) * 0.04;
        this.mouse.y += (this.mouse.targetY - this.mouse.y) * 0.04;

        if (this.bookGroup) {
            // Subtle idle breathing float
            const time = performance.now() * 0.001;
            this.bookGroup.position.y += Math.sin(time * 1.5) * 0.0008;

            // Interactive tilt response
            const baseRotY = this.isOpen ? 0.08 : 0;
            const baseRotX = this.isOpen ? 0.45 : 0.35;
            this.bookGroup.rotation.y = baseRotY + this.mouse.x * 0.12;
            this.bookGroup.rotation.x = baseRotX - this.mouse.y * 0.08;
        }

        // Particle floating
        if (this.particles) {
            const pos = this.particles.geometry.attributes.position.array;
            for (let i = 1; i < pos.length; i += 3) {
                pos[i] += 0.004;
                if (pos[i] > 6) pos[i] = -2;
            }
            this.particles.geometry.attributes.position.needsUpdate = true;
            this.particles.rotation.y += 0.0008;
        }

        this.renderer.render(this.scene, this.camera);
    }
}

// Instantiate when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new Education3DBook();
});
