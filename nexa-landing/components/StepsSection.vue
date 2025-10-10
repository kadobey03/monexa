<template>
  <section class="section">
    <div class="container-max text-center">
      <h2 class="text-2xl md:text-3xl font-extrabold text-ink">New to Trading?</h2>
      <p class="mt-3 text-slate-600">Get started with three simple steps.</p>

      <div class="mt-10 grid md:grid-cols-3 gap-6">
        <StepCard number="1" title="Choose a leader" desc="Pick a top trader and replicate their strategies automatically."/>
        <StepCard number="2" title="Allocate capital" desc="Set your budget and risk limits in a couple of clicks."/>
        <StepCard number="3" title="Mirror trading" desc="Your account follows the leader's moves while you stay in control."/>
      </div>

      <div class="mt-10">
        <button class="btn-primary">Sign up</button>
      </div>
    </div>
  </section>
</template>

<script setup>
</script>

