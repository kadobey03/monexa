<template>
  <section id="security" class="section">
    <div class="container-max text-center">
      <h2 class="text-2xl md:text-3xl font-extrabold text-ink">Ensuring your security</h2>
      <p class="mt-3 text-slate-600">We combine multiple layers of protection to keep your funds and data safe.</p>

      <div class="mt-10 grid grid-cols-2 md:grid-cols-5 gap-6">
        <SecurityBadge title="DDoS" desc="Mitigation" icon="shield"/>
        <SecurityBadge title="SSO" desc="Secure login" icon="lock"/>
        <SecurityBadge title="GDPR" desc="Compliant" icon="check"/>
        <SecurityBadge title="WAF" desc="Firewall" icon="shield"/>
        <SecurityBadge title="2FA" desc="Authentication" icon="key"/>
      </div>
    </div>
  </section>
</template>

<script setup>
</script>

