<template>
  <div ref="container" class="character"></div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue"
import * as THREE from "three"
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader"

const container = ref(null)

onMounted(() => {
  const scene = new THREE.Scene()

  const camera = new THREE.PerspectiveCamera(
    35,
    container.value.clientWidth / container.value.clientHeight,
    0.1,
    1000
  )
  camera.position.set(0, 1.5, 3)

  const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true, powerPreference: 'low-power' })
  renderer.setSize(container.value.clientWidth, container.value.clientHeight, false)
  renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 1.5))
  renderer.domElement.style.display = 'block'
  renderer.domElement.style.width = '100%'
  renderer.domElement.style.height = '100%'
  container.value.appendChild(renderer.domElement)

  // control running state from outer scope
  let running = true

  const light = new THREE.HemisphereLight(0xffffff, 0x444444, 3)
  scene.add(light)

  const loader = new GLTFLoader()

  loader.load(
    "/nanally_coluccisre_-_neverness_to_everness.glb",
    (gltf) => {
      const model = gltf.scene
      scene.add(model)

      // Center and fit model to camera using bounding sphere (better framing)
      try {
        const box = new THREE.Box3().setFromObject(model)
        const center = box.getCenter(new THREE.Vector3())
        // Re-center model to origin
        model.position.x -= center.x
        model.position.y -= center.y
        model.position.z -= center.z

        const sphere = new THREE.Sphere()
        box.getBoundingSphere(sphere)
        const radius = sphere.radius || Math.max(box.getSize(new THREE.Vector3()).length() / 2, 1)

        // Compute distance from camera to fit the sphere in view
        const fov = (camera.fov * Math.PI) / 180
        const distance = Math.abs(radius / Math.sin(fov / 2))
        const margin = 1.2
        const camZ = distance * margin

        // Place camera slightly above center so model is nicely framed
        camera.position.set(0, radius * 0.6, camZ)
        camera.near = Math.max(0.01, distance - radius * 4)
        camera.far = distance + radius * 10
        camera.updateProjectionMatrix()
        camera.lookAt(new THREE.Vector3(0, 0, 0))

        // Single render to apply new camera frame
        renderer.render(scene, camera)
      } catch (e) {
        console.warn('Model centering failed', e)
      }

      const mixer = new THREE.AnimationMixer(model)
      gltf.animations.forEach((clip) => {
        mixer.clipAction(clip).play()
      })

      // Use performance.now and a frame limiter instead of THREE.Clock
      let lastFrameTime = performance.now()
      const targetFPS = 30
      const frameInterval = 1000 / targetFPS

      function animate() {
        requestAnimationFrame(animate)
        if (!running) return
        const now = performance.now()
        const elapsed = now - lastFrameTime
        if (elapsed > frameInterval) {
          lastFrameTime = now - (elapsed % frameInterval)
          const delta = Math.min(elapsed / 1000, 0.1)
          mixer.update(delta)
          renderer.render(scene, camera)
        }
      }

      animate()
    },
    undefined,
    (error) => {
      console.error("Failed to load 3D character:", error)
    }
  )

  // Debounced resize handler
  let resizeTimeout = null
  function onWindowResize() {
    if (!container.value) return
    clearTimeout(resizeTimeout)
    resizeTimeout = setTimeout(() => {
      const width = container.value.clientWidth
      const height = container.value.clientHeight
      camera.aspect = width / height
      camera.updateProjectionMatrix()
      renderer.setSize(width, height, false)
    }, 120)
  }

  window.addEventListener('resize', onWindowResize)

  // Pause rendering when the element is not visible or tab is hidden
  const observer = new IntersectionObserver((entries) => {
    const entry = entries[0]
    running = entry.isIntersecting && !document.hidden
  })
  if (container.value) observer.observe(container.value)

  function onVisibilityChange() {
    running = !document.hidden
  }
  document.addEventListener('visibilitychange', onVisibilityChange)

  const cleanup = () => {
    window.removeEventListener('resize', onWindowResize)
    document.removeEventListener('visibilitychange', onVisibilityChange)
    if (observer) observer.disconnect()
    if (renderer) {
      renderer.dispose()
      if (renderer.domElement && renderer.domElement.parentNode) {
        renderer.domElement.parentNode.removeChild(renderer.domElement)
      }
    }
  }

  onUnmounted(() => {
    cleanup()
  })
})
</script>

<style scoped>
.character {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
}
</style>
