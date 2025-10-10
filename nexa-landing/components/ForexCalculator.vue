<template>
  <section class="section">
    <div class="container-max grid lg:grid-cols-2 gap-8 items-start">
      <div class="card p-6">
        <h2 class="text-xl font-bold mb-4">{{ t('forexCalc.title') }}</h2>
        <div class="grid sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm text-slate-600 mb-1">{{ t('forexCalc.pair') }}</label>
            <select v-model="pair" class="w-full rounded-md border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-2">
              <option v-for="p in pairs" :key="p.symbol" :value="p.symbol">{{ p.symbol }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm text-slate-600 mb-1">{{ t('forexCalc.lots') }}</label>
            <input type="number" step="0.01" v-model.number="lots" class="w-full rounded-md border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-2"/>
          </div>
          <div>
            <label class="block text-sm text-slate-600 mb-1">{{ t('forexCalc.entry') }}</label>
            <input type="number" step="0.0001" v-model.number="entry" class="w-full rounded-md border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-2"/>
          </div>
          <div>
            <label class="block text-sm text-slate-600 mb-1">{{ t('forexCalc.exit') }}</label>
            <input type="number" step="0.0001" v-model.number="exit" class="w-full rounded-md border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-2"/>
          </div>
        </div>
        <button class="btn-primary mt-5" @click="recalc">{{ t('forexCalc.calculate') }}</button>
      </div>

      <div class="card p-6">
        <h3 class="text-lg font-semibold">{{ t('forexCalc.result') }}</h3>
        <p class="mt-2 text-sm text-slate-600">{{ t('forexCalc.pips') }}: <strong>{{ pips }}</strong></p>
        <p class="mt-1 text-sm text-slate-600">{{ t('forexCalc.pipValue') }}: <strong>${{ pipValuePerLot.toFixed(2) }}</strong></p>
        <p class="mt-1 text-sm text-slate-600">{{ t('forexCalc.pl') }}: <strong :class="profit>=0 ? 'text-emerald-600' : 'text-rose-600'">${{ profit.toFixed(2) }}</strong></p>
        <p class="mt-4 text-xs text-slate-500">{{ t('forexCalc.disclaimer') }}</p>
      </div>
    </div>
  </section>
</template>

<script setup>
const { t } = useI18n()
const pairs = [
  { symbol: 'EURUSD', pipSize: 0.0001, pipValuePerLot: 10 },
  { symbol: 'GBPUSD', pipSize: 0.0001, pipValuePerLot: 10 },
  { symbol: 'USDJPY', pipSize: 0.01, pipValuePerLot: 9.13 }
]
const pair = ref('EURUSD')
const lots = ref(1)
const entry = ref(1.0800)
const exit = ref(1.0850)

const pipSize = computed(() => pairs.find(p => p.symbol === pair.value)?.pipSize ?? 0.0001)
const pipValuePerLot = computed(() => pairs.find(p => p.symbol === pair.value)?.pipValuePerLot ?? 10)
const pips = computed(() => Math.round(((exit.value - entry.value) / pipSize.value) * 100) / 100)
const profit = computed(() => pips.value * pipValuePerLot.value * lots.value)

const recalc = () => {
  // reactive computed handles updates; function kept for UX
}
</script>
