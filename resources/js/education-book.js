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

        // Book parts & dimensions
        this.PAGE_WIDTH = 2.2;
        this.PAGE_HEIGHT = 3.1;
        this.PAGE_DEPTH = 0.08;
        this.COVER_WIDTH = 2.3;
        this.COVER_HEIGHT = 3.24;
        this.COVER_DEPTH = 0.04;

        this.bookGroup = null;
        this.coverGroup = null;
        this.rightPageBlock = null;
        this.leftPageBlock = null;
        this.rightPageBgMaterial = null;
        this.contentMesh = null;
        this.contentMaterial = null;
        this.contentTexture = null;
        this.jurusanHitMeshes = [];
        this.hoveredJurusanIdx = -1;

        // Pagination state
        this.ITEMS_PER_PAGE = 4;
        const slideMatch = window.location.search.match(/slide=(\d+)/);
        this.currentSlide = slideMatch ? parseInt(slideMatch[1]) : 0;
        this.isSliding = false;

        // Tooltip DOM
        this.tooltip = document.getElementById('jurusan-tooltip');
        this.tooltipBadge = document.getElementById('tooltip-badge');
        this.tooltipTitle = document.getElementById('tooltip-title');
        this.tooltipDesc = document.getElementById('tooltip-desc');

        // Interaction state
        this.isOpen = false;
        this.isAnimating = false;
        this.mouse = { x: 0, y: 0, targetX: 0, targetY: 0 };
        this.raycaster = new THREE.Raycaster();
        this.pointer = new THREE.Vector2();

        this.particles = null;

        // Persistent 2D canvas for right page content overlay (reused always, zero re-allocations)
        this.contentCanvas = document.createElement('canvas');
        this.contentCanvas.width = 2048;
        this.contentCanvas.height = 2800;
        this.contentCtx = this.contentCanvas.getContext('2d');

        // Performance: RAF-based pointer throttling
        this._pointerDirty = false;
        this._pointerEvent = null;

        // Performance: particle update frame skip
        this._frameCount = 0;

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

        if (window.location.search.includes('open')) {
            this.coverGroup.rotation.y = -Math.PI;
            this.coverGroup.position.z = -this.PAGE_DEPTH;
            this.bookGroup.position.set(0, 0, 0);
            this.bookGroup.rotation.set(0, 0, 0);
            this.isOpen = true;
            this.showHUD();
            this.updatePageDots(1);

            if (window.location.search.includes('hover=')) {
                const match = window.location.search.match(/hover=(\d+)/);
                const hIdx = match ? parseInt(match[1]) : 0;
                const jur = (this.data.jurusans && this.data.jurusans[hIdx]) ? this.data.jurusans[hIdx] : { name: 'Rekayasa Perangkat Lunak', description: 'Jurusan yang mempelajari pengembangan perangkat lunak, pemrograman, dan sistem informasi.' };
                setTimeout(() => {
                    this.onJurusanHover(hIdx, jur, this.getJurusanCode(jur.name || jur.nama), 720, 260);
                }, 300);
            }

            if (window.location.search.includes('slide=')) {
                const match = window.location.search.match(/slide=(\d+)/);
                const sIdx = match ? parseInt(match[1]) : 0;
                setTimeout(() => {
                    this.goToSlide(sIdx);
                }, 400);
            }
        } else {
            // Auto start sequence after brief pause
            setTimeout(() => {
                this.showHUD();
                this.openBook();
            }, 800);
        }
    }

    createScene() {
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0x081735);
        this.scene.fog = new THREE.FogExp2(0x081735, 0.035);

        // Front-facing camera: eye level with the book center (0, 0, 0)
        const fov = this.width < 768 ? 62 : 46;
        this.camera = new THREE.PerspectiveCamera(fov, this.width / this.height, 0.1, 100);
        this.camera.position.set(0, 0, 5.7);
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
        this.renderer.outputColorSpace = THREE.SRGBColorSpace;
        this.renderer.toneMapping = THREE.NoToneMapping;
        this.renderer.toneMappingExposure = 1.0;
    }

    createLights() {
        // Balanced ambient fill
        const ambientLight = new THREE.AmbientLight(0xfff6ea, 1.0);
        this.scene.add(ambientLight);

        // Key light from front-top
        const keyLight = new THREE.DirectionalLight(0xfffaed, 1.4);
        keyLight.position.set(2.0, 4.0, 5.0);
        keyLight.castShadow = true;
        keyLight.shadow.mapSize.width = 512;  // 512 is plenty for this scene
        keyLight.shadow.mapSize.height = 512;
        keyLight.shadow.camera.near = 0.5;
        keyLight.shadow.camera.far = 20;
        keyLight.shadow.bias = -0.0008;
        this.scene.add(keyLight);

        // Soft left fill
        const leftFill = new THREE.DirectionalLight(0xffaf55, 0.6);
        leftFill.position.set(-4, 2, 3);
        this.scene.add(leftFill);

        // Subtle cool rim light from behind
        const rimLight = new THREE.DirectionalLight(0x4080dd, 0.8);
        rimLight.position.set(0, 2, -5);
        this.scene.add(rimLight);
    }

    createEnvironment() {
        // Circular display podium beneath book
        const podiumGeo = new THREE.CylinderGeometry(4.2, 4.6, 0.35, 64);
        const podiumMat = new THREE.MeshStandardMaterial({
            color: 0x051329,
            roughness: 0.5,
            metalness: 0.3,
        });
        const podium = new THREE.Mesh(podiumGeo, podiumMat);
        podium.position.y = -2.0;
        podium.receiveShadow = true;
        this.scene.add(podium);

        // Concentric glowing halo ring on podium
        const ringGeo = new THREE.RingGeometry(3.0, 3.16, 64);
        const ringMat = new THREE.MeshBasicMaterial({
            color: 0xff6b00,
            transparent: true,
            opacity: 0.45,
            side: THREE.DoubleSide,
        });
        const ring = new THREE.Mesh(ringGeo, ringMat);
        ring.rotation.x = -Math.PI / 2;
        ring.position.y = -1.82;
        this.scene.add(ring);
    }

    // Helper: Generate realistic paper edge texture
    createPaperEdgeTexture() {
        const canvas = document.createElement('canvas');
        canvas.width = 128;
        canvas.height = 256;
        const ctx = canvas.getContext('2d');

        ctx.fillStyle = '#FAF4E8';
        ctx.fillRect(0, 0, 128, 256);

        // Fine horizontal stacked page lines
        for (let y = 0; y < 256; y += 3) {
            ctx.fillStyle = Math.random() > 0.4 ? 'rgba(215, 200, 175, 0.55)' : 'rgba(235, 222, 200, 0.4)';
            ctx.fillRect(0, y, 128, 1.5);
        }

        const texture = new THREE.CanvasTexture(canvas);
        texture.wrapS = THREE.RepeatWrapping;
        texture.wrapT = THREE.RepeatWrapping;
        texture.repeat.set(4, 1);
        return texture;
    }

    // Helper: Code for jurusan (BR, BD, RPL, LPS, AKL, MPLB)
    getJurusanCode(name) {
        if (!name) return 'SMK';
        const lower = name.toLowerCase();
        if (lower.includes('retail') || lower.includes('br')) return 'BR';
        if (lower.includes('digital') || lower.includes('bd')) return 'BD';
        if (lower.includes('rekayasa') || lower.includes('perangkat lunak') || lower.includes('rpl')) return 'RPL';
        if (lower.includes('perbankan') || lower.includes('syariah') || lower.includes('lps')) return 'LPS';
        if (lower.includes('akuntansi') || lower.includes('keuangan') || lower.includes('akl')) return 'AKL';
        if (lower.includes('perkantoran') || lower.includes('layanan bisnis') || lower.includes('mplb')) return 'MPLB';
        return name.split(' ').map(w => w[0]).join('').slice(0, 4).toUpperCase();
    }

    // Helper: Wrap text for canvas within maxWidth
    wrapText(ctx, text, maxWidth) {
        if (!text) return [];
        const words = text.split(' ');
        const lines = [];
        let currentLine = '';

        for (const word of words) {
            const testLine = currentLine ? `${currentLine} ${word}` : word;
            if (ctx.measureText(testLine).width > maxWidth && currentLine) {
                lines.push(currentLine);
                currentLine = word;
            } else {
                currentLine = testLine;
            }
        }
        if (currentLine) lines.push(currentLine);
        return lines;
    }

    createBook() {
        // Book root group: perfectly eye-level and front-facing
        this.bookGroup = new THREE.Group();
        this.bookGroup.position.set(0, 0, 0);
        this.bookGroup.rotation.set(0, 0, 0); // Directly facing user / camera!
        this.scene.add(this.bookGroup);

        const edgeTexture = this.createPaperEdgeTexture();
        const edgeMaterial = new THREE.MeshStandardMaterial({
            map: edgeTexture,
            roughness: 0.85,
            metalness: 0.05,
        });

        // Luxury Hardcover navy material
        const coverMaterial = new THREE.MeshStandardMaterial({
            color: 0x081a38,
            roughness: 0.45,
            metalness: 0.25,
        });

        const goldTrimMaterial = new THREE.MeshStandardMaterial({
            color: 0xe5a823,
            roughness: 0.3,
            metalness: 0.9,
        });

        // ==========================================
        // 1. RIGHT SIDE: Stationary Back Cover + Right Page Block
        // ==========================================
        // Back cover board (underneath right page)
        const backCoverGeo = new THREE.BoxGeometry(this.COVER_WIDTH, this.COVER_HEIGHT, this.COVER_DEPTH);
        this.backCover = new THREE.Mesh(backCoverGeo, coverMaterial);
        this.backCover.position.set(this.COVER_WIDTH / 2, 0, -this.PAGE_DEPTH - this.COVER_DEPTH / 2);
        this.backCover.castShadow = true;
        this.backCover.receiveShadow = true;
        this.bookGroup.add(this.backCover);

        // Right page block background (solid white canvas texture, NEVER changes or fades)
        const rightBgTexture = this.createRightPageBgTexture();
        this.rightPageBgMaterial = new THREE.MeshBasicMaterial({
            map: rightBgTexture,
        });

        const rightBlockGeo = new THREE.BoxGeometry(this.PAGE_WIDTH, this.PAGE_HEIGHT, this.PAGE_DEPTH);
        const rightBlockMaterials = [
            edgeMaterial,                                      // right edge (+X)
            new THREE.MeshStandardMaterial({ color: 0xe3d8c2, roughness: 0.9 }), // gutter left (-X)
            edgeMaterial,                                      // top edge (+Y)
            edgeMaterial,                                      // bottom edge (-Y)
            this.rightPageBgMaterial,                          // FRONT FACE (+Z) -> Solid white background
            new THREE.MeshStandardMaterial({ color: 0xf5f0e6 }), // back face (-Z)
        ];
        this.rightPageBlock = new THREE.Mesh(rightBlockGeo, rightBlockMaterials);
        this.rightPageBlock.position.set(this.PAGE_WIDTH / 2, 0, -this.PAGE_DEPTH / 2);
        this.rightPageBlock.castShadow = true;
        this.rightPageBlock.receiveShadow = true;
        this.bookGroup.add(this.rightPageBlock);

        // Content overlay plane (fades via material.opacity on GPU during slide transitions!)
        this.contentTexture = new THREE.CanvasTexture(this.contentCanvas);
        this.contentTexture.colorSpace = THREE.SRGBColorSpace;
        this.contentTexture.anisotropy = this.renderer.capabilities.getMaxAnisotropy();
        this.contentTexture.generateMipmaps = true;
        this.contentTexture.minFilter = THREE.LinearMipmapLinearFilter;
        this.contentTexture.magFilter = THREE.LinearFilter;
        this.contentMaterial = new THREE.MeshBasicMaterial({
            map: this.contentTexture,
            transparent: true,
            opacity: 1.0,
            depthWrite: false,
            polygonOffset: true,
            polygonOffsetFactor: -1,
            polygonOffsetUnits: -1,
        });
        const contentGeo = new THREE.PlaneGeometry(this.PAGE_WIDTH, this.PAGE_HEIGHT);
        this.contentMesh = new THREE.Mesh(contentGeo, this.contentMaterial);
        this.contentMesh.position.set(this.PAGE_WIDTH / 2, 0, 0.002);
        this.bookGroup.add(this.contentMesh);

        // Draw initial content onto canvas
        this.drawRightPageContent(-1, this.currentSlide);

        // Add 4 transparent hit planes on right page block for hover detection
        this.setupJurusanHitMeshes();

        // ==========================================
        // 2. HARDCOVER SPINE CASING (Neatly at the back, behind the pages!)
        // ==========================================
        const spineGeo = new THREE.BoxGeometry(0.12, this.COVER_HEIGHT, this.COVER_DEPTH);
        this.spine = new THREE.Mesh(spineGeo, coverMaterial);
        this.spine.position.set(0, 0, -this.PAGE_DEPTH - this.COVER_DEPTH / 2);
        this.spine.castShadow = true;
        this.bookGroup.add(this.spine);

        // Decorative gold headband strip at top and bottom spine ends
        const headbandGeo = new THREE.CylinderGeometry(0.035, 0.035, 0.12, 16);
        const headbandTop = new THREE.Mesh(headbandGeo, goldTrimMaterial);
        headbandTop.rotation.z = Math.PI / 2;
        headbandTop.position.set(0, this.COVER_HEIGHT / 2, -this.PAGE_DEPTH - this.COVER_DEPTH / 2);
        this.bookGroup.add(headbandTop);

        const headbandBottom = headbandTop.clone();
        headbandBottom.position.y = -this.COVER_HEIGHT / 2;
        this.bookGroup.add(headbandBottom);

        // ==========================================
        // 3. LEFT SIDE: Front Cover + Left Page Block (Hinged at x = 0)
        // ==========================================
        this.coverGroup = new THREE.Group();
        this.coverGroup.position.set(0, 0, 0); // Pivot at spine line x = 0

        // Front cover board
        const frontCoverGeo = new THREE.BoxGeometry(this.COVER_WIDTH, this.COVER_HEIGHT, this.COVER_DEPTH);
        const frontCoverMaterials = [
            coverMaterial, coverMaterial, coverMaterial, coverMaterial,
            new THREE.MeshStandardMaterial({ map: this.createCoverTexture() }), // Front outside face (+Z)
            coverMaterial,                                                      // Back inside face (-Z)
        ];
        const frontCoverMesh = new THREE.Mesh(frontCoverGeo, frontCoverMaterials);
        frontCoverMesh.position.set(this.COVER_WIDTH / 2, 0, this.COVER_DEPTH / 2);
        frontCoverMesh.castShadow = true;
        this.coverGroup.add(frontCoverMesh);

        // Left page block attached to inside of front cover (MeshBasicMaterial preserves 100% canvas contrast)
        const leftPageTexture = this.createLeftPageTexture();
        const leftPageMaterial = new THREE.MeshBasicMaterial({
            map: leftPageTexture,
        });

        const leftBlockGeo = new THREE.BoxGeometry(this.PAGE_WIDTH, this.PAGE_HEIGHT, this.PAGE_DEPTH);
        const leftBlockMaterials = [
            edgeMaterial,                                      // outer edge
            new THREE.MeshStandardMaterial({ color: 0xe3d8c2, roughness: 0.9 }), // gutter edge
            edgeMaterial,                                      // top edge
            edgeMaterial,                                      // bottom edge
            new THREE.MeshStandardMaterial({ color: 0xf5f0e6 }), // back face (adhered to cover)
            leftPageMaterial,                                  // INSIDE FACE (-Z when closed, becomes +Z when open!)
        ];
        this.leftPageBlock = new THREE.Mesh(leftBlockGeo, leftBlockMaterials);
        // Position inside coverGroup so it sits flush when opened
        this.leftPageBlock.position.set(this.PAGE_WIDTH / 2, 0, -this.PAGE_DEPTH / 2);
        this.leftPageBlock.castShadow = true;
        this.coverGroup.add(this.leftPageBlock);

        // Add ornamental gold corner brackets on outer corners
        this.addCoverGoldCorners(frontCoverMesh);

        this.bookGroup.add(this.coverGroup);
    }

    addCoverGoldCorners(parentMesh) {
        const cornerMat = new THREE.MeshStandardMaterial({
            color: 0xe5a823,
            roughness: 0.25,
            metalness: 0.9,
        });
        const w = this.COVER_WIDTH;
        const h = this.COVER_HEIGHT;
        const positions = [
            [w / 2 - 0.12, h / 2 - 0.12],
            [w / 2 - 0.12, -h / 2 + 0.12],
        ];
        positions.forEach(([cx, cy]) => {
            const cornerGeo = new THREE.BoxGeometry(0.24, 0.24, 0.048);
            const cornerMesh = new THREE.Mesh(cornerGeo, cornerMat);
            cornerMesh.position.set(cx, cy, 0);
            parentMesh.add(cornerMesh);
        });
    }

    setupJurusanHitMeshes() {
        // Remove old hit meshes from scene
        this.jurusanHitMeshes.forEach(m => this.bookGroup.remove(m));
        this.jurusanHitMeshes = [];

        const allJurusans = this.getAllJurusans();
        const start = this.currentSlide * this.ITEMS_PER_PAGE;
        const slideItems = allJurusans.slice(start, start + this.ITEMS_PER_PAGE);

        // 4 vertical positions corresponding to the cards on the right page
        const yPositions = [0.725, 0.217, -0.294, -0.803];

        slideItems.forEach((j, i) => {
            const hitGeo = new THREE.PlaneGeometry(1.90, 0.44);
            // Transparent mesh with opacity 0 so Three.js Raycaster detects it
            const hitMat = new THREE.MeshBasicMaterial({
                transparent: true,
                opacity: 0,
                depthWrite: false,
                side: THREE.DoubleSide,
            });
            const hitMesh = new THREE.Mesh(hitGeo, hitMat);
            // Placed just slightly in front of the right page face (+Z)
            hitMesh.position.set(this.PAGE_WIDTH / 2, yPositions[i], 0.04);
            hitMesh.userData = {
                index: i,
                jurusan: j,
                code: this.getJurusanCode(j.name || j.nama),
            };

            this.bookGroup.add(hitMesh);
            this.jurusanHitMeshes.push(hitMesh);
        });
    }

    getAllJurusans() {
        return (this.data.jurusans && this.data.jurusans.length > 0)
            ? this.data.jurusans
            : [
                { name: 'Bisnis Retail', description: 'Program keahlian yang menyiapkan peserta didik untuk mengelola aktivitas ritel dari penataan barang hingga penjualan.' },
                { name: 'Bisnis Digital', description: 'Program keahlian yang berfokus pada pemasaran digital, e-commerce, media sosial, dan strategi bisnis online.' },
                { name: 'Rekayasa Perangkat Lunak', description: 'Program keahlian yang membekali peserta didik merancang, membangun, dan menguji perangkat lunak aplikasi.' },
                { name: 'Layanan Perbankan Syariah', description: 'Program keahlian operasional layanan perbankan syariah, pelayanan nasabah, dan administrasi transaksi.' },
                { name: 'Akuntansi dan Keuangan Lembaga', description: 'Program keahlian pencatatan transaksi, penyusunan laporan keuangan, dan administrasi perpajakan.' },
                { name: 'Manajemen Perkantoran dan Layanan Bisnis', description: 'Program keahlian administrasi perkantoran, korespondensi, kearsipan, dan otomasi dokumen digital.' },
            ];
    }

    getTotalSlides() {
        return Math.ceil(this.getAllJurusans().length / this.ITEMS_PER_PAGE);
    }

    goToSlide(targetSlide) {
        if (this.isSliding || targetSlide === this.currentSlide) return;
        if (targetSlide < 0 || targetSlide >= this.getTotalSlides()) return;

        this.isSliding = true;

        // Dismiss any active hover state first
        this.onJurusanLeave();

        // 1. Smooth harmonic fade out of current content (350ms, sine.in)
        // Starts gently from 1.0 and glides smoothly into 0 without lingering
        gsap.to(this.contentMaterial, {
            opacity: 0,
            duration: 0.35,
            ease: 'sine.in',
            onComplete: () => {
                // 2. Instant data swap at the exact base of the curve (zero blank gap)
                this.currentSlide = targetSlide;
                this.hoveredJurusanIdx = -1;
                this.drawRightPageContent(-1, this.currentSlide);
                this.setupJurusanHitMeshes();
                this.updateSlideNav();

                // 3. Smooth harmonic fade in of new slide content (370ms, sine.out)
                // Immediately starts ascending from 0 and softly settles into 1.0
                gsap.to(this.contentMaterial, {
                    opacity: 1,
                    duration: 0.37,
                    ease: 'sine.out',
                    onComplete: () => {
                        this.isSliding = false;
                    }
                });
            }
        });
    }

    updateSlideNav() {
        const total = this.getTotalSlides();
        const btnPrev = document.getElementById('btn-slide-prev');
        const btnNext = document.getElementById('btn-slide-next');
        const indicator = document.getElementById('slide-indicator');

        if (!btnPrev || !btnNext) return;

        if (total <= 1) {
            // No pagination needed
            btnPrev.classList.remove('visible');
            btnNext.classList.remove('visible');
            if (indicator) indicator.classList.remove('visible');
            return;
        }

        // Show/hide prev
        if (this.currentSlide > 0) {
            btnPrev.classList.add('visible');
        } else {
            btnPrev.classList.remove('visible');
        }

        // Show/hide next
        if (this.currentSlide < total - 1) {
            btnNext.classList.add('visible');
        } else {
            btnNext.classList.remove('visible');
        }

        // Rebuild slide indicator dots
        if (indicator) {
            indicator.innerHTML = '';
            for (let i = 0; i < total; i++) {
                const dot = document.createElement('div');
                dot.className = 'slide-dot' + (i === this.currentSlide ? ' active' : '');
                indicator.appendChild(dot);
            }
            indicator.classList.add('visible');
        }
    }

    createCoverTexture() {
        const canvas = document.createElement('canvas');
        canvas.width = 2048;
        canvas.height = 2800;
        const ctx = canvas.getContext('2d');

        // High quality dark academic navy gradient
        const grad = ctx.createLinearGradient(0, 0, 2048, 2800);
        grad.addColorStop(0, '#0F2B5C');
        grad.addColorStop(0.5, '#081A38');
        grad.addColorStop(1, '#051226');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, 2048, 2800);

        // Gold ornamental border
        ctx.strokeStyle = '#E5A823';
        ctx.lineWidth = 28;
        ctx.strokeRect(80, 80, 1888, 2640);

        ctx.strokeStyle = 'rgba(229, 168, 35, 0.5)';
        ctx.lineWidth = 8;
        ctx.strokeRect(120, 120, 1808, 2560);

        // Corner flourishes
        const corners = [[120, 120], [1928, 120], [120, 2680], [1928, 2680]];
        corners.forEach(([cx, cy]) => {
            ctx.fillStyle = '#FFA500';
            ctx.beginPath();
            ctx.arc(cx, cy, 24, 0, Math.PI * 2);
            ctx.fill();
        });

        // Cover Titles
        ctx.textAlign = 'center';
        ctx.fillStyle = '#FFFFFF';
        ctx.font = 'bold 96px Inter, sans-serif';
        ctx.fillText('SMKN 20 JAKARTA', 1024, 680);

        ctx.fillStyle = '#FFA500';
        ctx.font = 'bold 148px Outfit, sans-serif';
        ctx.fillText('TALOG20', 1024, 880);

        ctx.fillStyle = 'rgba(255, 255, 255, 0.88)';
        ctx.font = 'bold 54px Inter, sans-serif';
        ctx.fillText('PORTAL TUGAS AKHIR SISWA', 1024, 1000);

        // Divider
        ctx.strokeStyle = '#FFA500';
        ctx.lineWidth = 6;
        ctx.beginPath();
        ctx.moveTo(600, 1070);
        ctx.lineTo(1448, 1070);
        ctx.stroke();

        // Center circular seal
        ctx.beginPath();
        ctx.arc(1024, 1500, 260, 0, Math.PI * 2);
        ctx.fillStyle = 'rgba(255, 255, 255, 0.08)';
        ctx.fill();
        ctx.strokeStyle = '#FFA500';
        ctx.lineWidth = 10;
        ctx.stroke();

        if (this.data.logoUrl) {
            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.onload = () => {
                ctx.drawImage(img, 814, 1290, 420, 420);
                texture.needsUpdate = true;
            };
            img.src = this.data.logoUrl;
        }

        // Subtitle bottom
        ctx.fillStyle = '#FFA500';
        ctx.font = 'bold 56px Inter, sans-serif';
        ctx.fillText('BERKARAKTER • UNGGUL • BERPRESTASI', 1024, 2180);

        ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
        ctx.font = '44px Inter, sans-serif';
        ctx.fillText('Tahun Pelajaran 2024 / 2025', 1024, 2300);

        const texture = new THREE.CanvasTexture(canvas);
        texture.colorSpace = THREE.SRGBColorSpace;
        texture.anisotropy = this.renderer.capabilities.getMaxAnisotropy();
        return texture;
    }

    createLeftPageTexture() {
        const canvas = document.createElement('canvas');
        canvas.width = 2048;
        canvas.height = 2800;
        const ctx = canvas.getContext('2d');

        // Crisp canvas background (#F8FAFC to #FFFFFF)
        const bgGrad = ctx.createLinearGradient(0, 0, 2048, 2800);
        bgGrad.addColorStop(0, '#F8FAFC');
        bgGrad.addColorStop(1, '#FFFFFF');
        ctx.fillStyle = bgGrad;
        ctx.fillRect(0, 0, 2048, 2800);

        // Outer margin border
        ctx.strokeStyle = '#CBD5E1';
        ctx.lineWidth = 4;
        ctx.strokeRect(100, 100, 1848, 2600);

        // Header: #0F172A (heading slate-900)
        ctx.textAlign = 'center';
        ctx.fillStyle = '#0F172A';
        ctx.font = 'bold 88px Outfit, sans-serif';
        ctx.fillText('Selamat Datang', 1024, 420);

        // Accent Subtitle: #FF6B00 (Accent Orange, bold)
        ctx.fillStyle = '#FF6B00';
        ctx.font = 'bold 66px Inter, sans-serif';
        ctx.fillText('di TALOG SMKN 20', 1024, 530);

        // Gold / Orange divider
        ctx.strokeStyle = '#FF6B00';
        ctx.lineWidth = 6;
        ctx.beginPath();
        ctx.moveTo(760, 600);
        ctx.lineTo(1288, 600);
        ctx.stroke();

        // Body text: #334155 (body text slate-700, solid and clearly readable)
        ctx.textAlign = 'left';
        ctx.fillStyle = '#334155';
        ctx.font = '600 52px Inter, sans-serif';

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

        let y = 780;
        lines.forEach(line => {
            ctx.fillText(line, 240, y);
            y += 88;
        });

        // Seal bottom: #64748B (slate-500)
        ctx.textAlign = 'center';
        ctx.fillStyle = '#64748B';
        ctx.font = 'bold italic 44px Inter, sans-serif';
        ctx.fillText('SMKN 20 Jakarta — Melangkah dengan Pasti', 1024, 2520);

        const texture = new THREE.CanvasTexture(canvas);
        texture.colorSpace = THREE.SRGBColorSpace;
        texture.anisotropy = this.renderer.capabilities.getMaxAnisotropy();
        return texture;
    }

    createRightPageBgTexture() {
        const canvas = document.createElement('canvas');
        canvas.width = 2048;
        canvas.height = 2800;
        const ctx = canvas.getContext('2d');

        // Solid white gradient background
        const bgGrad = ctx.createLinearGradient(0, 0, 2048, 2800);
        bgGrad.addColorStop(0, '#F8FAFC');
        bgGrad.addColorStop(1, '#FFFFFF');
        ctx.fillStyle = bgGrad;
        ctx.fillRect(0, 0, 2048, 2800);

        // Subtle elegant border
        ctx.strokeStyle = '#CBD5E1';
        ctx.lineWidth = 4;
        ctx.strokeRect(100, 100, 1848, 2600);

        // 1. Static Title: #0F172A (heading slate-900) - static across all slides
        ctx.textAlign = 'center';
        ctx.fillStyle = '#0F172A';
        ctx.font = 'bold 80px Outfit, sans-serif';
        ctx.fillText('KONSENTRASI KEAHLIAN', 1024, 330);

        // 2. Static Accent Subtitle: #FF6B00 (Accent Orange, bold) - static across all slides
        ctx.fillStyle = '#FF6B00';
        ctx.font = 'bold 46px Inter, sans-serif';
        ctx.fillText('SMKN 20 JAKARTA', 1024, 410);

        // 3. Static Divider line - static across all slides
        ctx.strokeStyle = '#FF6B00';
        ctx.lineWidth = 6;
        ctx.beginPath();
        ctx.moveTo(800, 460);
        ctx.lineTo(1248, 460);
        ctx.stroke();

        const texture = new THREE.CanvasTexture(canvas);
        texture.colorSpace = THREE.SRGBColorSpace;
        texture.anisotropy = this.renderer.capabilities.getMaxAnisotropy();
        texture.generateMipmaps = true;
        texture.minFilter = THREE.LinearMipmapLinearFilter;
        texture.magFilter = THREE.LinearFilter;
        return texture;
    }

    drawRightPageContent(hoveredIdx = -1, slideIndex = 0) {
        const ctx = this.contentCtx;
        if (!ctx) return;

        // Clear content canvas (transparent background so solid white page and static headers show through)
        ctx.clearRect(0, 0, 2048, 2800);

        // Get the slice of jurusans for the current slide
        const allJurusans = this.getAllJurusans();
        const totalSlides = Math.ceil(allJurusans.length / this.ITEMS_PER_PAGE);
        const start = slideIndex * this.ITEMS_PER_PAGE;
        const slideItems = allJurusans.slice(start, start + this.ITEMS_PER_PAGE);
        const globalOffset = start;

        let startY = 530;
        slideItems.forEach((j, idx) => {
            const isHovered = (idx === hoveredIdx);
            const name = j.name || j.nama || 'Jurusan';
            const desc = j.description || j.deskripsi || 'Program keahlian unggulan berstandar industri.';
            const code = this.getJurusanCode(name);
            const globalNumber = globalOffset + idx + 1;

            const accent = j.accent_color || '#FF6B00';

            // Card Background: solid pure white for max contrast
            ctx.fillStyle = '#FFFFFF';
            ctx.beginPath();
            ctx.roundRect(160, startY, 1728, 410, 24);
            ctx.fill();

            // Card Border: #E2E8F0 (slate-200) or accent on hover
            ctx.strokeStyle = isHovered ? accent : '#E2E8F0';
            ctx.lineWidth = isHovered ? 8 : 4;
            ctx.stroke();

            // Number badge circle: accent with white number
            ctx.fillStyle = accent;
            ctx.beginPath();
            ctx.arc(260, startY + 110, 56, 0, Math.PI * 2);
            ctx.fill();

            ctx.fillStyle = '#FFFFFF';
            ctx.font = 'bold 56px Inter, sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText(String(globalNumber), 260, startY + 130);

            // Jurusan Title: #0F172A (heading slate-900, bold, pitch dark)
            ctx.textAlign = 'left';
            ctx.fillStyle = '#0F172A';
            ctx.font = 'bold 54px Outfit, sans-serif';
            ctx.fillText(name, 360, startY + 115);

            // Jurusan Code Pill Badge
            ctx.fillStyle = isHovered ? accent : '#F1F5F9';
            ctx.beginPath();
            ctx.roundRect(1650, startY + 65, 160, 68, 16);
            ctx.fill();

            ctx.fillStyle = isHovered ? '#FFFFFF' : '#0F172A';
            ctx.font = 'bold 36px Inter, sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText(code, 1730, startY + 113);

            // Description text: #334155 (body text slate-700)
            ctx.textAlign = 'left';
            ctx.fillStyle = '#334155';
            ctx.font = '600 36px Inter, sans-serif';

            const wrappedLines = this.wrapText(ctx, desc, 1260);
            let descY = startY + 205;
            wrappedLines.slice(0, 2).forEach((line, lineIdx) => {
                let lineText = line;
                if (lineIdx === 1 && wrappedLines.length > 2) {
                    lineText = line.length > 55 ? line.slice(0, 52) + '...' : line + '...';
                }
                ctx.fillText(lineText, 360, descY);
                descY += 52;
            });

            // Cursor hint
            ctx.fillStyle = '#FF6B00';
            ctx.font = 'bold 28px Inter, sans-serif';
            ctx.fillText('Arahkan kursor untuk melihat deskripsi lengkap →', 360, startY + 345);

            startY += 460;
        });

        // Slide indicator text at bottom (only when multiple slides exist)
        if (totalSlides > 1) {
            ctx.textAlign = 'center';
            ctx.fillStyle = '#94A3B8';
            ctx.font = '500 34px Inter, sans-serif';
            ctx.fillText(`Halaman ${slideIndex + 1} dari ${totalSlides}`, 1024, 2540);
        }

        if (this.contentTexture) {
            this.contentTexture.needsUpdate = true;
        }
    }

    createParticles() {
        // Reduced count: 55 particles is visually sufficient and much lighter
        const particleCount = 55;
        const geometry = new THREE.BufferGeometry();
        const positions = new Float32Array(particleCount * 3);

        for (let i = 0; i < particleCount * 3; i += 3) {
            positions[i]     = (Math.random() - 0.5) * 16;
            positions[i + 1] = Math.random() * 8 - 2;
            positions[i + 2] = (Math.random() - 0.5) * 10;
        }

        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));

        const material = new THREE.PointsMaterial({
            color: 0xffa033,
            size: 0.07,
            transparent: true,
            opacity: 0.45,
            blending: THREE.AdditiveBlending,
            depthWrite: false,   // skip depth write — cheaper for transparent points
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
        // Slide nav buttons
        const btnPrev = document.getElementById('btn-slide-prev');
        const btnNext = document.getElementById('btn-slide-next');
        if (btnPrev) {
            btnPrev.addEventListener('click', () => {
                this.goToSlide(this.currentSlide - 1);
            });
        }
        if (btnNext) {
            btnNext.addEventListener('click', () => {
                this.goToSlide(this.currentSlide + 1);
            });
        }
    }

    showHUD() {
        if (this.brandBadge) this.brandBadge.style.opacity = '1';
        if (this.bottomCta) this.bottomCta.style.opacity = '1';
        if (this.btnSkip) this.btnSkip.style.opacity = '1';
        if (this.pageInfo) this.pageInfo.style.opacity = '1';
        // Initialize slide nav (will show arrows if needed)
        this.updateSlideNav();
    }

    openBook() {
        if (this.isOpen || this.isAnimating) return;
        this.isAnimating = true;

        // Front cover swings open to the left by 180 degrees (lying flat open)
        gsap.to(this.coverGroup.rotation, {
            y: -Math.PI,
            duration: 2.2,
            ease: 'power3.inOut',
            onComplete: () => {
                this.isOpen = true;
                this.isAnimating = false;
                this.updatePageDots(1);
            }
        });

        // Lower coverGroup.position.z so both pages lie perfectly flush
        gsap.to(this.coverGroup.position, {
            z: -this.PAGE_DEPTH,
            duration: 2.2,
            ease: 'power3.inOut',
        });

        // Book remains directly FRONT-FACING (rotation.x = 0, rotation.y = 0)
        // Center the open spread (left page + right page)
        gsap.to(this.bookGroup.position, {
            x: 0,
            y: 0,
            z: 0,
            duration: 2.2,
            ease: 'power3.inOut',
        });

        gsap.to(this.bookGroup.rotation, {
            x: 0,
            y: 0,
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
        // Camera zoom in cinematic effect
        gsap.to(this.camera.position, {
            z: 2.0,
            y: 0,
            duration: 0.6,
            ease: 'power2.in',
            onComplete: () => {
                const destination = this.data.berandaUrl || '/beranda';
                if (window.TalogPageTransition) {
                    window.TalogPageTransition.navigate(destination);
                } else {
                    window.location.href = destination;
                }
            }
        });
    }

    setupEventListeners() {
        window.addEventListener('resize', () => this.onResize());

        // RAF-throttled pointermove: store latest event, consume it once per animation frame
        window.addEventListener('pointermove', (e) => {
            this._pointerDirty = true;
            this._pointerEvent = e;
        });

        // Click canvas to open if closed
        this.container.addEventListener('click', () => {
            if (!this.isOpen && !this.isAnimating) {
                this.openBook();
            }
        });
    }

    // Called once per frame from animate() — processes latest pointer position
    _consumePointer() {
        if (!this._pointerDirty || !this._pointerEvent) return;
        this._pointerDirty = false;
        const e = this._pointerEvent;

        this.mouse.targetX = (e.clientX / this.width - 0.5) * 2;
        this.mouse.targetY = (e.clientY / this.height - 0.5) * 2;
        this.pointer.x = (e.clientX / this.width) * 2 - 1;
        this.pointer.y = -(e.clientY / this.height) * 2 + 1;

        if (this.isOpen) {
            this.checkJurusanHover(e);
        }
    }

    checkJurusanHover(event) {
        if (!this.isOpen || this.jurusanHitMeshes.length === 0) return;

        this.raycaster.setFromCamera(this.pointer, this.camera);
        const intersects = this.raycaster.intersectObjects(this.jurusanHitMeshes);

        if (intersects.length > 0) {
            const data = intersects[0].object.userData;
            this.onJurusanHover(data.index, data.jurusan, data.code, event.clientX, event.clientY);
        } else {
            this.onJurusanLeave();
        }
    }

    onJurusanHover(index, jurusan, code, clientX, clientY) {
        document.body.style.cursor = 'pointer';

        // Only update tooltip text & highlight card when entering a DIFFERENT item
        if (this.hoveredJurusanIdx !== index) {
            this.hoveredJurusanIdx = index;

            const name = jurusan.name || jurusan.nama || 'Jurusan';
            const desc = jurusan.description || jurusan.deskripsi || 'Deskripsi program keahlian SMKN 20 Jakarta.';
            const accent = jurusan.accent_color || '#FF6B00';

            if (this.tooltipBadge) {
                this.tooltipBadge.textContent = code;
                this.tooltipBadge.style.backgroundColor = accent;
            }
            if (this.tooltip) {
                this.tooltip.style.borderLeft = `4px solid ${accent}`;
            }
            if (this.tooltipTitle) this.tooltipTitle.textContent = name;
            if (this.tooltipDesc) this.tooltipDesc.textContent = desc;

            // Highlight card in content canvas ONCE per card hover
            this.drawRightPageContent(index, this.currentSlide);
        }

        // Position tooltip using GPU translate3d (zero layout reflow)
        if (this.tooltip) {
            const tooltipWidth = 320;
            const tooltipHeight = 180;
            let left = clientX + 16;
            let top = clientY + 16;

            if (left + tooltipWidth > window.innerWidth - 16) {
                left = clientX - tooltipWidth - 16;
            }
            if (top + tooltipHeight > window.innerHeight - 16) {
                top = clientY - tooltipHeight - 16;
            }

            this.tooltip.style.transform = `translate3d(${left}px, ${top}px, 0)`;
            if (!this.tooltip.classList.contains('visible')) {
                this.tooltip.classList.add('visible');
            }
        }
    }

    onJurusanLeave() {
        document.body.style.cursor = 'default';

        if (this.tooltip && this.tooltip.classList.contains('visible')) {
            this.tooltip.classList.remove('visible');
        }

        // Only unhighlight if an item was actually hovered
        if (this.hoveredJurusanIdx !== -1) {
            this.hoveredJurusanIdx = -1;
            this.drawRightPageContent(-1, this.currentSlide);
        }
    }

    onResize() {
        this.width = window.innerWidth;
        this.height = window.innerHeight;
        this.camera.aspect = this.width / this.height;
        this.camera.fov = this.width < 768 ? 62 : 46;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(this.width, this.height);
        // Lock pixel ratio permanently to native screen devicePixelRatio (up to 2x for retina/4k)
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    }

    animate() {
        requestAnimationFrame(() => this.animate());

        // Consume latest pointer event (RAF-throttled, once per frame)
        this._consumePointer();

        // Gentle mouse parallax lerp
        this.mouse.x += (this.mouse.targetX - this.mouse.x) * 0.05;
        this.mouse.y += (this.mouse.targetY - this.mouse.y) * 0.05;

        if (this.bookGroup) {
            // Subtle idle breathing
            const time = performance.now() * 0.001;
            this.bookGroup.position.y = Math.sin(time * 1.5) * 0.015;

            // Rest position is straight front-facing (rotation = 0), with gentle parallax tilt
            this.bookGroup.rotation.y = this.mouse.x * 0.04;
            this.bookGroup.rotation.x = -this.mouse.y * 0.03;
        }

        // Particle floating — update positions every OTHER frame to halve GPU buffer uploads
        this._frameCount++;
        if (this.particles && (this._frameCount & 1) === 0) {
            const pos = this.particles.geometry.attributes.position.array;
            for (let i = 1; i < pos.length; i += 3) {
                pos[i] += 0.003;
                if (pos[i] > 5) pos[i] = -2;
            }
            this.particles.geometry.attributes.position.needsUpdate = true;
            this.particles.rotation.y += 0.0006;
        }

        this.renderer.render(this.scene, this.camera);
    }
}

// Instantiate when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new Education3DBook();
});
