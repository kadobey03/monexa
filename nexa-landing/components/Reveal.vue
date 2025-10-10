<template>
  <div ref="el" :class="baseClass">
    <slot />
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{ once?: boolean, class?: string }>()
const el = ref<HTMLElement | null>(null)
// On mobile, show immediately; only reveal on md and up
const baseClass = computed(() => `md:opacity-0 ${props.class ?? ''}`)

onMounted(() => {
  if (!el.value) return
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.remove('opacity-0')
        entry.target.classList.remove('md:opacity-0')
        entry.target.classList.add('animate-fade-in-up')
        if (props.once !== false) observer.unobserve(entry.target)
      }
    })
  }, { threshold: 0.1 })
  observer.observe(el.value)
})
</script>
