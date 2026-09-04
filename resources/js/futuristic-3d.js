import * as THREE from 'three';
import gsap from 'gsap';

class Futuristic3DExperience {
    constructor() {
        this.container = document.getElementById('cyber-canvas');
        if (!this.container) return;

        this.data = window.TALOG20_DATA || { jurusans: [], logoUrl: '', berandaUrl: '/beranda' };
        this.width = window.innerWidth;
        this.height = window.innerHeight;

        this.scene = null;
        this.camera = null;
        this.renderer = null;

        // Core 3D objects
        this.coreGroup = null;
        this.torusKnot = null;
        this.outerWireframe = null;
        this.orbitalRings = [];
        this.hologramLogo = null;
        this.particles = null;
        this.dustParticles = null;

        // Mouse & pointer interaction
        this.mouse = { x: 0, y: 0, targetX: 0, targetY: 0 };
        this.clock = new THREE.Clock();

        this.init();
    }

    init() {
        this.createScene();
        this.createLights();
        this.createStarfield();
        this.createOrganicCore();
        this.createOrbitalRings();
        this.createHologramLogo();
        this.setupHUD();
        this.setupEventListeners();

        this.animate();

        // Intro cinematic camera pan
        gsap.fromTo(this.camera.position, 
            { z: 16, y: 8, x: -6 },
            { z: 6.5, y: 1.2, x: 0, duration: 2.8, ease: 'power3.out', onComplete: () => {
                this.showHUD();
            }}
        );
    }

    createScene() {
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0x050814);
        this.scene.fog = new THREE.FogExp2(0x050814, 0.035);

        const fov = this.width < 768 ? 60 : 45;
        this.camera = new THREE.PerspectiveCamera(fov, this.width / this.height, 0.1, 100);
        this.camera.position.set(0, 1.2, 6.5);
        this.camera.lookAt(0, 0, 0);

        this.renderer = new THREE.WebGLRenderer({
            canvas: this.container,
            antialias: true,
            powerPreference: 'high-performance',
        });
        this.renderer.setSize(this.width, this.height);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
        this.renderer.toneMappingExposure = 1.2;
    }

    createLights() {
        // Ambient dark blue tone
        const ambientLight = new THREE.AmbientLight(0x0c1938, 1.5);
        this.scene.add(ambientLight);

        // Neon Cyan Key Light
        this.cyanLight = new THREE.PointLight(0x00F0FF, 3.5, 14);
        this.cyanLight.position.set(-3.5, 2.5, 3);
        this.scene.add(this.cyanLight);

        // Neon Synthwave Purple Fill Light
        this.purpleLight = new THREE.PointLight(0xB026FF, 3.5, 14);
        this.purpleLight.position.set(3.5, -2, 3);
        this.scene.add(this.purpleLight);

        // Back Rim Light (Cyber Lime)
        const rimLight = new THREE.DirectionalLight(0x00FF88, 1.8);
        rimLight.position.set(0, -4, -5);
        this.scene.add(rimLight);
    }

    createStarfield() {
        // High density quantum starfield
        const starCount = 600;
        const starGeo = new THREE.BufferGeometry();
        const starPositions = new Float32Array(starCount * 3);
        const starColors = new Float32Array(starCount * 3);

        const color1 = new THREE.Color(0x00F0FF);
        const color2 = new THREE.Color(0xB026FF);
        const color3 = new THREE.Color(0x00FF88);

        for (let i = 0; i < starCount * 3; i += 3) {
            starPositions[i] = (Math.random() - 0.5) * 35;
            starPositions[i + 1] = (Math.random() - 0.5) * 25;
            starPositions[i + 2] = (Math.random() - 0.5) * 30 - 5;

            const pickedColor = Math.random() > 0.5 ? (Math.random() > 0.5 ? color1 : color2) : color3;
            starColors[i] = pickedColor.r;
            starColors[i + 1] = pickedColor.g;
            starColors[i + 2] = pickedColor.b;
        }

        starGeo.setAttribute('position', new THREE.BufferAttribute(starPositions, 3));
        starGeo.setAttribute('color', new THREE.BufferAttribute(starColors, 3));

        const starMat = new THREE.PointsMaterial({
            size: 0.07,
            vertexColors: true,
            transparent: true,
            opacity: 0.7,
            blending: THREE.AdditiveBlending,
        });

        this.particles = new THREE.Points(starGeo, starMat);
        this.scene.add(this.particles);
    }

    createOrganicCore() {
        this.coreGroup = new THREE.Group();
        this.scene.add(this.coreGroup);

        // 1. Organic 3D Torus Knot with Physical Glass/Metallic Material
        const knotGeo = new THREE.TorusKnotGeometry(1.0, 0.28, 128, 32, 2, 3);
        const knotMat = new THREE.MeshPhysicalMaterial({
            color: 0x051838,
            emissive: 0x071b48,
            emissiveIntensity: 0.4,
            roughness: 0.15,
            metalness: 0.85,
            clearcoat: 1.0,
            clearcoatRoughness: 0.1,
            reflectivity: 0.9,
            wireframe: false,
        });
        this.torusKnot = new THREE.Mesh(knotGeo, knotMat);
        this.coreGroup.add(this.torusKnot);

        // 2. Outer Wireframe Polyhedron Cage
        const icoGeo = new THREE.IcosahedronGeometry(1.85, 1);
        const icoMat = new THREE.MeshBasicMaterial({
            color: 0x00F0FF,
            wireframe: true,
            transparent: true,
            opacity: 0.22,
        });
        this.outerWireframe = new THREE.Mesh(icoGeo, icoMat);
        this.coreGroup.add(this.outerWireframe);

        // 3. Inner Pulsing Energy Core
        const innerGeo = new THREE.SphereGeometry(0.55, 32, 32);
        const innerMat = new THREE.MeshBasicMaterial({
            color: 0xB026FF,
            transparent: true,
            opacity: 0.65,
            blending: THREE.AdditiveBlending,
        });
        this.innerSphere = new THREE.Mesh(innerGeo, innerMat);
        this.coreGroup.add(this.innerSphere);
    }

    createOrbitalRings() {
        const ringConfigs = [
            { radius: 2.3, tube: 0.012, color: 0x00F0FF, rotX: 1.2, rotY: 0.3, speed: 0.008 },
            { radius: 2.7, tube: 0.008, color: 0xB026FF, rotX: -0.8, rotY: 0.9, speed: -0.006 },
            { radius: 3.1, tube: 0.010, color: 0x00FF88, rotX: 0.4, rotY: -1.1, speed: 0.004 },
        ];

        ringConfigs.forEach((cfg) => {
            const geo = new THREE.TorusGeometry(cfg.radius, cfg.tube, 16, 100);
            const mat = new THREE.MeshBasicMaterial({
                color: cfg.color,
                transparent: true,
                opacity: 0.5,
                blending: THREE.AdditiveBlending,
            });
            const ring = new THREE.Mesh(geo, mat);
            ring.rotation.x = cfg.rotX;
            ring.rotation.y = cfg.rotY;
            ring.userData = { speed: cfg.speed };
            this.coreGroup.add(ring);
            this.orbitalRings.push(ring);
        });
    }

    createHologramLogo() {
        // Holographic SMKN 20 Disc in front of the core
        const canvas = document.createElement('canvas');
        canvas.width = 512;
        canvas.height = 512;
        const ctx = canvas.getContext('2d');

        // Circular glow background
        const grad = ctx.createRadialGradient(256, 256, 30, 256, 256, 240);
        grad.addColorStop(0, 'rgba(0, 240, 255, 0.4)');
        grad.addColorStop(0.5, 'rgba(176, 38, 255, 0.2)');
        grad.addColorStop(1, 'rgba(5, 8, 20, 0)');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, 512, 512);

        // Tech ring border
        ctx.strokeStyle = '#00F0FF';
        ctx.lineWidth = 6;
        ctx.beginPath();
        ctx.arc(256, 256, 210, 0, Math.PI * 2);
        ctx.stroke();

        ctx.strokeStyle = '#B026FF';
        ctx.lineWidth = 3;
        ctx.setLineDash([12, 8]);
        ctx.beginPath();
        ctx.arc(256, 256, 226, 0, Math.PI * 2);
        ctx.stroke();
        ctx.setLineDash([]);

        // Load logo
        if (this.data.logoUrl) {
            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.onload = () => {
                ctx.drawImage(img, 106, 106, 300, 300);
                discTexture.needsUpdate = true;
            };
            img.src = this.data.logoUrl;
        }

        const discTexture = new THREE.CanvasTexture(canvas);
        const discGeo = new THREE.PlaneGeometry(1.9, 1.9);
        const discMat = new THREE.MeshBasicMaterial({
            map: discTexture,
            transparent: true,
            opacity: 0.92,
            blending: THREE.AdditiveBlending,
            side: THREE.DoubleSide,
        });

        this.hologramLogo = new THREE.Mesh(discGeo, discMat);
        this.hologramLogo.position.set(0, 0, 1.4);
        this.coreGroup.add(this.hologramLogo);
    }

    setupHUD() {
        this.hud = document.getElementById('cyber-hud');
        this.btnBeranda = document.getElementById('btn-beranda-cyber');
        this.overlay = document.getElementById('cyber-warp-overlay');

        if (this.btnBeranda) {
            this.btnBeranda.addEventListener('click', (e) => {
                e.preventDefault();
                this.warpSpeedTransition();
            });
        }
    }

    showHUD() {
        if (this.hud) {
            this.hud.style.opacity = '1';
            this.hud.style.pointerEvents = 'auto';
        }
    }

    warpSpeedTransition() {
        if (this.overlay) {
            this.overlay.classList.add('active');
        }

        // Warp speed camera plunge into core
        gsap.to(this.camera.position, {
            z: 0.1,
            duration: 0.7,
            ease: 'power4.in',
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

        const elapsed = this.clock.getElapsedTime();

        // Mouse parallax lerp
        this.mouse.x += (this.mouse.targetX - this.mouse.x) * 0.05;
        this.mouse.y += (this.mouse.targetY - this.mouse.y) * 0.05;

        // Rotate organic core
        if (this.torusKnot) {
            this.torusKnot.rotation.x = elapsed * 0.35 + this.mouse.y * 0.2;
            this.torusKnot.rotation.y = elapsed * 0.45 + this.mouse.x * 0.3;
        }

        if (this.outerWireframe) {
            this.outerWireframe.rotation.x = -elapsed * 0.15;
            this.outerWireframe.rotation.y = -elapsed * 0.25;
        }

        // Pulse inner sphere
        if (this.innerSphere) {
            const scale = 1 + Math.sin(elapsed * 4) * 0.12;
            this.innerSphere.scale.set(scale, scale, scale);
        }

        // Rotate orbital rings
        this.orbitalRings.forEach((ring) => {
            ring.rotation.z += ring.userData.speed;
        });

        // Floating hologram logo face camera
        if (this.hologramLogo) {
            this.hologramLogo.position.y = Math.sin(elapsed * 2) * 0.08;
        }

        // Lights oscillation
        if (this.cyanLight) {
            this.cyanLight.position.x = Math.sin(elapsed * 0.8) * 4;
            this.cyanLight.position.y = Math.cos(elapsed * 0.6) * 3;
        }
        if (this.purpleLight) {
            this.purpleLight.position.x = -Math.sin(elapsed * 0.7) * 4;
            this.purpleLight.position.y = -Math.cos(elapsed * 0.5) * 3;
        }

        // Stars gentle rotation
        if (this.particles) {
            this.particles.rotation.y = elapsed * 0.02;
        }

        // Core group mouse tilt
        if (this.coreGroup) {
            this.coreGroup.position.x = this.mouse.x * 0.4;
            this.coreGroup.position.y = -this.mouse.y * 0.3;
        }

        this.renderer.render(this.scene, this.camera);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new Futuristic3DExperience();
});
