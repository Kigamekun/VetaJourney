const canvas = document.querySelector('.webgl')
const scene = new THREE.Scene()
const textureLoader = new THREE.TextureLoader()
const sizes = {
    width: 800,
    height: 400
}

// Base camera
const camera = new THREE.PerspectiveCamera(70, sizes.width / sizes.height, .1, 100)
camera.position.x = 10
camera.position.y = 20
camera.position.z = 50
scene.add(camera)

// Controls
const controls = new THREE.OrbitControls(camera, canvas)
controls.enableDamping = true
controls.enableZoom = true
controls.enablePan = false
controls.minDistance = 20
controls.maxDistance = 40
controls.minPolarAngle = Math.PI / 4
controls.maxPolarAngle = Math.PI / 2
controls.minAzimuthAngle = -Math.PI / 80
controls.maxAzimuthAngle = Math.PI / 2.5

// Renderer
const renderer = new THREE.WebGLRenderer({
    canvas: canvas,
    antialias: true,
    alpha: true
})

renderer.setSize(sizes.width, sizes.height)
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2))
renderer.outputEncoding = THREE.sRGBEncoding

// Loader
const loader = new THREE.GLTFLoader()
let model

loader.load('./3d/veteriner3d.glb',
    (gltf) => {
        model = gltf.scene
        gltf.scene.traverse( child => {

            if ( child.material ) child.material.metalness = .5;
        
        } );
        // model.traverse(child => child.material = bakedMaterial)
        model.position.set(0,0,0)
        scene.add(model)

        const light = new THREE.AmbientLight(0xffffff,1); // soft white light
        scene.add(light);
        

        // Start the animation loop after the model is loaded
        animateModel()
    },
    (xhr) => {
        console.log((xhr.loaded / xhr.total * 100) + '% loaded')
    }
)

// Animation
function animateModel() {
    if (model) {
        // Rotate the model around its Y-axis
        model.rotation.y += 0.005;
    }

    controls.update()
    renderer.render(scene, camera)
    requestAnimationFrame(animateModel)
}
