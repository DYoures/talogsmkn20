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
        this.trefoilRibbon = null;    // Primary signature torusknot ribbon
        this.innerCage = null;        // Clean sparse icosahedron wireframe
        this.orbitalRings = [];
        this.hologramEmblem = null;
        this.particles = null;
        this.dataStreams = null;       // Subtle animated point helix

        // Lighting
        this.cyanLight = null;
        this.purpleLight = null;
        this.centerLight = null;

        // Continuous rotation state
        this.accumulatedTime = 0;
        this.ribbonRotX = 0;
        this.ribbonRotY = 0;
        this.rotationSpeedMultiplier = 1.0;

        // Interaction state
        this.mouse = { x: 0, y: 0, targetX: 0, targetY: 0 };
        this.clock = new THREE.Clock();

        // Card hover state — debounced reset to avoid flash when switching cards quickly
        this.activeCard = null;
        this.resetTimeout = null;
        this.defaultCyan  = new THREE.Color(0x00F0FF);
        this.defaultPurple = new THREE.Color(0xB026FF);

        this.init();
    }

    init() {
        this.createScene();
        this.createLights();
        this.createStarfield();
        this.createDataHelix();
        this.createOrganicCyberCore();
        this.createOrbitalGimbalRings();
        this.createHologramEmblem();
        this.setupHUD();
        this.setupMajorInteractions();
        this.setupEventListeners();

        this.animate();

        // Intro cinematic camera glide
        gsap.fromTo(this.camera.position,
            { z: 14, y: 4, x: -3 },
            { z: 6.0, y: 0.2, x: 0, duration: 2.8, ease: 'power3.out', onComplete: () => {
                this.showHUD();
            }}
        );
    }

    createScene() {
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0x040a12);
        this.scene.fog = new THREE.FogExp2(0x040a12, 0.028);

        const fov = this.width < 900 ? 55 : 44;
        this.camera = new THREE.PerspectiveCamera(fov, this.width / this.height, 0.1, 100);
        this.camera.position.set(0, 0.2, 6.0);
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
        this.renderer.sortObjects = true; // Important for correct transparency
    }

    createLights() {
        // Ambient base — very dark to keep neon pops vivid
        const ambient = new THREE.AmbientLight(0x050b1a, 2.5);
        this.scene.add(ambient);

        // Primary cyan key light — orbits slowly in animate()
        this.cyanLight = new THREE.PointLight(0x00F0FF, 5.0, 18);
        this.cyanLight.position.set(-3.5, 2.5, 4);
        this.scene.add(this.cyanLight);

        // Secondary purple fill — counter-orbits
        this.purpleLight = new THREE.PointLight(0xB026FF, 4.0, 18);
        this.purpleLight.position.set(3.5, -2.5, 4);
        this.scene.add(this.purpleLight);

        // Center emissive core — pulsed in animate()
        this.centerLight = new THREE.PointLight(0x00F0FF, 3.0, 9);
        this.centerLight.position.set(0, 0, 1.5);
        this.scene.add(this.centerLight);

        // Back rim directional — green edge separation
        const rimLight = new THREE.DirectionalLight(0x00FF88, 1.2);
        rimLight.position.set(0, -4, -6);
        this.scene.add(rimLight);
    }

    createStarfield() {
        const count = 360;
        const geo = new THREE.BufferGeometry();
        const pos = new Float32Array(count * 3);
        const col = new Float32Array(count * 3);

        const c1 = new THREE.Color(0x00F0FF);
        const c2 = new THREE.Color(0xB026FF);
        const c3 = new THREE.Color(0x00FF88);

        for (let i = 0; i < count * 3; i += 3) {
            pos[i]     = (Math.random() - 0.5) * 40;
            pos[i + 1] = (Math.random() - 0.5) * 28;
            pos[i + 2] = (Math.random() - 0.5) * 35 - 5;

            const r = Math.random();
            const pick = r < 0.45 ? c1 : (r < 0.75 ? c2 : c3);
            col[i] = pick.r; col[i + 1] = pick.g; col[i + 2] = pick.b;
        }

        geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
        geo.setAttribute('color', new THREE.BufferAttribute(col, 3));

        const mat = new THREE.PointsMaterial({
            size: 0.06,
            vertexColors: true,
            transparent: true,
            opacity: 0.65,
            blending: THREE.AdditiveBlending,
            depthWrite: false,
        });

        this.particles = new THREE.Points(geo, mat);
        this.scene.add(this.particles);
    }

    createDataHelix() {
        // Subtle double helix data stream — adds depth without clutter
        const count = 120;
        const geo = new THREE.BufferGeometry();
        const pos = new Float32Array(count * 3);
        const col = new Float32Array(count * 3);

        const cyan   = new THREE.Color(0x00F0FF);
        const purple = new THREE.Color(0xB026FF);

        for (let i = 0; i < count; i++) {
            const t = (i / count) * Math.PI * 5;
            const r = 1.65 + Math.sin(t * 0.6) * 0.18;
            pos[i * 3]     = Math.cos(t) * r;
            pos[i * 3 + 1] = ((i / count) - 0.5) * 3.2;
            pos[i * 3 + 2] = Math.sin(t) * r;

            const c = (i % 2 === 0) ? cyan : purple;
            col[i * 3] = c.r; col[i * 3 + 1] = c.g; col[i * 3 + 2] = c.b;
        }

        geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
        geo.setAttribute('color', new THREE.BufferAttribute(col, 3));

        const mat = new THREE.PointsMaterial({
            size: 0.07,
            vertexColors: true,
            transparent: true,
            opacity: 0.7,
            blending: THREE.AdditiveBlending,
            depthWrite: false,
        });

        this.dataStreams = new THREE.Points(geo, mat);
        this.scene.add(this.dataStreams);
    }

    createOrganicCyberCore() {
        this.coreGroup = new THREE.Group();
        this.scene.add(this.coreGroup);

        // === PRIMARY ELEMENT: Single Elegant Trefoil Ribbon ===
        // A (2,3) torus knot (trefoil) — visually clean, clearly structured,
        // orbits the central logo without burying it
        const trefoilGeo = new THREE.TorusKnotGeometry(1.55, 0.048, 220, 20, 2, 3);
        this.ribbonMat1 = new THREE.MeshPhysicalMaterial({
            color: 0x041832,
            emissive: 0x00F0FF,
            emissiveIntensity: 1.0,
            roughness: 0.12,
            metalness: 0.35,
            transmission: 0.72,
            transparent: true,
            opacity: 0.88,
            ior: 1.45,
            clearcoat: 1.0,
            clearcoatRoughness: 0.08,
        });
        this.trefoilRibbon = new THREE.Mesh(trefoilGeo, this.ribbonMat1);
        this.trefoilRibbon.renderOrder = 1;
        this.coreGroup.add(this.trefoilRibbon);

        // === SECONDARY ELEMENT: Sparse Clean Icosahedron Cage ===
        // detail=0 → only 20 triangles, very clean wireframe, no visual noise
        const cageGeo = new THREE.IcosahedronGeometry(2.05, 0);
        const cageMat = new THREE.MeshBasicMaterial({
            color: 0x00F0FF,
            wireframe: true,
            transparent: true,
            opacity: 0.14,
            blending: THREE.AdditiveBlending,
            depthWrite: false,
        });
        this.innerCage = new THREE.Mesh(cageGeo, cageMat);
        this.innerCage.renderOrder = 0;
        this.coreGroup.add(this.innerCage);
    }

    createOrbitalGimbalRings() {
        // Only 2 rings — clearly separated radii, distinct colors, no overlap clutter
        const ringConfigs = [
            {
                radius: 2.55, tube: 0.011, color: 0x00F0FF,
                rotX: 1.15, rotY: 0.25, speed: 0.006,
                opacity: 0.55,
            },
            {
                radius: 3.25, tube: 0.009, color: 0xB026FF,
                rotX: -0.65, rotY: 1.0, speed: -0.0045,
                opacity: 0.45,
            },
        ];

        ringConfigs.forEach((cfg, idx) => {
            const geo = new THREE.TorusGeometry(cfg.radius, cfg.tube, 16, 140);
            const mat = new THREE.MeshBasicMaterial({
                color: cfg.color,
                transparent: true,
                opacity: cfg.opacity,
                blending: THREE.AdditiveBlending,
                depthWrite: false,
            });
            const ring = new THREE.Mesh(geo, mat);
            ring.rotation.x = cfg.rotX;
            ring.rotation.y = cfg.rotY;
            ring.userData = { speed: cfg.speed };
            this.coreGroup.add(ring);
            this.orbitalRings.push(ring);

            // One glowing satellite per ring
            const satGeo = new THREE.SphereGeometry(0.055, 10, 10);
            const satMat = new THREE.MeshBasicMaterial({
                color: cfg.color,
                blending: THREE.AdditiveBlending,
                depthWrite: false,
            });
            const sat = new THREE.Mesh(satGeo, satMat);
            sat.position.set(cfg.radius, 0, 0);
            ring.add(sat);
            // Store as orbitingSatellites for animate()
            if (!this.orbitingSatellites) this.orbitingSatellites = [];
            this.orbitingSatellites.push({ mesh: sat, radius: cfg.radius, angle: idx * Math.PI });
        });
    }

    createHologramEmblem() {
        const size = 1024;
        const canvas = document.createElement('canvas');
        canvas.width = size;
        canvas.height = size;
        const ctx = canvas.getContext('2d');
        const center = size / 2;

        // 1. Radial cyber glow halo
        const glow = ctx.createRadialGradient(center, center, 55, center, center, center - 10);
        glow.addColorStop(0, 'rgba(0, 240, 255, 0.40)');
        glow.addColorStop(0.45, 'rgba(176, 38, 255, 0.18)');
        glow.addColorStop(0.72, 'rgba(0, 255, 136, 0.06)');
        glow.addColorStop(1, 'rgba(4, 10, 18, 0)');
        ctx.fillStyle = glow;
        ctx.fillRect(0, 0, size, size);

        // 2. Main neon ring
        ctx.strokeStyle = 'rgba(0, 240, 255, 0.7)';
        ctx.lineWidth = 5;
        ctx.beginPath();
        ctx.arc(center, center, 390, 0, Math.PI * 2);
        ctx.stroke();

        // 3. Dashed outer ring
        ctx.strokeStyle = 'rgba(176, 38, 255, 0.55)';
        ctx.lineWidth = 3;
        ctx.setLineDash([18, 12]);
        ctx.beginPath();
        ctx.arc(center, center, 415, 0, Math.PI * 2);
        ctx.stroke();
        ctx.setLineDash([]);

        // 4. Sparse tick marks on the ring (12 ticks like a clock)
        ctx.strokeStyle = '#00FF88';
        ctx.lineWidth = 3;
        for (let i = 0; i < 12; i++) {
            const angle = (i / 12) * Math.PI * 2;
            const r1 = 420, r2 = 436;
            ctx.beginPath();
            ctx.moveTo(center + Math.cos(angle) * r1, center + Math.sin(angle) * r1);
            ctx.lineTo(center + Math.cos(angle) * r2, center + Math.sin(angle) * r2);
            ctx.stroke();
        }

        // 5. Inner thin ring
        ctx.strokeStyle = 'rgba(0, 240, 255, 0.3)';
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.arc(center, center, 340, 0, Math.PI * 2);
        ctx.stroke();

        const discTexture = new THREE.CanvasTexture(canvas);
        discTexture.anisotropy = 8;

        // 6. Load SMKN 20 logo — sized proportionally inside the rings
        if (this.data.logoUrl) {
            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.onload = () => {
                // Logo occupies ~50% of canvas so rings remain visible around it
                const logoSize = 490;
                ctx.drawImage(img, (size - logoSize) / 2, (size - logoSize) / 2, logoSize, logoSize);
                discTexture.needsUpdate = true;
            };
            img.src = this.data.logoUrl;
        }

        const discGeo = new THREE.PlaneGeometry(2.0, 2.0);
        const discMat = new THREE.MeshBasicMaterial({
            map: discTexture,
            transparent: true,
            opacity: 0.97,
            blending: THREE.AdditiveBlending,
            side: THREE.DoubleSide,
            depthWrite: false,
        });

        this.hologramEmblem = new THREE.Mesh(discGeo, discMat);
        this.hologramEmblem.position.set(0, 0, 1.15); // Clearly in front of all rings/ribbon
        this.hologramEmblem.renderOrder = 10;
        this.coreGroup.add(this.hologramEmblem);
    }

    setupHUD() {
        this.hud = document.getElementById('cyber-hud');
        this.btnBeranda = document.getElementById('btn-beranda-cyber');

        if (this.btnBeranda) {
            this.btnBeranda.addEventListener('click', (e) => {
                e.preventDefault();
                this.warpSpeedTransition();
            });
        }
    }

    setupMajorInteractions() {
        const streamContainer = document.getElementById('majors-stream');
        const flyout = document.getElementById('cyber-flyout-drawer');
        const cards = document.querySelectorAll('.stream-card');

        let isOverFlyout = false;

        const applyTargetColor = (color) => {
            gsap.killTweensOf(this.cyanLight.color);
            gsap.killTweensOf(this.centerLight.color);
            gsap.killTweensOf(this.ribbonMat1.emissive);
            gsap.killTweensOf(this.centerLight);

            gsap.to(this.cyanLight.color,     { r: color.r, g: color.g, b: color.b, duration: 0.45, ease: 'power2.out' });
            gsap.to(this.centerLight.color,   { r: color.r, g: color.g, b: color.b, duration: 0.45, ease: 'power2.out' });
            gsap.to(this.ribbonMat1.emissive, { r: color.r, g: color.g, b: color.b, duration: 0.45, ease: 'power2.out' });
            gsap.to(this.centerLight, { intensity: 4.8, duration: 0.4, ease: 'power2.out' });
        };

        // ── Grace period constants & state (3 seconds buffer for relaxed navigation) ──
        const GRACE_PERIOD_MS = 3000;
        const graceBar = document.getElementById('drawer-grace-bar');
        let graceTimeout = null;
        let graceTween = null;

        // Cancel any running grace drain (timer + animation)
        const cancelGraceDrain = () => {
            if (graceTimeout) {
                clearTimeout(graceTimeout);
                graceTimeout = null;
            }
            if (graceTween) {
                graceTween.kill();
                graceTween = null;
            }
            if (graceBar) {
                graceBar.classList.remove('is-draining');
                gsap.set(graceBar, { scaleX: 1, opacity: 0 });
            }
        };

        // Start the grace drain: progress bar shrinks over GRACE_PERIOD_MS, then hide
        const startGraceDrain = () => {
            // Always cancel any previous drain first (prevents race conditions)
            cancelGraceDrain();

            if (graceBar) {
                gsap.set(graceBar, { scaleX: 1, opacity: 1 });
                graceBar.classList.add('is-draining');
                graceTween = gsap.to(graceBar, {
                    scaleX: 0,
                    duration: GRACE_PERIOD_MS / 1000,
                    ease: 'none', // linear drain
                    onComplete: () => {
                        graceTween = null;
                    }
                });
            }

            graceTimeout = setTimeout(() => {
                graceTimeout = null;
                // Final check: if cursor is back on card or flyout, abort
                if (!isOverFlyout && !this.isOverCard) {
                    resetToDefaultState();
                }
            }, GRACE_PERIOD_MS);
        };

        const resetToDefaultState = () => {
            // Clean up any grace drain artefacts
            cancelGraceDrain();

            // Smoothly decelerate rotation speed multiplier to 1.0 (no sudden jumps!)
            gsap.killTweensOf(this);
            gsap.to(this, { rotationSpeedMultiplier: 1.0, duration: 0.8, ease: 'power2.inOut' });

            // Smoothly cross-fade colors back to default
            gsap.killTweensOf(this.cyanLight.color);
            gsap.killTweensOf(this.centerLight.color);
            gsap.killTweensOf(this.ribbonMat1.emissive);
            gsap.killTweensOf(this.centerLight);

            gsap.to(this.cyanLight.color,     { r: this.defaultCyan.r, g: this.defaultCyan.g, b: this.defaultCyan.b, duration: 0.65, ease: 'power2.inOut' });
            gsap.to(this.centerLight.color,   { r: this.defaultCyan.r, g: this.defaultCyan.g, b: this.defaultCyan.b, duration: 0.65, ease: 'power2.inOut' });
            gsap.to(this.ribbonMat1.emissive, { r: this.defaultCyan.r, g: this.defaultCyan.g, b: this.defaultCyan.b, duration: 0.65, ease: 'power2.inOut' });
            gsap.to(this.centerLight, { intensity: 3.0, duration: 0.65, ease: 'power2.inOut' });

            if (flyout) {
                flyout.classList.remove('active');
            }
            if (graceBar) {
                graceBar.classList.remove('is-draining');
                gsap.set(graceBar, { scaleX: 1, opacity: 0 });
            }
            if (this.activeCard) {
                this.activeCard.classList.remove('is-active');
                this.activeCard = null;
            }
        };

        const updateFlyoutContent = (card) => {
            if (!flyout) return;
            const kode = card.getAttribute('data-kode') || '';
            const name = card.getAttribute('data-name') || '';
            const title = card.getAttribute('data-title') || `DATA KONSENTRASI: ${kode}`;
            const badge = card.getAttribute('data-badge') || 'TERAKREDITASI A';
            const desc = card.getAttribute('data-desc') || '';
            const link = card.getAttribute('data-link') || '#';
            const color = card.getAttribute('data-color') || '#00F0FF';
            let tools = [];
            try {
                tools = JSON.parse(card.getAttribute('data-tools') || '[]');
            } catch(e) {}
            const toolsExtra = card.getAttribute('data-tools-extra') || '';

            flyout.style.setProperty('--card-accent', color);

            const titleEl = flyout.querySelector('.flyout-title');
            if (titleEl) {
                titleEl.textContent = `// KONSENTRASI: ${kode}`;
            }

            const nameEl = flyout.querySelector('.flyout-name');
            if (nameEl && name) {
                nameEl.textContent = name;
            }

            const badgeEl = flyout.querySelector('.flyout-badge');
            if (badgeEl) badgeEl.textContent = badge;

            const descEl = flyout.querySelector('.flyout-desc');
            if (descEl) descEl.textContent = desc;

            const linkEl = flyout.querySelector('.flyout-link');
            if (linkEl) linkEl.setAttribute('href', link);

            const tagsContainer = flyout.querySelector('.flyout-tags');
            if (tagsContainer) {
                // Display 2-3 main tags + badge +N for the rest
                let tagsHtml = tools.slice(0, 3).map(t => `<span class="drawer-tag">${t}</span>`).join('');
                if (toolsExtra) {
                    tagsHtml += `<span class="drawer-tag drawer-tag-extra">${toolsExtra}</span>`;
                }
                tagsContainer.innerHTML = tagsHtml || '<span class="drawer-tag">Kurikulum Industri</span>';
            }

            // Fixed Right-side HUD positioning: clear any legacy inline positions
            flyout.style.removeProperty('top');
            flyout.style.removeProperty('left');
            flyout.classList.add('active');

            // Cancel any running grace drain since we're showing new content
            cancelGraceDrain();
        };

        // Track whether cursor is currently over any stream-card
        this.isOverCard = false;

        cards.forEach((card) => {
            const colorHex = card.getAttribute('data-color') || '#00F0FF';
            const targetColor = new THREE.Color(colorHex);

            card.addEventListener('mouseenter', () => {
                this.isOverCard = true;

                // Cancel any pending grace drain (cursor came back in time)
                cancelGraceDrain();

                if (this.activeCard && this.activeCard !== card) {
                    this.activeCard.classList.remove('is-active');
                }
                this.activeCard = card;
                card.classList.add('is-active');

                // Smoothly accelerate rotation speed using GSAP (continuous interpolation)
                gsap.killTweensOf(this, 'rotationSpeedMultiplier');
                gsap.to(this, { rotationSpeedMultiplier: 1.55, duration: 0.5, ease: 'power2.out' });

                applyTargetColor(targetColor);
                updateFlyoutContent(card);
            });

            card.addEventListener('mouseleave', () => {
                this.isOverCard = false;
                // Start grace period — drawer stays visible, progress bar drains
                startGraceDrain();
            });
        });

        if (flyout) {
            flyout.addEventListener('mouseenter', () => {
                isOverFlyout = true;
                // Cancel grace drain — cursor reached the drawer in time
                cancelGraceDrain();
            });

            flyout.addEventListener('mouseleave', () => {
                isOverFlyout = false;
                // Start grace period again when leaving the drawer
                startGraceDrain();
            });
        }

        if (streamContainer) {
            streamContainer.addEventListener('mouseleave', () => {
                // Only start drain if not hovering flyout
                if (!isOverFlyout) {
                    this.isOverCard = false;
                    startGraceDrain();
                }
            });

            // Keep horizontal scroll strictly at 0
            streamContainer.addEventListener('scroll', () => {
                if (streamContainer.scrollLeft !== 0) {
                    streamContainer.scrollLeft = 0;
                }
                if (this.activeCard) {
                    updateFlyoutContent(this.activeCard);
                }
            }, { passive: true });
        }
    }

    showHUD() {
        if (this.hud) {
            this.hud.style.opacity = '1';
            this.hud.style.pointerEvents = 'auto';
        }
    }

    warpSpeedTransition() {
        gsap.to(this.camera.position, {
            z: 0.05,
            duration: 0.65,
            ease: 'power4.in',
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
        window.addEventListener('pointermove', (e) => {
            this.mouse.targetX = (e.clientX / this.width - 0.5) * 2;
            this.mouse.targetY = (e.clientY / this.height - 0.5) * 2;
        });
    }

    onResize() {
        this.width = window.innerWidth;
        this.height = window.innerHeight;
        this.camera.aspect = this.width / this.height;
        this.camera.fov = this.width < 900 ? 55 : 44;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(this.width, this.height);
    }

    animate() {
        requestAnimationFrame(() => this.animate());

        const delta = Math.min(this.clock.getDelta(), 0.1);
        this.accumulatedTime += delta;
        const elapsed = this.accumulatedTime;
        const spd = this.rotationSpeedMultiplier;

        // Smooth mouse parallax
        this.mouse.x += (this.mouse.targetX - this.mouse.x) * 0.045;
        this.mouse.y += (this.mouse.targetY - this.mouse.y) * 0.045;

        // === Trefoil Ribbon — smooth continuous delta accumulation (NO JUMP ON SPEED CHANGE) ===
        this.ribbonRotX += delta * 0.25 * spd;
        this.ribbonRotY += delta * 0.35 * spd;

        if (this.trefoilRibbon) {
            this.trefoilRibbon.rotation.x = this.ribbonRotX + this.mouse.y * 0.12;
            this.trefoilRibbon.rotation.y = this.ribbonRotY + this.mouse.x * 0.18;
        }

        // === Sparse cage — slow independent rotation for depth ===
        if (this.innerCage) {
            this.innerCage.rotation.x = elapsed * 0.065;
            this.innerCage.rotation.y = -elapsed * 0.09;
        }

        // === Orbital gimbal rings ===
        this.orbitalRings.forEach((ring) => {
            ring.rotation.z += ring.userData.speed * spd * delta * 60;
        });

        // === Hologram emblem — gentle float ===
        if (this.hologramEmblem) {
            this.hologramEmblem.position.y = Math.sin(elapsed * 1.6) * 0.055;
            this.hologramEmblem.rotation.z = Math.sin(elapsed * 0.7) * 0.025;
        }

        // === Lights orbit ===
        if (this.cyanLight) {
            this.cyanLight.position.x = Math.sin(elapsed * 0.75) * 4.0;
            this.cyanLight.position.y = Math.cos(elapsed * 0.55) * 3.0;
        }
        if (this.purpleLight) {
            this.purpleLight.position.x = -Math.sin(elapsed * 0.65) * 4.0;
            this.purpleLight.position.y = -Math.cos(elapsed * 0.50) * 3.0;
        }

        // Center light pulse — subtle heartbeat
        if (this.centerLight) {
            const basePulse = 0.12;
            this.centerLight.intensity = (this.centerLight.intensity || 3.0) * 1.0;
            // Gentle sine overlay (doesn't fight GSAP tweens — very small amplitude)
            this.centerLight.position.z = 1.5 + Math.sin(elapsed * 2.2) * 0.15;
        }

        // === Starfield slow drift ===
        if (this.particles) this.particles.rotation.y = elapsed * 0.018;

        // === Data helix rotate ===
        if (this.dataStreams) {
            this.dataStreams.rotation.y = -elapsed * 0.12;
            this.dataStreams.position.y = Math.sin(elapsed * 0.9) * 0.12;
        }

        // === Core group mouse parallax tilt ===
        if (this.coreGroup) {
            this.coreGroup.position.x = this.mouse.x * 0.3;
            this.coreGroup.position.y = -this.mouse.y * 0.22;
        }

        this.renderer.render(this.scene, this.camera);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new Futuristic3DExperience();
});
